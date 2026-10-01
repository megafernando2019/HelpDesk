<?php

namespace Modules\Reports\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Reports\Repositories\Interfaces\IReportRepository;

class ReportRepository implements IReportRepository {

    public function getCategorySummaryTicket(
        $teamId, 
        $membersId,
        $dateFrom,
        $dateTo
    )
    {
        return DB::table('tickets_categories as tc')
                ->whereIn('tc.team_id', $teamId)
                ->leftJoin('tickets_services as ts', 'ts.category_id', '=', 'tc.id')
                ->leftJoin('tickets as t', function ($q) use (
                    $teamId,$dateFrom,$dateTo) {
                    $q->on('t.ticket_service_id', '=', 'ts.id')
                         ->whereIn('t.team_id', $teamId);

                    if ($dateFrom && $dateTo) {
                        $q->whereBetween('t.created_at', [$dateFrom, $dateTo]);
                    }
                })
                ->when(!empty($membersId), function($q) use ($membersId) {
                    $q->join('tickets_users_assignations as us', 't.id', '=', 'us.ticket_id')
                      ->whereIn('us.user_id', $membersId);
                })
                ->select(
                    'tc.id as category_id',
                    'tc.name as category_name',
                    DB::raw('COUNT(t.id) as total_tickets'),
                    DB::raw('SUM(CASE WHEN t.status_id = 1 THEN 1 ELSE 0 END) as por_asignar'),
                    DB::raw('SUM(CASE WHEN t.status_id = 2 THEN 1 ELSE 0 END) as en_proceso'),
                    DB::raw('SUM(CASE WHEN t.status_id = 3 THEN 1 ELSE 0 END) as en_espera'),
                    DB::raw('SUM(CASE WHEN t.status_id = 4 THEN 1 ELSE 0 END) as solucionados'),
                    DB::raw('SUM(CASE WHEN t.status_id = 5 THEN 1 ELSE 0 END) as cerrados'),
                    DB::raw('SUM(CASE WHEN t.status_id = 6 THEN 1 ELSE 0 END) as cancelados'),
                    DB::raw('SUM(CASE WHEN t.status_id = 4 THEN TIMESTAMPDIFF(HOUR, t.created_at, t.updated_at) ELSE 0 END) as total_horas_solucion')
                )
                 ->groupBy('tc.id','tc.name')
                 ->havingRaw('COUNT(t.id) > 0')
                 ->simplePaginate('5');
    }

}