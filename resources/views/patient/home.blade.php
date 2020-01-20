@extends('layout')
@section('nav_bar')
    @include('partials.patient_nav_var', $user = session()->get('user'))
@endsection

@section('content')
    <div class="row mt-5" style="text-align:justify">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
            @if(session()->has('message'))
                <div class="alert alert-{{session()->get('message')['type']}} alert-dismissible fade show mt-4" role="alert">
                    {{session()->get('message')['text']}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-12 col-lg-6 col-md-6">
                    <div class="card border-primary mt-4">
                        <div class="card-header">
                            <h4><i class="fa fa-bullseye"></i> Misión</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                La Asociación Psinergia buscar facilitar procesos para el desarrollo humano sostenible, caracterizados por la sinergia y la transdisciplinariedad brindando servicios psicológicos, educativos, legales y comunicacionales.
                            </p>
                        </div>
                    </div>        
                </div>
                <div class="col-12 col-lg-6 col-md-6">
                    <div class="card border-primary mt-4">
                        <div class="card-header">
                            <h4><i class="fa fa-eye"></i> Visión</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                La Asociación Psinergia – Centro de Investigación y Desarrollo Humano con proyección local, regional, nacional e internacional que planifica, administra, ejecuta y evalúa procesos y proyectos para el desarrollo humano 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-primary mt-4">
                        <div class="card-header">
                            <h4><i class="fa fa-book"></i> Filosofia</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                Psinergia sigue como filosofía institucional la construcción del conocimiento desde un enfoque sinérgico, sistémico y cosmocéntrico.
                            </p>
                            <ul>
                                * Un enfoque sinérgico que nos permite comprender que los seres humanos somos energía, estamos hechos de energías y generamos energías, cuyos encuentros o desencuentros hacen nuevas formas de energía, nuevas formas de existencia, nuevas formas de creación, nuevos sistemas.
                            </ul>
                            <ul>
                                * Un enfoque sistémico que nos permite comprender que los seres humanos somos un sistema en nosotros mismos, que estamos conformados de sistemas más pequeños y que a su vez somos parte de otros sistemas mayores; en una relación de ida y vuelta donde todo lo que afecta a un sistema afecta a los demás. 
                            </ul>
                            <ul>
                                * Un enfoque cosmocéntrico que nos permite comprender que los seres humanos somos parte del cosmos y como tal compartimos la existencia con otras partes del mismo, con otros elementos, con otras energías, con otros sistemas y que somos responsables de nuestra existencia y la del cosmos.
                            </ul>
                            <p class="text-center" style="font-size:16px; font-weight:bold;"><i>“No puedes arrancar una flor, sin lastimar una estrella”</i></p>   
                            <p>
                                Psinergia aporta en la construcción del conocimiento humano asumiendo el cambio permanente e histórico del mismo, reconociendo los acuerdos sociales y culturales pero cuestionando su inamovilidad y universalización.                        
                            </p>
                            <p class="text-center">
                                <img src="{{asset('images/logo-sinergia.png')}}" alt="">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
