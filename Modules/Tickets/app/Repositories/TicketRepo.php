<?php

namespace Modules\Tickets\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Modules\Tickets\Models\Ticket;
use Modules\Tickets\Models\TicketAttachment;
use Modules\Tickets\Models\TicketLog;
use Modules\Tickets\Models\TicketObservation;

class TicketRepo implements ITicketRepo {

    public function getActionTicketByUid($uid)
    {
        return DB::table('tickets_actions')
                  ->where('uid', $uid)
                  ->first();
    }

    public function getNotifications($userId, $filters = null)
    {
        $q= DB::table('tickets_notifications as n')
            ->join('users as u', 'n.user_id', '=', 'u.id') 
            ->join('tickets as t', 'n.ticket_id', '=', 't.id')
            ->join('tickets_actions as ta', 'n.ticket_action_id', '=', 'ta.id')
            ->select(
                'n.*',
                'u.first_name as first_name_user',
                'u.last_name as last_name_user',
                't.uid as ticket_folio',
                'ta.uid as ticket_action_folio'
            )
            ->where('n.user_id', $userId);

            switch ($filters) {
                case 'today':
                    // Notificaciones del día de hoy
                    $q->whereDate('n.created_at', Carbon::today());
                    break;

                case 'week':
                    
                    // Notificaciones de esta semana (desde el lunes o últimos 7 días)
                    $q->where('n.created_at', '>=', Carbon::now()->startOfWeek());
                    break;
                case 'not_read':
                    // Notificaciones que no han sido leídas
                    $q->whereNull('n.read_at');
                    break;

                case 'read':
                    // Notificaciones que ya han sido leídas
                    $q->whereNotNull('n.read_at');
                    break;

                default:
                    // Por defecto, si no manda filtro o es 'today'
                    $fechaHaceUnMes = Carbon::now()->subMonth();
                    $q->where('n.created_at', '>=', $fechaHaceUnMes);
                    break;
            }

            return $q->orderBy('n.created_at', 'desc')
            ->simplePaginate(10);
    }

