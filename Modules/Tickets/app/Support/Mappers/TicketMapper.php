<?php

namespace Modules\Tickets\Support\Mappers;

use Carbon\Carbon;
use Modules\Tickets\Support\Dtos\TicketCardDto;

final class TicketMapper {

    public static function toDto($ticket): TicketCardDto
    {
        $assignedName = trim(($ticket?->assigned_first_name ?? '') . ' ' . ($ticket?->assigned_last_name ?? ''));

        $formattedDate = 'Creado el ' . Carbon::parse($ticket?->created_at)->locale('es')->isoFormat('DD [de] MMMM, YYYY');

        return new TicketCardDto(
            id: $ticket?->id,
            uid: $ticket?->uid ?? "Dato no disponible",
            title: $ticket?->title ?? '',
            description: $ticket?->description ?? '',
            createdAt: $formattedDate,
            serviceName: $ticket?->service_name ?? 'Dato no disponible',
            priorityName: $ticket?->priority_name ?? 'Dato no disponible',
            priorityBgColor: $ticket?->priority?->bg_color ?? '#FFF8DD',
            priorityTextColor: $ticket?->priority?->text_color ?? '#F1416C',
            assignedId: $ticket?->assigned_id ?? 0,
            assignedUserName: $assignedName,
            statusId: (int) $ticket?->status_id
        );
    }

    public static function toCollection($args)
    {
        return collect($args)->map(fn($ticket) => self::toDto($ticket));
    }
    
}