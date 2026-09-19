<?php

namespace Modules\Tickets\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Tickets\Models\Ticket;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrateLegacyTicketLogs extends Command
{
    //AUN EN DESARROLLO ESTE COMANDO 
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tickets:migrate-legacy-logs';

    /**
     * The console command description.
     */
     protected $description = 'Genera logs iniciales a tickets antiguos importados del dump';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener los IDs de tickets que ya tienen logs para ignorarlos
        $existingLoggedTicketIds = DB::table('ticket_logs')
            ->pluck('ticket_id')
            ->toArray();

        // Traer solo tickets sin logs
        $legacyTickets = DB::table('tickets as t')
        ->whereNotIn('t.id', $existingLoggedTicketIds)
        ->leftJoin('tickets_notifications as tn', 'tn.ticket_id', '=', 't.id')
        ->select(
            // Campos principales del Ticket
            't.id as ticket_id',
            't.uid as ticket_uid',
            't.ticket_priority_id',
            't.user_id as ticket_creator_id', // Creador original del ticket
            't.team_id',
            't.status_id',
            't.title as ticket_title',
            't.description as ticket_description',
            't.created_at as ticket_created_at',
            't.updated_at as ticket_updated_at',

            // Campos de la Notificación (Acción ejecutada)
            'tn.id as notification_id',
            'tn.ticket_action_id',
            'tn.user_id as action_user_id', // Usuario que ejecutó la acción en la notificación del ticket, a este usar en el user_id de los logs
            'tn.title as action_title',
            'tn.description as action_description',
            'tn.created_at as action_created_at'
        )
        ->get();

        if ($legacyTickets->isEmpty()) {
            $this->info('No hay tickets pendientes de migrar logs.');
            return 0;
        }

        $this->info("Procesando {$legacyTickets->count()} tickets antiguos...");

        DB::transaction(function () use ($legacyTickets) {
            
            foreach ($legacyTickets as $ticket) {

                \Log::info([$ticket]);
                //  Insertar Log Inicial de Creación
                // $creator = DB::table('users')->find($creatorUserId);
                // $creatorName = $creator ? "{$creator->first_name} {$creator->last_name}" : 'Usuario Sistema';

                // DB::table('ticket_logs')->insert([
                //     'ticket_id'      => $ticket->id,
                //     'user_id'        => $creatorUserId,
                //     'resource_name'  => 'create',
                //     'section_name'   => 'show',
                //     'message'        => "El usuario {$creatorName} creó el ticket",
                //     'event_type'     => 'CREATE_TICKET', // Ajustar a tus constantes de event_type
                //     'values'         => json_encode([
                //         'id'    => $ticket->id,
                //         'uid'   => $ticket->uid ?? $ticket->code,
                //         'title' => $ticket->title
                //     ]),
                //     'created_at'     => $ticket->created_at, // Preservar la fecha original
                //     'updated_at'     => $ticket->created_at
                // ]);

                // Si el ticket tiene un asignado, crear el log de asignación
                // if ($assignedUserId) {
                //     $assignedUser = DB::table('users')->find($assignedUserId);
                //     $assignedName = $assignedUser ? "{$assignedUser->first_name} {$assignedUser->last_name}" : '';

                //     DB::table('ticket_logs')->insert([
                //         'ticket_id'      => $ticket->id,
                //         'user_id'        => $creatorUserId, 
                //         'resource_name'  => 'update',
                //         'section_name'   => 'show',
                //         'message'        => "El ticket fue asignado a {$assignedName}",
                //         'event_type'     => 'ASSIGN_TICKET',
                //         'values'         => json_encode([
                //             'id'       => $ticket->id,
                //             'assigned' => $assignedUserId
                //         ]),
                //         'created_at'     => $ticket->updated_at ?? $ticket->created_at,
                //         'updated_at'     => $ticket->updated_at ?? $ticket->created_at
                //     ]);
                // }
            }
        });

        $this->info('Migración de logs completada con éxito.');
        return 0;
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
