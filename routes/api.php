<?php

use App\Http\Controllers\API\C_categories;
use App\Http\Controllers\API\C_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    // User
    Route::get('/user', [C_user::class, 'all_data']); // Get All Data User
    // Auth
    Route::get('/logout', [C_user::class, 'logout']); // Logout and clear token
    // Categories
    Route::get('/categories', [C_categories::class, 'all_data']);
    Route::post('/categories/create', [C_categories::class, 'create']);
    Route::get('/categories/detail/{id}', [C_categories::class, 'detail']);
    Route::post('/categories/update', [C_categories::class, 'update']);
    Route::get('/categories/delete/{id}', [C_categories::class, 'delete']);
});

Route::post('/user/register', [C_user::class, 'register']);
Route::post('/login', [C_user::class, 'login']);
