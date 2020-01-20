@extends('layout')

@include('partials.employee_nav_var',$user = session()->get('user'))

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
                    <h4>Lista de Pacientes</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="text-center table table-bordered table-striped" id="users">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th style="text-align:left;">Nombre y Apellido</th>
                                <th>Edad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style="text-align:left;"><i style="color:{{($patient->user->deleted_at == null) ? 'green': 'red'}}" class="fa fa-circle"></i> {{$patient->user->first_name . " ". $patient->user->last_name}}</td>
                                    <td>{{\Carbon\Carbon::parse($patient->date_of_birth)->diffInYears(\Carbon\Carbon::now())}} años</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-success" onclick="getUserInfo({{$patient->user->id}})" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i> Información</button>
                                            <a type="button" class="btn btn-primary" href="{{route("employee.showRecords", ["id" => $patient->id])}}"><i class="fa fa-check"></i> Ver Progreso</a>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('updateUser')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8 offset-2 text-center">
                                <img src="" id="uProfilePhoto" width="200" height="200" class="img-fluid rounded img-thumbnail">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <input type="hidden" id="user_id" name="user_id">
                            <div class="col-12 col-md-6">
                                <label for="">Nombre</label>
                                <input class="form-control" type="text" id="uFirstName" name="uFirstName">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Apellido</label>
                                <input class="form-control" type="text" id="uLastName" name="uLastName">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Usuario</label>
                                <input class="form-control" type="text" id="uUsername" name="uUsername">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Fecha de Registro</label>
                                <input class="form-control" type="text" id="uCreatedAt" disabled name="uCreatedAt">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Estado</label>
                                <select name="uDeletedAt" class="form-control" id="uDeletedAt">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Rol</label>
                                <input class="form-control" type="text" disabled id="uRole">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="mSubmit">Guardar</button>
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

        const getUserInfo = (id)=>{
            $("#user_id").val(id);
            $("#mSubmit").hide();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('getUserInfo')}}/' + id,
                method: 'GET',
                dataType: 'json',
                success: data => {
                    let role = '';
                    switch (data.role_id) {
                        case 1:
                            role = 'Administrador';
                            break;
                        case 2:
                            role = 'Psicologo';
                            break;
                        case 3:
                            role = 'Paciente';
                            break;
                    }
                    
                    //value
                    $('#uFirstName').val(data.first_name);
                    $('#uLastName').val(data.last_name);
                    $('#uUsername').val(data.username);
                    $('#uCreatedAt').val(data.created_at);
                    $('#uDeletedAt').val( (data.deleted_at == null) ? '1' : '0' );
                    $('#uRole').val(role);
                    
                    //disabled
                    $('#uFirstName').prop('disabled','disabled')
                    $('#uLastName').prop('disabled','disabled')
                    $('#uUsername').prop('disabled','disabled')
                    $('#uCreatedAt').prop('disabled','disabled')
                    $('#uDeletedAt').prop('disabled','disabled')
                    $('#uRole').prop('disabled','disabled')
                    
                    if(!data.profile_photo == ''){
                        $('#uProfilePhoto').attr('src', '{{asset('storage/profile_photos')}}/' + data.profile_photo);
                    }else{
                        $('#uProfilePhoto').attr('src', '{{asset('images/user.png')}}');
                    }
                }
            })
        }

        const editUserInfo = (id)=>{
            $("#user_id").val(id);
            $("#mSubmit").show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('getUserInfo')}}/' + id,
                method: 'GET',
                dataType: 'json',
                success: data => {
                    let role = '';
                    switch (data.role_id) {
                        case 1:
                            role = 'Administrador';
                            break;
                        case 2:
                            role = 'Psicologo';
                            break;
                        case 3:
                            role = 'Paciente';
                            break;
                    }
                    //values
                    $('#uFirstName').val(data.first_name);
                    $('#uLastName').val(data.last_name);
                    $('#uUsername').val(data.username);
                    $('#uCreatedAt').val(data.created_at);
                    $('#uDeletedAt').val( (data.deleted_at == null) ? '1' : '0' );
                    $('#uRole').val(role);
                    
                    //disabled
                    $('#uFirstName').prop('disabled','')
                    $('#uLastName').prop('disabled','')
                    $('#uUsername').prop('disabled','')
                    $('#uDeletedAt').prop('disabled','')
                    if(!data.profile_photo == ''){
                        $('#uProfilePhoto').attr('src', '{{asset('storage/profile_photos')}}/' + data.profile_photo);
                    }else{
                        $('#uProfilePhoto').attr('src', '{{asset('images/user.png')}}');
                    }
                }
            })
        }

        const deletePatient = (id) =>{
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('deleteUser')}}/' + id,
                method: 'POST',
                dataType: 'json',
                success: res => {
                    if(res.code == 1){
                        location.reload();
                    }else{
                        console.error(res);
                        location.reload();
                    }
                }
            })
        }
    </script>
@endpush
