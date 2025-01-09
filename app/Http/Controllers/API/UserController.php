<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function createUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email', // Added email validation and uniqueness check
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'message' => 'Validation errors occurred',
                'error_message' => $validator->errors()
            );
            return response()->json($result, 400); // Bad request
        }
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]
        );
        if ($user->id) {
            $result = array('status' => true, 'message' => 'User created', 'data' => $user);
            return response()->json($result, 200); // Success response
        } else {
            $result = array('status' => false, 'message' => 'User not created');
            return response()->json($result, 400); // Failure response
        }
    //    return response()->json(['status' => true, 'message' => 'hello wrold','data' => $request->all()]); 
    //    return response()->json($result,$responseCode); 
    }
    public function getUser(){
        $users = User::all();
        // $result = array('status' => true, 'message' => 'User List', 'data' => $users);
        $result = array('status' => true, 'message' => count($users). " users fetched", 'data' => $users);
        $responseCode = 200;
        return response()->json($result,$responseCode);
    }
}
