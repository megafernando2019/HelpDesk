<?php

namespace Modules\Categories\Repositories\Interfaces;

interface ITicketCategoryRepo
{
    public function getCategoriesByTeam($team_id);
}

