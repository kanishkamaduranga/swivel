<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Collection;

class JsonModel
{

    /**
     * json file name
     * @var
     */
    protected $file_name;

    /**
     * @var array
     */
    public $fillable = [];

    /**
     * this is json file storage path
     * @var string
     */
    protected $storage_path;

    /**
     * @var
     */
    protected $collection_obj;
    /**
     * JsonModel constructor.
     */

    public function __construct()
    {
        $this->storage_path = storage_path();
        $this->collection_obj = $this->collection();
        $this->fillable = $this->getFillable();
    }

    public function getFillable()
    {
        return array_keys( $this->getFields());
    }

    /**
     * @return array
     */
    public function getFields()
    {
        $data = $this->all();
        $field_list = [];

        foreach ($data[0] as $key => $first_data){
            try {
                $field_list[$key] = trim(ucwords(str_replace('_', ' ', $key)));
            }catch (\Exception $exception){}
        }

        return $field_list;
    }

    public function validateFields( $field)
    {
        if ('any' == trim($field)){
            return true;
        }
        foreach ($this->fillable as $fiel){
            if ( trim($fiel) == trim($field)){
                return true;
            }
        }
        return false;
    }

    public function paginate()
    {
        try {
            $request = request()->input();
            $page = (int)((isset($request['page'])) ? $request['page'] : 1);
            $limit = (int)((isset($request['limit'])) ? $request['limit'] : 10);

            //$collection_obj = $this->collection();
            $from = $this->from($page, $limit);
            $data = $this->generateData($page, $limit);
            $total = $this->count();
            $to = $this->to($page, $limit, $total);
            $last_page = $this->last_page($total, $limit);

            if( $total < $limit ){
                return [ 'error' => 1003 ];
            }
            if( $last_page < $page ){
                return [ 'error' => 1002 ];
            }


            return [
                'error' => false,
                'data' => [
                    'current_page' => $page,
                    'data' => $data,
                    'from' => $from,
                    'to' => $to,
                    'last_page' => $last_page,
                    'pre_page' => $limit,
                    'total' => $total,
                ]
            ];
        }catch (\Exception $exception){

            return [ 'error' => 1001 ];
        }
    }

    protected function last_page($total, $limit)
    {

        return ( $total % $limit ) ? intdiv( $total, $limit) +1 : intdiv( $total, $limit);
    }
    /**
     * @param $page
     * @param $limit
     * @return float|int
     */
    protected function to($page, $limit, $total)
    {
        return ( $total > ( $limit * $page) ) ? ( $limit * $page) : $total;
    }
    /**
     * @param $page
     * @param $limit
     * @return float|int
     */
    protected function from($page, $limit)
    {
        return (($page - 1) * $limit ) +1;
    }

    /**
     * @param $page
     * @param $limit
     * @return array
     */
    protected function generateData($page, $limit)
    {
        return $this->collection_obj->slice(($page - 1) * $limit, $limit)->all();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->collection_obj->count();
    }

    /**
     * @return array
     */
    public function all()
    {
        //$collection_obj = $this->collection();
        return $this->collection_obj->all();
    }

    /**
     * generate collection
     * @return \Illuminate\Support\Collection
     */
    protected function collection()
    {
        $content = json_decode( $this->loadFileContents(), true);
        $collection = new Collection($content);
        $collection = collect($content);

        return $collection;
    }

    /**
     * load json content
     * @return mixed
     */
    protected function loadFileContents()
    {
        return file_get_contents($this->storage_path.'/'.$this->file_name);
    }

}
