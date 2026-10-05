<?php

namespace Modules\User\app\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\User\app\Repositories\Interfaces\IUserRepo;
use Modules\User\app\Models\Team;

class UserRepo implements IUserRepo
{

    public function syncUserHasPermissions(
        $currentPermissionsIds,
        $newPermissions,
        $userId
    )
    {
        // Borrar los permisos actuales del usuario y despues añadirlo de nuevo
        DB::table('model_has_permissions')
          ->where('model_id', $userId)
          ->where('model_type', User::class)
          ->whereIn('permission_id', $currentPermissionsIds)
          ->whereNotIn('permission_id', function ($q) {
                $q->select('id')
                    ->from('permissions')
                    ->whereIn('name', ['manage-user-roles']);
          })
          ->delete();

        //Filas a añadir
        DB::table('model_has_permissions')
          ->insert($newPermissions);
    }

    public function getPermissionsIdsByName($args)
    {
        return DB::table('permissions')
         ->whereIn('name', $args)
         ->pluck('id');
    }
  
    public function getAllPermissions()
    {
        return DB::table('permissions')->get();
    }

    public function existsRol($record)
    {
       return DB::table('model_has_roles')
        ->where('model_id', $record['model_id'])
        ->where('model_type', $record['model_type'])
        ->exists();
    }

    public function getAllRoles()
    {
        return DB::table('roles')->get();
    }

    public function createRol($record)
    {
        return DB::table('model_has_roles')->insert($record);
    }

    public function updateRol($record)
    {
       return DB::table('model_has_roles')
        ->where('model_id', $record['model_id'])
        ->where('model_type', $record['model_type'])
        ->update([
            'role_id' => $record['role_id'],
        ]);
    }

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
            ->whereIn('tu.team_id', $teamId)
            ->where('u.active', 1)
            ->select(
                'u.id',
                'u.first_name',
                'u.last_name',
                'u.email'
            )
            ->selectSub(function ($query)  use($teamId) {
                $query->selectRaw('count(*)')
                      ->from('tickets_users_assignations as tua')
                      ->join('tickets as t', 'tua.ticket_id', '=', 't.id')

                      ->whereColumn('tua.user_id', 'u.id') 
                      ->whereNotIn('t.status_id', [4, 5, 6])
                      ->whereIn('t.team_id', $teamId);
            }, 'tickets_count')
            ->distinct()
            ->get();
    }


    public function getTeams(array $fields = ['*'])
    {
        return Team::select($fields)->get();
    }

}
