<?php

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

/**
 * Web
 */
Route::group([
    'middleware' => [
        'web',
    ],
],
function ()
{
    Auth::routes();
    
    Route::get('/',                     'WelcomeController@index');
    Route::get('home',                  'HomeController@index')->name('home');

    /**
     * sample
     */
    Route::group([
        'prefix'    => 'sample',
        'namespace' => 'Sample',
    ],
    function ()
    {
        /**
         * api
         */
        Route::group([
            'prefix'    => 'api',
            'namespace' => 'Api',
        ],
        function ()
        {
            Route::get('/',             'EccubeApiController@index')->name('sample.api');
            Route::get('customers',     'CustomersController@index')->name('sample.api.customers');
            Route::get('orders',        'OrdersController@index')->name('sample.api.orders');
            Route::get('products',      'ProductsController@index')->name('sample.api.products');

            /**
             * sample
             */
//             Route::group([
//                 'prefix'    => 'sample',
//                 'namespace' => 'Sample',
//             ],
//                 function ()
//                 {
//                     Route::get('api',          'ApiController@index')->name('sample.api');
//             });
        });
    });
});
