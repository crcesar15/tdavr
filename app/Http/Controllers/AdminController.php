<?php

namespace App\Http\Controllers;

use App\User;
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
}
