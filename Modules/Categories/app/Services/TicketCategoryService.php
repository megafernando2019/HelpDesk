<?php

namespace Modules\Categories\Services;

use Modules\Categories\Repositories\Interfaces\ITicketCategoryRepo;

class TicketCategoryService
{
    public function __construct(private readonly ITicketCategoryRepo $repo) {
        
    }

    public function getCategoriesByTeam($request)
    {
        $team_id = (int) $request->team_id ?? 0;
        return $this->repo->getCategoriesByTeam($team_id);
    }
}
