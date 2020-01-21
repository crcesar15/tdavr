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
                <div class="row">
                    <div class="col-12">
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
                                <canvas id="labOne"></canvas>
                                <hr>
                                <h4>Datos</h4>
                                <div id="dataOne">
                                    
                                </div>                         
                            </div>
                            <div class="tab-pane container fade" id="menu1">
                                <canvas id="labTwo"></canvas>  
                                <hr>
                                <h4>Datos</h4>
                                <div id="dataTwo">
                                    
                                </div>                                  
                            </div>
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
    $(document).ready(() => {
        let labOneRecords = {!! json_encode($labOneRecords->toArray()) !!}
        console.log(labOneRecords)
        let i = 0;
        let labels = [];
        let dataSuccesses = []
        let dataMistakes = []

        let html = `<table class="table table-striped table-bordered">
                        <tr>
                            <th style="width: 5%">N° de <br>Intento</th>
                            <th style="width: 15%">Fecha</th>
                            <th style="width: 10%">Aciertos <br> (A)</th>
                            <th style="width: 10%">Errores <br> (E)</th>
                            <th style="width: 10%">Aciertos <br>Netos (A-E)</th>
                            <th style="width: 15%">Indice de <br>Control de <br>Impulsividad |C|</th>
                            <th style="width: 15%">Tiempo <br> [minutos]</th>
                            <th style="width: 20%">Observaciones</th>
                        </tr>`;
        labOneRecords.map((record) => {
            labels[i] = moment(record.created_at).format('DD-MM-YYYY')
            dataSuccesses[i] = record.successes;
            dataMistakes[i] = record.mistakes;
            html += `<tr>
                        <td>${i+1}</td>
                        <td>${moment(record.created_at).format('DD-MM-YYYY')}</th>
                        <td>${record.successes}</td>
                        <td>${record.mistakes}</td>
                        <td>${record.successes - record.mistakes}</td>
                        <td>${Math.round(((record.successes - record.mistakes)/(record.successes + record.mistakes))*100,2)}</td>
                        <td>${record.time}</td>
                        <td>${record.observations}</td>
                    </tr>`
            i++;
        })

        html += '</table>';
        $("#dataOne").html(html);

        let oneData = [{
                label: "Aciertos",
                borderColor: 'rgba(0, 99, 132, 1)',
                backgroundColor: 'rgba(0, 99, 132, 0.6)',
                data: dataSuccesses
            },
            {
                label: "Errores",
                borderColor: 'rgba(210, 99, 132, 1)',
                backgroundColor: 'rgba(210, 99, 132, 0.6)',
                data: dataMistakes
            }
        ];

        var ctx = document.getElementById('labOne').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: oneData
            },
        });

        html = `<table class="table table-striped table-bordered">
                        <tr>
                            <th style="width: 5%">N° de <br>Intento</th>
                            <th style="width: 15%">Fecha</th>
                            <th style="width: 10%">Aciertos <br> (A)</th>
                            <th style="width: 10%">Errores <br> (E)</th>
                            <th style="width: 10%">Aciertos <br>Netos (A-E)</th>
                            <th style="width: 15%">Indice de <br>Control de <br>Impulsividad |C|</th>
                            <th style="width: 15%">Tiempo <br> [minutos]</th>
                            <th style="width: 20%">Observaciones</th>
                        </tr>`;   

        let labTwoRecords = {!! json_encode($labTwoRecords->toArray()) !!}
        i = 0;
        labels = [];
        dataSuccesses = []
        dataMistakes = []
        labTwoRecords.map((record) => {
            labels[i] = moment(record.created_at).format('DD-MM-YYYY')
            dataSuccesses[i] = record.successes;
            dataMistakes[i] = record.mistakes;
            html += `<tr>
                        <td>${i+1}</td>
                        <td>${moment(record.created_at).format('DD-MM-YYYY')}</th>
                        <td>${record.successes}</td>
                        <td>${record.mistakes}</td>
                        <td>${record.successes - record.mistakes}</td>
                        <td>${Math.round(((record.successes - record.mistakes)/(record.successes + record.mistakes))*100,2)}</td>
                        <td>${record.time}</td>
                        <td>${record.observations}</td>
                    </tr>`
            i++;
        })

        html += '</table>';
        $("#dataTwo").html(html);

        let twoData = [{
                label: "Aciertos",
                borderColor: 'rgba(0, 99, 132, 1)',
                backgroundColor: 'rgba(0, 99, 132, 0.6)',
                data: dataSuccesses
            },
            {
                label: "Errores",
                borderColor: 'rgba(210, 99, 132, 1)',
                backgroundColor: 'rgba(210, 99, 132, 0.6)',
                data: dataMistakes
            }
        ];

        var ctx = document.getElementById('labTwo').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: twoData
            },
        });
    })

</script>
@endpush
