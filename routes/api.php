<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::resource('products', 'Api\ProductController');
Route::resource('townships', 'Api\TownshipController');
Route::resource('customers', 'Api\CustomerController');

// Route::get('photo', 'Api/ProductController@store');
Route::post('order', 'Api\OrderController@store');
Route::get('getorderdetail', 'Api\OrderController@show');
Route::get('getorder', 'Api\OrderController@orders');