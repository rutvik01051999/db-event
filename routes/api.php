<?php

use App\Http\Controllers\Api\AuthenticateApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Login
Route::post('login', [AuthenticateApiController::class, 'userLogin']);
