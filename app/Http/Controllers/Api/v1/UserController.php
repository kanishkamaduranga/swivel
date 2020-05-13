<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Api\ApiController;
use App\Repository\User\UserInterface;

class UserController extends ApiController
{

    /**
     * @var UserInterface
     */
    private $user_interface;

    public function __construct(
        UserInterface $user_interface
    )
    {
        $this->user_interface = $user_interface;
    }

    public function index()
    {
        try{
            $data = $this->user_interface->paginate();

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
