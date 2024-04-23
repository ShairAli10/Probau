<?php
namespace App\Http\Responses;

class ApiResponse {
     public static function error($data=null)
     {
        $response = [
            'status' => false,
            'message' => 'Email not founded in Database ',
       ];
          return response()->json($response, 200);
}

     }
