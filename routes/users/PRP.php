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
Route::post('prp/leave_request/feedback/{id}','Requests\LeaveRequestController@requestFeedback')->name('prp.leave_request.feedback');

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


// -- OVERTIME REQUEST

// user_id:4,
// status_id:3,

// get all feedbacked overtime request that belongs of approver
Route::get('prp/overtime_request/feedbacked/{user_id}','Requests\OvertimeRequestsController@getAllFeedbackedRequest')->name('prp.overtime_request.feedbacked');

// get all approved overtime request that belongs of approver
Route::get('prp/overtime_request/approved/{user_id}','Requests\OvertimeRequestsController@getAllApprovedRequest')->name('prp.overtime_request.approved');

// get all disapproved overtime request that belongs of approver
Route::get('prp/overtime_request/disapproved/{user_id}','Requests\OvertimeRequestsController@getAllDisapprovedRequest')->name('prp.overtime_request.disapproved');

// get all pending overtimerequest that belongs of approver
Route::get('prp/overtime_request/pending/{user_id}','Requests\OvertimeRequestsController@getPendingRequest')->name('prp.overtime_request.pending');

// approve or disapprove a overtime request
Route::post('prp/overtime_request/feedback/{id}','Requests\OvertimeRequestsController@requestFeedback')->name('prp.overtime_request.feedback');


// -- TRAVEL AUTHORIZATION REQUEST

// user_id:4,
// status_id:3,

// get all feedbacked travel authorization request that belongs of approver
Route::get('prp/travel_auth_request/feedbacked/{user_id}','Requests\TravelAuthRequestsController@getAllFeedbackedRequest')->name('prp.travel_auth_request.feedbacked');

// get all approved travel authorization request that belongs of approver
Route::get('prp/travel_auth_request/approved/{user_id}','Requests\TravelAuthRequestsController@getAllApprovedRequest')->name('prp.travel_auth_request.approved');

// get all disapproved travel authorization request that belongs of approver
Route::get('prp/travel_auth_request/disapproved/{user_id}','Requests\TravelAuthRequestsController@getAllDisapprovedRequest')->name('prp.travel_auth_request.disapproved');

// get all pending travel authorization request that belongs of approver
Route::get('prp/travel_auth_request/pending/{user_id}','Requests\TravelAuthRequestsController@getPendingRequest')->name('prp.travel_auth_request.pending');

// approve or disapprove a travel authorization request
Route::post('prp/travel_auth_request/feedback/{id}','Requests\TravelAuthRequestsController@requestFeedback')->name('prp.travel_auth_request.feedback');


// -- BUDGET REQUEST

// user_id:4,
// status_id:3,

// get all feedbacked budget request that belongs of approver
Route::get('prp/budget_request/feedbacked/{user_id}','Requests\BudgetRequestsController@getAllFeedbackedRequest')->name('prp.budget_request.feedbacked');

// get all approved budget request that belongs of approver
Route::get('prp/budget_request/approved/{user_id}','Requests\BudgetRequestsController@getAllApprovedRequest')->name('prp.budget_request.approved');

// get all disapproved budget request that belongs of approver
Route::get('prp/budget_request/disapproved/{user_id}','Requests\BudgetRequestsController@getAllDisapprovedRequest')->name('prp.budget_request.disapproved');

// get all pending travel authorization request that belongs of approver
Route::get('prp/budget_request/pending/{user_id}','Requests\BudgetRequestsController@getPendingRequest')->name('prp.budget_request.pending');

// approve or disapprove a budget request
Route::post('prp/budget_request/feedback/{id}','Requests\BudgetRequestsController@requestFeedback')->name('prp.budget_request.feedback');


// -- PETTY CASH REQUEST

// user_id:4,
// status_id:3,

// get all petty cash budget request that belongs of approver
Route::get('prp/petty_cash_request/feedbacked/{user_id}','Requests\PettyCashRequestsController@getAllFeedbackedRequest')->name('prp.petty_cash_request.feedbacked');

// get all petty cash request that belongs of approver
Route::get('prp/petty_cash_request/approved/{user_id}','Requests\PettyCashRequestsController@getAllApprovedRequest')->name('prp.petty_cash_request.approved');

// get all petty cash budget request that belongs of approver
Route::get('prp/petty_cash_request/disapproved/{user_id}','Requests\PettyCashRequestsController@getAllDisapprovedRequest')->name('prp.petty_cash_request.disapproved');

// get all pending petty cash request that belongs of approver
Route::get('prp/petty_cash_request/pending/{user_id}','Requests\PettyCashRequestsController@getPendingRequest')->name('prp.petty_cash_request.pending');

// approve or disapprove a petty cash request
Route::post('prp/petty_cash_request/feedback/{id}','Requests\PettyCashRequestsController@requestFeedback')->name('prp.petty_cash_request.feedback');

// get all pending petty cash request that belongs of approver
Route::get('prp/petty_cash_request/pending','Requests\PettyCashRequestsController@getPendingRequestHR')->name('prp.petty_cash_request.pending');
