<?php

namespace Modules\Tickets\Support\Dtos;

use Illuminate\Support\Collection;

class ViewParamsIndexDto {
    public function __construct(
        public readonly Collection $priorities,
        public readonly Collection $statuses
    ) {}

    public function toArray(): array
    {
        return [
            'priorities' => $this->priorities,
            'statuses' => $this->statuses,
        ];
    }
}