<?php

namespace Modules\Services\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Services\Repositories\Interfaces\ITicketServiceRepo;

class TicketServiceRepo implements ITicketServiceRepo
{
    public function getServicesByCategory($category_id)
    {
        return DB::table('tickets_services')->where('category_id', $category_id)->get();
    }

    public function getServicesByIdsCategory($categories_ids)
    {
         return DB::table('tickets_services')->whereIn('category_id', $categories_ids)->get();
    }
}
