<?php

namespace Modules\Categories\Repositories\Interfaces;

interface ITicketCategoryRepo
{
    public function getCategoriesByDepartment($department_id);
}

