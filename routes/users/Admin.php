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
