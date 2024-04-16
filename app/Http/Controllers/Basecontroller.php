<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as controller;
class Basecontroller extends Controller
{

    public function sendresponse($result,$message)
    {
      $respose=[
        'success'=>true,
        'data'=>$result,
        'message'=>$message

      ];
      return response()->json($respose,200);
    }
    public function sendError($error,$errormessage= [],$code=404 )
    {
      $respose=[
        'success'=>false,
        'data'=>$error
      ];
      if(!empty($errormessage))
      {
        $response['data']=$errormessage;
      }
      return response()->json($respose,$code);
    }

}
