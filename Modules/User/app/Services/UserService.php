<?php

namespace Modules\User\app\Services;

use App\Helpers\GetInitials;
use Modules\User\app\Repositories\Interfaces\IUserRepo;

class UserService
{
    public function __construct(
         private readonly IUserRepo $repo
    )
    {
        
    }

    public function getUsersByDepartmentId($request)
    {
        $departmentId = (int) $request->query('department_id');
        $rows = $this->repo->getUserByDepartmentId($departmentId);

        if ($rows->isEmpty()) {
            return collect();
        }

        $invoke = new GetInitials();

        $users = $rows->map(function($u) use($invoke) {
                 $u->initials = $invoke(sprintf(
                    '%s %s',
                    $u->first_name,
                    $u->last_name
                 ));

                 return $u;
        });

        return $users;
    }

    public function getTeams()
    {
        return $this->repo->getTeams();
    }
}
