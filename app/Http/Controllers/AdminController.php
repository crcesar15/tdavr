<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //This functions shows the admin home page
    public function home (){
        return view('admin.home');
    }

    //This function list all users (Search Page)
    public function listUsers(){
        $users = User::with('Role')->get();
        return view('admin.users', compact('users'));
    }

    //This function list all employees (Employees Page)
    public function listEmployees(){
        $employees = Employee::with('User')->get();
        return view('admin.employees', compact('employees'));
    }

    //This function list all Patients (Patients Page)
    public function listPatients(){
        $patients = Patient::with('User')->get();
        return view('admin.patients', compact('patients'));
    }

    //This function list all schedules per patient
    public function assignPatients($id){
        $patients = Patient::withCount(['Schedules' => function($query){
            $from = Carbon::now()->startOfWeek()->format('Y-m-d H:i');
            $to = Carbon::now()->endOfWeek()->format('Y-m-d H:i');
            $query->whereBetween('datetime', [$from, $to])
                  ->where('deleted_at', null);
        }])->get();
        return view('admin.assignPatients', compact('patients'));
    }
}
