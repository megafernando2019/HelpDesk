<?php

namespace Modules\Tickets\Support\Enums;

enum TicketStatus : string
{
    case EN_PROCESO    = 'En proceso';
    case POR_ASIGNAR = 'Por asignar';
    case EN_ESPERA   = 'En espera';
    case SOLUCIONADO = 'Solucionado';
    case CERRADO = 'Cerrado';
    case CANCELADO = 'Cancelado';


    /**
     * Retorna la etiqueta legible del estatus.
     */
    public function label(): string
    {
        return $this->value;
    }

    /**
     * Traduce un status_id numérico de la base de datos al nombre legible del estatus.
     *
     * @param int|string|null $statusId
     * @return string
     */
    public static function getNameById($statusId): string
    {
        return match ((int) $statusId) {
            1 => self::POR_ASIGNAR->value,
            2 => self::EN_PROCESO->value, 
            3 => self::EN_ESPERA->value,
            4 => self::SOLUCIONADO->value,
            5 => self::CERRADO->value,
            6 => self::CANCELADO->value,
            default => 'Desconocido',
        };
    }

    /**
    * Retorna el ícono según el estatus
    */
    public function icon(): string
    {
        return match($this) {
            self::EN_PROCESO     => 'ti ti-progress-check',
            self::POR_ASIGNAR     => 'ti ti-user',
            self::EN_ESPERA   => 'ti ti-clock',
            self::CANCELADO => 'ti ti-cancel',
            self::CERRADO => 'ti ti-lock-check',
            self::SOLUCIONADO => 'ti ti-circle-check',
        };
    }


    /**
     * Retorna el color Hexadecimal de fondo según el estatus
     */
    public function bgColor(): string
    {
        return match($this) {
            self::EN_PROCESO   => '#f3f6ff', // Corresponde a "En proceso"
            self::POR_ASIGNAR => '#faf8ff',
            self::EN_ESPERA   => '#fafbfb',
            self::SOLUCIONADO => '#f2fdf5',
            self::CERRADO     => '#fff9f1',
            self::CANCELADO   => '#fffafa',
        };
    }

    /**
     * Retorna la clase badge de Bootstrap / Tabler para estilos
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::EN_PROCESO   => 'bg-primary-subtle text-primary',
            self::POR_ASIGNAR => 'bg-purple-subtle text-purple',
            self::EN_ESPERA   => 'bg-secondary-subtle text-secondary',
            self::SOLUCIONADO => 'bg-success-subtle text-success',
            self::CERRADO     => 'bg-warning-subtle text-warning',
            self::CANCELADO   => 'bg-danger-subtle text-danger',
        };
    }

    /**
     * Obtiene el color Hexadecimal pasando una cadena o null
     */
    public static function getBgColor(?string $status): string
    {
        return self::tryFrom($status ?? '')?->bgColor() ?? '#ffffff';
    }

    /**
     * Obtiene la clase de badge pasando una cadena o null
     */
    public static function getBadgeClass(?string $status): string
    {
        return self::tryFrom($status ?? '')?->badgeClass() ?? 'bg-light text-dark';
    }

    /**
    * Obtiene el ícono pasando una cadena o null
    */
    public static function getIcon(?string $status): string
    {
        return self::tryFrom($status ?? '')?->icon() ?? 'ti ti-help-circle';
    }

}