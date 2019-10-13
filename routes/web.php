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
Route::get('register', 'AuthController@getRegister')->name('register')->middleware('auth');
Route::post('register', 'AuthController@postRegister')->name('saveUser')->middleware('auth');
Route::get('getUserInfo/{id}', 'UsersController@getUserInfo')->name('getUserInfo')->middleware('auth');
Route::get('createPatient', 'UsersController@createPatient')->name('createPatient')->middleware('auth');
Route::get('createEmployee', 'UsersController@createEmployee')->name('createEmployee')->middleware('auth');
Route::post('registerPatient', 'UsersController@registerPatient')->name('registerPatient')->middleware('auth');
Route::post('registerEmployee', 'UsersController@registerEmployee')->name('registerEmployee')->middleware('auth');

//Administrator Routes
Route::middleware('auth')->prefix('/admin')->group(function (){
    Route::get('home', 'AdminController@home')->name('admin.home');
    Route::get('listUsers', 'AdminController@listUsers')->name('admin.users');
});

