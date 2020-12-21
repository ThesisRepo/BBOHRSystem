<?php
Route::get('admin/pending_requests','RequestsController@all')->name('pending_requests.all');

Route::get('admin/leave_request/pending','Requests\LeaveRequestController@pending')->name('pending_requests.all');

Route::post('admin/leave_request/feedback/{id}','Requests\LeaveRequestController@requestFeedback')->name('admin.leave_request.feedback');

Route::get('admin/leave_request','Requests\LeaveRequestController@getAllNonPendingLeaveRequest')->name('non.pending_requests.all');

Route::get('admin/shift_change_request/pending','Requests\ShiftChangeRequestController@pending')->name('pending_requests.all');

Route::post('admin/shift_change_request/feedback/{id}','Requests\ShiftChangeRequestController@requestFeedback')->name('admin.leave_request.feedback');

Route::get('admin/shift_change_request','Requests\ShiftChangeRequestController@getAllNonPendingLeaveRequest')->name('non.pending_requests.all');
