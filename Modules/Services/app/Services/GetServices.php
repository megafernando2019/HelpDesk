<?php

namespace Modules\Services\Services;

use Illuminate\Http\Request;
use Modules\Services\Repositories\Interfaces\ITicketServiceRepo;

class GetServices 
{
   public function __construct(
        protected ITicketServiceRepo $repo
   ) {}

   public function __invoke(
      Request $request
   )
   {
      $category_id = (int) $request->category_id ?? 0;

      return $this->repo->getServicesByCategory($category_id);
   }
}
