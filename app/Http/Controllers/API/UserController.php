<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function createUser(Request $request){
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]
        );
        if($user->id){
            $result = array('status' => true, 'message' => 'user created','data' => $user);
            $responseCode = 200;
        }
        else{
            $result = array('status' => false, 'message' => 'user not created');
            $responseCode = 400;
        }
    //    return response()->json(['status' => true, 'message' => 'hello wrold','data' => $request->all()]); 
       return response()->json($result,$responseCode); 
    }
}
