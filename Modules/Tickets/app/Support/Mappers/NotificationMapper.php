<?php

namespace Modules\Tickets\Support\Mappers;

use Modules\Tickets\Support\Dtos\NotificationDto;
use Modules\Tickets\Support\Enums\TicketAction;
use Modules\Tickets\Support\Enums\TicketStatus;

class NotificationMapper
{
    public static function fromModel($notification)
    {
        $actionEnum = TicketAction::tryFrom($notification?->ticket_action_folio ?? '');
        $ticketUrl = $notification->ticket_id ? route('tickets.show', $notification->ticket_folio) : '#';
        $matched = '';

        if (preg_match('/“([^"]*)”/', $notification->description, $coincidencias)) {
          
            $matched = $coincidencias[1]; 
        }


        return new NotificationDto(
            id: $notification->id ?? 0,
            ticketId: $notification?->ticket_id ?? 0,
            ticket_action_id: $notification->ticket_action_id,
            title: $notification->title ?? '',
            ticketUrl: $ticketUrl,
            matched: str_replace(
                $matched, 
                sprintf(
                                '<a href="%s" style="
                                    text-decoration: underline !important;
                                " target="_blank" rel="noopener noreferrer">%s</a>',
                                $ticketUrl,
                                $matched
                        ), 
                $notification->description),
            description: $notification->description ?? '',
            createdAt: $notification->created_at ?? '',
            readAt: $notification->read_at ?? '',
            icon: $actionEnum->icon($actionEnum->value),
            bgColor: '',
            badgeClass: $actionEnum->badgeClasses($actionEnum->value)
        );
    }

    public static function collection($notifications): array
    {
        return collect($notifications)->map(function ($notification) {
            return self::fromModel($notification)->toArray();
        })->all();
    }
}