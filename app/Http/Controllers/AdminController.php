<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Patient;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home (){
        return view('admin.home');
    }

    public function listUsers(){
        $users = User::with('Role')->get();
        return view('admin.users', compact('users'));
    }

    public function listEmployees(){
        $employees = Employee::with('User')->get();
        return view('admin.employees', compact('employees'));
    }

    public function listPatients(){
        $users = User::with('Role')->get();
        return view('admin.users', compact('users'));
    }

    public function asignPatients(){
        $patients = Patient::with('Employees')->with('User')->get();
        return view('admin.asignPatients', compact('patients'));
    }
}
