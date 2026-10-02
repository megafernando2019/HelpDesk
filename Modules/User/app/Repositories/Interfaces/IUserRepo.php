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
