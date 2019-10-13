<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    public function postLogin(Request $request)
    {
        $check = Auth::attempt( array(
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ));

        if ($check) {
            \App\User::where('email', $request->input('email'))->update(['status' => 'active']);
            $user = \App\User::where('email', $request->input('email'))->first();
            session(['user' => $user->toArray()]);
            return Redirect::route('home');
        } else {
            Session::flash('message', "Invalid Credentials , Please try again.");
            return Redirect::back();
        }
    }

    public function getLogout() {
        \App\User::where('email', session()->get('user')['email'])->update(['status' => 'inactive']);
        Session::flush();
        Auth::logout();
        return Redirect::back();
    }

    public function getLogin(){
        return view('login.index');
    }
}