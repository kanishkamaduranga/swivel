<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Repository\Organization\OrganizationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrganizationController extends ApiController
{
    /**
     * @var OrganizationInterface
     */
    private $organization;

    /**
     * OrganizationController constructor.
     * @param OrganizationInterface $organization
     */
    public function __construct(
        OrganizationInterface $organization
    )
    {
        $this->organization = $organization;
    }

    public function index()
    {
        try{
            $data = $this->organization->paginate();

            if(isset($data['error'])) {
                if($data['error']) {
                    return $this->returnError($data['error']);
                }
            }
            return $this->returnSuccess( $data['data']);

        }catch (\Exception $exception){
            return $this->returnError(500);
        }
    }
}
