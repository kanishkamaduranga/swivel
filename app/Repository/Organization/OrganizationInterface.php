<?php


namespace App\Repository\Organization;


interface OrganizationInterface
{
    /**
     * @param int $page
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function paginate();

    public function fields();

    public function search($field, $keyword);

    public function getOrganizationById( $id);

    public function getFields();
}
