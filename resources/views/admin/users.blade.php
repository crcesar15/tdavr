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
                    <h4>Usuarios Registrados</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="text-center table table-bordered table-striped" id="users">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre y Apellido</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->first_name . " ". $user->last_name}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-success" onclick="getUserInfo({{$user->id}})" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i> Ver</button>
                                            <button type="button" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</button>
                                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
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
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 offset-2">
                            <img src="" id="uProfilePhoto" class="img-fluid rounded img-thumbnail">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="">Nombre</label>
                            <input class="form-control" type="text" disabled id="uFirstName">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Apellido</label>
                            <input class="form-control" type="text" disabled id="uLastName">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Usuario</label>
                            <input class="form-control" type="text" disabled id="uUsername">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Fecha de Registro</label>
                            <input class="form-control" type="text" disabled id="uCreatedAt">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Estado</label>
                            <input class="form-control" type="text" disabled id="uDeletedAt">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Rol</label>
                            <input class="form-control" type="text" disabled id="uRole">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
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
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('getUserInfo')}}/' + id,
                method: 'GET',
                dataType: 'json',
                success: data => {
                    console.log(data.profile_photo);
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
                    $('#uFirstName').val(data.first_name);
                    $('#uLastName').val(data.last_name);
                    $('#uUsername').val(data.username);
                    $('#uCreatedAt').val(data.created_at);
                    $('#uDeletedAt').val( (data.deleted_at == '') ? 'Deshabilidato' : 'Activo' );
                    $('#uRole').val(role);
                    $('#uProfilePhoto').attr('src', '{{asset('storage/profile_photos')}}/' + data.profile_photo);
                }
            })
        }
    </script>
@endpush
