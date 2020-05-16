<?php


namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Repository\Organization\OrganizationInterface;
use App\Repository\Ticket\TicketInterface;
use App\Repository\User\UserInterface;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends ApiController
{

    /**
     * @var SearchService
     */
    private $search_service;
    /**
     * @var OrganizationInterface
     */
    private $organization_interface;
    /**
     * @var TicketInterface
     */
    private $ticket_interface;
    /**
     * @var UserInterface
     */
    private $user_interface;

    public function __construct(
        SearchService $search_service,
        OrganizationInterface $organization_interface,
        TicketInterface $ticket_interface,
        UserInterface $user_interface
    )
    {
        $this->search_service = $search_service;
        $this->organization_interface = $organization_interface;
        $this->ticket_interface = $ticket_interface;
        $this->user_interface = $user_interface;
    }

    /**
     * @param $main_type
     * @return \Illuminate\Http\JsonResponse
     */
    public function fields($main_type)
    {
        try{

            return $this->returnSuccess( $this->search_service->getFields($main_type));

        }catch (\Exception $exception){
            return $this->returnError();
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function main()
    {
        try{

            return $this->returnSuccess($this->search_service->mainTypes());
        }catch (\Exception $exception){
            return $this->returnError();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {

            $inputs = $request->all();
            $rule =[
                "main_types" => 'required|in:organizations,tickets,users',
                "field" => 'required',
            ];
            $validator = Validator::make($inputs, $rule);

            if ($validator->fails()) {
                return $this->returnError(1005, $validator->errors());
            } else {

                $result =  $this->search_service->search( $inputs);

                if(isset($result['error'])){
                    return $this->returnError($result['error']);
                }else{
                    return $this->returnSuccess($result);
                }

            }

        }catch (\Exception $exception){
            return $this->returnError(1004);
        }
    }
}
