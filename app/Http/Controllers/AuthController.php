<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * Class AuthController
 * This controller manage the system authentication
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * This function is used to verify the credentials
     * @param Request $request
     * @return mixed
     */
    public function postLogin(Request $request) {
        if (Auth::attempt ( array (
            'username' => $request->get ( 'username' ),
            'password' => $request->get ( 'password' )
        ) )) {
            $user = User::where('username', $request->get('username'))->first();
            session ( [
                'user' => $user
            ] );
            return Redirect::to('/');
        } else {
            Session::flash ( 'message', "<strong>Credenciales Invalidos</strong>. Por favor, intente nuevamente." );
            return Redirect::back ();
        }
    }

    /**
     * This function is used to logout the current user
     * @return mixed
     */
    public function getLogout() {
        Session::flush ();
        Auth::logout ();
        return Redirect::back ();
    }

    public function getLogin(){
        return view('login');
    }

    public function verifyUser(){
        if(Auth::check()){
            return redirect()->route('admin.home');
        }else {
            return redirect()->route('login');
        }
    }
}
