@extends('layouts.app')

@section('title', 'Detalle del Curso')
@section('page-title', 'Estudiantes del Curso')

@section('content')
    <div class="container-fluid">

        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body">
                <h4 class="fw-bold" style="color: #003b73;">
                    <i class="fas fa-book me-2" style="color: #4ec7d2;"></i>
                    {{ $grado }} - Sección {{ $seccion }}
                </h4>
            </div>
        </div>

        <!-- Lista de estudiantes -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body">
                <h5 class="fw-bold mb-3" style="color: #003b73;">
                    <i class="fas fa-users me-2" style="color: #4ec7d2;"></i>
                    Estudiantes Matriculados ({{ $estudiantes->count() }})
                </h5>

                @if($estudiantes->isEmpty())
                    <p class="text-muted">No hay estudiantes matriculados en este curso.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Fecha Nacimiento</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($estudiantes as $estudiante)
                            <tr>
                                <td>{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}</td>
                                <td>{{ $estudiante->dni ?? 'N/A' }}</td>
                                <td>{{ $estudiante->fecha_nacimiento }}</td>
                                <td>
                                    <span class="badge {{ $estudiante->estado == 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($estudiante->estado) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('consultaestudiantesxcurso.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
