<?php

namespace Modules\Categories\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Categories\Models\TicketCategory;
use Modules\Categories\Repositories\Interfaces\ITicketCategoryRepo;

class TicketCategoryRepo implements ITicketCategoryRepo
{
    public function getCategoriesByDepartment($department_id)
    {
        return DB::table('tickets_categories')->where('department_id', $department_id)->get();
    }
}
