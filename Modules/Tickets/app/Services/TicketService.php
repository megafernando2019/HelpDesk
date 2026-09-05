<?php

namespace Modules\Tickets\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Modules\Tickets\Support\Mappers\TicketMapper;
use Modules\Tickets\Support\Mappers\ViewParamsIndexMapper;
use Illuminate\Support\Str;
use Modules\Tickets\app\Support\Exceptions\TicketException;
use Modules\Tickets\Models\Ticket;
use Modules\Tickets\Support\Enums\TicketAction;

class TicketService {

    public function __construct(
       private readonly ITicketRepo $repo,
       private readonly TicketLogService $log_ticket_service,
    ) {
       
    }

    public function updateStatus($request)
    {
       $status = (int) $request?->ticket_status ?? 0;
       $ticket_id = (int) $request?->ticket_id ?? 0;

       $result = $this->repo->updateStatus($status, $ticket_id);

       //Si se actualizo el estatus con éxito
       if($result) {
            $enum_action = null;

            switch ($status) {
                case 2:
                    $enum_action = TicketAction::STATUS_IN_PROGRESS;
                    break;
                case 6:
                    $enum_action = TicketAction::STATUS_CANCELLED;
                    break;
                
                default:
                    
                    break;
            }
            

            if ($enum_action !== null) {

                $ticket = $this->getTicket($ticket_id);

                //guardar logs
                $this->log_ticket_service->logAction(
                    $ticket,
                    $enum_action,
                    'update',
                    'tickets/show'
                );
            }
       }

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

       //Si se creo la entidad, guardo su log
       if ($ticket) {
         $enum_action = TicketAction::CREATE_TICKET;

         $this->log_ticket_service->logAction(
            $ticket,
            $enum_action,
            'create',
            'tickets/create'
         );
       }

    }

    public function getLogsTicketFormat($request = null, $param_ticket_id = null)
    {
        $logs = collect($request?->input('logs') ?? $request?->logs ?? []);
        $raw_id = $param_ticket_id 
            ?? $request?->param_ticket_id ?? 0;

        $ticket_id = (int) $raw_id;

        //Si no hay información cargada, la consulto con los parametros
        if ($logs->isEmpty() && $ticket_id > 0) {

            \Log::info('No se encontro información, consulto a la DB');
            $logs = $this->repo->getLogsByTicketId(
                $ticket_id
            );

            //Compruebo nuevamente si aun no arrojo resultados la query, entonces retorno asi la coleccion
            if ($logs->isEmpty()) {
                return $logs;
            }
        }
        
        $dto = TicketMapper::toCollectionTicketLogs($logs);

        return $dto;
    }

    public function saveObservations($request)
    {
        $records = [
            'ticket_id' => $request?->ticket_id,
            'status_id' => $request?->status_id,
            //Toma el id en sesión, ya que es la persona que realiza la observación
            'user_id' => Auth::user()->id,
            'ticket_priority_id' => $request?->ticket_priority_id,
            'description' => $request?->observation_d
        ];

        return $this->repo->saveObservations($records);
    }


    public function assignUser($request)
    {
        $selectedName = $request?->selectedName ?? '';
        //Cortar parentesis y email del string
        $selectedName = strstr($selectedName, '(', true); 
        $ticket_id = $request?->ticket_id;
        $ticket =  $this->getTicket($ticket_id);
        $users_ids = $request?->assignees ?? [];
        $flag_exist_assigned = $request?->flag_exist_assigned ?? [];
        $enum_action = TicketAction::ASSIGN_TICKET;

        if (!$ticket || $ticket === null) {
            throw new TicketException('No se encontro un ticket válido');
        }

        //Ya tenia un usuario asignado previamente
        if (!empty($flag_exist_assigned)) {
            $enum_action = TicketAction::REASSIGN_TICKET;
        }

        $this->repo->assignUser($ticket, $users_ids);

        // Registrar en los logs
        $this->log_ticket_service->logAction(
            $ticket,
            $enum_action,
            'update',
            'tickets/show',
            $selectedName
        );

        return $ticket;
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