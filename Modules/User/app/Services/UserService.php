<?php

namespace Modules\User\app\Services;

use App\Helpers\GetInitials;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\User\app\Repositories\Interfaces\IUserRepo;
use Modules\User\app\Support\Mappers\MembersMapper;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

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

    /**
     * Recupera los ids de cada permiso asignado al usuario en sesion
     *
     * @return array
     */
    public function getCurrentPermissionsOnlyIds()
    {
        return Auth::user()
           ->getAllPermissions()
           ->pluck('id')
           ->toArray();
    }

    public function changeProcessRole($request)
    {
        $roleId =  $request?->role ?? 0;
        $user = Auth::user();

        $record = [
          'model_id' => $user->id,
          'model_type' => User::class,
          'role_id' => $roleId
        ];

        //Compruebo si ya existia el rol
        $rolExist = $this->repo->existsRol($record);

        if ($rolExist) {
           $this->repo->updateRol($record);
        } else {
           $this->repo->createRol($record);
        }

        // Forzar a Eloquent a olvidar la relación en memoria para que obtenga el ROL NUEVO de la BD
        $user->unsetRelation('roles');

        // Obtengo el rol actual ya con la actualizacion
        $currentRolName = $user->getRoleNames()->first();

        // Verifico al final si ya tiene los permisos especificados para su rol, si no lo tiene se los añadimos a ese usuario
        $rolePermissionsMap = [
            'Jefe de equipo' => [
                'create-ticket',
                'view-tickets',
                'assign-tickets',
                'reassign-tickets',
                'move-ticket-to-wait',
                'add-observations',
                'solve-ticket',
                'close-ticket',
                'cancel-ticket',
                'view-statistics'
            ],
            'Encargado' => [
                'create-ticket',
                'view-tickets',
                'view-statistics',
                'move-ticket-to-wait',
                'add-observations',
                'solve-ticket'
            ],
            'Usuario' => [
                'create-ticket',
                'view-tickets',
                'close-ticket',
                'cancel-ticket'
            ],
            'Sistemas' => [
                'create-ticket',
                'view-tickets',
                'add-observations',
                'create-team'
            ]
        ];

        // Obtener los nombres de permisos para el rol asignado
        $defaultPermissionNames = $rolePermissionsMap[$currentRolName] ?? [];

        if (!empty($defaultPermissionNames)) {
            // Obtener los modelos de Permiso por su campo 'name'
            $permissions = $this->repo->getPermissionsIdsByName($defaultPermissionNames);
           
            $NewpermissionsIds = [];
            $rows = [];

            if ($permissions->isNotEmpty()) {
                $NewpermissionsIds = $permissions->toArray();

                foreach ($NewpermissionsIds as $value) {
                    $rows[] = [
                        'permission_id' => (int) $value,
                        'model_type'    =>  User::class,
                        'model_id'      =>  $user->id
                    ];
                }
            }

            //Obtener los permisos actuales con solo sus ids
            $directPermissionIds = $this->getCurrentPermissionsOnlyIds();

            // Borrar los permisos actuales del usuario y despues añadirlo de nuevo
            $this->repo->syncUserHasPermissions(
                $directPermissionIds,
                $rows,
                $user->id
            );

            // Limpiar la caché de permisos de Spatie para que se apliquen inmediatamente
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
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
