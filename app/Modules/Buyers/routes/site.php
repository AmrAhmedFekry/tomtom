<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Buyers Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your main "front office" application.
| Please note that this file is auto imported in the main routes file, so it will inherit the main "prefix"
| and "namespace", so don't edit it to add for example "api" as a prefix.
*/

Route::post('/buyers/register', 'Modules\Buyers\Controllers\Site\BuyersController@store');
Route::post('/buyers/login', 'Modules\Buyers\Controllers\Site\Auth\LoginController@index')->name('login');
Route::post('/buyers/forget-password', 'Modules\Buyers\Controllers\Site\Auth\ForgetPasswordController@index');
Route::post('/buyers/reset-password', 'Modules\Buyers\Controllers\Site\Auth\ResetPasswordController@index');

Route::group([
    'namespace' => 'Modules\Buyers\Controllers\Site',
], function () {
    // list records
    Route::get('/buyers', 'BuyersController@index');
    // one record
    Route::get('/buyers/{id}', 'BuyersController@show');
    // Child routes
});
