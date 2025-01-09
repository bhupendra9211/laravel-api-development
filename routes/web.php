<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', function () {
    $users = User::all();
    return view('users', ['users' => $users]);
});
// Route::get('/users', function () {
//     return view('users');
// });

