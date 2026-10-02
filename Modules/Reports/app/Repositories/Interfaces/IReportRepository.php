<?php

namespace Modules\Reports\Repositories\Interfaces;

interface IReportRepository
{
    public function getCategorySummaryTicket(
        $teamId, 
        $membersId,
        $dateFrom,
        $dateTo
    );

    public function getServiceSummaryTicket(
        $teamId, 
        $membersId,
        $dateFrom,
        $dateTo
    );

    public function getUsersAssingsSummaryTicket(
        $teamId,
        $dateFrom,
        $dateTo
    );
}
