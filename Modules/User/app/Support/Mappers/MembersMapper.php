<?php

namespace Modules\User\app\Support\Mappers;

use App\Helpers\GetInitials;
use App\Models\User;
use Illuminate\Support\Collection;
use Modules\User\app\Support\Dtos\MembersDto;

class MembersMapper
{
    public function __construct(
        protected GetInitials $getInitials
    ) {}

    /**
     * Mapea de forma flexible la lista de miembros a un array agregando las iniciales.
     *
     * @param mixed $members
     * @return array
     */
    protected function mapMembers($members): array
    {
        if (empty($members)) {
            return [];
        }

        // Si es una colección de Eloquent, la convertimos a iterable
        $items = $members instanceof Collection ? $members : collect($members);

        return $items->map(function ($member) {
            // Aseguramos formato array para no romper si viene como modelo o array
            $memberData = is_array($member) ? $member : $member->toArray();

            $firstName = $memberData['first_name'] ?? '';
            $lastName = $memberData['last_name'] ?? '';
            
            $fullName = trim(sprintf('%s %s', $firstName, $lastName));

            // Agregamos el campo initials al array del miembro
            $memberData['initials'] = ($this->getInitials)($fullName);

            return $memberData;
        })->toArray();
    }

    /**
     * Mapea un único modelo Team a MemberDto.
     */
    public function toDto($team)
    {
        $fullName = sprintf('%s %s', $team?->user?->first_name ?? '', $team?->user?->last_name ?? '');
        $initials = ($this->getInitials)($fullName);

        return new MembersDto(
            team_id: $team->id ?? 0,
            team_name: $team?->name ?? 'Dato no disponible',
            team_is_active: $team?->is_active ?? 0,
            members: $this->mapMembers($team?->members)
        );
    }

    /**
     * Mapea una colección a una colección de MemberDto.
     *
     * @param Collection<Any> $args
     * @return Collection<MembersDto>
     */
    public function toDtoCollection($args): Collection
    {
        return $args->map(fn ($team) => $this->toDto($team));
    }
}