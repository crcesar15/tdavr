@extends('layout')

@include('partials.admin_nav_var',$user = session()->get('user'))

@section('content')
    <div class="row mt-5">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
            @if(session()->has('message'))
                <div class="alert alert-{{session()->get('message')['type']}} alert-dismissible fade show mt-4" role="alert">
                    {{session()->get('message')['text']}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card border-primary mt-4">
                <div class="card-header">
                    <h4>Lista de Sesiones Semanales por Paciente</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="text-center table table-bordered table-striped" id="users">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre y Apellido</th>
                                <th>Edad</th>
                                <th>Sesiones <br> Semanales</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$patient->user->first_name . " ". $patient->user->last_name}}</td>
                                    <td>{{\Carbon\Carbon::parse($patient->date_of_birth)->diffInYears(\Carbon\Carbon::now())}} años</td>
                                    <td>{{$patient->schedules_count}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button {{($patient->schedules_count == "0") ? "disabled" : ""}} type="button" class="btn btn-success" onclick="getPatientSchedules({{$patient->id}})" data-toggle="modal" data-target="#listSchedules"><i class="fa fa-eye"></i> Ver Sesiones</button>
                                            <button {{($patient->schedules_count == "3") ? "disabled" : ""}} type="button" class="btn btn-primary" onclick="savePatientSchedules({{$patient->id}})" data-toggle="modal" data-target="#saveSchedule"><i class="fa fa-clock"></i> Programar Sesión</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center"> No existen registros aún</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- List Schedules Modal -->
    <div class="modal fade" id="listSchedules" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sesiones del Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="schedulesTable">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Save Schedule Modal -->
    <div class="modal fade" id="saveSchedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Programar Sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url("savePatientSchedule")}}" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" id="patient_id" name="patient_id">
                            <input type="hidden" id="employee_id" name="employee_id" value="{{Route::input('id')}}">
                            <div class="col-12 col-md-6">
                                <label for="">Fecha</label>
                                <input class="form-control" type="date" required id="date" name="date">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Hora</label>
                                <input class="form-control" type="time" required id="time" name="time">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="sumbit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            $('#users').dataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
                }
            });
        });

        const getPatientSchedules = (id) =>{
            let html = `<table class="table table-bordered table-striped">
                            <tr class="text-center">
                                <th>N°</th>
                                <th>Fecha - Hora</th>
                                <th>Psicólogo</th>
                                <th>Acciones</th>
                            </tr>`;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('getPatientSchedules')}}/' + id,
                method: 'GET',
                dataType: 'json',
                success: schedules => {
                    let i = 1;
                    schedules.map((schedule)=>{
                        html += `<tr class="text-center">
                                    <td>${i}</td>
                                    <td>${moment(schedule.datetime).format('DD/MM/YYYY')} ${moment(schedule.datetime).format('HH:mm')}</td>
                                    <td>${schedule.employee.user.first_name} ${schedule.employee.user.last_name}</td>
                                    <td><button onclick="deleteSchedule(${schedule.id})" class="btn btn-danger"><i class="fa fa-trash"></i> Cancelar Sesión</button></td>
                                </tr>`
                        i++;
                    })
                    html += '</table>';
                    $("#schedulesTable").html(html);
                }
            })
        }

        const deleteSchedule = (id) =>{
            if(confirm("¿Esta seguro de cancelar esta sesión")){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url('deletePatientSchedule')}}/' + id,
                    method: 'POST',
                    dataType: 'json',
                    success: res => {
                        if(res.code == 1){
                            location.reload();
                        }else{
                            console.error(res);
                        }
                    }
                }) 
            }
        }

        const savePatientSchedules = (id) =>{
            $("input#patient_id").val(id);
        }
    </script>
@endpush
