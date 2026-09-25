<?php

namespace Modules\Services\Services;

use Modules\Services\Repositories\Interfaces\ITicketServiceRepo;

class CatalogService
{
    public function __construct(
        private readonly ITicketServiceRepo $repo
    )
    {
        
         
    }

    public function getServicesByCategory(
        $request
       )
    {
        $category_id = (int) $request->category_id ?? 0;

        return $this->repo->getServicesByCategory($category_id);
    }

    public function getServicesByCategories($categoriesIds)
    {
        return $this->repo->getServicesByIdsCategory($categoriesIds);
    }
}
