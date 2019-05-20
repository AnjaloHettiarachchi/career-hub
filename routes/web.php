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

//Admin Routes
Route::prefix('admin')->group(function () {

    Route::get('/login', 'Auth\AdminLoginController@showAdminLogin')->name('admins.showLogin');
    Route::post('/login', 'Auth\AdminLoginController@doAdminLogin')->name('admins.doLogin');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admins.logout');

    Route::get('/register', 'AdminController@showAdminRegister')->name('admins.showRegister');
    Route::post('/register', 'AdminController@doAdminRegister')->name('admins.doRegister');
    Route::get('/dashboard', 'AdminController@showDashboard')->name('admins.dashboard');

    Route::get('/students', 'AdminSectionsController@students')->name('admin.sections.student');
    Route::get('/companies', 'AdminSectionsController@companies')->name('admin.sections.companies');

});

//Company Routes
Route::prefix('company')->group(function () {

    Route::get('/', 'SiteController@showCompanyIndex')->name('companies.index');

    Route::get('/login', 'Auth\CompanyLoginController@showCompanyLogin')->name('companies.showLogin');
    Route::post('/login', 'Auth\CompanyLoginController@doCompanyLogin')->name('companies.doLogin');
    Route::post('/logout', 'Auth\CompanyLoginController@logout')->name('companies.logout');

    Route::get('/register', 'Auth\CompanyRegisterController@showCompanyRegister')->name('companies.showRegister');
    Route::post('/register', 'Auth\CompanyRegisterController@doCompanyRegister')->name('companies.doRegister');

    Route::get('{id}/home', 'CompanyController@showHome')->name('companies.home');
    Route::get('/create', 'CompanyController@showCreate')->name('companies.showCreate');
    Route::post('/create', 'CompanyController@doCreate')->name('companies.doCreate');

    //Miscellaneous
    Route::get('/stuList', 'CompanyController@listStudents')->name('companies.stuList');


});

//Student Routes
Route::prefix('student')->group(function () {
    Route::get('/', 'SiteController@showStudentIndex')->name('students.index');

    Route::get('/login', 'Auth\StudentLoginController@showStudentLogin')->name('students.showLogin');
    Route::post('/login', 'Auth\StudentLoginController@attemptLogin')->name('students.doLogin');
    Route::post('/logout', 'Auth\StudentLoginController@logout')->name('students.logout');

    Route::get('{id}/home', 'StudentController@showHome')->name('students.home');
    Route::get('/create', 'StudentController@showCreate')->name('students.showCreate');
    Route::post('/create', 'StudentController@doCreate')->name('students.doCreate');
    Route::get('/skills', 'StudentController@showSkills')->name('students.showSkills');
    Route::post('/skills/save', 'StudentController@saveSkills')->name('students.saveSkills');
    Route::put('/{id}', 'StudentController@update')->name('students.update');

    //Miscellaneous
    Route::get('/comList', 'StudentController@listCompanies')->name('students.comList');
    Route::get('/degList', 'StudentController@listDegreePrograms')->name('students.degreeList');
    Route::get('/testOps/{id}', 'StudentController@sortOpportunities')->name('students.testOps');

    //Generate Letter
    Route::get('/generate', 'StudentController@generateLetter')->name('students.generateLetter');

});

//Conversation Routes
Route::prefix('conversations')->group(function () {

    Route::post('/', 'ConversationController@store')->name('conversations.store');
    Route::post('/get', 'ConversationController@getDocId')->name('conversations.get');

});

//Resources
Route::resource('stuIdTypes', 'StudentIdTypeController');

Route::resource('degreePrograms', 'DegreeProgramController');

Route::resource('faculties', 'FacultyController');

Route::resource('universities', 'UniversityController');

Route::resource('opportunities', 'OpportunityController');

Route::resource('skills', 'SkillController');

Route::resource('achievements', 'AchievementController');

