@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="mb-4">Acciones Importantes del Sistema</h1>

        <div class="row">

            {{-- MATRÍCULAS --}}
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Matrículas recientes
                    </div>
                    <div class="card-body">

                        @if($matriculasRecientes->isEmpty())
                            <p class="text-muted">No hay matrículas recientes.</p>
                        @else
                            <ul class="list-group">
                                @foreach($matriculasRecientes as $m)
                                    <li class="list-group-item">
                                        <strong>{{ $m->estudiante->nombre }}</strong><br>
                                        <small class="text-muted">
                                            Fecha: {{ $m->fecha_matricula }}<br>
                                            Estado: {{ ucfirst($m->estado) }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>

            {{-- SOLICITUDES --}}
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        Solicitudes pendientes
                    </div>
                    <div class="card-body">

                        @if($solicitudesPendientes->isEmpty())
                            <p class="text-muted">No hay solicitudes pendientes.</p>
                        @else
                            <ul class="list-group">
                                @foreach($solicitudesPendientes as $s)
                                    <li class="list-group-item">
                                        <strong>{{ $s->estudiante->nombre }}</strong><br>
                                        <small class="text-muted">
                                            Estado: {{ ucfirst($s->estado) }}<br>
                                            Fecha: {{ $s->created_at->format('Y-m-d') }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>

            {{-- CALIFICACIONES --}}
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        Calificaciones recientes
                    </div>
                    <div class="card-body">

                        @if($calificacionesRecientes->isEmpty())
                            <p class="text-muted">No hay calificaciones recientes.</p>
                        @else
                            <ul class="list-group">
                                @foreach($calificacionesRecientes as $c)
                                    <li class="list-group-item">
                                        <strong>{{ $c->estudiante->nombre }}</strong><br>
                                        <small class="text-muted">
                                            Materia: {{ $c->materia->nombre }}<br>
                                            Nota: {{ $c->nota }}<br>
                                            Fecha: {{ $c->created_at->format('Y-m-d') }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
