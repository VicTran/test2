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
    return view('home');
});

// Auth 
Auth::routes();

Route::get('register/verify/{token}','Auth\RegisterController@verify');
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

// Profile 
Route::get('show-profile','ProfileController@showProfileToUser')->name('show-profile');
Route::get('determine-profile-route','ProfileController@determineProfileRoute')->name('determine-profile-route');
Route::resource('profile','ProfileController');

//Admin
Route::get('/admin','AdminController@index')->name('admin');

//User 
Route::resource('user','UserController');
Route::get('change-new-password/{user}/edit','ChangeNewPasswordController@edit');
Route::match(array('POST'), "/change-new-password/{id}", array(
      'uses' => 'ChangeNewPasswordController@update',
      'as' => 'ChangeNewPassword.update'
));



