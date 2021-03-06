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

Route::get('/', ['as' => 'home', 'uses' => 'PhotoController@index']);
Route::get('photos/search', ['as' => 'search', 'uses' => 'PhotoController@search']);
Route::get('photos/{id}', ['as' => 'show', 'uses' => 'PhotoController@show'])->where('id', '[0-9]+');