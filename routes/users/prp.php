<?php

// get all feedbacked leave request that belongs of approver
Route::get('prp/leave_request/feedbacked/{user_id}','Requests\LeaveRequestController@getAllFeedbackedRequest')->name('prp.get_all_feedbacked_leave_request');

// get all approved leave request that belongs of approver
Route::get('prp/leave_request/approved/{user_id}','Requests\LeaveRequestController@getAllApprovedRequest')->name('prp.get_all_approved_leave_request');

// get all disapproved leave request that belongs of approver
Route::get('prp/leave_request/disapproved/{user_id}','Requests\LeaveRequestController@getAllDisapprovedRequest')->name('prp.get_all_disapproved_leave_request');

// get all pending leave request that belongs of approver
Route::get('prp/leave_request/pending/{user_id}','Requests\LeaveRequestController@getPendingRequest')->name('leave_request.get_pending_request_to_approve');

// approve or disapprove a leave request
Route::post('prp/leave_request/feedback/{id}','Requests\LeaveRequestController@requestFeedback')->name('leave_request.feedback');
