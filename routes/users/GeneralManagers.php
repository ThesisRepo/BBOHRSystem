<?php
// get all of pending request 
Route::get('gm/user_info/pending_requests/{user_id}','UserInformationController@getAllPendingRequests')->name('hr.user_info.find.all_pending_requests');
