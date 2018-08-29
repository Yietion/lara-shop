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
Route::get('products', 'ProductsController@index')->name('products.index');

Auth::routes();

Route::group(['middleware'=>'auth'], function(){
    Route::get('/email_verify_notice', 'PagesController@emailVerifyNotice')->name('email_verify_notice');
    Route::get('/email_verification/send', 'EmailVerificationController@send')->name('email_verification.send');
    Route::get('/email_verification/verify', 'EmailVerificationController@verify')->name('email_verification.verify');
    //开始
    Route::group(['middleware'=>'email_verified'], function(){
        //收件地址
        Route::resource('user-addresses', 'UserAddressesController');
        Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
        Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
        Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');
        Route::post('cart', 'CartController@add')->name('cart.add');
        Route::get('cart', 'CartController@index')->name('cart.index');
        Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
    });
});
	Route::get('products/{product}', 'ProductsController@show')->name('products.show');