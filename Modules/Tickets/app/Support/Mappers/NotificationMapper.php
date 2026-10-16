<?php

namespace Modules\Tickets\Support\Mappers;

use Modules\Tickets\Support\Dtos\NotificationDto;
use Modules\Tickets\Support\Enums\TicketStatus;

class NotificationMapper
{
    public static function fromModel($notification)
    {
      
        $statusName = TicketStatus::getNameById($notification?->ticket_action_id ?? 0);
        $statusEnum = TicketStatus::tryFrom($statusName);
        $ticketUrl = $notification->ticket_id ? route('tickets.show', $notification->ticket_id) : '#';

        return new NotificationDto(
            id: $notification->id ?? 0,
            ticketId: $notification?->ticket_id ?? 0,
            ticket_action_id: $notification->ticket_action_id,
            title: $notification->title ?? '',
            ticketUrl: $ticketUrl,
            description: $notification->description ?? '',
            createdAt: $notification->created_at ?? '',
            readAt: $notification->read_at ?? '',
            icon: TicketStatus::getIcon($statusName),
            bgColor: TicketStatus::getBgColor($statusName),
            badgeClass: TicketStatus::getBadgeClass($statusName)
        );
    }

    public static function collection($notifications): array
    {
        return collect($notifications)->map(function ($notification) {
            return self::fromModel($notification)->toArray();
        })->all();
    }
}