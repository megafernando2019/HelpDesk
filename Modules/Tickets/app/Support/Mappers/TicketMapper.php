<?php

namespace Modules\Tickets\Support\Mappers;

use Carbon\Carbon;
use Modules\Tickets\Models\TicketLog;
use Modules\Tickets\Support\Dtos\TicketCardDto;
use Modules\Tickets\Support\Dtos\TicketLogDetailsDto;
use Modules\Tickets\Support\Enums\TicketAction;

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
            priorityId: $ticket?->ticket_priority_id ?? 0,
            userId: $ticket?->user_id ?? 0,
            observation: $ticket?->observation ?? '',
            userAssingId: (int) $ticket?->user_assing_id ?? 0,
            statusId: (int) $ticket?->status_id ?? 0
        );
    }

    public static function toCollection($args)
    {
        return collect($args)->map(fn($ticket) => self::toDto($ticket));
    }


    public static function toDetailsLogsDto($entity): TicketLogDetailsDto
    {
       // $entity simpre trabajara como objeto
       if (is_array($entity)) {
            $entity = (object) $entity;
       }
        
       $enum = TicketAction::tryFrom($entity->event_type);
       $bgColor = $enum->badgeClasses();
       $icon = $enum->icon();

       return new TicketLogDetailsDto(
           message: $entity->message ?? 'Dato no disponible',
           bgColor: $bgColor,
           icon: $icon,
           formatDate: sprintf(
             '%s a las %s',
              Carbon::parse($entity?->created_at)?->format('d/m/Y'),
              Carbon::parse($entity?->created_at)?->format('h:i a')
           )
       );
    }

    public static function toCollectionTicketLogs($args)
    {
        return collect($args)->map(fn($log) => self::toDetailsLogsDto($log));
    }
    
}