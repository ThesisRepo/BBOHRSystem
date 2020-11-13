<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::group(
    [
        'namespace' => 'Auth'
    ], 

    function () {

        Route::get('login', 'LoginController@login')->name('login');

        Route::post('login', 'LoginController@authenticate');

        //edit
        // Route::get('logout', 'LoginController@logout')->name('logout');

        Route::post('logout', 'LoginController@logout')->name('logout');
    
        Route::get('forget-password', 'ForgotPasswordController@getEmail')->name('password.request');
    
        Route::post('forget-password', 'ForgotPasswordController@postEmail');

        Route::get('reset-password/{token}', 'ResetPasswordController@getPassword')->name('password.reset');

        Route::post('reset-password', 'ResetPasswordController@updatePassword');

        Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');

        Route::get('/email/verify/{id}', 'VerificationController@verify')->name('verification.verify');

        Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');

    }
);
Route::get('user/activation/{token}','Auth\LoginController@userActivationToken');

Route::get('/', function () {
    return redirect()->route('login');
}); 

Route::get('google', function () {
    return view('googleAuth');
});

Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');

Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
