<?php

namespace Modules\Tickets\app\Support\Exceptions;

use Exception;

class TicketException extends Exception
{
    public function __construct(
        string $message
    )  {
        parent::__construct($message);
    }
}
