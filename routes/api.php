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
Route::post('od', 'Api\OrderController@stor');


Route::get('/getorderdetail/{id}', 'Api\OrderController@orderdetail');


Route::get('getorder', 'Api\OrderController@orders');

Route::put('/deliverystatus/{id}', 'Api\OrderController@deliverystatus');
Route::post('/deleteorder/{id}', 'Api\OrderController@deleteorder');

Route::get('orderprepare', 'Api\OrderController@orderprepare');
Route::get('delivery', 'Api\OrderController@delivery');
Route::get('payment', 'Api\OrderController@payment');
Route::get('complete', 'Api\OrderController@complete');

Route::get('dailyorder', 'Api\OrderController@dailyorder');
Route::get('monthlyorder', 'Api\OrderController@monthlyorder');
Route::get('yearlyorder', 'Api\OrderController@yearlyorder');


Route::post('search', 'Api\OrderController@search');

