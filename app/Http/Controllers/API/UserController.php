<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        if ($request->isMethod('get')) {
            // Render the create user view
            return view('users.create');
        }

        // Handle POST request for creating a user
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                // Return JSON response for API
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors occurred',
                    'error_message' => $validator->errors(),
                ], 400);
            }

            // Return errors to the view
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user,
            ], 200);
        }

        // Redirect to user list after successful creation
        return redirect()->route('users.list')->with('success', 'User created successfully');
    }

    public function getUsers(Request $request)
    {
        $users = User::all();

        if ($request->expectsJson()) {
            // Return JSON response for API
            return response()->json([
                'status' => true,
                'message' => count($users) . ' users fetched',
                'data' => $users,
            ], 200);
        }

        // Render the view with user data
        return view('users.index', compact('users'));
    }
}
