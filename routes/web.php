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

use Illuminate\Support\Facades\Mail;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->route('home');
Route::get('/find', 'HomeController@findCreators');

Route::post('/google-sign', 'HomeController@googleSign');

Route::get('/actvate_user', 'HomeController@activateUser');

Route::get('/test', function() {
    $user = Auth::user();
    $mi = $user->id;
    return $user;
});

Route::get('/mail', function() {
    $msg = \App\Message::all()->first();
    $user = \App\User::all()->first();

    $mail = new \App\Mail\MessageReceived($msg);

    Mail::to($user)->send($mail);
    return $mail;
});
Auth::routes();
Route::get('/messages', 'HomeController@showMessages');
Route::post('/messages/{id}/send', 'HomeController@sendMessage');

Route::get('/profile/{slug?}', 'HomeController@profile');
Route::post('/profile', 'HomeController@updateProfile');
Route::get('/settings', 'HomeController@settings');

Route::get('/payment/confirm', 'HomeController@paymentConfirm');
Route::get('/payment/cancel', 'HomeController@paymentCancel');
Route::get('/payment/test', 'HomeController@testPayment');

Route::get('/subscribe/confirm', 'HomeController@confirmSubscription');
Route::get('/subscribe/cancel', 'HomeController@cancelSubscription');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');