    public function searchByUid(string $args)
    {
        return DB::table('tickets')
        ->whereLike('uid', "%{$args}%")
        ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()])
        ->get();
    }

    public function getOpenTicketsAgeDistribution($membersId = [], $filters = [])
    {
        return DB::table('tickets')
            ->join('tickets_users_assignations', 'tickets.id', '=', 'tickets_users_assignations.ticket_id')
            ->selectRaw("
                CASE 
                    WHEN DATEDIFF(NOW(), tickets.created_at) <= 1 THEN '1 día'
                    WHEN DATEDIFF(NOW(), tickets.created_at) BETWEEN 2 AND 3 THEN '2 - 3 días'
                    WHEN DATEDIFF(NOW(), tickets.created_at) BETWEEN 4 AND 5 THEN '4 - 5 días'
                    ELSE '6+ días'
                END AS range_label,
                COUNT(*) AS total
            ")
            ->when(!empty($membersId), function($q) use ($membersId) {
                $q->whereIn('tickets_users_assignations.user_id', $membersId);
            })
            ->when(!empty(array_filter((array) ($filters['service_ids'] ?? []))), function($q) use ($filters) {
                $q->whereIn('tickets.ticket_service_id', $filters['service_ids']);
            })
            ->when(!empty($filters['date_from']) && !empty($filters['date_to']), function($q) use ($filters) {
                $q->whereBetween('tickets.updated_at', [$filters['date_from'], $filters['date_to']]);
            })
            ->whereNotIn('tickets.status_id', [4,5,6])
            ->groupBy('range_label')
            ->get();
    }

     public function getRateToAssingVsClosure(
      $membersId = [],
      $filters = []
    )
    {
        $q = DB::table('tickets')
               ->join('tickets_users_assignations', 'tickets.id', '=', 'tickets_users_assignations.ticket_id')
               ->when(!empty($membersId), function($q) use ($membersId) {
                    $q->whereIn('tickets_users_assignations.user_id', $membersId);
                })
               ->when(!empty(array_filter((array) ($filters['service_ids'] ?? []))), function($q) use ($filters) {
                    $q->whereIn('tickets.ticket_service_id', $filters['service_ids']);
                });

        $received = (clone $q)
            ->when(!empty($filters['date_from']) && !empty($filters['date_to']), function($q) use ($filters) {
                $q->whereBetween('tickets.created_at', [$filters['date_from'], $filters['date_to']]);
            })
            ->select(
                DB::raw('DATE(tickets.created_at) as date_key'),
                DB::raw('COUNT(DISTINCT tickets.id) as total')
            )
            ->groupBy(DB::raw('DATE(tickets.created_at)'))
            ->pluck('total', 'date_key')
            ->toArray();

        $closed = (clone $q)
            ->join('status', 'tickets.status_id', '=', 'status.id')
            ->whereIn('status.name', ['Cerrado', 'Solucionado'])
            ->when(!empty($filters['date_from']) && !empty($filters['date_to']), function($q) use ($filters) {
                $q->whereBetween('tickets.updated_at', [$filters['date_from'], $filters['date_to']]);
            })
            ->select(
                DB::raw('DATE(tickets.updated_at) as date_key'),
                DB::raw('COUNT(DISTINCT tickets.id) as total')
            )
            ->groupBy(DB::raw('DATE(tickets.updated_at)'))
            ->pluck('total', 'date_key')
            ->toArray();
        
        return compact(
                        'received',
                        'closed'
        );
    }

    public function avgTimeByStatus(
        $membersId = [],
        $filters = []
    ) 
    {
        return DB::table('tickets')
        ->join('status', 'tickets.status_id', '=', 'status.id')
        ->join('tickets_users_assignations', 'tickets.id', '=', 'tickets_users_assignations.ticket_id')
        ->where('tickets.status_id', '!=', 6)
        ->select(
            'status.name as status_name',
            DB::raw('COALESCE(ROUND(AVG(DATEDIFF(tickets.updated_at, tickets.created_at)), 1), 0) as avg_days')

        )
        ->when(!empty($membersId), function($q) use ($membersId) {
            $q->whereIn('tickets_users_assignations.user_id', $membersId);
        })
        // Filtro por Rango de Fechas
        ->when(!empty($filters['date_from']) && !empty($filters['date_to']), function($q) use ($filters) {
            $q->whereBetween('tickets.created_at', [$filters['date_from'], $filters['date_to']]);
        })
        // Filtro por Servicios 
        ->when(!empty(array_filter((array) ($filters['service_ids'] ?? []))), function($q) use ($filters) {
            $q->whereIn('tickets.ticket_service_id', $filters['service_ids']);
        })
        ->groupBy('status.id', 'status.name')
        ->pluck('avg_days', 'status_name');
    }

    public function getClosureRateByMember(
        $membersId = [],
        $filters = []
    )
    {
        return DB::table('tickets')
            ->join('tickets_users_assignations', 'tickets.id', '=', 'tickets_users_assignations.ticket_id')
            ->join('status', 'tickets.status_id', '=', 'status.id')
            // Filtro dinámico por miembros
            ->when(!empty($membersId), function($q) use ($membersId) {
                $q->whereIn('tickets_users_assignations.user_id', $membersId);
            })
            // Filtro por Rango de Fechas
            ->when(!empty($filters['date_from']) && !empty($filters['date_to']), function($q) use ($filters) {
                $q->whereBetween('tickets.created_at', [$filters['date_from'], $filters['date_to']]);
            })
            // Filtro por Servicios 
            ->when(!empty(array_filter((array) ($filters['service_ids'] ?? []))), function($q) use ($filters) {
                $q->whereIn('tickets.ticket_service_id', $filters['service_ids']);
            })
            ->where('tickets.status_id', '!=', 6)
            ->select(
            DB::raw('COUNT(DISTINCT tickets.id) as total_assigned'),
            DB::raw("COUNT(DISTINCT CASE WHEN status.name = 'Cerrado' THEN tickets.id END) as total_closed"),
            DB::raw("COALESCE(ROUND(AVG(CASE WHEN status.name IN ('Cerrado', 'Solucionado') THEN DATEDIFF(tickets.updated_at, tickets.created_at) END), 1), 0) as avg_resolution_days")
        )
        ->first();
    }

    public function getTicketsByStatusDistribution($membersId = [], $filters = []) 
    {
        return DB::table('tickets')
            ->join('tickets_users_assignations', 'tickets.id', '=', 'tickets_users_assignations.ticket_id')
            ->join('users', 'tickets_users_assignations.user_id', '=', 'users.id')
            ->join('status', 'tickets.status_id', '=', 'status.id')
            // Filtro dinámico por miembros
            ->when(!empty($membersId), function($q) use ($membersId) {
                $q->whereIn('tickets_users_assignations.user_id', $membersId);
            })
            // Filtro por Rango de Fechas
            ->when(!empty($filters['date_from']) && !empty($filters['date_to']), function($q) use ($filters) {
                $q->whereBetween('tickets.created_at', [$filters['date_from'], $filters['date_to']]);
            })
            // Filtro por Servicios 
            ->when(!empty(array_filter((array) ($filters['service_ids'] ?? []))), function($q) use ($filters) {
                $q->whereIn('tickets.ticket_service_id', $filters['service_ids']);
            })
            ->select(
                'users.id as user_id',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_name"),
                'status.name as status_name',
                DB::raw('COUNT(DISTINCT tickets.id) as total')
            )
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'status.id', 'status.name')
            // Forzamos el ordenamiento por la posición de la columna status.name
            ->orderByRaw("FIELD(status.name, 'Cerrado', 'Solucionado', 'En espera', 'En proceso')")
            ->get();
    }

    public function findByStatusesIdsByTeamId(
        $teamsIds,
        $ticket_statuses,
        $priority = 0,
        $startDate = null,
        $endDate = null,
        $applyDateDefault = false
    )
    {
        $rol = auth()?->user()?->roles?->first() ?? null;

        if (!$rol) {
            throw new InvalidArgumentException('El rol del usuario es inválido o no tiene asignado uno aún.');
        }

        $q = DB::table('tickets as t')
        ->select([
            't.id',
            't.uid',
            't.title',
            't.description',
            't.created_at',
            't.status_id',
            't.ticket_priority_id',
            't.user_id',
            't.team_id',
            'ts.name as service_name',
            'tp.name as priority_name',
            'u.id as assigned_id',
            'u.first_name as assigned_first_name',
            'u.last_name as assigned_last_name',
            'tob.description as observation',
            'tua.user_id as user_assing_id',
            'uc.id as user_id_create',
            'uc.first_name as user_first_name_create',
            'uc.last_name as user_last_name_create',
            'uc.email as user_email_create'
        ])
        ->whereIn('t.team_id', $teamsIds)
        ->whereIn('t.status_id', $ticket_statuses)
        ->when($priority, function ($q, $priority) {
            return $q->where('t.ticket_priority_id', $priority);
        })
        ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
            return $q->whereBetween('t.created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        })
        //Fecha inicial
        ->when($applyDateDefault, function($q) {
            $q->where('t.created_at', '>=', now()->subMonth()->startOfDay());
        })
        ->leftJoin('tickets_services as ts', 'ts.id', '=', 't.ticket_service_id')
        ->leftJoin('tickets_priorities as tp', 'tp.id', '=', 't.ticket_priority_id')
        ->leftJoin('tickets_users_assignations as tua', 'tua.ticket_id', '=', 't.id')
        ->leftJoin('users as u', 'u.id', '=', 'tua.user_id')
        ->leftJoin('tickets_observations as tob', 'tob.ticket_id', '=', 't.id')
        ->leftJoin('users as uc', 't.user_id', '=', 'uc.id')
        ->orderByDesc('t.id');
        
        //Solo para el encargado
        if ($rol->uid ===  User::ENCARGADO) {
            $q->where('tua.user_id', Auth::user()->id);
        }
        
        return $q->get();
    }

    public function getAssignedTicketsByUserId(
        int $userId,
        array $team
    )
    {
        return DB::table('tickets as t')
            ->join('tickets_users_assignations as tua', 't.id', '=', 'tua.ticket_id')
            ->leftJoin('tickets_priorities as p', 't.ticket_priority_id', '=', 'p.id')
            ->leftJoin('tickets_services as s', 't.ticket_service_id', '=', 's.id')
            ->leftJoin('users as u', 't.user_id', '=', 'u.id')
            ->where('tua.user_id', $userId)
            ->whereIn('t.team_id', $team) //Solo tickets pertenecientes al equipo
            ->whereNotIn('t.status_id', [4, 5, 6]) // Excluyendo resueltos/cerrados/cancelados
            ->select(
                't.uid',
                't.title',
                't.description',
                'p.name as priority_name',
                's.name as services_name',
                't.created_at',
                'u.first_name as user_ticket_first_name',
                'u.last_name as user_ticket_last_name',
                'u.email as user_email_create',
                'tua.user_id as user_id_current_asing'
            )
            ->get();
    }

    public function countTicketsByStatusAssingByTeam($teamsIds)
    {
        return DB::table('tickets as t')
            ->leftJoin('tickets_users_assignations as tua', 't.id', '=', 'tua.ticket_id')
            ->whereNull('tua.ticket_id')
            ->whereIn('t.team_id', $teamsIds)
            ->whereIn('t.status_id', [1, 2, 3])
            ->count();
    }

    public function getTicketsByStatusAssing($userId)
    {
        return DB::table('tickets as t')
        ->leftJoin('tickets_services as s', 't.ticket_service_id', '=', 's.id')
        ->leftJoin('users as u', 't.user_id', '=', 'u.id')
        ->leftJoin('tickets_priorities as p', 't.ticket_priority_id', '=', 'p.id')
        // Unimos la tabla de asignaciones
        ->leftJoin('tickets_users_assignations as tua', 't.id', '=', 'tua.ticket_id')
        // Filtramos solo los que NO tienen registro en la tabla de asignaciones
        ->whereNull('tua.ticket_id')
        ->whereIn('t.team_id', function ($q) use ($userId) {
            $q->select('team_id')
                  ->from('team_user')
                  ->where('user_id', $userId);
        })
        ->whereIn('t.status_id', [1,2,3])
        ->select(
            't.uid',
            't.title',
            't.description',
            'p.name as priority_name',
            's.name as services_name',
            't.created_at',
            'u.first_name as user_ticket_first_name',
            'u.last_name as user_ticket_last_name',
            'u.email as user_email_create'
        )
        ->orderBy('t.id', 'desc')
        ->simplePaginate(5);
    }

    public function getTicket($id, $relations = [])
    {
       return Ticket::with($relations)->find($id);
    }

    public function getTicketByUid($uid, $relations = [])
    {
       return Ticket::with($relations)->where('uid',$uid)->first();
    }

    public function getStatus()
    {
       return DB::table('status')->select('id', 'name')->get();
    }

    public function getPriorities()
    {
       return DB::table('tickets_priorities')->get();
    }

    public function getStatusesWithCount($userId)
    {
        return DB::table('status')
        ->leftJoin('tickets', function ($join) use ($userId) {
            $join->on('status.id', '=', 'tickets.status_id')
                 ->where('tickets.user_id', '=', $userId);
        })
        ->select(
            'status.id', 
            'status.name', 
            DB::raw('COUNT(tickets.id) as tickets_count')
        )
        ->groupBy('status.id', 'status.name')
        ->get();
    }

    public function applyFilters(
        $status,
        $userId,
        $priority = 0,
        $startDate = null,
        $endDate = null
        )
    {    

        return DB::table('tickets as t')
            ->select([
                't.id',
                't.uid',
                't.title',
                't.description',
                't.created_at',
                't.status_id',
                't.ticket_priority_id',
                't.user_id',
                'ts.name as service_name',
                'tp.name as priority_name',
                'u.id as assigned_id',
                'u.first_name as assigned_first_name',
                'u.last_name as assigned_last_name',
                'tob.description as observation',
                'tua.user_id as user_assing_id'
            ])
            ->where('t.user_id', $userId)
            ->where('t.status_id', $status)
            ->when($priority, function ($q, $priority) {
                return $q->where('t.ticket_priority_id', $priority);
            })
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                return $q->whereBetween('t.created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            })
            ->leftJoin('tickets_services as ts', 'ts.id', '=', 't.ticket_service_id')
            ->leftJoin('tickets_priorities as tp', 'tp.id', '=', 't.ticket_priority_id')
            ->leftJoin('tickets_users_assignations as tua', function ($join) {
                $join->on('tua.id', '=', DB::raw('(
                    SELECT id FROM tickets_users_assignations
                    WHERE ticket_id = t.id 
                    ORDER BY id ASC LIMIT 1
                )'));
            })
            ->leftJoin('users as u', 'u.id', '=', 'tua.user_id')
            ->leftJoin('tickets_observations as tob', 'tob.ticket_id', '=', 't.id')
            ->orderByDesc('t.id')
            ->get();
    }

    public function getTicketsTypes()
    {
        return DB::table('tickets_types')->get();
    }

    public function getTicketPriorities()
    {
        return DB::table('tickets_priorities')->get();
    }

    public function addTicket($args)
    {
        return Ticket::create($args);
    }

    public function addTicketUrl($ticket_id, $url)
    {
        return DB::table('tickets_urls')->insert([
            'ticket_id'   => $ticket_id, 
            'url'         => $url,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function storeAttachment($args)
    {
        return TicketAttachment::create($args);
    }

    public function saveObservations($args)
    {
       return TicketObservation::updateOrCreate(
         ['ticket_id' => $args['ticket_id']],
         $args
       );
    }

    public function assignUser(Ticket $ticket, array $users_ids)
    {
       return $ticket->assignees()->sync($users_ids);
    }

    public function updateStatus(int $status, int $ticket_id)
    {
        return Ticket::where('id', $ticket_id)->update([
            'status_id' => $status,
            'updated_at' => now()
            ]);
    }

    public function saveLog($record)
    {
        TicketLog::create($record);
    }

    public function getAllTicketsActions()
    {
       return DB::table('tickets_actions')->get();
    }

    public function getLogsByTicketId($id)
    {
        return DB::table('ticket_logs')
        ->where('ticket_id', $id)
        ->orderBy('id', 'desc')
        ->get();
    }
}