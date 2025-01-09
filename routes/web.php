<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\API\UserController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/users', function () {
//     $users = User::all();
//     return view('users', ['users' => $users]);
// });
// Route::get('/users', function () {
//     return view('users');
// });


Route::get('/users', [UserController::class, 'getUsers'])->name('users.list');
Route::match(['get', 'post'], '/users/create', [UserController::class, 'createUser'])->name('create.user');


