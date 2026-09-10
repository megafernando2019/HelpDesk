<?php

namespace Modules\Tickets\Support\Enums;

enum TicketPriorityColor: string
{
    CASE BAJA = 'baja';
    CASE MEDIA = 'media';
    CASE ALTA = 'alta';
    CASE MUY_ALTA = 'muy alta';

    public function textColor(): string
    {
        return match($this) {
            self::BAJA => '#eab308',
            self::MEDIA => '#fa995c ',
            self::ALTA => '#ff5757',
            self::MUY_ALTA => '#aa1515',
            default => '#6b7280',
        };
    }

    public function bgColor(): string
    {
        return match($this) {
            self::BAJA => '#eab3081a',
            self::MEDIA => '#fa995c1a',
            self::ALTA => '#ff57571a',
            self::MUY_ALTA => '#aa15151a',
            default => '#6b7280',
        };
    }

    // Método estático para obtener la configuración limpia enviando el string de prioridad
    public static function getColorConfig(?string $priorityName): array
    {
        $priority = self::tryFrom(mb_strtolower(trim($priorityName ?? '')));

        return [
            'text' => $priority?->textColor() ?? '#6b7280',
            'bg'   => $priority?->bgColor() ?? '#6b72801a',
        ];
    }
}