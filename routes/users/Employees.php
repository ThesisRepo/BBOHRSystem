<?php

// home
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

// userInformation
Route::get('user_info/{id}','UserInformationController@show')->name('user_info.find');
Route::post('user_info/{id}','UserInformationController@update')->name('user_info.update');

// LeaveRequest
Route::post('leave_request','Requests\LeaveRequestController@store')->name('leave_request.store');
// Route::post('leave_request/{id}','Requests\LeaveRequestController@index')->name('leave_request.index');
Route::get('leave_request/{id}','Requests\LeaveRequestController@show')->name('leave_request.find');
Route::post('leave_request/{id}','Requests\LeaveRequestController@update')->name('leave_request.update');
// Route::delete('leave_request/{id}','Requests\LeaveRequestController@delete')->name('leave_request.delete');

