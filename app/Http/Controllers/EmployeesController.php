<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Record;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployeesController extends Controller
{
    //This functions shows the employee home page
    public function home (){
        return view('employee.home');
    }

    public function listPatients(){
        $patients = Patient::whereHas('schedules', function($q){
            $user = User::with('employee')->where('id', Session::get('user')->id)->get()->toArray();
            $employee_id = $user[0]["employee"]["id"];
            $from = Carbon::now()->startOfWeek()->format('Y-m-d H:i');
            $to = Carbon::now()->endOfWeek()->format('Y-m-d H:i');
            $q->whereBetween('datetime', [$from, $to])
              ->where('employee_id',$employee_id);
        })->get();
        return view('employee.patients', compact('patients'));
    }

    public function patientsStats(){
        $user = User::with('employee')->where('id', Session::get('user')->id)->get()->toArray();
        $employee_id = $user[0]["employee"]["id"];

        $patients = Patient::whereHas('schedules', function($q){
            $q->where('employee_id',1);
        })->get();
        return view('employee.patientsStats', compact('patients'));
    }

    public function createRecords($id){
        $patient = Patient::with('user')
                          ->where('id', $id)
                          ->first();
        return view('employee.createRecords', compact('patient'));
    }

    public function saveRecords(Request $request){
        \DB::beginTransaction();
        try{
            Record::insert([
                [
                    "successes" => $request->input('successOne'),
                    "mistakes" => $request->input('mistakesOne'),
                    "time" => $request->input('timeOne'),
                    "patient_id" => $request->input('patient_id'),
                    "false_positive_rate" => 0,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "test" => 1
                ],
                [
                    "successes" => $request->input('successTwo'),
                    "mistakes" => $request->input('mistakesTwo'),
                    "time" => $request->input('timeTwo'),
                    "patient_id" => $request->input('patient_id'),
                    "false_positive_rate" => 0,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "test" => 1
                ]
               ] 
            );
            Session::flash('message', ['text' => "Se Guardaron Correctamente los Datos", 'type' => 'success']);
            \DB::commit();
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', ['text' => "Ocurrio un Error al Guardar, Intente Nuevamente o Contacte al Administrador", 'type' => 'danger']);
            \DB::rollback();
        }            
        return redirect()->back();
    }

    public function showRecords($id){
        $patient = Patient::with('user')
                          ->where('id', $id)
                          ->first();
        $labOneRecords = Record::where('patient_id', $id)
                                ->where('test', 1)
                                ->orderBy('created_at','ASC')
                                ->get();

        $labTwoRecords = Record::where('patient_id', $id)
                                ->where('test', 2)
                                ->orderBy('created_at','ASC')
                                ->get();

        return view('employee.showRecords', compact('patient', 'labOneRecords', 'labTwoRecords'));
    }
}
