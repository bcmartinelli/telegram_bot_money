<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('cotacao');
});

Route::post('webhook/115524025:AAEGJD4EiE31ODPXlT1u-I0gAgKKKDQOpEg', 'CotacaoController@index');
