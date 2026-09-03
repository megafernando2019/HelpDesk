<?php

namespace Modules\Tickets\Repositories\Interfaces;

use Modules\Tickets\Models\Ticket;

interface ITicketRepo {

    /**
     *
     * @param int $id
     * @param array $relations
     * @return void
     */
    public function getTicket($id, $relations = []);

    /**
     *
     * @return void
     */
    public function getStatus();

    /**
     *
     * @return void
     */
    public function getPriorities();

    /**
     *
     * @param [type] $userId
     * @return void
     */
    public function getStatusesWithCount($userId);

    /**
     *
     * @param int $status
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function applyFilters(
        $status,
        $userId,
        $priority = 0,
        $startDate = null,
        $endDate = null
    );

   /**
    *
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function getTicketsTypes();

    /**
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTicketPriorities();

    /**
     *
     * @param [type] $args
     * @return void
     */
    public function addTicket($args);

    /**
     *
     * @param [type] $ticket_id
     * @param [type] $url
     * @return void
     */
    public function addTicketUrl($ticket_id, $url);

    /**
     *
     * @param [type] $args
     * @return void
     */
    public function storeAttachment($args);


    /**
     *
     * @param array $args
     * @return void
     */
    public function saveObservations($args);

    /**
     *
     * @param Ticket $ticket
     * @param array $userId
     * @return void
     */
    public function assignUser(Ticket $ticket, array $users_ids);

    /**
     *
     * @param int $status
     * @return void
     */
    public function updateStatus(int $status, int $ticket_id);

    /**
     *
     * @param array $record
     * @return void
     */
    public function saveLog($record);

    /**
     *
     * @return void
     */
    public function getAllTicketsActions();

    /**
     * 
     * @param  $id
     */
    public function getLogsByTicketId($id);

}