<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Api\ApiController;
use App\Repository\Ticket\TicketInterface;

class TicketController extends ApiController
{

    /**
     * @var TicketInterface
     */
    private $ticket_interface;

    public function __construct(
        TicketInterface $ticket_interface
    )
    {
        $this->ticket_interface = $ticket_interface;
    }

    public function index()
    {
        try{
            $data = $this->ticket_interface->paginate();

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
