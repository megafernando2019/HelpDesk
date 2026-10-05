<?php

namespace Modules\User\app\Repositories\Interfaces;

interface IUserRepo
{
    /**
     *
     * @param array $currentPermissionsIds
     * @param array $newPermissions
     * @return void
     */
    public function syncUserHasPermissions(
        $currentPermissionsIds,
        $newPermissions,
        $userId
    );

    /**
     *
     * @param array $args
     * @return void
     */
    public function getPermissionsIdsByName(
        $args
    );
    
    /**
     *
     * @return void
     */
    public function getAllPermissions();

    /**
     *
     * @param int $department_id
     * @return void
     */
    public function getUserByDepartmentId($department_id);

    /**
     *
     * @return void
     */
    public function getTeams(array $fields = ['*']);


    /**
     *
     * @param array $teamId
     * @param int $userId
     * @return void
     */
    public function getUsersByTeamId($teamId);

    /**
     *
     * @param array $record
     * @return void
     */
    public function updateRol($record);

    /**
     *
     * @param array $record
     * @return void
     */
    public function createRol($record);
    
    /**
     *
     * @return void
     */
    public function getAllRoles();

    /**
     *
     * @param array $record
     * @return void
     */
    public function existsRol($record);
}
