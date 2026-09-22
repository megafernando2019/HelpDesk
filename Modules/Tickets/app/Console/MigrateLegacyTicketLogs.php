<?php

namespace Modules\Tickets\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Tickets\Models\Ticket;
use Modules\Tickets\Models\TicketLog;
use Modules\Tickets\Support\Enums\TicketAction;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrateLegacyTicketLogs extends Command
{
    //AUN EN DESARROLLO ESTE COMANDO 
    /**
     * The name and signature of the console command.
     */
     protected $signature = 'tickets:migrate-legacy-logs {--rollback : Revierte los logs generados por este comando}';

    /**
     * The console command description.
     */
    protected $description = 'Genera o revierte logs iniciales de tickets antiguos importados del dump';

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

        if ($this->option('rollback')) {
            return $this->handleRollback();
        }

        // Obtener los IDs de tickets que ya tienen logs para ignorarlos
        $existingLoggedTicketIds = DB::table('ticket_logs')
            ->pluck('ticket_id')
            ->toArray();

        // Traer solo tickets sin logs
        $legacyTickets = DB::table('tickets as t')
        ->whereNotIn('t.id', $existingLoggedTicketIds)
        ->whereBetween('t.created_at', [
            Carbon::now()->startOfYear(), // 2026-01-01 00:00:00
            Carbon::now()                 // Fecha y hora actual exacta
        ])
        //uid de prueba ->whereIn('t.uid', ['TKT28BYN'])
        ->leftJoin('users as u', 'u.id', '=', 't.user_id')
        ->leftJoin('tickets_notifications as tn', 'tn.ticket_id', '=', 't.id')
        ->leftJoin('tickets_users_assignations as tu', 'tu.ticket_id', '=', 't.id')
        ->leftJoin('tickets_actions as tac',  'tac.id', 'tn.ticket_action_id')
        ->leftJoin('users as uc', 'uc.id', '=', 'tn.user_id')
        ->leftJoin('users as to_assing', 'to_assing.id', '=', 'tu.user_id')
        ->leftJoin('tickets_observations as o', 'o.ticket_id', '=', 't.id')
        ->select(
            // Campos principales del Ticket
            't.id as ticket_id',
            't.uid as ticket_uid',
            't.ticket_priority_id',
            't.user_id as ticket_creator_id', // Creador original del ticket
            't.team_id',
            't.status_id',
            't.title as ticket_title',
            't.ticket_service_id as ticket_service_id',
            't.description as ticket_description',
            't.created_at as ticket_created_at',
            't.updated_at as ticket_updated_at',
            //ticket observacion
            'o.description as observation',
            //persona que creo el ticket
            'u.first_name as user_create_first_name',
            'u.last_name as user_create_last_name',
            // Campos de la Notificación
            'tn.id as notification_id',
            'tn.ticket_action_id',
            'tn.user_id as action_user_id', // Usuario que ejecutó la acción en la notificación del ticket, a este usar en el user_id de los logs
            'uc.first_name as user_action_first_name',
            'uc.last_name as user_action_last_name',
            'tn.created_at as action_created_at',
            //ticket action folio uid
            'tac.uid as ticket_action_uid',
            //Usuario a cargo del ticket si es que tiene
            'to_assing.id as user_assing_id',
            'to_assing.first_name as user_assing_first_name',
            'to_assing.last_name as user_assing_last_name'
        )
        ->get();

        if ($legacyTickets->isEmpty()) {
            $this->info('No hay tickets pendientes de migrar logs.');
            return 0;
        }

        $this->info("Transfiriendo detalles de tickets antiguos...");


        DB::transaction(function () use ($legacyTickets) {
            
            foreach ($legacyTickets as $ticket) {

                $current_ticket = $ticket->ticket_id;

                $user_create_fullname = sprintf(
                    '%s %s',
                    $ticket?->user_create_first_name ?? 'Dato no disponible',
                    $ticket?->user_create_last_name ?? 'Dato no disponible',
                );


                TicketLog::firstOrCreate(
                    [
                        'ticket_id'  => $current_ticket,
                        'event_type' => 'ACT33AHJ',
                    ],
                    [
                        'user_id'       => $ticket->ticket_creator_id,
                        'resource_name' => 'create',
                        'section_name'  => 'show',
                        'message'       => "El usuario {$user_create_fullname} creó el ticket {$ticket->ticket_uid}",
                        'values'        => json_encode([
                            'id'                   => $current_ticket,
                            'uid'                  => $ticket->ticket_uid,
                            'title'                => $ticket->ticket_title,
                            'ticket_priority_id'   => $ticket->ticket_priority_id,
                            'team_id'              => 0,
                            'status_id'            => $ticket->status_id,
                            'ticket_service_id'    => $ticket->ticket_service_id,
                            'description'          => $ticket->ticket_description,
                            'migrated_from_legacy' => true,
                        ]),
                        'created_at'    => $ticket->ticket_created_at,
                        'updated_at'    => $ticket->ticket_updated_at,
                    ]
                );
                

                $user_action_fullname = sprintf(
                    '%s %s',
                    $ticket?->user_action_first_name ?? 'Dato no disponible',
                    $ticket?->user_action_last_name ?? 'Dato no disponible',
                );

                $user_assing_fullname = sprintf(
                    '%s %s',
                    $ticket?->user_assing_first_name,
                    $ticket?->user_assing_last_name
                );

                $data = [
                    'user_create' => $user_create_fullname,
                    'user_name' => $user_action_fullname,
                    'assigned_to' => $user_assing_fullname,
                    'ticket' => $ticket?->ticket_uid ?? '',
                    'observation' => $ticket?->observation ?? '',
                    'cancel_reason' => null,
                    'completed_reason' => null
                ];

                if (!$ticket->ticket_action_uid) {
                    continue;
                }


                $enum = TicketAction::tryFrom($ticket->ticket_action_uid);
            
                DB::table('ticket_logs')->insert([
                    'ticket_id'     => $current_ticket,
                    'user_id'       => $ticket->action_user_id, 
                    'resource_name' => 'update',
                    'section_name'  => 'show',
                    'message'       => $enum->formatDescription($data),
                    'event_type'    => $enum->value, 
                    'values'        => json_encode([
                        'id'    => $current_ticket,
                        'uid'   => $ticket->ticket_uid,
                        'title' => $ticket->ticket_title,
                        'ticket_priority_id' => $ticket?->ticket_priority_id,
                        'team_id' => $ticket->team_id,
                        'status_id' => $ticket->status_id,
                        'ticket_service_id' => $ticket?->ticket_service_id,
                        'observation' => $ticket?->observation,
                        'migrated_from_legacy' => true
                    ]),
                    'created_at'    => $ticket->action_created_at,
                    'updated_at'    => $ticket->action_created_at
                ]);
                
            }
        });

        $this->info('Migración de logs completada con éxito.');
        return 0;
    }

    
    /**
     * Revierte únicamente los logs insertados por la migración.
     */
    protected function handleRollback(): int
    {
        if (!$this->confirm('¿Deseas eliminar todos los logs insertados por el proceso de migración?')) {
            $this->warn('Rollback cancelado.');
            return 0;
        }

        //Se indentifican por la bandera introducida en values y se revierten los registros
        $deleted = DB::table('ticket_logs')
            ->where('values->migrated_from_legacy', true)
            ->delete();

        $this->info("Rollback finalizado. Se eliminaron {$deleted} registros de 'ticket_logs'.");

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
