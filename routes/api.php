<?php

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

/**
 * Api (prefix:api)
 */
Route::group([
    'namespace' => 'Api',
    'middleware' => [
        'api',
    ],
],
function ()
{
    /**
     * Products
     */
    Route::group([
        'prefix' => 'products',
    ],
    function ()
    {
        Route::get('/',               'ProductsController@index')->name('api.products');
    });

    /**
     * Orders
     */
    Route::group([
        'prefix' => 'orders',
    ],
    function ()
    {
        Route::get('/',               'OrdersController@index')->name('api.orders');
    });

    /**
     * Customers
     */
    Route::group([
        'prefix' => 'customers',
    ],
    function ()
    {
        Route::get('/',               'CustomersController@index')->name('api.customers');
    });
});
