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

//Company Routes
Route::prefix('companies')->group(function () {

    Route::get('/', 'SiteController@showCompanyIndex')->name('companies.index');

    Route::get('/login', 'auth\CompanyLoginController@showCompanyLogin')->name('companies.showLogin');
    Route::post('/login', 'auth\CompanyLoginController@doCompanyLogin')->name('companies.doLogin');
    Route::post('/logout', 'auth\CompanyLoginController@logout')->name('companies.logout');

    Route::get('/register', 'auth\CompanyRegisterController@showCompanyRegister')->name('companies.showRegister');
    Route::post('/register', 'auth\CompanyRegisterController@doCompanyRegister')->name('companies.doRegister');

    Route::get('/home', 'CompanyController@showHome')->name('companies.home');
    Route::get('/create', 'CompanyController@showCreate')->name('companies.showCreate');
    Route::post('/create', 'CompanyController@doCreate')->name('companies.doCreate');


});

//Admin Routes
Route::prefix('admins')->group(function () {

    Route::get('/login', 'auth\AdminLoginController@showAdminLogin')->name('admins.showLogin');
    Route::post('/login', 'auth\AdminLoginController@doAdminLogin')->name('admins.doLogin');
    Route::post('/logout', 'auth\AdminLoginController@logout')->name('admins.logout');

    Route::get('/register', 'AdminController@showAdminRegister')->name('admins.showRegister');
    Route::post('/register', 'AdminController@doAdminRegister')->name('admins.doRegister');
    Route::get('/dashboard', 'AdminController@showDashboard')->name('admins.dashboard');

});

Route::resource('opportunities', 'OpportunityController')->middleware('auth:company');
Route::resource('skills', 'SkillController');
