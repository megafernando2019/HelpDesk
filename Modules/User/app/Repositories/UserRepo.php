<?php

namespace Modules\User\app\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\User\app\Repositories\Interfaces\IUserRepo;
use Modules\User\app\Models\Team;

class UserRepo implements IUserRepo
{
    public function getUserByDepartmentId($department_id)
    {
        return User::where('department_id', $department_id)
                    ->where('active', 1)
                    ->select('id', 
                             'first_name', 
                             'last_name', 
                             'email',
                             )
                    ->withCount(['tickets' => function ($query) {
                        $query->whereNotIn('tickets.status_id', [4, 5, 6]);
                    }])
                    ->get();
    }

    public function getUsersByTeamId($teamId)
    {
        return DB::table('users as u')
            ->join('team_user as tu', 'u.id', '=', 'tu.user_id')
            ->where('tu.team_id', $teamId)
            ->where('u.active', 1)
            ->select(
                'u.id',
                'u.first_name',
                'u.last_name',
                'u.email'
            )
            ->selectSub(function ($query) {
                $query->selectRaw('count(*)')
                      ->from('tickets_users_assignations as tua')
                      ->join('tickets as t', 'tua.ticket_id', '=', 't.id')
                      ->whereColumn('tua.user_id', 'u.id') 
                      ->whereNotIn('t.status_id', [4, 5, 6]);
            }, 'tickets_count')
            ->distinct()
            ->get();
    }


    public function getTeams(array $fields = ['*'])
    {
        return Team::select($fields)->get();
    }

}
