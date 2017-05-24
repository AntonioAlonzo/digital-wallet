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
        Route::patch('/wallets/{id}', 'WalletController@update');

        Route::get('/categories', 'CategoryController@index');
        Route::get('/categories/{id}', 'CategoryController@show');

        Route::get('/currencies', 'CurrencyController@index');
        Route::get('/currencies/{id}', 'CurrencyController@show');

        Route::get('/transactions' , 'TransactionController@index');
        Route::get('/transactions/{id}' , 'TransactionController@show');
        Route::post('/transactions' , 'TransactionController@store');
        Route::delete('/transactions/{id}', 'TransactionController@destroy');
        Route::patch('/transactions/{id}', 'TransactionController@update');

        Route::get('/transfers' , 'TransferController@index');
        Route::get('/transfers/{id}' , 'TransferController@show');
        Route::post('/transfers' , 'TransferController@store');
    });

});

