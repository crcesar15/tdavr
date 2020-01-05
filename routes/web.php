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

//Login Routes
Route::get('/', 'AuthController@verifyUser');
Route::get('/test', function (){
   $patients = \App\Patient::with('Records')->first();
   dd($patients->Records);
});

Route::get('login', 'AuthController@getLogin')->name('login');
Route::get('logout', 'AuthController@getLogout')->name('logout');
Route::post('login', 'AuthController@postLogin')->name('postLogin');

// User Management Routes...
Route::middleware('auth')->prefix('/')->group(function (){
    Route::get('register', 'AuthController@getRegister')->name('register');
    Route::post('register', 'AuthController@postRegister')->name('saveUser');
    Route::get('getUserInfo/{id}', 'UsersController@getUserInfo')->name('getUserInfo');
    Route::get('createPatient', 'UsersController@createPatient')->name('createPatient');
    Route::get('createEmployee', 'UsersController@createEmployee')->name('createEmployee');
    Route::post('registerPatient', 'UsersController@registerPatient')->name('registerPatient');
    Route::post('registerEmployee', 'UsersController@registerEmployee')->name('registerEmployee');
});

//Administrator Routes
Route::middleware('auth')->prefix('/admin')->group(function (){
    Route::get('home', 'AdminController@home')->name('admin.home');
    Route::get('listUsers', 'AdminController@listUsers')->name('admin.users');
    Route::get('listEmployees', 'AdminController@listEmployees')->name('admin.listEmployees');
    Route::get('listPatients', 'AdminController@listPatients')->name('admin.listPatients');
    Route::get('asignPatients', 'AdminController@asignPatients')->name('admin.asignPatients');
});

