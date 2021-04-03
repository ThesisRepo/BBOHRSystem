<?php
Route::get('admin/pending_requests','RequestsController@all');

Route::get('admin/leave_request/pending','Requests\LeaveRequestController@pending');

Route::post('admin/leave_request/feedback/{id}','Requests\LeaveRequestController@requestFeedback');

Route::get('admin/leave_request','Requests\LeaveRequestController@getAllNonPendingLeaveRequest');

Route::get('admin/shift_change_request/pending','Requests\ShiftChangeRequestController@pending');

Route::post('admin/shift_change_request/feedback/{id}','Requests\ShiftChangeRequestController@requestFeedback');

Route::get('admin/shift_change_request','Requests\ShiftChangeRequestController@getAllNonPendingLeaveRequest');

Route::get('admin/overtime_request/pending','Requests\OvertimeRequestController@pending');

Route::post('admin/overtime_request/feedback/{id}','Requests\OvertimeRequestController@requestFeedback');

Route::get('admin/overtime_request','Requests\OvertimeRequestController@getAllNonPendingLeaveRequest');

Route::get('admin/petty_cash_request/pending','Requests\PettyCashRequestController@pending');

Route::post('admin/petty_cash_request/feedback/{id}','Requests\PettyCashRequestController@requestFeedback');

Route::get('admin/petty_cash_request','Requests\PettyCashRequestController@getAllNonPendingLeaveRequest');

Route::get('admin/budget_request/pending','Requests\BudgetRequestController@pending');

Route::post('admin/budget_request/feedback/{id}','Requests\BudgetRequestController@requestFeedback');

Route::get('admin/budget_request','Requests\BudgetRequestController@getAllNonPendingLeaveRequest');

Route::get('admin/travel_auth_request/pending','Requests\TravelAuthRequestController@pending');

Route::post('admin/travel_auth_request/feedback/{id}','Requests\TravelAuthRequestController@requestFeedback');

Route::get('admin/travel_auth_request','Requests\TravelAuthRequestController@getAllNonPendingLeaveRequest');
