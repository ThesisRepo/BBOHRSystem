<?php
// home
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

// userInformation
Route::get('user_info/{id}','UserInformationController@show')->name('user_info.find');
Route::post('user_info/update/{id}','UserInformationController@update')->name('user_info.update');

// LeaveRequest
Route::get('leave_request','LeaveRequestController@index')->name('user_info.index');
