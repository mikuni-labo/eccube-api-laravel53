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
    
    Route::get('/',        'Controller@welcome');
    
    Route::get('home',     'HomeController@index');
    
    Route::get('test',     'TestController@index');
});
