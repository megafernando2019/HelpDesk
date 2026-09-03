<?php

namespace Modules\Tickets\Support\Dtos;

class TicketLogDetailsDto
{
    public function __construct(
        public readonly string $message,
        public readonly string $bgColor,
        public readonly string $icon,
        public readonly string $formatDate
    )
    {
        
    }
}
