<?php

namespace Modules\User\app\Support\Dtos;

use Illuminate\Support\Collection;

class MembersDto
{
    public function __construct(
        public readonly int $team_id,
        public readonly string $team_name,
        public readonly int $team_is_active,
        public readonly array|Collection $members = []
    ) {}
}