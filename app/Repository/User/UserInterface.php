<?php


namespace App\Repository\User;


interface UserInterface
{

    /**
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function paginate();

    public function fields();

    public function getUsersByOrganizationId( $organization_id);

    public function getUserBYId( $id);

    public function search( $field, $keyword);
}
