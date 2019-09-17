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
    return view('welcome');
});
Route::get('dashboard','DashboardController@index')->name('dashboard');
Route::get('profile','ProfileController@profile')->name('usr.profile');
Route::get('login','AdminLoginController@adminLoginForm')->name('admin.loginForm');
Route::post('login','AdminLoginController@adminLogin')->name('admin.login');
