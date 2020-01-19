<?php

namespace App\Http\Controllers;

use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PatientsController extends Controller
{
    public function getPatientSchedules($id){
        $from = Carbon::now()->startOfWeek()->format('Y-m-d H:i');
        $to = Carbon::now()->endOfWeek()->format('Y-m-d H:i');
        $schedules = Schedule::with('Employee.user')
                             ->where('patient_id',$id)
                             ->where('deleted_at', null)
                             ->whereBetween('datetime',[$from, $to])
                             ->orderBy('datetime','ASC')
                             ->get();
        return json_encode($schedules);
    }

    public function savePatientSchedule(Request $request){
        \DB::beginTransaction();
        try{
            Schedule::insert([
                                'patient_id'=> $request->input('patient_id'), 
                                'employee_id'=> $request->input('employee_id'),
                                'datetime'=> $request->input('date') . " " . $request->input('time')
                             ]);
            \DB::commit();
            Session::flash('message', ['text' => "Se Guardo Correctamente la Sesión", 'type' => 'success']);
            return Redirect::back();
        }catch(\Illuminate\Database\QueryException $e){
            //dd($e);
            Session::flash('message', ['text' => "Ocurrio un Error al Guardar, Intente Nuevamente o Contacte al Administrador", 'type' => 'danger']);
            return Redirect::back();
            \DB::rollback();
        }
    }

    public function deletePatientSchedule($id){
        \DB::beginTransaction();
        try{
            Schedule::where('id', $id)
                    ->update(['deleted_at' => Carbon::now()]);
            \DB::commit();
            Session::flash('message', ['text' => "Se Cancelo Correctamente la Sesión", 'type' => 'success']);
            return json_encode(["code" => 1]);
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', ['text' => "Ocurrio un Error al Guardar, Intente Nuevamente o Contacte al Administrador", 'type' => 'danger']);
            \DB::rollback();
            return json_encode($e);
        }
    }
}
