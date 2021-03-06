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

Route::get('text/{id}', 'Text@get');
Route::resource('add','Text');

Route::resource('search','Search');
Route::resource('pivoting','Pivoting');
Route::resource('newSearch','NewSearch');