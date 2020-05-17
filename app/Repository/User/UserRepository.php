<?php


namespace App\Repository\User;


use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserInterface
{

    /**
     * @var User
     */
    private $user;

    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }

    public function getFields(){

        return $this->user->getFields();
    }

    public function paginate( )
    {
        return $this->user->paginate( );
    }

    public function fields(){
        return $this->user->fillable;
    }

    public function getUserBYId( $id)
    {
        foreach ( $this->user->all() as $value){
            try {
                if ($id == $value['_id']) {
                    return $value['name'];
                }
            }catch (\Exception $exception){
                Log::error([$exception->getMessage(), $this]);
            }
        }
    }

    public function getUsersByOrganizationId( $organization_id)
    {
        $return_list = [];
        foreach ( $this->user->all() as $value){

            try {
                if ($organization_id == $value['organization_id']) {
                    $return_list[] = $value['name'];
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

        if($this->user->validateFields( $field)){

            foreach ($this->user->all() as $data_record ) {

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
                    $result_list[] = $data_record;
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
