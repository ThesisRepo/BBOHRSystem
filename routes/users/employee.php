<?php
// home
Route::get('/home', 'Employees\HomeController@index')->name('home')->middleware('verified');

// userInformation
Route::resource('user_info', Employees\UserInformationController::class)->except(['create', 'edit']);
