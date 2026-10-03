<?php

namespace Modules\User\app\Services;

use App\Helpers\GetInitials;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\User\app\Repositories\Interfaces\IUserRepo;
use Modules\User\app\Support\Mappers\MembersMapper;

class UserService
{
    public function __construct(
         private readonly IUserRepo $repo,
         private readonly MembersMapper $membersMap
    )
    {
        
    }

    public function permissionListAuthenticatable()
    {
        /**
         * Lista completa de permisos a evaluar para los tickets.
         */
        $defaultPermissions = $this->repo->getAllPermissions();
        $currentPermissions = [];

        if ($defaultPermissions->isNotEmpty()) {
            $permissionsDbNames = $defaultPermissions->pluck('name')->toArray();
            
            foreach ($permissionsDbNames as $value) {
                
                // El usuario tiene el permiso
                $currentPermissions[] = [
                        'permission' => $value ?? 'Sin permiso asignado',
                        'apply' => Auth::user()?->can($value ?? 'Sin permiso asignado')
                ];
            }
        }

        return $currentPermissions; 
    }


    public function getRoles()
    {
        return $this->repo->getAllRoles();
    }

    public function changeProcessRole($request)
    {
        $record = [
          'model_id' => Auth::user()->id,
          'model_type' => User::class,
          'role_id' => $request?->role ?? 0
        ];

        //Compruebo si ya existia el rol
        $rolExist = $this->repo->existsRol($record);

        if ($rolExist) {
            return $this->repo->updateRol($record);
        } else {
            return $this->repo->createRol($record);
        }
    }

    /**
     * Regresa una coleccion de los miembros con su equipo instanciados a una clase DTO
     *
     * @param $membersCtx
     * @param MembersMaModules\User\app\Support\Mappers\MembersMapper $mapper
     * @return void
     */
    public function getCollectionMembersDto(
        $members
    )
    {
        if ($members->isEmpty()) {
            return collect();
        }

        return $this->membersMap->toDtoCollection($members);  
    }
    
    /**
     * Obtiene a el equipo y sus miebros por medio del team Id en la sesion
     */
    public function getCurrentMembers()
    {
        $user = Auth::user();
       
        if ($user) {
            $user->load('teams.members');
        }

        return $user?->teams ?? collect();
    }

    public function getUsersByTeam($request)
    {
        $teamId = $request?->team_id ?? [];
        
        if (!empty($teamId)) {
            $teamId = array_map(function ($teamId) {
                   return (int) $teamId;
            }, $teamId );
        }

        $rows = $this->repo->getUsersByTeamId($teamId);

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

                 $u->tickets_count_pending = $u?->tickets_count ?? 0;

                 return $u;
        });

        return $users;
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

                 $u->tickets_count_pending = $u?->tickets_count ?? 0;

                 return $u;
        });

        return $users;
    }

    public function getTeams()
    {
        return $this->repo->getTeams();
    }
}
