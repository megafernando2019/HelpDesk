<?php

namespace Modules\Tickets\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Repositories\Interfaces\ITicketRepo;

class TicketLogService
{
    public function __construct(
       private readonly ITicketRepo $repo
    )
    {
        
    }

    public function logAction(
        $ticket,
        $enum_action,
        $resource_name,
        $section_name,
        $selectedName = null,
    )
    {
        $data = [
            'user_name' => sprintf(
                '%s %s',
                Auth::user()->first_name,
                Auth::user()->last_name
            ),
            'assigned_to' => $selectedName,
            'ticket' => $ticket?->uid ?? '',
            'observation' => $ticket?->observation?->description ?? ''
        ];

        $record = [
            'ticket_id' => $ticket?->id,
            'user_id' => Auth::user()->id,
            'event_type' => $enum_action->value,
            'message' => $enum_action->formatDescription($data),
            'resource_name' => $resource_name,
            'section_name' => $section_name,
            'values' => $ticket?->toJson()
        ];

        $this->repo->saveLog($record);
        
    }

}
