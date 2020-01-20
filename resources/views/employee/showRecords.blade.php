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
                    <form action="{{route('employee.saveRecords')}}" method="POST">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{$patient->id}}">
                        <div class="row">
                            <div class="col-12">
                                <h3>Laberinto #1</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label for="">N° de Aciertos</label>
                                <input class="form-control" type="number" required name="successOne">
                                <br>
                                <label for="">N° de Fallas</label>
                                <input class="form-control" type="number" required name="mistakesOne">
                                <br>
                                <label for="">Tiempo [segundos]</label>
                                <input class="form-control" type="number" required name="timeOne">
                            </div>
                            <div class="col-md-6 col-12 text-center">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO-YujKED9eL63zFLBhVLlIJsZXGW4vItmphgWNRCmkDsm0GDEbw&s" width="85%" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3>Laberinto #2</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label for="">N° de Aciertos</label>
                                <input class="form-control" type="number" required name="successTwo">
                                <br>
                                <label for="">N° de Fallas</label>
                                <input class="form-control" type="number" required name="mistakesTwo">
                                <br>
                                <label for="">Tiempo [segundos]</label>
                                <input class="form-control" type="number" required name="timeTwo">
                            </div>
                            <div class="col-md-6 col-12 text-center">
                                <img src="https://res.cloudinary.com/jerrick/image/upload/fl_progressive,q_auto,w_1024/q6hgjkv5yy4ilmgzpa1p.jpg" width="85%" alt="">
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
    
@endsection

@push('scripts')
    <script>

    </script>
@endpush
