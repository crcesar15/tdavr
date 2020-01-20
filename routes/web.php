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

use App\Schedule;
use Carbon\Carbon;

Route::get('/', 'AuthController@verifyUser');
Route::get('/test', function (){
    $from = Carbon::now()->startOfWeek()->format('Y-m-d H:i');
    $to = Carbon::now()->endOfWeek()->format('Y-m-d H:i');
    $schedules = Schedule::with('Employee')->get();
   dd($schedules);
});

Route::get('login', 'AuthController@getLogin')->name('login');
Route::get('logout', 'AuthController@getLogout')->name('logout');
Route::post('login', 'AuthController@postLogin')->name('postLogin');

// User Management Routes...
Route::middleware('auth')->prefix('/')->group(function (){
    Route::get('register', 'AuthController@getRegister')->name('register');
    Route::post('register', 'AuthController@postRegister')->name('saveUser');
    Route::get('getUserInfo/{id}', 'UsersController@getUserInfo')->name('getUserInfo');
    Route::get('getPatientSchedules/{id}', 'PatientsController@getPatientSchedules')->name('getPatientSchedules');
    Route::post('savePatientSchedule', 'PatientsController@savePatientSchedule')->name('savePatientSchedule');
    Route::post('deletePatientSchedule/{id}', 'PatientsController@deletePatientSchedule')->name('deletePatientScheduel');
    Route::get('createPatient', 'UsersController@createPatient')->name('createPatient');
    Route::get('createEmployee', 'UsersController@createEmployee')->name('createEmployee');
    Route::post('registerPatient', 'UsersController@registerPatient')->name('registerPatient');
    Route::post('registerEmployee', 'UsersController@registerEmployee')->name('registerEmployee');
    Route::post('updateUser', 'UsersController@updateUser')->name('updateUser');
    Route::post('deleteUser/{id}', 'UsersController@deleteUser')->name('deleteUser');

});

//Administrator Routes
Route::middleware('auth')->prefix('/admin')->group(function (){
    Route::get('home', 'AdminController@home')->name('admin.home');
    Route::get('listUsers', 'AdminController@listUsers')->name('admin.users');
    Route::get('listEmployees', 'AdminController@listEmployees')->name('admin.listEmployees');
    Route::get('listPatients', 'AdminController@listPatients')->name('admin.listPatients');
    Route::get('assignPatients/{id}', 'AdminController@assignPatients')->name('admin.assignPatients');
});

//Employee Routes
Route::middleware('auth')->prefix('/employee')->group(function (){
    Route::get('home', 'EmployeesController@home')->name('employee.home');
    Route::get('listPatients', 'EmployeesController@listPatients')->name('employee.listPatients');
    Route::get('patientsStats', 'EmployeesController@patientsStats')->name('employee.patientsStats');
    Route::get('createRecords/{id}', 'EmployeesController@createRecords')->name('employee.createRecords');
    Route::post('saveRecords','EmployeesController@saveRecords')->name('employee.saveRecords');
    Route::get('showRecords/{id}','EmployeesController@showRecords')->name('employee.showRecords');
});

//Patient Routes
Route::middleware('auth')->prefix('/patient')->group(function (){
    Route::get('home', 'PatientsController@home')->name('patient.home');
    Route::get('showRecords','PatientsController@showRecords')->name('patient.showRecords');
});

