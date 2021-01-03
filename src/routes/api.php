<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/user', 'UserController@create');

Route::group([
  'middleware' => 'ensure_user'
], function () {
  Route::post('/profile', 'ProfileController@create');

  Route::get('/kampret', function () {
    return 'woww';
  });

  Route::post('/precheckout', 'CheckoutController@precheckout');

  Route::post('/checkout', 'CheckoutController@checkout');
});
