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
Route::get('phone_check', 'Api\CustomerController@phoneCheck');
Route::post('profile', 'Api\CustomerController@profile');

Route::get('product_detail', 'Api\ProductController@productDetail');

// Route::get('photo', 'Api/ProductController@store');
Route::post('order', 'Api\OrderController@store');
Route::post('od', 'Api\OrderController@stor');

Route::get('session', 'Api\OrderController@session');
Route::get('show_cart', 'Api\OrderController@show_cart');
Route::get('remove_cart', 'Api\OrderController@remove_cart');

Route::get('/getorderdetail', 'Api\OrderController@orderdetail');
Route::get('/getorder-pending-detail', 'Api\OrderController@ordersPendingDetail');


Route::get('getorder', 'Api\OrderController@orders');
Route::get('getorder-pending', 'Api\OrderController@ordersPending');

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

//Favorite
Route::post('favorite', 'Api\FavoriteController@favoritePost');
Route::get('my_favorites', 'Api\FavoriteController@myFavorites');

Route::get('count_favorite', 'Api\CountController@count_favorite');
Route::get('count_cart', 'Api\CountController@count_cart');

Route::get('pos_product', 'Api\POSProductController@index');