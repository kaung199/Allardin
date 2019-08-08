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


Route::group(['middleware' => ['auth', 'admin', 'superadmin']], function ()
	{
        Route::get('/admin', function () {
            return redirect()->route('dashboard');
        });
        
        Route::resource('products', 'ProductController');
        Route::resource('townships', 'TownshipController');
        Route::resource('customers', 'CustomerController');

        Route::get('/', 'ProductController@userindex');

        //customer
        Route::get('/customers', 'CustomerController@index')->name('customers');
        Route::get('/customerdetail/{id}', 'CustomerController@customerdetail')->name('customerdetail');

        Route::post('/search', 'ProductController@search')->name('search');
        Route::post('/searchbydate', 'OrderController@search')->name('searchbydate');

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
        Route::get('deliverystatussearch/{id}', 'OrderController@deliverystatussearch')->name('deliverystatussearch');

        //all order
        Route::get('orderprepare', 'OrderController@orderprepare')->name('orderprepare');
        Route::get('delivery', 'OrderController@delivery')->name('delivery');
        Route::get('payment', 'OrderController@payment')->name('payment');
        Route::get('complete', 'OrderController@complete')->name('complete');
        
        //daily order
        Route::get('orderprepared', 'OrderController@orderprepared')->name('orderprepared');
        Route::get('deliveryd', 'OrderController@deliveryd')->name('deliveryd');
        Route::get('paymentd', 'OrderController@paymentd')->name('paymentd');
        Route::get('completed', 'OrderController@completed')->name('completed');
        
        //monthly order
        Route::get('orderpreparem', 'OrderController@orderpreparem')->name('orderpreparem');
        Route::get('deliverym', 'OrderController@deliverym')->name('deliverym');
        Route::get('paymentm', 'OrderController@paymentm')->name('paymentm');
        Route::get('completem', 'OrderController@completem')->name('completem');

        //yearly order
        Route::get('orderpreparey', 'OrderController@orderpreparey')->name('orderpreparey');
        Route::get('deliveryy', 'OrderController@deliveryy')->name('deliveryy');
        Route::get('paymenty', 'OrderController@paymenty')->name('paymenty');
        Route::get('completey', 'OrderController@completey')->name('completey');

        
        // all order dmy
        Route::get('daily', 'OrderController@dailyorder')->name('daily');
        Route::get('monthly', 'OrderController@monthlyorder')->name('monthly');
        Route::get('yearly', 'OrderController@yearlyorder')->name('yearly');

        // dashboard page
        Route::get('dashboard', 'CustomerController@dashboard')->name('dashboard');
    });

   
    
    Route::group(['middleware' => ['delivery']], function ()
	{
       Route::get('/wellcome', function () {
            return view('welcome');
        });
    });
    


    Route::get('/{vue_capture?}', function () {
        return view('home');
      })->where('vue_capture', '[\/\w\.-]*');