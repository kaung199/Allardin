<?php
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {

    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/firstlayout', function () {
    return view('layouts/firstlayout');
});


// Route::get('/vueui/{any}', function () {
//     return view('home');
// })->where('any', '.*');


Route::get('home', 'HomeController@index');

Auth::routes();


Route::group(['middleware' => ['auth', 'superadmin']], function ()
	{
        Route::get('/admin', function () {
            return redirect()->route('products.index');
        });
        
        Route::resource('products', 'ProductController');
        Route::resource('townships', 'TownshipController');
        Route::resource('customers', 'CustomerController');
    });

    Route::group(['middleware' => ['auth', 'admin']], function ()
	{
       
    });
    Route::get('/', 'ProductController@userindex');

    Route::post('/search', 'ProductController@search')->name('search');

    Route::get('/cartadd/{id}', 'CartController@cartadd')->name('cartadd');
    Route::get('/cartview', 'CartController@cartview');
    Route::patch('/update-cart', 'CartController@update');
    Route::patch('/update-cart-sub', 'CartController@updatesub');
    
    // cartremove
    Route::get('/cart/remove/all', 'CartController@alldelete')->name('cart.alldelete');
    Route::delete('cart/remove-from-cart', 'CartController@remove')->name('cart.remove-from-cart');

    //admin order 
    Route::get('checkoutform', 'OrderController@checkoutform')->name('checkoutform');
    Route::post('checkout', 'OrderController@checkout')->name('checkout');
    Route::get('order', 'OrderController@order')->name('order');
    Route::get('orderdetail/{id}', 'OrderController@orderdetail')->name('orderdetail');
    Route::delete('deleteorder/{id}', 'OrderController@destroy')->name('orders.destroy');
    Route::get('deliverystatus/{id}', 'OrderController@deliverystatus')->name('deliverystatus');

    Route::get('orderprepare', 'OrderController@orderprepare')->name('orderprepare');
    Route::get('delivery', 'OrderController@delivery')->name('delivery');
    Route::get('payment', 'OrderController@payment')->name('payment');
    Route::get('complete', 'OrderController@complete')->name('complete');


    Route::get('/{vue_capture?}', function () {
        return view('home');
      })->where('vue_capture', '[\/\w\.-]*');