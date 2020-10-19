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

//edit pp
Route::post('changePP','UserInformationController@updatePP')->name('user_info.update');



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

// update change request
Route::post('shift_change_request/{id}','Requests\ShiftChangeRequestController@update')->name('shift_change_request.update');

// delete change request
Route::delete('shift_change_request/{id}','Requests\ShiftChangeRequestController@delete')->name('shift_change_request.delete');


// -- OVERTIME REQUEST

// add overtime request
Route::post('overtime_request','Requests\OvertimeRequestController@store')->name('overtime_request.store');

// retrieve all overtime request of a user
Route::get('overtime_request/{id}','Requests\OvertimeRequestController@show')->name('overtime_request.find');

// update overtime request
Route::post('overtime_request/{id}','Requests\OvertimeRequestController@update')->name('overtime_request.update');

// delete overtime request
Route::delete('overtime_request/{id}','Requests\OvertimeRequestController@delete')->name('overtime_request.delete');


// -- Department

//get all departments
Route::get('departments','DepartmentController@index')->name('departments.retrieve');


// -- PETTY CASH REQUEST

// add petty cash request
Route::post('petty_cash_request','Requests\PettyCashRequestController@store')->name('petty_cash_request.store');

// retrieve all petty cash request of a user
Route::get('petty_cash_request/{id}','Requests\PettyCashRequestController@show')->name('petty_cash_request.find');

// update petty cash request
Route::post('petty_cash_request/{id}','Requests\PettyCashRequestController@update')->name('petty_cash_request.update');

// delete petty cash request
Route::delete('petty_cash_request/{id}','Requests\PettyCashRequestController@delete')->name('petty_cash_request.delete');
