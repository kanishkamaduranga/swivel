<?php


namespace App\Repository\Organization;


use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationRepository implements OrganizationInterface
{

    /**
     * @var Organization
     */
    private $organization_model;

    public function __construct(
        Organization $organization_model
    )
    {
        $this->organization_model = $organization_model;
    }

    public function getFields()
    {

        return $this->organization_model->getFields();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return array|int[]|mixed
     */
    public function paginate(  )
    {
        return $this->organization_model->paginate( );
    }

    /**
     * @return string[]
     */
    public function fields(){
        return $this->organization_model->fillable;
    }

    public function search($field, $keyword)
    {

        $result_list = [];

        if($this->organization_model->validateFields( $field)){

            foreach ($this->organization_model->all() as $data_record ) {

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

    public function getOrganizationById( $id)
    {
        foreach ($this->organization_model->all() as $data_record ) {
            if( $id == $data_record['_id']){
                return $data_record['name'];
            }
        }
        return '';
    }
}
