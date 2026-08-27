<?php

namespace Modules\Tickets\Repositories\Interfaces;

interface ITicketRepo {

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

}