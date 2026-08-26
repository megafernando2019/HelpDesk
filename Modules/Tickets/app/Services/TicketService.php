<?php

namespace Modules\Tickets\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Modules\Tickets\Support\Mappers\TicketMapper;
use Modules\Tickets\Support\Mappers\ViewParamsIndexMapper;

class TicketService {

    public function __construct(
       private readonly ITicketRepo $repo
    ) {
       
    }

    public function getAllStatus() 
    {
       return $this->repo->getStatus();
    }

    public function getAllPriorities()
    {
       return $this->repo->getPriorities();
    }

    public function getDetailsIndex()
    {
        $count_details = [];
        $priorities = $this->repo->getPriorities();
        $statuses = $this->repo->getStatus();

        $user_id = Auth::user()->id;

        $count_details_ctx = $this->repo->getStatusesWithCount($user_id);

        if($count_details_ctx->isNotEmpty()) {
            foreach ($count_details_ctx as $value) {
                
                $key = strtolower(str_replace(' ', '_', $value->name ?? ''));
                $count_details[$key] = [
                    'name' => $value?->name ?? '',
                    'tickets_count' =>  $value->tickets_count ?? 0
                ];
                
            }
        }

        //mapper aqui para la vista
        return ViewParamsIndexMapper::map(
            $priorities, $statuses, $count_details
        );
    }

    public function getDataIndexCard($request)
    {
        $user_id = Auth::user()->id;
        $ticket_status = (int) $request->ticket_status ?? 1;
        $priority = (int) $request->priority ?? 0;
        $startDate = $request->start_date ?? null;
        $endDate = $request->end_date ?? null;

        if ($startDate === "null") {
            $startDate = null;
        }

        if ($endDate === "null") {
            $endDate = "null";
        }

        $ctx = $this->repo->applyFilters(
            $ticket_status,
            $user_id,
            $priority,
            $startDate,
            $endDate
        );

        return TicketMapper::toCollection(
            $ctx
        );

    }
}