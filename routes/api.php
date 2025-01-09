<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('create-user',[UserController::class,'createUser']);
Route::get('get-user',[UserController::class,'getUser']);
Route::get('get-user/{id}',[UserController::class,'getUserDetail']);
