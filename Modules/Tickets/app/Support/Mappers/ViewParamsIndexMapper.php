<?php

namespace Modules\Tickets\Support\Mappers;

use Modules\Tickets\Support\Dtos\ViewParamsIndexDto;

class ViewParamsIndexMapper {

    private const STATUS_STYLES = [
        'por_asignar' => [
            'bg_color'   => '#faf8ff',
            'badge_bg'  => '#f0e8ff',
            'text_color' => '#8a5cf6',
            'icon'       => 'ti ti-user',
        ],
        'en_proceso' => [
            'bg_color'   => '#f3f6ff',
            'badge_bg'  => '#dbeafe',
            'text_color' => '#3b82f6',
            'icon'       => 'ti ti-progress-check',
        ],
        'en_espera' => [
            'bg_color'   => '#fafbfb',
            'badge_bg'  => '#f1f5f9',
            'text_color' => '#64748b',
            'icon'       => 'ti ti-clock',
        ],
        'solucionado' => [
            'bg_color'   => '#f2fdf5',
            'badge_bg'  => '#dcfce7',
            'text_color' => '#22c55e',
            'icon'       => 'ti ti-circle-check',
        ],
        'cerrado' => [
            'bg_color'   => '#fff9f1',
            'badge_bg'  => '#fef3c7',
            'text_color' => '#f59e0b',
            'icon'       => 'ti ti-lock-check',
        ],
        'cancelado' => [
            'bg_color'   => '#fffafa',
            'badge_bg'  => '#fee2e2',
            'text_color' => '#ef4444',
            'icon'       => 'ti ti-cancel',
        ],
    ];

    /**
     * Mapea colecciones o arreglos de orígenes hacia el DTO de la vista.
     */
    public static function map(mixed $priorities = null,
                               mixed $statuses = null,
                               mixed $count_details = null): ViewParamsIndexDto
    {
        $mappedStatuses = collect($statuses ?? [])->map(function ($status) use($count_details) {

            $key = strtolower(str_replace(' ', '_', is_array($status) ? $status['name'] ?? '' : $status->name ?? ''));

            $style = self::STATUS_STYLES[$key] ?? [
                'bg_color'   => '#ffffff',
                'badge_bg'  => '#f3f4f6',
                'text_color' => '#6b7280',
                'icon'       => 'ti ti-help-circle',
            ];

            if (is_array($status)) {
               
                return array_merge($status, $style);
            }

            $status->bg_color   = $style['bg_color'];
            $status->badge_bg  = $style['badge_bg'];
            $status->text_color = $style['text_color'];
            $status->icon       = $style['icon'];
            $status->tickets_count =  $count_details[$key] ?
            ($count_details[$key]['tickets_count'] ?? 0) : 0;

            return $status;
        });

        return new ViewParamsIndexDto(
            priorities: collect($priorities??[]),
            statuses: $mappedStatuses
        );
    }
}