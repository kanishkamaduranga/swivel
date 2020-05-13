<?php


namespace App\Repository\Ticket;


use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class TicketRepository implements TicketInterface
{
    /**
     * @var Ticket
     */
    private $ticket;

    public function __construct(
        Ticket $ticket
    )
    {
        $this->ticket = $ticket;
    }

    public function paginate( )
    {
        return $this->ticket->paginate( );
    }

    public function fields(){
        return $this->ticket->fillable;
    }

    public function getTicketByOrganizationId( $organization_id)
    {
        $return_list = [];
        foreach ( $this->ticket->all() as $value){

            try {
                if ($organization_id == $value['organization_id']) {
                    $return_list[$value['_id']] = $value['subject'];
                }
            }catch (\Exception $exception){
                Log::info($exception);
            }
        }
        return $return_list;
    }

    public function getTicketsByUserId( $user_id, $type = 'assignee')
    {
        $return_list = [];
        foreach ( $this->ticket->all() as $value){

            try {
                if ($type == 'assignee' || $user_id == $value['assignee_id']) {
                    $return_list[$value['_id']] = $value['subject'];
                }else if ($type == 'submitted' || $user_id == $value['submitter_id']) {
                    $return_list[$value['_id']] = $value['subject'];
                }
            }catch (\Exception $exception){
                Log::error([$exception->getMessage(), $this]);
            }
        }
        return $return_list;
    }

    public function search( $field, $keyword)
    {
        $result_list = [];

        if($this->ticket->validateFields( $field)){

            foreach ($this->ticket->all() as $data_record ) {

                $data_record_id = $data_record['_id'];
                $status = false;
                foreach ($data_record as $key => $value) {
                    if ('any' == $field && !$status) {
                        $status = $this->searchRow ($value, $keyword);
                    } else if ($field == $key) {
                        $status = $this->searchRow ($value, $keyword);
                    }
                }

                if($status){
                    $result_list[$data_record_id] = $data_record;
                }
            }

            return $result_list;
        }
        return [ 'error' => 1006];
    }

    public function searchRow ($value, $keyword){

        if (is_array($value)) {

            return in_array($keyword, $value);
        } else if(trim($keyword)) {
            if(trim($value)) {
                if (strpos($value, $keyword) !== false) {
                    return  true;
                }
            }
        }else{
            if( ! trim($value)){
                return true;
            }
        }
        return false;

    }
}
