<?php

namespace Modules\Reports\Services;

use Carbon\Carbon;
use Modules\Reports\Repositories\ReportRepository;

class ReportService {

   public function __construct(
      private readonly ReportRepository $repo
   )
   {
     
   }

   /**
    * Manejo de data por categoria de modulo
    *
    * @param [type] $request
    * @return void
    */
   public function getSummaryReportsModule($request)
   {
      $module = $request?->module ?? null;
      $teamId = $request?->team_id ?? null;
      $membersId = $request?->members_id ?? [];
      $dateRange =  $request->date_range ?? null;
      $dateFrom = null;
      $dateTo = null;

      if (!empty($dateRange)) {
            //Seperarar fechas
            $dateRangeValues = str_replace('a', ',', $dateRange);
            $dates = explode(',', $dateRangeValues);

            $dateFromStr = trim($dates[0]);
            $dateToStr   = isset($dates[1]) ? trim($dates[1]) : $dateFromStr;

            $currentStart = Carbon::parse($dateFromStr);
            $currentEnd   = Carbon::parse($dateToStr);

            // Fechas formateadas para la consulta actual
            $dateFrom = $currentStart->format('Y-m-d 00:00:00');
            $dateTo   = $currentEnd->format('Y-m-d 23:59:59');
        } else {
            //Fechas de un mes por defecto
            $dateFrom = now()->subMonth()->startOfDay()->format('Y-m-d H:i:s');
            $dateTo   = now()->endOfDay()->format('Y-m-d H:i:s');
        }
         
      return match ($module) {
         'categories' => $this->repo->getCategorySummaryTicket(
                        $teamId, 
                        $membersId,
                        $dateFrom,
                        $dateTo
         ),
         'services' => $this->repo->getServiceSummaryTicket(
                     $teamId, 
                     $membersId,
                     $dateFrom,
                     $dateTo
         ),
         'users_assing' => $this->repo->getSummaryReportUsersAssing(
                    $teamId,
                    $dateFrom,
                    $dateTo
         ), 

         default => collect()
      };
   }

   public function calculateMetrics($args)
   {
      if ($args->isEmpty()) {
         return;
      }
     
      return $args->through(function($a) {
         $completed = (int) $a?->solucionados ?? 0;
         $assings_total = (int) $a?->total_tickets ?? 0;

         $percentaje = $assings_total > 0 
             ? round(($completed / $assings_total) * 100, 2) 
             : 0;

         $a->compliance = $percentaje . '%';

         $totalHoursSolved = $a?->total_horas_solucion ?? 0;

         //  Calculo del TPS
         if ($completed > 0 && $totalHoursSolved > 0) {
               $averageHourly = $totalHoursSolved / $completed;

               if ($averageHourly < 24) {
                   $a->tps = round($averageHourly, 1) . ' hrs';
               } else {
                   $days = round($averageHourly / 24, 1);
                   $a->tps = $days == 1 ? '1 día' : $days . ' días';
               }
         } else {
               $a->tps = '0 hrs';
         }

         return $a;
      });

   }


}