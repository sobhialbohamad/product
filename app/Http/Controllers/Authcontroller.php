<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Basecontroller as Basecontroller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Validator;

class Authcontroller extends Basecontroller
{
  public function register(Request $request)
      {
       //$input=$request->all();
       $validator = Validator::make($request->all(),[
               'name'=>'required',
               'email'=>'required|email',
               'password'=>'required',
               'c_password'=>'required|same:password'
           ]);
        if ($validator->fails()) {
          return $this->sendError('please validate error',$validator->errors());
       }
        $input=$request->all();
        $input['password']=Hash::make( $input['password']);
        $user=User::create($input);
        $success['token_type']='Bearer';
        $success['token']=$user->createToken('sobhi')->accessToken;
        $success['name']=$user->name;
         return $this->sendresponse($success,'user registerd successfully');
      }
      public function login(Request $request)
      {
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
          $user=Auth::user();
          $success['token_type']='Bearer';
          $success['token']=$user->createToken('sobhi')->accessToken;
           $success['name']=$user->name;
           return $this->sendresponse($success,'user login successfully');
        }
       else {
          return $this->sendError('please check your auth',['error'=>'unauthorized']);

 }
 }













}
