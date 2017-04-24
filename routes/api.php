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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/auth', 'Auth\AuthController@authenticate');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/wallets', 'WalletController@index');
        Route::get('/wallets/{id}', 'WalletController@show');
        Route::post('/wallets', 'WalletController@store');
        Route::delete('/wallets/{id}', 'WalletController@destroy');
        Route::put('/wallets/{id}', 'WalletController@modify');
        Route::patch('/wallets/{id}', 'WalletController@update');
    });
});

