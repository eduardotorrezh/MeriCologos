<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return "Mericologos API";
    // return view('test');
});

Route::namespace('App\Http\Controllers\Api')->group(function (){
    // Route::get('/paypal/pay', 'PaymentController@payWithPayPal')->name('make.payment');
    // Route::get('/paypal/status', 'PaymentController@payPalStatus');
    // Route::get('/paypal2/status/{saleInfo}', 'DateController@payPalStatus');
});
