<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
    <a class="navbar-brand" href="#">TDAVR</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('employee.home')}}">
                    <i class="fa fa-home"></i> Inicio
                </a>
            </li>
            <!--<li>
                <a class="nav-link" href="{{route('admin.listEmployees')}}">
                    <i class="fa fa-graduation-cap"> </i> Lista de Psicólogos
                </a>
            </li>-->
            <li>
                <a class="nav-link" href="{{route('employee.listPatients')}}">
                    <i class="fa fa-child"> </i> Lista de Pacientes
                </a>
            </li>
            <!--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="navbarUsersDropdown">
                    <i class="fa fa-users"></i> Gestión de Usuarios
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarUsersDropdown">
                    <a class="dropdown-item" href="{{route('createEmployee')}}">
                        <i class="fa fa-graduation-cap"> </i> Registrar Profesional
                    </a>
                    <a class="dropdown-item" href="{{route('createPatient')}}">
                        <i class="fa fa-child"> </i> Registrar Paciente
                    </a>
                    <a class="dropdown-item" href="{{route('admin.users')}}">
                        <i class="fa fa-search"> </i> Búsqueda
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-chart-line"></i> Estadísticas
                </a>
            </li>-->
            <li class="nav-item">
                <a class="nav-link" href="{{route('employee.patientsStats')}}">
                    <i class="fa fa-edit"></i> Reportes
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ">
            <li class="nav-item">
                <img src="{{($user->profile_photo != '') ? asset('storage/profile_photos/' . $user->profile_photo) : asset('images/user.png')}}"  class="rounded-circle" width=35" >
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown">
                    <strong>{{$user->first_name}} {{$user->last_name}}</strong>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">
                        Editar Perfil
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('logout')}}">Salir</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
