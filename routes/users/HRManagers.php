<?php

//create new users
Route::post('hr/user_info','UserInformationController@store')->name('user_info.store');
