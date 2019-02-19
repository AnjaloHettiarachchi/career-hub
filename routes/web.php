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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Index Page
Route::get('/', 'SiteController@showIndex')->name('site.index');

Auth::routes();

//Student Routes
Route::prefix('students')->group(function () {

    Route::get('/', 'StudentController@showIndex')->name('students.index');

});

//Admin Routes
Route::prefix('admins')->group(function () {

    Route::get('/login', 'auth\AdminLoginController@showAdminLogin')->name('admins.showLogin');
    Route::post('/login', 'auth\AdminLoginController@doAdminLogin')->name('admins.doLogin');
    Route::get('/register', 'auth\AdminLoginController@showAdminRegister')->name('admins.showRegister');
    Route::post('/register', 'auth\AdminLoginController@doAdminRegister')->name('admins.doRegister');
    Route::get('/dashboard', 'AdminController@showDashboard')->name('admins.dashboard');
    Route::post('/logout', 'auth\AdminLoginController@logout')->name('admins.logout');

});
