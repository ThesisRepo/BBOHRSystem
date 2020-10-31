<?php

// -- LEAVE REQUEST

// user_id:4,
// status_id:3,

// get all feedbacked leave request that belongs of approver
Route::get('prp/leave_request/feedbacked/{user_id}','Requests\LeaveRequestController@getAllFeedbackedRequest')->name('prp.leave_request.feedbacked');

// get all approved leave request that belongs of approver
Route::get('prp/leave_request/approved/{user_id}','Requests\LeaveRequestController@getAllApprovedRequest')->name('prp.leave_request.approved');

// get all disapproved leave request that belongs of approver
Route::get('prp/leave_request/disapproved/{user_id}','Requests\LeaveRequestController@getAllDisapprovedRequest')->name('prp.leave_request.disapproved');

// get all pending leave request that belongs of approver
Route::get('prp/leave_request/pending/{user_id}','Requests\LeaveRequestController@getPendingRequest')->name('prp.leave_request.pending');

// approve or disapprove a leave request
Route::post('prp/leave_request/feedback/{id}','Requests\p@requestFeedback')->name('prp.leave_request.feedback');


// -- SHIFT CHANGE REQUEST

// user_id:4,
// status_id:3,

// get all feedbacked shift change request that belongs of approver
Route::get('prp/shift_change_request/feedbacked/{user_id}','Requests\ShiftChangeRequestController@getAllFeedbackedRequest')->name('prp.shift_change_request.feedbacked');

// get all approved shift change request that belongs of approver
Route::get('prp/shift_change_request/approved/{user_id}','Requests\ShiftChangeRequestController@getAllApprovedRequest')->name('prp.shift_change_request.approved');

// get all disapproved lshift changeeave request that belongs of approver
Route::get('prp/shift_change_request/disapproved/{user_id}','Requests\ShiftChangeRequestController@getAllDisapprovedRequest')->name('prp.shift_change_request.disapproved');

// get all pending shift change request that belongs of approver
Route::get('prp/shift_change_request/pending/{user_id}','Requests\ShiftChangeRequestController@getPendingRequest')->name('prp.shift_change_request.pending');

// approve or disapprove a shift change request
Route::post('prp/shift_change_request/feedback/{id}','Requests\ShiftChangeRequestController@requestFeedback')->name('prp.shift_change_request.feedback');
