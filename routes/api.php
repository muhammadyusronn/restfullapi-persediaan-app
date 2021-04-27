<?php

use App\Http\Controllers\API\C_buy;
use App\Http\Controllers\API\C_categories;
use App\Http\Controllers\API\C_items;
use App\Http\Controllers\API\C_sell;
use App\Http\Controllers\API\C_supplier;
use App\Http\Controllers\API\C_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    // User
    Route::get('/user', [C_user::class, 'all_data']); // Get All Data User
    // Auth
    Route::get('/logout', [C_user::class, 'logout']); // Logout and clear token
    // Categories
    Route::get('/categories', [C_categories::class, 'all_data']); // Get All Data Categories
    Route::post('/categories/create', [C_categories::class, 'create']); // Create Data Cataegory
    Route::get('/categories/detail/{id}', [C_categories::class, 'detail']); // Detail Category
    Route::post('/categories/update', [C_categories::class, 'update']); // Update Category
    Route::get('/categories/delete/{id}', [C_categories::class, 'delete']); // Delete Category
    // Items
    Route::get('/items', [C_items::class, 'all_data']); // Get All Data Items
    Route::post('/items/create', [C_items::class, 'create']);   // Create Items
    Route::get('/items/detail/{id}', [C_items::class, 'detail']);   // Detail Items
    Route::post('items/update', [C_items::class, 'update']);    // Update Items
    Route::get('items/delete/{id}', [C_items::class, 'delete']);    // Delete Items
    // Supplier
    Route::get('/supplier', [C_supplier::class, 'all_data']); // Get All Data supplier
    Route::post('/supplier/create', [C_supplier::class, 'create']);   // Create supplier
    Route::get('/supplier/detail/{id}', [C_supplier::class, 'detail']);   // Detail supplier
    Route::post('supplier/update', [C_supplier::class, 'update']);    // Update supplier
    Route::get('supplier/delete/{id}', [C_supplier::class, 'delete']);    // Delete supplier

    // buys
    Route::get('buy', [C_buy::class, 'all_data']); // Show buy's transaction
    Route::post('buy/create', [C_buy::class, 'create']); // Create buy's transaction
    Route::get('buy/detail/{id}', [C_buy::class, 'detail']); // Detail buy's transaction

    Route::get('buy/cart', [C_buy::class, 'cart_show']); // show Cart
    Route::post('buy/cart/create', [C_buy::class, 'cart_create']); // Add Cart
    Route::get('buy/cart/delete/{id}', [C_buy::class, 'cart_delete']); // Cancel Cart
    Route::get('buy/cart/cancel', [C_buy::class, 'cart_cancel']); // Cancel Cart

    // Sells
    Route::get('sell', [C_sell::class, 'all_data']); // Show sell's transaction
    Route::post('sell/create', [C_sell::class, 'create']); // Create sell's transaction
    Route::get('sell/detail/{id}', [C_sell::class, 'detail']); // Detail sell's transaction

    Route::get('sell/cart', [C_sell::class, 'cart_show']); // show Cart
    Route::post('sell/cart/create', [C_sell::class, 'cart_create']); // Add Cart
    Route::get('sell/cart/delete/{id}', [C_sell::class, 'cart_delete']); // Cancel Cart
    Route::get('sell/cart/cancel', [C_sell::class, 'cart_cancel']); // Cancel Cart
});

Route::post('/user/register', [C_user::class, 'register']);
Route::post('/login', [C_user::class, 'login']);
