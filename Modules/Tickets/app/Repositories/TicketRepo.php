<?php

namespace Modules\Tickets\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Illuminate\Support\Facades\DB;
use Modules\Tickets\Models\Ticket;
use Modules\Tickets\Models\TicketAttachment;
use Modules\Tickets\Models\TicketLog;
use Modules\Tickets\Models\TicketObservation;
use Override;

class TicketRepo implements ITicketRepo {

    public function findByStatusesIdsByIdUserAssing(
        $userId,
        $ticket_statuses,
        $priority = 0,
        $startDate = null,
        $endDate =null
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
            'tua.user_id as user_assing_id',
            'uc.id as user_id_create',
            'uc.first_name as user_first_name_create',
            'uc.last_name as user_last_name_create',
        ])
        ->where('tua.user_id', 2361)
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
        ->leftJoin('tickets_services as ts', 'ts.id', '=', 't.ticket_service_id')
        ->leftJoin('tickets_priorities as tp', 'tp.id', '=', 't.ticket_priority_id')
        ->leftJoin('tickets_users_assignations as tua', 'tua.ticket_id', '=', 't.id')
        ->leftJoin('users as u', 'u.id', '=', 'tua.user_id')
        ->leftJoin('tickets_observations as tob', 'tob.ticket_id', '=', 't.id')
        ->leftJoin('users as uc', 't.user_id', '=', 'uc.id')
        ->orderByDesc('t.id')
        ->get();
    }

    public function getAssignedTicketsByUserId(int $userId)
    {
        return DB::table('tickets as t')
            ->join('tickets_users_assignations as tua', 't.id', '=', 'tua.ticket_id')
            ->leftJoin('tickets_priorities as p', 't.ticket_priority_id', '=', 'p.id')
            ->leftJoin('tickets_services as s', 't.ticket_service_id', '=', 's.id')
            ->leftJoin('users as u', 't.user_id', '=', 'u.id')
            ->where('tua.user_id', $userId)
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
                'tua.user_id as user_id_current_asing'
            )
            ->get();
    }

    public function getTicketsByStatusAssing()
    {
        return DB::table('tickets as t')
        ->leftJoin('tickets_services as s', 't.ticket_service_id', '=', 's.id')
        ->leftJoin('users as u', 't.user_id', '=', 'u.id')
        ->leftJoin('tickets_priorities as p', 't.ticket_priority_id', '=', 'p.id')
        // Unimos la tabla de asignaciones
        ->leftJoin('tickets_users_assignations as tua', 't.id', '=', 'tua.ticket_id')
        // Filtramos solo los que NO tienen registro en la tabla de asignaciones
        ->whereNull('tua.ticket_id')
        ->where('t.status_id', 1)
        ->select(
            't.uid',
            't.title',
            't.description',
            'p.name as priority_name',
            's.name as services_name',
            't.created_at',
            'u.first_name as user_ticket_first_name',
            'u.last_name as user_ticket_last_name'
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