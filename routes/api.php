<?php

use App\Http\Controllers\API\C_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', [C_user::class, 'all_data']); // Get All Data User
    Route::get('/logout', [C_user::class, 'logout']); // Logout and clear token
});

Route::post('/user/register', [C_user::class, 'register']);
Route::post('/login', [C_user::class, 'login']);
