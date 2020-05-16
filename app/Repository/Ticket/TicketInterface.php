<?php


namespace App\Repository\Ticket;


interface TicketInterface
{

    /**
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function paginate();

    public function fields();

    public function getTicketByOrganizationId( $organization_id);

    public function getTicketsByUserId( $user_id, $type = 'assignee');

    public function search( $field, $keyword);

    public function getFields();
}
