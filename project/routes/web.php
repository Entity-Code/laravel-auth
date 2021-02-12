<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index') 
    -> name('home');

//logica invio email 
Route::post('/send', 'HomeController@sendMail')
    -> name('send-mail');
