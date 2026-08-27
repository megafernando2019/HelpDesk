<?php

namespace Modules\Services\Repositories\Interfaces;

interface ITicketServiceRepo
{
   public function getServicesByCategory($category_id);
}
