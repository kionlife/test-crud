<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function apiSuccessResponse($message, $data=null, $code = 200){
        return response()->json([
            'status'    => 'true',
            'message'   => $message,
            'data'      => $data
        ], $code);
    }

    public function apiErrorResponse($message, $data=null, $code = 404){
        return response()->json([
            'status'    => 'false',
            'message'   => $message,
            'data'      => $data
        ], $code);
    }
}
