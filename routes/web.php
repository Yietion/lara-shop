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

Route::get('/', 'Pagescontroller@root')->name('root');

Auth::routes();

Route::group(['middleware'=>'auth'], function(){
    Route::get('/email_verify_notice', 'PagesController@emailVerifyNotice')->name('email_verify_notice');
    Route::get('/email_verification/send', 'EmailVerificationController@send')->name('email_verification.send');
    Route::get('/email_verification/verify', 'EmailVerificationController@verify')->name('email_verification.verify');
    //开始
    Route::group(['middleware'=>'email_verified'], function(){
        //收件地址
        Route::resource('user-addresses', 'UserAddressesController');
    });
});