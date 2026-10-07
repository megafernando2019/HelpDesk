<?php

namespace Modules\Reports\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Reports\Repositories\Interfaces\IReportRepository;

class ReportRepository implements IReportRepository {

    public function getSummaryReportUsersAssing(
        $teamId,
        $dateFrom = null,
        $dateTo = null
    ) {
        // Normalizar a array si viene un valor único
        $teamIds = is_array($teamId) ? $teamId : [$teamId];

        // Subconsulta para obtener el total global de tickets asignados en el rango/equipo
        $totalPlatformTicketsSubquery = DB::table('tickets_users_assignations as us_sub')
            ->join('tickets as t_sub', 't_sub.id', '=', 'us_sub.ticket_id')
            ->whereIn('t_sub.team_id', $teamIds)
            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('us_sub.created_at', [$dateFrom, $dateTo]);
            })
            ->selectRaw('COUNT(DISTINCT t_sub.id)');

        return DB::table('users as u')
            ->join('tickets_users_assignations as us', 'us.user_id', '=', 'u.id')
            ->join('tickets as t', function ($join) use ($teamIds) {
                $join->on('t.id', '=', 'us.ticket_id')
                     ->whereIn('t.team_id', $teamIds);
            })
            ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('us.created_at', [$dateFrom, $dateTo]);
            })
            ->select(
                'u.id as user_id',
                'u.first_name as user_first_name',
                'u.last_name as user_last_name',
                DB::raw('COUNT(DISTINCT t.id) as total_tickets'),
                // Subconsulta integrada para obtener el total de asignados
                DB::raw('(' . $totalPlatformTicketsSubquery->toSql() . ') as total_platform_tickets'),
                // Desglose de estatus
                DB::raw('SUM(CASE WHEN t.status_id = 2 THEN 1 ELSE 0 END) as en_proceso'),
                DB::raw('SUM(CASE WHEN t.status_id = 3 THEN 1 ELSE 0 END) as en_espera'),
                DB::raw('SUM(CASE WHEN t.status_id = 4 THEN 1 ELSE 0 END) as solucionados'),
                DB::raw('SUM(CASE WHEN t.status_id = 5 THEN 1 ELSE 0 END) as cerrados'),
                DB::raw('SUM(CASE WHEN t.status_id = 6 THEN 1 ELSE 0 END) as cancelados'),
                // Cumplimiento = (Solucionados / Asignados al usuario) * 100
                DB::raw('ROUND((SUM(CASE WHEN t.status_id = 4 THEN 1 ELSE 0 END) / NULLIF(COUNT(DISTINCT t.id), 0)) * 100, 2) as compliance'),
                // TPS (Tiempo Promedio de Solución en Días)
                DB::raw('ROUND(AVG(CASE WHEN t.status_id = 4 THEN TIMESTAMPDIFF(HOUR, t.created_at, t.updated_at) / 24.0 ELSE NULL END), 1) as tps_dias'),
                // TC (Tasa de Cierre = Cerrados / Solucionados * 100)
                DB::raw('ROUND((SUM(CASE WHEN t.status_id = 5 THEN 1 ELSE 0 END) / NULLIF(SUM(CASE WHEN t.status_id = 4 THEN 1 ELSE 0 END), 0)) * 100, 2) as tasa_cierre')
            )
            // Pasamos los bindings de la subconsulta
            ->mergeBindings($totalPlatformTicketsSubquery)
            ->groupBy('u.id', 'u.first_name', 'u.last_name')
            ->havingRaw('COUNT(DISTINCT t.id) > 0')
            ->simplePaginate(5);
    }

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

    public function getServiceSummaryTicket(
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
                    'ts.id as service_id',
                    'ts.name as service_name',
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
                 ->groupBy('ts.id','ts.name', 'tc.name')
                 ->havingRaw('COUNT(t.id) > 0')
                 ->simplePaginate('5');
    }

    public function getUsersAssingsSummaryTicket(
        $teamId,
        $dateFrom,
        $dateTo
    ) {
        /*
         * Tickets recibidos por el equipo durante el periodo.
         *
         * Esta consulta se mantiene como subconsulta porque
         * necesitamos el total global para calcular la carga.
         */
        $ticketsReceived = DB::table('tickets as tr')
            ->whereIn('tr.team_id', $teamId)
            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('tr.created_at', [$dateFrom, $dateTo]);
            });

        /*
         * Total de tickets recibidos.
         */
        $totalTicketsReceived = $ticketsReceived
            ->clone()
            ->selectRaw('COUNT(*) as total');

        /*
         * Tickets del periodo que tienen asignación.
         */
        $assignedTickets = DB::table('tickets_users_assignations as tua')
            ->joinSub(
                $ticketsReceived,
                't',
                function ($join) {
                    $join->on('t.id', '=', 'tua.ticket_id');
                }
            )
            ->join('users as u', 'u.id', '=', 'tua.user_id');

        return $assignedTickets
            ->crossJoinSub(
                $totalTicketsReceived,
                'received'
            )

            ->select(
                'tua.user_id',
                'u.name as user_name',

                /*
                 * Total asignados.
                 */
                DB::raw('COUNT(DISTINCT t.id) as total_asignados'),

                /*
                 * Total recibidos por el equipo.
                 */
                DB::raw('received.total as total_tickets_recibidos'),

                /*
                 * 2 / 20
                 */
                DB::raw("
                    CONCAT(
                        COUNT(DISTINCT t.id),
                        ' / ',
                        received.total
                    ) as carga_actual
                "),

                /*
                 * Porcentaje.
                 */
                DB::raw("
                    ROUND(
                        COUNT(DISTINCT t.id)
                        / NULLIF(received.total, 0)
                        * 100,
                        2
                    ) as carga_actual_porcentaje
                "),

                /*
                 * Estados.
                 */
                DB::raw("
                    COUNT(DISTINCT CASE
                        WHEN t.status_id = 1 THEN t.id
                    END) as por_asignar
                "),

                DB::raw("
                    COUNT(DISTINCT CASE
                        WHEN t.status_id = 2 THEN t.id
                    END) as en_proceso
                "),

                DB::raw("
                    COUNT(DISTINCT CASE
                        WHEN t.status_id = 3 THEN t.id
                    END) as en_espera
                "),

                DB::raw("
                    COUNT(DISTINCT CASE
                        WHEN t.status_id = 4 THEN t.id
                    END) as solucionados
                "),

                DB::raw("
                    COUNT(DISTINCT CASE
                        WHEN t.status_id = 5 THEN t.id
                    END) as cerrados
                "),

                DB::raw("
                    COUNT(DISTINCT CASE
                        WHEN t.status_id = 6 THEN t.id
                    END) as cancelados
                "),

                /*
                 * Horas de solución.
                 */
                DB::raw("
                    SUM(
                        CASE
                            WHEN t.status_id = 4
                            THEN TIMESTAMPDIFF(
                                HOUR,
                                t.created_at,
                                t.updated_at
                            )
                            ELSE 0
                        END
                    ) as total_horas_solucion
                ")
            )

            ->groupBy(
                'tua.user_id',
                'u.name',
                'received.total'
            )
            ->orderBy('u.name')
            ->simplePaginate(5);
    }
   
    // public function getUsersAssingsSummaryTicket(
    //     $teamId, 
    //     $membersId,
    //     $dateFrom,
    //     $dateTo
    // )
    // {
    //     return DB::table('tickets_categories as tc')
    //             ->whereIn('tc.team_id', $teamId)
    //             ->leftJoin('tickets_services as ts', 'ts.category_id', '=', 'tc.id')
    //             ->leftJoin('tickets as t', function ($q) use (
    //                 $teamId,$dateFrom,$dateTo) {
    //                 $q->on('t.ticket_service_id', '=', 'ts.id')
    //                      ->whereIn('t.team_id', $teamId);

    //                 if ($dateFrom && $dateTo) {
    //                     $q->whereBetween('t.created_at', [$dateFrom, $dateTo]);
    //                 }
    //             })
    //             ->when(!empty($membersId), function($q) use ($membersId) {
    //                 $q->join('tickets_users_assignations as us', 't.id', '=', 'us.ticket_id')
    //                   ->whereIn('us.user_id', $membersId);
    //             })
    //             ->select(
    //                 'ts.id as service_id',
    //                 'ts.name as service_name',
    //                 'tc.name as category_name',
    //                 DB::raw('COUNT(t.id) as total_tickets'),
    //                 DB::raw('SUM(CASE WHEN t.status_id = 1 THEN 1 ELSE 0 END) as por_asignar'),
    //                 DB::raw('SUM(CASE WHEN t.status_id = 2 THEN 1 ELSE 0 END) as en_proceso'),
    //                 DB::raw('SUM(CASE WHEN t.status_id = 3 THEN 1 ELSE 0 END) as en_espera'),
    //                 DB::raw('SUM(CASE WHEN t.status_id = 4 THEN 1 ELSE 0 END) as solucionados'),
    //                 DB::raw('SUM(CASE WHEN t.status_id = 5 THEN 1 ELSE 0 END) as cerrados'),
    //                 DB::raw('SUM(CASE WHEN t.status_id = 6 THEN 1 ELSE 0 END) as cancelados'),
    //                 DB::raw('SUM(CASE WHEN t.status_id = 4 THEN TIMESTAMPDIFF(HOUR, t.created_at, t.updated_at) ELSE 0 END) as total_horas_solucion')
    //             )
    //              ->groupBy('ts.id','ts.name', 'tc.name')
    //              ->havingRaw('COUNT(t.id) > 0')
    //              ->simplePaginate('5');
    // }

}