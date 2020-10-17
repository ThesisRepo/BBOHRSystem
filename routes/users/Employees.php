<?php

// home
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


// -- USER INFORMATION

//get user info of a user
Route::get('user_info/{id}','UserInformationController@show')->name('user_info.find');

// updates user info
Route::post('user_info/{id}','UserInformationController@update')->name('user_info.update');

//get all prps
Route::get('prp','UserInformationController@getAllPrp')->name('user_info.findPrp');


// -- LEAVE REQUEST

// add leave request
Route::post('leave_request','Requests\LeaveRequestController@store')->name('leave_request.store');

// get all leave request that belongs to user
Route::get('leave_request/{id}','Requests\LeaveRequestController@show')->name('leave_request.find');

// update leave request
Route::post('leave_request/{id}','Requests\LeaveRequestController@update')->name('leave_request.update');

// delete leave request
Route::delete('leave_request/{id}','Requests\LeaveRequestController@delete')->name('leave_request.delete');


// -- LeaveType

//get all leave types
Route::get('leave_type','Dependencies\LeaveTypeController@index')->name('leave_types.retrieve');


// -- SHIFT CHANGE REQUEST


// add shift change request
Route::post('shift_change_request','Requests\ShiftChangeRequestController@store')->name('shift_change_request.store');

// retrieve all shift change request of a user
Route::get('shift_change_request/{id}','Requests\ShiftChangeRequestController@show')->name('shift_change_request.find');
