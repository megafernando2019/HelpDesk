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
}
