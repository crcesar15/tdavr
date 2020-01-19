<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Patient;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function getUserInfo($id){
        $user = User::where('id', $id)->first();
        $user = json_encode($user);
        return $user;
    }

    public function createPatient(){
        return view('admin.patient_register');
    }

    public function registerPatient(Request $request){
        try{
            \DB::beginTransaction();

            if($request->has('profile_photo')){
                $image = $request->file('profile_photo');
                $name = str_slug($request->input('username').'_'.time()).'.'.$image->getClientOriginalExtension();
                $image->storeAs('profile_photos',$name);
            }else{
                $name = '';
            }

            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'role_id' => \App\Role::PATIENT,
                'profile_photo' => $name,
            ]);

            Patient::create([
                'date_of_birth' => $request->input('date_of_birth'),
                'contact_number' => $request->input('contact_number'),
                'responsible_name' => $request->input('responsible_name'),
                'user_id' => $user->id
            ]);

            \DB::commit();
            Session::flash('message', ['text' => 'Registro exitoso, recuerde cambiar la contraseña una vez iniciada la sesión', 'type' => 'success']);
        }catch (\Illuminate\Database\QueryException $exception){
            \DB::rollBack();
            Session::flash('message', ['text' => $exception, 'type' => 'danger']);
        }
        return redirect()->route('admin.users');
    }

    public function createEmployee(){
        return view('admin.employee_register');
    }

    public function registerEmployee(Request $request){
        try{
            \DB::beginTransaction();

            if($request->has('profile_photo')){
                $image = $request->file('profile_photo');
                $name = str_slug($request->input('username').'_'.time()).'.'.$image->getClientOriginalExtension();
                $image->storeAs('profile_photos',$name);
            }else{
                $name = '';
            }

            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'role_id' => \App\Role::EMPLOYEE,
                'profile_photo' => $name,
            ]);

            Employee::create([
                'profession' => $request->input('profession'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'user_id' => $user->id
            ]);

            \DB::commit();
            Session::flash('message', ['text' => 'Registro exitoso, recuerde cambiar la contraseña una vez iniciada la sesión', 'type' => 'success']);
        }catch (\Illuminate\Database\QueryException $exception){
            Session::flash('message', ['text' => $exception, 'type' => 'danger']);
            \DB::rollBack();
        }
        return redirect()->route('admin.users');
    }

    public function updateUser(Request $request){
        $id = $request->input('user_id');
        $first_name = $request->input('uFirstName');
        $last_name = $request->input('uLastName');
        $username = $request->input('uUsername');
        $deleted_at = ($request->input('uDeletedAt') == "0" ? Carbon::now() : null);

        \DB::beginTransaction();
        try{
            User::where('id', $id)
                ->update([
                            "first_name" => $first_name,
                            "last_name" => $last_name,
                            "username" => $username,
                            "deleted_at" => $deleted_at
                        ]);
            \DB::commit();
            Session::flash('message', ['text' => 'Se actualizo correctamente el usuario', 'type' => 'success']);
        }catch(\Illuminate\Database\QueryException $exception){
            \DB::rollback();
            Session::flash('message', ['text' => 'Ocurrio un error al intentar actualizar el usuario, intente nuevamente o contacte con el administrador', 'type' => 'danger']);
        }
        return redirect()->back();
    }

    public function deleteUser($id){
        \DB::beginTransaction();
        try{
            User::where('id', $id)
                    ->update(['deleted_at' => Carbon::now()]);
            \DB::commit();
            Session::flash('message', ['text' => "Se Inhabilito Correctamente", 'type' => 'success']);
            return json_encode(["code" => 1]);
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', ['text' => "Ocurrio un Error , Intente Nuevamente o Contacte al Administrador", 'type' => 'danger']);
            \DB::rollback();
            return json_encode($e);
        }
    }
}
