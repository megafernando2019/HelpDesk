<?php

namespace Modules\Tickets\Support\Dtos;

class TicketCardDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $uid,
        public readonly string $title,
        public readonly string $description,
        public readonly string $createdAt,
        public readonly string $serviceName,
        public readonly string $priorityName,
        public readonly ?string $priorityBgColor,
        public readonly ?string $priorityTextColor,
        public readonly ?int $assignedId,
        public readonly ?string $assignedUserName,
        public readonly ?int $priorityId,
        public readonly ?int $userId,
        public readonly ?string $observation,
        public readonly ?int $userAssingId,
        public readonly int $statusId
    ) {}

    
}