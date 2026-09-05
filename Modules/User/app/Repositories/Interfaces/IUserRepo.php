<?php

namespace Modules\User\app\Repositories\Interfaces;

interface IUserRepo
{
    public function getUserByDepartmentId($department_id);

    /**
     *
     * @return void
     */
    public function getTeams(array $fields = ['*']);
}
