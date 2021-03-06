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

Route::get('/orderlayout', function () {
    return view('layouts/orderprepare');
});

Route::get('/getapp', function () {
    return view('products/getapp');
});


// Route::get('/vueui/{any}', function () {
//     return view('home');
// })->where('any', '.*');

Route::get('/', 'ProductController@userindex');
Route::get('/detail/{id}', 'ProductController@userdetail');
Route::get('home', 'HomeController@index');
Route::get('productssearch', 'ProductController@productssearch')->name('productssearch');

//order_prepare
Route::get('o_prepare/{id}', 'OrderprepareController@index')->name('o_prepare');
Route::get('o_p_barcode', 'OrderprepareController@barcode')->name('o_p_barcode');
Route::get('o_p_cancel', 'OrderprepareController@remove')->name('o_p_cancel');
Route::get('o_p_confirm', 'OrderprepareController@confirm')->name('o_p_confirm');
Auth::routes();


Route::group(['middleware' => ['auth', 'admin', 'superadmin']], function ()
	{
        Route::get('/admin', function () {
            return redirect()->route('dashboard');
        });

        //products min
        Route::get('product-min', 'ProductController@min')->name('product-min');
        Route::get('product-min-search', 'ProductController@product_min_search')->name('product-min-search');
        
        ///stock checked
        Route::get('stock-check', 'StockController@index')->name('stock-check');
        Route::get('search-stock-check', 'StockController@search')->name('search-stock-check');
        Route::post('stock-check-create', 'StockController@store')->name('stock-check-create');
        Route::patch('/stock-check-update/{id}', 'StockController@update')->name('stock-check-update');



        // voucher
        Route::get('voucher_data', 'VoucherController@index')->name('voucher_data');
        Route::get('voucher_search', 'VoucherController@order_search')->name('voucher_search');
        
        Route::get('voucher_cancel', 'VoucherController@destroy')->name('voucher_cancel');
        Route::get('voucher_confirm', 'VoucherController@confirm')->name('voucher_confirm');


        //category 
        Route::get('category', 'CategoryController@index')->name('category');
        Route::post('category_store', 'CategoryController@store')->name('category_store');
        Route::get('category_edit/{id}', 'CategoryController@edit')->name('category_edit');
        Route::post('category_update/{id}', 'CategoryController@update')->name('category_update');
        Route::delete('category_delete/{id}', 'CategoryController@destroy')->name('category_delete');
        //export 
        Route::get('product_export', 'ProductController@product_export')->name('product_export');
        Route::resource('deliveries', 'DeliveryController');
        Route::resource('products', 'ProductController');
        Route::resource('townships', 'TownshipController');
        Route::resource('customers', 'CustomerController');
        Route::get('editproduct/{id}/{page}', 'ProductController@edit')->name('editproduct');

        Route::get('/admincartview', 'CartController@admincartview');
        Route::get('adminindex', 'ProductController@adminindex')->name('adminindex');
        Route::post('searchproducts', 'ProductController@searchproducts')->name('searchproducts');
        Route::get('/productdetail/{id}', 'ProductController@productdetail')->name('productdetail');
        Route::get('admincheckoutform', 'OrderController@admincheckoutform')->name('admincheckoutform');
        Route::get('adminorders', 'AccountController@adminorders')->name('adminorders');
        Route::get('adminorderdetail/{id}', 'AccountController@adminorderdetail')->name('adminorderdetail');
        Route::get('admin_cart_detail/{id}', 'OrderController@admin_cart_detail')->name('admin_cart_detail');

        Route::get('/editdetail/{id}', 'ProductController@editdetail')->name('editdetail');

        //customer
        Route::get('/customers', 'CustomerController@index')->name('customers');
        Route::get('/customerdetail/{id}', 'CustomerController@customerdetail')->name('customerdetail');

        Route::get('/search', 'ProductController@search')->name('search');
        Route::get('/searchbydate', 'OrderController@search')->name('searchbydate');
        Route::get('/searchallo', 'OrderController@searcho')->name('searchallo');
        Route::get('/searchalld', 'OrderController@searchd')->name('searchalld');
        Route::get('/searchallp', 'OrderController@searchp')->name('searchallp');
        Route::get('/searchallc', 'OrderController@searchc')->name('searchallc');
        Route::get('/searchbydateo', 'OrderController@searchbydateo')->name('searchbydateo');
        Route::get('/searchbydated', 'OrderController@searchbydated')->name('searchbydated');
        Route::get('/searchbydatep', 'OrderController@searchbydatep')->name('searchbydatep');
        Route::get('/searchbydatec', 'OrderController@searchbydatec')->name('searchbydatec');
        Route::get('/searchxls', 'OrderController@searchxls')->name('searchxls');
        Route::get('/ddsearch', 'OrderController@ddsearch')->name('ddsearch');
        Route::get('/ddadminsearch', 'OrderController@ddadminsearch')->name('ddadminsearch');
        Route::get('/searchbydatedaily', 'OrderController@searchdaily')->name('searchbydatedaily');
        Route::post('/searchtotal', 'OrderController@searchtotal')->name('searchtotal');
        Route::get('/searchbydatedelivery', 'OrderController@searchdelivery')->name('searchbydatedelivery');

        Route::get('/cartadd/{id}', 'CartController@cartadd')->name('cartadd');
        Route::get('/cartview', 'CartController@cartview');
        Route::patch('/update-cart', 'CartController@update');
        Route::patch('/update_order_cart', 'CartController@update_order_cart');
        Route::patch('/update-cart-sub', 'CartController@updatesub');
        Route::patch('/update_order_cart_sub', 'CartController@update_order_cart_sub');
        
        // cartremove
        Route::get('/cart/remove/all', 'CartController@alldelete')->name('cart.alldelete');
        Route::delete('cart/remove-from-cart', 'CartController@remove')->name('cart.remove-from-cart');
        Route::delete('cart/remove-from-order-cart', 'CartController@remove_order_cart')->name('cart.remove-from-order-cart');

        //admin order 
        Route::delete('orderdelivery/{id}', 'OrderController@orderdelivery')->name('orders.orderdelivery');


        Route::get('checkoutform', 'OrderController@checkoutform')->name('checkoutform');
        Route::post('checkout', 'OrderController@checkout')->name('checkout');
        Route::post('cart_checkout', 'OrderController@cart_checkout')->name('cart_checkout');
        Route::get('order', 'OrderController@order')->name('order');
        Route::get('order_cart', 'OrderController@order_cart')->name('order_cart');
        Route::delete('order_cart_delete/{id}', 'OrderController@order_cart_delete')->name('order_cart_delete');
        Route::get('order_cart_edit/{id}', 'OrderController@order_cart_edit')->name('orders.order_cart_edit');
        Route::get('order_cart_editp/{id}', 'OrderController@order_cart_editp')->name('orders.order_cart_editp');
        Route::put('order_cart_update/{id}', 'OrderController@order_cart_update')->name('orders.order_cart_update');
        Route::get('order_cart_confirm/{id}', 'OrderController@order_cart_confirm')->name('orders.order_cart_confirm');
        Route::get('cart_product/{id}', 'ProductController@cart_product')->name('products.cart_product');
        Route::get('cartadd_cart_order/{id}/{o_id}', 'CartController@cartadd_cart_order')->name('cartadd_cart_order');

        Route::get('orderdetail/{id}', 'OrderController@orderdetail')->name('orderdetail');
        Route::get('orderdetailsimple/{id}', 'OrderController@orderdetailsimple')->name('orderdetailsimple');
        Route::get('deliveryorderdetail/{id}', 'OrderController@deliveryorderdetail')->name('deliveryorderdetail');
        Route::delete('deleteorder/{id}', 'OrderController@destroy')->name('orders.destroy');
        Route::get('deliverystatus/{id}', 'OrderController@deliverystatus')->name('deliverystatus');
        Route::post('orderdelivery/{id}', 'OrderController@orderdelivery')->name('orderdelivery');
        Route::post('orderdeliverysearch/{id}', 'OrderController@orderdeliverysearch')->name('orderdeliverysearch');
        Route::get('deliverystatussearch/{id}', 'OrderController@deliverystatussearch')->name('deliverystatussearch');
        Route::get('editorderdetail', 'OrderController@editOrderDetail')->name('editOrderDetail');

        //all order
        Route::get('totalsaledetail/{id}', 'OrderController@totalsaledetail')->name('totalsaledetail');
        Route::get('totalsalebydate/{id}/{from}/{to}', 'OrderController@totalsalebydate')->name('totalsalebydate');
        Route::get('deliverydetail/{id}', 'OrderController@deliverydetail')->name('deliverydetail');
        Route::get('totalsale', 'OrderController@totalsale')->name('totalsale');

        Route::get('orderprepare', 'OrderController@orderprepare')->name('orderprepare');
        Route::get('delivery', 'OrderController@delivery')->name('delivery');
        Route::get('payment', 'OrderController@payment')->name('payment');
        Route::get('complete', 'OrderController@complete')->name('complete');
        //filter dstatus by date
        Route::get('orderpreparef/{from}/{to}', 'OrderController@orderpreparef')->name('orderpreparef');
        Route::get('deliveryf/{from}/{to}', 'OrderController@deliveryf')->name('deliveryf');
        Route::get('paymentf/{from}/{to}', 'OrderController@paymentf')->name('paymentf');
        Route::get('completef/{from}/{to}', 'OrderController@completef')->name('completef');
        
        //daily order
        Route::get('orderprepared', 'OrderController@orderprepared')->name('orderprepared');
        Route::get('deliveryd', 'OrderController@deliveryd')->name('deliveryd');
        Route::get('paymentd', 'OrderController@paymentd')->name('paymentd');
        Route::get('completed', 'OrderController@completed')->name('completed');
        Route::get('export/{from}/{to}', 'OrderController@export')->name('export');
        Route::get('ddexport/{from}/{to}', 'OrderController@ddexport')->name('ddexport');

        //daily order filterbydate
        Route::get('orderpreparedf/{from}/{to}', 'OrderController@orderpreparedf')->name('orderpreparedf');
        Route::get('deliverydf/{from}/{to}', 'OrderController@deliverydf')->name('deliverydf');
        Route::get('paymentdf/{from}/{to}', 'OrderController@paymentdf')->name('paymentdf');
        Route::get('completedf/{from}/{to}', 'OrderController@completedf')->name('completedf');
        
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

        // Barcode
        Route::get('barcode', 'BarcodeController@barcode')->name('barcode');

        //Advertise
        Route::resource('adv_products', 'AdvertiseProductController');

    });

   
    Route::get('searchdo/{id}', 'AccountController@searchdo')->name('searchdo');
    
    Route::group(['middleware' => ['auth', 'delivery']], function ()
	{       
        Route::get('orderd', 'AccountController@orderd')->name('orderd');
        Route::post('searchd', 'AccountController@searchp')->name('searchd');
        Route::get('deliverydd', 'AccountController@delivery')->name('deliverydd'); 
        Route::get('deliverystatusd/{id}', 'AccountController@deliverystatus')->name('deliverystatusd');
        Route::get('deliverystatusdd/{id}', 'AccountController@deliverystatusd')->name('deliverystatusdd');
        Route::get('orderdetaild/{id}', 'AccountController@orderdetail')->name('orderdetaild');

    });
    
    Route::group(['middleware' => ['auth', 'order']], function ()
	{
        Route::get('orderp', 'AccountController@order')->name('orderp');
        Route::post('searchp', 'AccountController@searchp')->name('searchp');
        Route::post('orderdeliveryp/{id}', 'AccountController@orderdelivery')->name('orderdeliveryp');
        Route::post('orderdeliverypp/{id}', 'AccountController@orderdeliveryp')->name('orderdeliverypp');
        Route::get('orderpreparep', 'AccountController@orderprepare')->name('orderpreparep');
        Route::get('orderdetailp/{id}', 'AccountController@orderdetail')->name('orderdetailp');
        Route::get('orderdetailpo/{id}', 'AccountController@orderdetailo')->name('orderdetailpo');

    });
    Route::group(['middleware' => ['auth', 'sale']], function ()
	{
        
    //pos
    Route::post('/load_data', 'PosSaleController@load_data')->name('load_data');
    Route::get("salesload/data",'PosSaleController@pageload');
    Route::get('/pos', 'PosSaleController@pos')->name('pos');
    Route::get("sales/data", 'PosSaleController@data');
    Route::get("sales/remove", 'PosSaleController@remove');
    Route::get("sales/allremove", 'PosSaleController@allremove');
    Route::post("sales/confirm", 'PosSaleController@confirm');
    Route::get("salesqualtity/qtyadd",'PosSaleController@qtyadd');
    Route::get("sales/report",'PosSaleReportController@report')->name('report');
    Route::get("sales/search",'PosSaleReportController@salesearch')->name('sale-search');
    Route::get("sales/detail/{id}",'PosSaleReportController@detail')->name('sale-detail');
    Route::get("sales/totalsale",'PosSaleReportController@dailytotal')->name('total-sale');

    });



    Route::get('/{vue_capture?}', function () {
        return view('home');
      })->where('vue_capture', '[\/\w\.-]*');