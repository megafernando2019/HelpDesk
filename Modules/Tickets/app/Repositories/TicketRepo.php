<?php

namespace Modules\Tickets\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Illuminate\Support\Facades\DB;

class TicketRepo implements ITicketRepo {

    public function getStatus()
    {
       return DB::table('status')->select('id', 'name')->get();
    }

    public function getPriorities()
    {
       return DB::table('tickets_priorities')->select('id', 'name')->get();
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

        // Subconsulta optimizada para obtener el primer usuario asignado por ticket
        $firstAssignation = DB::table('tickets_users_assignations as tua')
            ->select('tua.ticket_id', DB::raw('MIN(tua.user_id) as user_id'))
            ->groupBy('tua.ticket_id');

        return DB::table('tickets as t')
            ->select([
                't.id',
                't.uid',
                't.title',
                't.description',
                't.created_at',
                't.status_id',
                'ts.name as service_name',
                'tp.name as priority_name',
                'u.id as assigned_id',
                'u.first_name as assigned_first_name',
                'u.last_name as assigned_last_name',
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
            ->leftJoinSub($firstAssignation, 'fa', function ($join) {
                $join->on('fa.ticket_id', '=', 't.id');
            })
            ->leftJoin('users as u', 'u.id', '=', 'fa.user_id')
            ->orderByDesc('t.id')
            ->get();
    }
}