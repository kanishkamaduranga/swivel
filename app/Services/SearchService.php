<?php


namespace App\Services;


use App\Repository\Organization\OrganizationInterface;
use App\Repository\Ticket\TicketInterface;
use App\Repository\User\UserInterface;
use Illuminate\Support\Facades\Log;

class SearchService
{
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
        OrganizationInterface $organization_interface,
        TicketInterface $ticket_interface,
        UserInterface $user_interface
    )
    {
        $this->organization_interface = $organization_interface;
        $this->ticket_interface = $ticket_interface;
        $this->user_interface = $user_interface;
    }

    public function getFields( $type)
    {
        switch ( $type){
            case 'organizations' :

                return $this->organization_interface->getFields();
                break;
            case 'tickets':

                return $this->ticket_interface->getFields();
                break;
            case 'users':

                return $this->user_interface->getFields();
                break;
        }
    }

    /** return mail types
     * @return string[]
     */
    public function mainTypes()
    {

        return [
            'organizations' => 'Organizations',
            'tickets'   => 'Tickets',
            'users'     => 'Users'
        ];
    }

    /**
     * @param $inputs
     * @return int[]|mixed
     */
    public function search($inputs){

        try{

            switch (trim($inputs['main_types'])){
                case 'organizations' :

                    $data =  $this->organizationSearch(trim($inputs['field']), $inputs['keyword']);
                    break;
                case 'tickets':

                    $data = $this->ticketSearch(trim($inputs['field']), $inputs['keyword']);
                    break;
                case 'users':

                    $data = $this->userSearch(trim($inputs['field']), $inputs['keyword']);
                    break;
            }

            return $data;
        }catch (\Exception $exception){ dd($exception->getMessage());
            return [ 'error' => 1004 ];
        }
    }

    /**
     * @param $field
     * @param $keyword
     * @return mixed
     */
    public function ticketSearch($field, $keyword)
    {
        $result = $this->ticket_interface->search( $field, $keyword);

        if(isset($result['error'])){

            return $result;

        }else {
            foreach ($result as $key => $vales) {
                try {
                    $result[$key]['organization_name'] = $this->organization_interface->getOrganizationById($vales['organization_id']);
                    $result[$key]['submitter_name'] = $this->user_interface->getUserBYId($vales['submitter_id']);
                    $result[$key]['assignee_name'] = $this->user_interface->getUserBYId($vales['assignee_id']);


                }catch (\Exception $exception){
                    Log::error([$exception->getMessage(), $this]);
                }
            }
            return $result;
        }
    }

    /**
     * @param $field
     * @param $keyword
     * @return mixed
     */
    public function userSearch($field, $keyword)
    {
        $result = $this->user_interface->search( $field, $keyword);

        if(isset($result['error'])){

            return $result;

        }else{
            foreach ($result as $key => $vales){
                try{
                    $result[$key]['organization_name'] =  $this->organization_interface->getOrganizationById($vales['organization_id']);
                    $result[$key]['assignee_ticket'] =  $this->ticket_interface->getTicketsByUserId($key, 'assignee');
                    $result[$key]['submitted_ticket'] =  $this->ticket_interface->getTicketsByUserId( $key, 'submitted');
                }catch (\Exception $exception){
                    Log::error([$exception->getMessage(), $this]);
                }
            }
            return $result;
        }
    }

    /**
     * @param $field
     * @param $keyword
     * @return mixed
     */
    public function organizationSearch($field, $keyword){

        $result = $this->organization_interface->search( $field, $keyword);

        if(isset($result['error'])){

            return $result;

        }else{
            foreach ($result as $key => $vales){
                try{
                    $result[$key]['ticket'] = $this->ticket_interface->getTicketByOrganizationId($key);
                    $result[$key]['users'] =  $this->user_interface->getUsersByOrganizationId($key);
                }catch (\Exception $exception){
                    Log::error([$exception->getMessage(), $this]);
                }
            }
            return $result;
        }
    }
}
