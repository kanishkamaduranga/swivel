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

    public function index( Request $request){

        try {

            $inputs = $request->all();
            $rule =[
                "type" => 'required|in:organization,ticket,user',
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
