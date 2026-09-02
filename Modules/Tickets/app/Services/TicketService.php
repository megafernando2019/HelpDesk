<?php

namespace Modules\Tickets\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Modules\Tickets\Support\Mappers\TicketMapper;
use Modules\Tickets\Support\Mappers\ViewParamsIndexMapper;
use Illuminate\Support\Str;
use Modules\Tickets\app\Support\Exceptions\TicketException;
use Modules\Tickets\Models\Ticket;

class TicketService {

    public function __construct(
       private readonly ITicketRepo $repo
    ) {
       
    }

    public function updateStatus($request)
    {
       $status = (int) $request?->ticket_status ?? 0;
       $ticket_id = (int) $request?->ticket_id ?? 0;

       return $this->repo->updateStatus($status, $ticket_id);
    }

    public function getTicket($id, $relations = [])
    {
       return $this->repo->getTicket($id, $relations);
    }

    public function getAllStatus() 
    {
       return $this->repo->getStatus();
    }

    public function getAllPriorities()
    {
       return $this->repo->getPriorities();
    }

    public function getDetailsIndex()
    {
        $count_details = [];
        $priorities = $this->repo->getPriorities();
        $statuses = $this->repo->getStatus();

        $user_id = Auth::user()->id;

        $count_details_ctx = $this->repo->getStatusesWithCount($user_id);

        if($count_details_ctx->isNotEmpty()) {
            foreach ($count_details_ctx as $value) {
                
                $key = strtolower(str_replace(' ', '_', $value->name ?? ''));
                $count_details[$key] = [
                    'name' => $value?->name ?? '',
                    'tickets_count' =>  $value->tickets_count ?? 0
                ];
                
            }
        }

        //mapper aqui para la vista
        return ViewParamsIndexMapper::map(
            $priorities, $statuses, $count_details
        );
    }

    public function getDataIndexCard($request)
    {
        $user_id = Auth::user()->id;
        $ticket_status = (int) $request->ticket_status ?? 1;
        $priority = (int) $request->priority ?? 0;
        $startDate = $request->start_date ?? null;
        $endDate = $request->end_date ?? null;

        if ($startDate === "null") {
            $startDate = null;
        }

        if ($endDate === "null") {
            $endDate = "null";
        }

        $ctx = $this->repo->applyFilters(
            $ticket_status,
            $user_id,
            $priority,
            $startDate,
            $endDate
        );

        return TicketMapper::toCollection(
            $ctx
        );

    }

    public function getTicketsTypes()
    {
        return $this->repo->getTicketsTypes();
    }

    public function getTicketPriorities()
    {
        return $this->repo->getPriorities();
    }

    /**
     * Regresa un array con los datos de cada archivo para guardarlo en la BD
     *
     * @param array $files
     * @return array
     */
    public function uploadAttachments(
        $files, $uid
    ): array
    {
        $data = [];

        if (!empty($files)) {
            foreach ($files as $file) {

                if (!$file) {
                    continue;
                }

                $timestamp = str_replace(".", "", (string) microtime(true));
                $extension = $file->getClientOriginalExtension();
                $hashName = sprintf(
                                    '%s_%s_%s.%s', 
                                              md5($file->getClientOriginalName()),
                                              date('d_m_Y_His'),
                                              $timestamp,
                                              $extension

                            );

                $path = $file->storeAs('tickets/'.$uid.'/attachments', $hashName, 'public');

                $data[] = [
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ];
            }

            return $data;
        }

        return $data;

    }

    /**
     * Crea un nuevo ticket o actualiza* en proximos comits
     *
     * @param $args
     * @return void
     */
    public function saveTicket($request)
    {
       $values = $request->all();
       $uid = $this->generateUniqueUid();
       $files = $request->file('attachments') ?? [];

       $values['uid'] = $uid;
       $values['user_id'] = Auth::user()->id;
       $values['status_id'] = 1;

       $ticket = $this->repo->addTicket($values);

       if (!empty($values['url']) && isset($values['url'])) {
                $this->repo->addTicketUrl(
                    $ticket->id, 
                    $values['url']
                );
       }

       //Subir archivos adjuntos
       $records = $this->uploadAttachments($files, $ticket->uid);

       //Si ya se subieron al servidor los archivos adjuntos
       if (!empty($records)) {
    
        foreach ($records as $record) {
            
            $record['ticket_id'] = $ticket->id;

            $this->repo->storeAttachment($record);
        }

       }

    }

    public function saveObservations($request)
    {
        $records = [
            'ticket_id' => $request->ticket_id,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,
            'ticket_priority_id' => $request->ticket_priority_id,
            'description' => $request->observation_d
        ];

        return $this->repo->saveObservations($records);
    }


    public function assignUser($request)
    {
        $ticket_id = $request?->ticket_id;
        $ticket =  $this->getTicket($ticket_id);
        $users_ids = $request?->assignees ?? [];

        if (!$ticket || $ticket === null) {
            throw new TicketException('No se encontro un ticket válido');
        }

        $this->repo->assignUser($ticket, $users_ids);

        // Registrar en los logs
        // $this->logAction(
        //     $ticket->id,
        //     'assigned_user',
        //     "Se asignó el ticket al usuario ID: {$userId}"
        // );
    }



    public function logAction()
    {

    }
    

    /**
     * Genera un UID para el ticket unico
     * @return string
     */
    public function generateUniqueUid()
    {
        do {
            $randomString = strtoupper(Str::random(5));
            $uid = "TKT{$randomString}";
            
            // Repite el bucle solo si el UID ya existe en la base de datos
        } while (Ticket::where('uid', $uid)->exists());

        return $uid;
    }

}