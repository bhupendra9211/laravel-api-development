<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    //
    public function updateUser(Request $request,$id){
        $user = User::find($id);
        if(!$user){
            // return response()->json(['status' => false,'message'=>'user not found'],404);
            $result = array('status'=>false,'message'=>'user not found');
            $responseCode = 404;
            return response()->json($result,$responseCode);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,'.$id, // Added email validation and uniqueness check
        ]);
        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'message' => 'Validation errors occurred',
                'error_message' => $validator->errors()
            );
            return response()->json($result, 400); // Bad request
        }
       
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $result = array('status'=>true,'message'=>'user updated sucessfully','data' => $user);
        $responseCode = 200;

        return response()->json($result,$responseCode);
    }
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
        $token = $user->createToken($request->name);
        if ($user->id) {
            $result = array('status' => true, 'message' => 'User created', 'data' => $user,'token' => $token->plainTextToken);
            return response()->json($result, 200); // Success response
        } else {
            $result = array('status' => false, 'message' => 'User not created');
            return response()->json($result, 400); // Failure response
        }
    //    return response()->json(['status' => true, 'message' => 'hello wrold','data' => $request->all()]); 
    //    return response()->json($result,$responseCode); 
    }
    public function getUsers(){
        try{
            $users = User::all();
            // $result = array('status' => true, 'message' => 'User List', 'data' => $users);
            $result = array('status' => true, 'message' => count($users). " users fetched", 'data' => $users);
            $responseCode = 200;
            return response()->json($result,$responseCode);
        }catch(Exception $e){
            $result = array("status"=>false,'message'=>"Api failed dut to an error",'error'=>$e->getMessage());
            $responseCode = 500;
            return response()->json($result,$responseCode);
        }
    }
    public function getUserDetail($id){
        $user = User::find($id);
        if(!$user){
            $result = array('status' => false, 'message' => "user not found",404);
            $responseCode = 404; // not found user
            return response()->json($result,$responseCode);
        }
        // $result = array('status' => true, 'message' => 'User List', 'data' => $users);
        $result = array('status' => true, 'message' => "user found", 'data' => $user);
        $responseCode = 200;
        return response()->json($result,$responseCode);
    }
    public function deleteUser($id){
        $user = User::find($id);
        if(!$user){
            // return response()->json(['status' => false,'message'=>'user not found'],404);
            $result = array('status'=>false,'message'=>'user not found');
            $responseCode = 404;
            return response()->json($result,$responseCode);
        }


        $user->delete();

        $result = array('status'=>true,'message'=>'user deleted sucessfully');
        $responseCode = 200;

        return response()->json($result,$responseCode);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'message' => 'Validation errors occurred',
                'error_message' => $validator->errors()
            );
            return response()->json($result, 400); // Bad request
        }
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'errors' => [
                    'email' => ['The provided credentials are incorrect.']
                ]
            ];
            // return [
            //     'message' => 'The provided credentials are incorrect.' 
            // ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];

        // $credentials = $request->only("email","password");

        // if(Auth::attempt($credentials)){
        //     $user = Auth::user();

            // $token = $user->createToken('MyApp')->accessToken;
            // $token = $user->createToken('token-name', ['server:update'])->plainTextToken;
            // $token = $user->createToken('MyApp')->plainTextToken;

            // $result = array('status'=>true,'message'=>'Login sucessfully',"data"=>$user);
            // $responseCode = 200;
    
            // return response()->json($result,$responseCode);


        // }else{

            // $result = array('status'=>false,'message'=>'Invalid Login');
            // $responseCode = 401;
    
            // return response()->json($result,$responseCode);
        // }

    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.' 
        ];
    }
}
