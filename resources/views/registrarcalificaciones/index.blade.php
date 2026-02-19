@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Listado de Calificaciones</h1>

            <!-- Botón para ir a registrar calificaciones -->
            <a href="{{ route('registrarcalificaciones.create') }}" class="btn btn-primary">
                Registrar calificaciones
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($calificaciones->isEmpty())
            <p>No hay calificaciones registradas.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Curso</th>
                    <th>Materia</th>
                    <th>Periodo</th>
                    <th>Nota</th>
                    <th>Observación</th>
                </tr>
                </thead>
                <tbody>
                @foreach($calificaciones as $c)
                    <tr>
                        <td>{{ $c->estudiante->nombre }}</td>
                        <td>{{ $c->curso->nombre }}</td>
                        <td>{{ $c->materia->nombre }}</td>
                        <td>{{ $c->periodoAcademico->nombre }}</td>
                        <td>{{ $c->nota }}</td>
                        <td>{{ $c->observacion }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
