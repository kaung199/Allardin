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


    Route::get('/{vue_capture?}', function () {
        return view('home');
      })->where('vue_capture', '[\/\w\.-]*');