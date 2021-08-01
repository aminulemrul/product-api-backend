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

Route::post('/login', 'APILoginController@login');
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'APILoginController@logout');
    Route::get('/products', 'ProductsController@index');
    Route::post('/products', 'ProductsController@store');
    Route::get('/products/{product}', 'ProductsController@show');
    Route::put('/products/{product}', 'ProductsController@update');
    Route::delete('/product/{product}', 'ProductsController@destroy')->name('product.destroy');
});


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
