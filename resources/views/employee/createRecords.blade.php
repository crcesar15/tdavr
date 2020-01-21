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
                    <h4>Paciente: {{$patient->user->first_name}} {{$patient->user->last_name}}</h4>
                </div>
                <div class="card-body table-responsive">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home">Laberinto #1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu1">Laberinto #2</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="home">
                            <br>
                            <h4>Datos</h4>
                            <div id="dataOne">
                                <form action="{{route('employee.saveRecords')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" value="{{$patient->id}}">
                                    <input type="hidden" name="type_lab" value="one">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <label for="">N° de Aciertos</label>
                                            <input class="form-control" type="number" min="0" max="10" required name="successOne">
                                            <br>
                                            <label for="">N° de Errores</label>
                                            <input class="form-control" type="number" min="0" max="10" required name="mistakesOne">
                                            <br>
                                            <label for="">Tiempo [minutos]</label>
                                            <input class="form-control" type="number" min="1" required name="timeOne">
                                            <br>
                                            <label for="">Observaciones (Opcional)</label>
                                            <textarea name="observations" id="observations" rows="4" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-6 col-12 text-center">
                                            <img src="{{asset('images/lab1.png')}}" width="85%" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Guardar Datos</button>
                                        </div>
                                    </div>
                                </form>        
                            </div>                         
                        </div>
                        <div class="tab-pane container fade" id="menu1">
                            <br>
                            <h4>Datos</h4>
                            <div id="dataTwo">
                                <form action="{{route('employee.saveRecords')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" value="{{$patient->id}}">
                                    <input type="hidden" name="type_lab" value="two">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <label for="">N° de Aciertos</label>
                                            <input class="form-control" type="number" min="0" max="40" required name="successTwo">
                                            <br>
                                            <label for="">N° de Errores</label>
                                            <input class="form-control" type="number" min="0" max="40" required name="mistakesTwo">
                                            <br>
                                            <label for="">Tiempo [minutos]</label>
                                            <input class="form-control" type="number" min="1" required name="timeTwo">
                                            <br>
                                            <label for="">Observaciones (Opcional)</label>
                                            <textarea name="observations" id="observations" rows="4" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-6 col-12 text-center">
                                            <img src="{{asset('images/lab2.png')}}" width="85%" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Guardar Datos</button>
                                        </div>
                                    </div>
                                </form>
                            </div>                                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
    <script>

    </script>
@endpush
