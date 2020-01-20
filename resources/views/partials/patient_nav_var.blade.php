<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
    <a class="navbar-brand" href="#">TDAVR</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('patient.home')}}">
                    <i class="fa fa-home"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('patient.showRecords')}}">
                    <i class="fa fa-edit"></i> Puntuaciones
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
