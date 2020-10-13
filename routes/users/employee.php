<?php
// home
Route::get('/home', 'Employees\HomeController@index')->name('home')->middleware('verified');

// userInformation
Route::get('user_info/{id}','Employees\UserInformationController@show')->name('user_info.find');
Route::post('user_info','Employees\UserInformationController@store')->name('user_info.store');
Route::post('user_info/update/{id}','Employees\UserInformationController@update')->name('user_info.update');
