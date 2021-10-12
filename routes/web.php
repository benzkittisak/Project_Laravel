<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CartMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

// Product Route
Route::get('/product' , [ProductController::class,'index']);
Route::get('/product/search' , [ProductController::class ,'search']);
Route::post('/product/search' , [ProductController::class ,'search']);
Route::get('/product/edit/{id?}' , [ProductController::class , 'edit']);
Route::post('/product/update' , [ProductController::class , 'update']);
Route::post('/product/insert' , [ProductController::class , 'insert']);
Route::get('/product/remove/{id}', [ProductController::class , 'remove']);

// Category Route
Route::get('/category' , [CategoryController::class,'index']);
Route::get('/category/edit/{id?}' , [CategoryController::class,'edit']);
Route::post('/category/insert' , [CategoryController::class , 'insert']);
Route::post('/category/update' , [CategoryController::class , 'update']);
Route::get('/category/remove/{id}', [CategoryController::class , 'remove']);


// Cart Route

Route::group(['prefix' => 'cart'] , function(){
    Route::get('/view' , [CartController::class , 'viewCart']);
    Route::get('/add/{id}' , [CartController::class , 'addToCart']);
    Route::get('/delete/{id}' , [CartController::class , 'deleteCart']);

    Route::middleware([CartMiddleware::class]) -> group(function(){
        Route::get('/update/{id}/{qty}' , [CartController::class , 'updateCart']);
    });

    Route::get('/checkout' , [CartController::class , 'checkout']);
    Route::get('/complete' , [CartController::class , 'complete']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']] , function(){
    Route::get('/logout' , [HomeController::class , 'logout']);
});

// Route::get('/logout' , [HomeController::class , 'logout'])->middleware('auth');