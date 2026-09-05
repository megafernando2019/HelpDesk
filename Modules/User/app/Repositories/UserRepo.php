<?php

namespace Modules\User\app\Repositories;

use App\Models\User;
use Modules\User\app\Repositories\Interfaces\IUserRepo;
use Modules\User\app\Models\Team;

class UserRepo implements IUserRepo
{
    public function getUserByDepartmentId($department_id)
    {
        return User::where('department_id', $department_id)
                    ->where('active', 1)
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->get();
    }

    public function getTeams(array $fields = ['*'])
    {
        return Team::select($fields)->get();
    }

}
