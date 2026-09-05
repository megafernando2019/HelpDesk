<?php

namespace Modules\Categories\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Categories\Repositories\Interfaces\ITicketCategoryRepo;

class TicketCategoryRepo implements ITicketCategoryRepo
{
    public function getCategoriesByTeam($team_id)
    {
        return DB::table('tickets_categories')->where('team_id', $team_id)->get();
    }
}
