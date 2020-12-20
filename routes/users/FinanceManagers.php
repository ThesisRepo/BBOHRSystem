<?php
Route::post('finance/summary/petty_cash_request','UserInformationController@getAllFeedbackedDatePettyCash')->name('finance.summary.petty_cash_request.approved');

Route::post('finance/summary/budget_request','UserInformationController@getAllFeedbackedDateBudget')->name('finance.summary.budget_request.approved');
