<?php

Route::view('/', 'welcome');

// Status Route
Route::get('statuses', 'StatusesController@index')->name('statuses.index');
Route::post('statuses', 'StatusesController@store')->name('statuses.store');

// Status Like Route
Route::post('statuses/{status}/likes', 'StatusLikeController@store')->name('statuses.likes.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
