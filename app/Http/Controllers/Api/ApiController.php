<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    public $status_codes = [];

    public function returnSuccess( $data = array(),  $status_code = 200){

        $this->status_codes = config('status_codes.status');
        $code_length = strlen((string)$status_code);

        return Response::json(
            [
                'status' => $status_code,
                'description' => $this->status_codes[$status_code],
                'data' => $data
            ], (int)200
        );
    }

    public function returnError($status_code = 403, $msg = []){

        $this->status_codes = config('status_codes.status');
        $code_length = strlen((string)$status_code);

        $return_array =  [
            'status' => $status_code,
            'description' => $this->status_codes[$status_code],
            'error_code' => $status_code,
            'messages' => $msg,
        ];

        if($code_length>3){
            $return_array['status'] = 403;
        }

        return Response::json( $return_array, (int)$return_array['status']);
    }
}
