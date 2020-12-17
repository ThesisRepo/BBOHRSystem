<?php
Route::post('finance/summary/petty_cash_request/{user_id}','UserInformationController@getAllFeedbackedDatePettyCash')->name('finance.summary.petty_cash_request.approved');

Route::post('finance/summary/budget_request/{user_id}','UserInformationController@getAllFeedbackedDateBudget')->name('finance.summary.budget_request.approved');
