<?php

namespace Modules\Tickets\Services;

use Modules\Tickets\Repositories\Interfaces\ITicketRepo;

class TicketLogService
{

    const CREATE_TICKET = 'created_ticket';
    const ASSIGN_USER = 'assing_user';
    const REASSING_USER = 'reassing_user';

    public function __construct(
       private readonly ITicketRepo $repo
    )
    {
        
    }


}
