<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;


trait ResponseTrait {

    public function successResponse($code='', $message = '', $data='')
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data'  => $data,
            'error' => '',
        ],$code);
    }

    public function addSuccessResponse($code='', $message = '', $data='')
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data'  => $data,
            'error' => '',
        ],$code);
    }

    public function errorResponse( $code='', $message = '',$data='')
    {
        return response()->json([
            'status' => $code,
            'ResponseCode' => $code,
            'message' => $message,
            'data'  => null,
            'error' => $message,
        ],$code);
    }
    public function addErrorResponse( $code='', $message = '',$data='')
    {
        return response()->json([
            'status' => $code,
            'ResponseCode' => $code,
            'message' => $message,
            'data'  => null,
            'error' => $message,
        ],$code);
    }
    public function errorComputing($validator)
    {
             $err_conatiner = '';
            foreach ($validator->errors()->getMessages() as $index => $error) {
                if(!$err_conatiner)
                $err_conatiner = $error[0];
                else
                $err_conatiner =  $err_conatiner .",". $error[0];
            }
            return response()->json([
                'status' => 409,
                'ResponseCode' => 401,
                'Result' => 'false',
                'ResponseMsg'  => $err_conatiner,
                'message'  => $err_conatiner,
                'data'  => [],
                'error' => $err_conatiner
            ],401);

    }

}