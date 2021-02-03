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

Route::get('/run', function() {
    $client = new CybsSoapClient();
    $request = $client->createRequest('trippickup_egp');

    $card = new stdClass();
    $card->accountNumber = '4111111111111111';
    $card->expirationMonth = '12';
    $card->expirationYear = '2020';
    $request->card = $card;

    // Populate $request here with other necessary properties

    $reply = $client->runTransaction($request);
    dd($reply);
});
