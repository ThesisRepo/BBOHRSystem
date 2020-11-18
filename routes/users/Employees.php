<?php

// home
// Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/', 'HomeController@index')->name('home');


// -- USER INFORMATION

//get user info of a user
Route::get('user_info/{id}','UserInformationController@show')->name('user_info.find');

// updates user info
Route::post('user_info/{id}','UserInformationController@update')->name('user_info.update');

//get all per department prps
Route::get('prp/{user_id}','UserInformationController@getAllPrpInDepartment')->name('user_info.all.department.prp');

//get all prps
Route::get('prp','UserInformationController@getAllPrp')->name('user_info.all.prp');

//update prp
Route::post('prp/{user_id}','UserInformationController@updatePrp')->name('user_info.update.prp');

//get all Finance
Route::get('finance','UserInformationController@getAllFinance')->name('user_info.find.finance');

//update Finance
Route::post('finance/{user_id}','UserInformationController@updateFinance')->name('user_info.update.finance');

//edit profile pic
Route::post('update_profile_img/{id}','UserInformationController@updateProfileImg')->name('user_info.update_profile_img');

// get all of pending request 
Route::get('user_info/pending_requests/{user_id}','UserInformationController@getAllPendingRequests')->name('user_info.find.all_pending_requests');


// get count of approved request 
Route::get('user_info/approved_requests/count/{user_id}','UserInformationController@getCountApprovedRequests')->name('user_info.find.count.all_approved_requests');

// get count of pending request 
Route::get('user_info/pending_requests/count/{user_id}','UserInformationController@getCountPendingRequests')->name('user_info.find.count.all_pending_requests');


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

// prp_assigned_id:5,
// user_id:4,
// reason:'hdfddaman',
// shift_date: '2020-10-10',
// shift_time-id: 1,

// add shift change request
Route::post('shift_change_request','Requests\ShiftChangeRequestController@store')->name('shift_change_request.store');

// retrieve all shift change request of a user
Route::get('shift_change_request/{id}','Requests\ShiftChangeRequestController@show')->name('shift_change_request.find');

// update change request
Route::post('shift_change_request/{id}','Requests\ShiftChangeRequestController@update')->name('shift_change_request.update');

// delete change request
Route::delete('shift_change_request/{id}','Requests\ShiftChangeRequestController@delete')->name('shift_change_request.delete');

// -- ShiftTime

//get all shift time
Route::get('shift_time','Dependencies\ShiftTimeController@index')->name('shift_time.retrieve');
Route::get('shift_time/mine','Dependencies\ShiftTimeController@getUserShiftTime')->name('shift_time.retrieve');

// -- OVERTIME REQUEST

// prp_assigned_id:5,
// user_id: 1,
// reason: 'over over',
// date: '2020-12-12',
// start_time: '12:30',
// end_time: '14:00',

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


//get all co-workers in department
Route::get('departments/employees','UserInformationController@getAllCoEmployeesInDepartment')->name('departments.employees.retrieve');

// -- PETTY CASH REQUEST

// prp_assigned_id:5,
// user_id:4,
// description_need:'hdfddaman',
// date: '2020-10-10',
// total_amount: '10000'

// add petty cash request
Route::post('petty_cash_request','Requests\PettyCashRequestController@store')->name('petty_cash_request.store');

// retrieve all petty cash request of a user
Route::get('petty_cash_request/{id}','Requests\PettyCashRequestController@show')->name('petty_cash_request.find');

// update petty cash request
Route::post('petty_cash_request/{id}','Requests\PettyCashRequestController@update')->name('petty_cash_request.update');

// delete petty cash request
Route::delete('petty_cash_request/{id}','Requests\PettyCashRequestController@delete')->name('petty_cash_request.delete');


// -- BUDGET REQUEST

// prp_assigned_id:5,
// user_id:4,
// description_need:'hdfddaman',
// date: '2020-10-10',
// total_amount: '10000',
// details: 'what are you talking aoub'

// add budget request
Route::post('budget_request','Requests\BudgetRequestController@store')->name('budget_request.store');

// retrieve all budget request of a user
Route::get('budget_request/{id}','Requests\BudgetRequestController@show')->name('budget_request.find');

// update budget request
Route::post('budget_request/{id}','Requests\BudgetRequestController@update')->name('budget_request.update');

// delete budget request
Route::delete('budget_request/{id}','Requests\BudgetRequestController@delete')->name('budget_request.delete');


// -- Travel Authorization REQUEST


// add travel authorization request
Route::post('travel_auth_request','Requests\TravelAuthRequestController@store')->name('travel_auth_request.store');

// retrieve all travel authorization request of a user
Route::get('travel_auth_request/{id}','Requests\TravelAuthRequestController@show')->name('travel_auth_request.find');

// update travel authorization request
Route::post('travel_auth_request/{id}','Requests\TravelAuthRequestController@update')->name('travel_auth_request.update');

// delete travel authorization request
Route::delete('travel_auth_request/{id}','Requests\TravelAuthRequestController@delete')->name('travel_auth_request.delete');

// submit multiple file
// Route::post('submit_multiple_files/{id}','UserInformationController@updateProfileImg')->name('user_info.update_profile_img');

// Route::get('event_types/{user_id}','EventTypeController@show')->name('event_type.show');
// Route::post('event_types','EventTypeController@store')->name('event_type.store');


Route::get('user_info/event_types/{user_id}','UserInformationController@getEventTypes')->name('user_info.event_type.show');

Route::post('user_info/event_types/{user_id}','UserInformationController@addEventTypes')->name('user_info.event_type.store');

Route::post('event_types/{id}','EventTypeController@update')->name('event_type.update');

Route::delete('event_types/{user_id}','EventTypeController@delete')->name('event_type.delete');

