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

//upload img
Route::post('/update/user/icon', 'HomeController@updateUserIcon')
    -> name('update-icon');

//delete img
Route::get('/clear/user/icon', 'HomeController@clearUserIcon')
    -> name('clear-icon');