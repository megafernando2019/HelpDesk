<?php

namespace Modules\Categories\Services;

use Modules\Categories\Repositories\Interfaces\ITicketCategoryRepo;

class TicketCategoryService
{
    public function __construct(private readonly ITicketCategoryRepo $repo) {
        
    }

    public function getCategoriesByDepartment($request)
    {
        $department_id = (int) $request->department_id ?? 0;
        return $this->repo->getCategoriesByDepartment($department_id);
    }
}
