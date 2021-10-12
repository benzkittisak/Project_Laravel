<?php

use App\Http\Controllers\API\CategoryControllerAPI;
use App\Http\Controllers\API\ProductControllerAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::get('/product',[ProductControllerAPI::class , 'product_list']);

Route::get('/product/{category_id?}',[ProductControllerAPI::class , 'product_list']);
Route::post('/product/search' , [ProductControllerAPI::class,'product_search']);

Route::get('/category',[CategoryControllerAPI::class , 'categories_list']);

