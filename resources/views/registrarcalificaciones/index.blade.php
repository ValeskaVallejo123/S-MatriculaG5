@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Mis Calificaciones Registradas</h2>

        <a href="{{ route('registrarcalificaciones.create') }}" class="btn btn-primary mb-3">
            Registrar nuevas calificaciones
        </a>

        @if($calificaciones->isEmpty())
            <div class="alert alert-info">
                No has registrado calificaciones todavía.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Curso</th>
                    <th>Materia</th>
                    <th>Parcial</th>
                    <th>Nota</th>
                </tr>
                </thead>
                <tbody>
                @foreach($calificaciones as $c)
                    <tr>
                        <td>
                            {{ $c->estudiante->nombre1 }}
                            {{ $c->estudiante->apellido1 }}
                        </td>
                        <td>{{ $c->curso->nombre }}</td>
                        <td>{{ $c->materia->nombre }}</td>
                        <td>{{ $c->parcial }}</td>
                        <td>{{ $c->nota }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
