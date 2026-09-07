<?php

namespace Modules\Tickets\Support\Enums;

enum TicketAction: string
{
    case ASSIGN_TICKET    = 'ACT01AEU';
    case STATUS_IN_PROGRESS = 'ACT42LSD';
    case STATUS_PENDING   = 'ACT11JHH';
    case STATUS_SOLVED    = 'ACT87WEH';
    case STATUS_CLOSED    = 'ACT49PHW';
    case STATUS_CANCELLED = 'ACT25INE';
    case ADD_COMMENT      = 'ACT99PQA';
    case REMOVE_TICKET    = 'ACT54SZX';
    case REASSIGN_TICKET  = 'ACT28NQL';
    case CREATE_TICKET    = 'ACT33AHJ';
    case OBSERVE_TICKET   = 'ACT08TLO';

    /**
     * Plantillas para los mensajes de los logs
     *
     * @param array $data
     * @return string
     */
    public function formatDescription(array $data = []): string
    {
        $user = $data['user_name'] ?? 'Un usuario';
        $ticket = $data['ticket_code'] ?? '';
        $observation = $data['observation'] ?? '';

        return match($this) {
            self::CREATE_TICKET     => "El usuario {$user} creó el ticket {$ticket}",
            self::ASSIGN_TICKET     => "El ticket {$ticket} fue asignado a " . ($data['assigned_to'] ?? ''),
            self::REASSIGN_TICKET   => "El ticket {$ticket} fue reasignado a " . ($data['assigned_to'] ?? '') . " por {$user}",
            self::STATUS_IN_PROGRESS => "El ticket {$ticket} cambió de estatus a En proceso",
            self::STATUS_PENDING    => "El ticket {$ticket} cambió de estatus a En espera",
            self::STATUS_SOLVED     => "El ticket {$ticket} fue solucionado",
            self::STATUS_CLOSED     => "El ticket {$ticket} fue cerrado",
            self::STATUS_CANCELLED  => "El ticket {$ticket} fue cancelado",
            self::ADD_COMMENT       => "{$user} realizó una observación en el ticket {$ticket}",
            self::OBSERVE_TICKET    => "El usuario {$user} ha agregado la siguiente observación: {$observation}",
            self::REMOVE_TICKET     => "{$user} retiró el ticket {$ticket}",
        };
    }

    /**
     * Retorna las clases de estilo de Bootstrap 5 según la acción.
     */
    public function badgeClasses(): string
    {
        return match($this) {
            self::CREATE_TICKET     => 'bg-info-subtle text-info-emphasis',
            self::ASSIGN_TICKET     => 'bg-warning-subtle text-warning-emphasis',
            self::REASSIGN_TICKET   => 'bg-secondary-subtle text-secondary-emphasis',
            self::STATUS_IN_PROGRESS => 'bg-primary-subtle text-primary-emphasis',
            self::STATUS_PENDING    => 'bg-danger-subtle text-danger-emphasis',
            self::STATUS_SOLVED     => 'bg-success-subtle text-success-emphasis',
            self::STATUS_CLOSED     => 'bg-light-subtle text-dark border',
            self::STATUS_CANCELLED  => 'bg-danger-subtle text-danger',
            self::ADD_COMMENT,      
            self::OBSERVE_TICKET    => 'bg-info-subtle text-info',
            self::REMOVE_TICKET     => 'bg-secondary-subtle text-secondary',
        };
    }

    /**
     * Retorna el ícono según la acción.
     */
    public function icon(): string
    {
        return match($this) {
            self::CREATE_TICKET     => 'ti ti-writing',
            self::ASSIGN_TICKET     => 'ti ti-user-check',
            self::REASSIGN_TICKET   => 'ti ti-replace-user',
            self::STATUS_IN_PROGRESS => 'ti ti-progress-check',
            self::STATUS_PENDING    => 'ti ti-clock-pause',
            self::STATUS_SOLVED     => 'ti ti-circle-check',
            self::STATUS_CLOSED     => 'ti ti-lock-check',
            self::STATUS_CANCELLED  => 'ti ti-circle-x',
            self::ADD_COMMENT       => 'ti ti-message-dots',
            self::OBSERVE_TICKET    => 'ti ti-edit-circle',
            self::REMOVE_TICKET     => 'ti ti-user-minus',
        };
    }
}