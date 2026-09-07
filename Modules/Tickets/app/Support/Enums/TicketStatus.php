<?php

namespace Modules\Tickets\Support\Enums;

enum TicketStatus : string
{
    case PENDIENTE    = 'Pendiente';
    case POR_ASIGNAR = 'Por asignar';
    case EN_ESPERA   = 'En espera';
    case SOLUCIONADO = 'Solucionado';
    case CERRADO = 'Cerrado';
    case CANCELADO = 'Cancelado';

    /**
    * Retorna el ícono según el estatus
    */
    public function icon(): string
    {
        return match($this) {
            self::PENDIENTE     => 'ti ti-writing',
            self::POR_ASIGNAR     => 'ti ti-progress-check',
            self::EN_ESPERA   => 'ti ti-clock',
            self::CANCELADO => 'ti ti-cancel',
            self::CERRADO => 'ti ti-lock-check',
            self::SOLUCIONADO => 'ti ti-circle-check',
        };
    }

    /**
    * Obtiene el ícono pasando una cadena o null
    */
    public static function getIcon(?string $status): string
    {
        return self::tryFrom($status ?? '')?->icon() ?? 'ti ti-help-circle';
    }

}