@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mi Horario Académico</h2>
    <a href="{{ route('horario.exportPDF') }}" class="btn btn-primary mb-3">Exportar PDF</a>

    @if(session('mensaje'))
        <div class="alert alert-success">{{ session('mensaje') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Día</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Materia</th>
                <th>Sección</th>
                <th>Salón</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
            <tr @if($horario->updated_at->diffInDays(now()) < 1) class="table-warning" @endif>
                <td>{{ $horario->dia }}</td>
                <td>{{ $horario->hora_inicio }}</td>
                <td>{{ $horario->hora_fin }}</td>
                <td>{{ $horario->materia }}</td>
                <td>{{ $horario->seccion }}</td>
                <td>{{ $horario->salon }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <small class="text-muted">*Los horarios resaltados en amarillo han sido modificados en las últimas 24 horas.</small>
</div>
@endsection
