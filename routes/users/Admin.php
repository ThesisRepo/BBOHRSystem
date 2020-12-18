<?php
Route::get('admin/pending_requests','RequestsController@all')->name('pending_requests.all');

Route::get('admin/leave_request/pending','RequestsController@getAllPendingLeaveRequest')->name('pending_requests.all');

Route::post('admin/leave_request/feedback/{id}','Requests\LeaveRequestController@requestFeedback')->name('admin.leave_request.feedback');

Route::get('admin/leave_request','Requests\LeaveRequestController@getAllNonPendingLeaveRequest')->name('non.pending_requests.all');
