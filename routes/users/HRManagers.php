<?php

// create new users

// var params = {   
//   role_id: 2,        
//   first_name: 'mddion',
//   last_name: 'balugo',
//   email: 'maridn@gail.com',
//   password: '123456789',
//   password_confirmation: '123456789',
//   department_id :  1, 
//   shift_time_id: 1,
//   gender: 1,
//   company_number: '123456',
//   profile_url: null,
//   company_position: 'bagger',
//   date_hired: '2020-12-12',
//   company_status:'regular',
//   birthday: '2020-10-10',
//   allowed_leave_number: 10,
//   address: 'paa, hilongos, leyte',
//   civil_status: 'single',
//   contact_number: '012346481',
//   pag_ibig_number:'12313',
//   sss_number:'1563',
//   tin_number:'146512',
//   philhealth_number:'561'
// }
Route::get('hr/manage/user','UserInformationController@show')->name('user.manage.show');
Route::get('hr/manage/user/{id}','UserInformationController@find')->name('user.manage.find');
Route::post('hr/manage/user','UserInformationController@store')->name('user.manage.store');
Route::post('hr/manage/user/{id}','UserInformationController@update')->name('user.manage.update');
Route::delete('hr/manage/user/{id}','UserInformationController@delete')->name('user.manage.delete');


