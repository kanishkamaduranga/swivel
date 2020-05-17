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
            $fields = $this->ticket_interface->getFields();
            $return_array = [];

            foreach ($result as $key => $vales) {
                $temp_array = [];
                try {

                    foreach ($vales as $k => $val )
                    {
                        $temp_array[$k] = [
                            'label' => $fields[$k],
                            'value' => $val
                        ];
                    }

                    $temp_array['organization_name'] = [
                        'label' => 'Organization Name',
                        'value' => $this->organization_interface->getOrganizationById($vales['organization_id'])
                    ];
                    $temp_array['submitter_name'] = [
                        'label' => 'Submitter Name',
                        'value' => $this->user_interface->getUserBYId($vales['submitter_id'])
                    ];
                    $temp_array['assignee_name'] = [
                        'label' => 'Assignee Name',
                        'value' => $this->user_interface->getUserBYId($vales['assignee_id'])
                    ];

                    $return_array[] = $temp_array;

                }catch (\Exception $exception){
                    Log::error([$exception->getMessage(), $this]);
                }
            }
            return $return_array;
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
            $fields = $this->user_interface->getFields();
            $return_array = [];

            foreach ($result as $key => $vales){
                try{
                    foreach ($vales as $k => $val )
                    {
                        $temp_array[$k] = [
                            'label' => $fields[$k],
                            'value' => $val
                        ];
                    }

                    $id = $vales['_id'];
                    $temp_array['organization_name'] = [
                        'label' => 'Organization Name',
                        'value' => $this->organization_interface->getOrganizationById($vales['organization_id'])
                    ];
                    $temp_array['assignee_ticket'] = [
                        'label' => 'Assignee Name',
                        'value' => $this->ticket_interface->getTicketsByUserId($id, 'assignee')
                    ];
                    $temp_array['submitted_ticket'] = [
                        'label' => 'Submitted Name',
                        'value' => $this->ticket_interface->getTicketsByUserId($id, 'submitted')
                    ];

                    $return_array[] = $temp_array;

                }catch (\Exception $exception){
                    Log::error([$exception->getMessage(), $this]);
                }
            }
            return $return_array;
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
            $fields = $this->organization_interface->getFields();
            $return_array = [];
            foreach ($result as $key => $vales){
                try{
                    foreach ($vales as $k => $val )
                    {
                        $temp_array[$k] = [
                            'label' => $fields[$k],
                            'value' => $val
                        ];
                    }
                    $id = $vales['_id'];

                    $temp_array['ticket'] = [
                        'label' => 'Ticket',
                        'value' => $this->ticket_interface->getTicketByOrganizationId($id)
                    ];
                    $temp_array['users'] = [
                        'label' => 'Users',
                        'value' => $this->user_interface->getUsersByOrganizationId($id)
                    ];

                    $return_array[] = $temp_array;

                }catch (\Exception $exception){
                    Log::error([$exception->getMessage(), $this]);
                }
            }
            return $return_array;
        }
    }
}
