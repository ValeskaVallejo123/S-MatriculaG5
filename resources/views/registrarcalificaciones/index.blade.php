@extends('layouts.app')

{{-- SECCION PARA EL BOTON DE VER CALIFICACIONES --}}
@section('topbar-actions')

    @php
        $gradoSeleccionado = request('grado_id');
    @endphp

    {{-- BOTÓN VOLVER --}}
    @php
        $usuario = auth()->user();
        $rutaDashboard = match($usuario->rol->nombre ?? '') {
            'Administrador' => route('admin.dashboard'),
            'Super Administrador' => route('superadmin.dashboard'),
            'Profesor' => route('profesor.dashboard'),
            'Estudiante' => route('estudiante.dashboard'),
            'Padre' => route('padre.dashboard'),
            default => route('home'),
        };
    @endphp

    <div style="display:flex; gap:10px;">

        {{-- BOTÓN VER CALIFICACIONES --}}
            <a href="{{route('registrarcalificaciones.ver')}}"
               class="btn btn-primary">
                Ver Calificaciones
            </a>

        <a href="{{ $rutaDashboard }}"
           class="btn btn-outline-primary">
            ← Volver
        </a>

    </div>

@endsection
{{-- FIN DE LA SECCION --}}

@section('content')
    <div class="container">

        <h2 class="mb-4">Registrar Calificaciones</h2>


        {{-- SELECT CURSO --}}
        <div class="card mb-4">
            <div class="card-body">

                <label class="form-label fw-bold">Seleccione Curso</label>

                <form method="GET" action="{{ route('registrarcalificaciones.index') }}">

                    <div class="mb-3">

                        <select name="grado_id"
                                class="form-select"
                                onchange="this.form.submit()"
                                required>

                            <option value="">Seleccione curso</option>

                            @foreach($grados as $grado)

                                <option value="{{ $grado->id }}"
                                    {{ request('grado_id') == $grado->id ? 'selected' : '' }}>

                                    {{ $grado->numero }}°
                                    {{ ucfirst($grado->nivel) }}
                                    - Sección {{ $grado->seccion }}
                                    ({{ $grado->anio_lectivo }})

                                </option>

                            @endforeach

                        </select>

                    </div>

                </form>

            </div>
        </div>


        {{-- SI HAY GRADO SELECCIONADO --}}
        @if(request()->filled('grado_id'))

            <form action="{{ route('registrarcalificaciones.store') }}" method="POST">

                @csrf

                <input type="hidden"
                       name="grado_id"
                       value="{{ request('grado_id') }}">


                {{-- PROFESOR --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">Profesor</label>

                    <select name="profesor_id" class="form-select" required>

                        <option value="">Seleccione profesor</option>

                        @foreach($profesores as $profesor)

                            <option value="{{ $profesor->id }}">
                                {{ $profesor->apellido }},
                                {{ $profesor->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- MATERIA --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">Materia</label>

                    <select name="materia_id" class="form-select" required>

                        <option value="">Seleccione materia</option>

                        @foreach($materias as $materia)

                            <option value="{{ $materia->id }}">
                                {{ $materia->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- PERIODO --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">Periodo Académico</label>

                    <select name="periodo_academico_id" class="form-select" required>

                        <option value="">Seleccione periodo</option>

                        @foreach($periodos as $periodo)

                            <option value="{{ $periodo->id }}">
                                {{ $periodo->nombre_periodo }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <hr>


                {{-- ESTUDIANTES --}}
                <h4 class="mb-3">Estudiantes del curso</h4>

                @if($estudiantes->isEmpty())

                    <div class="alert alert-warning">
                        No hay estudiantes en este curso.
                    </div>

                @else

                    <table class="table table-bordered">

                        <thead class="table-dark">
                        <tr>
                            <th>Estudiante</th>
                            <th>Nota</th>
                            <th>Observación</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($estudiantes as $estudiante)

                            <tr>

                                <td>
                                    {{ $estudiante->apellido1 }}
                                    {{ $estudiante->apellido2 }},
                                    {{ $estudiante->nombre1 }}
                                    {{ $estudiante->nombre2 }}
                                </td>

                                <td>

                                    <input type="number"
                                           name="notas[{{ $estudiante->id }}]"
                                           class="form-control"
                                           min="0"
                                           max="100"
                                           step="0.01">

                                </td>
                                <td>
                                    <input type="text"
                                           name="observacion[{{ $estudiante->id }}]"
                                           class="form-control">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit"
                            class="btn btn-success">
                        Guardar Calificaciones
                    </button>
                @endif
            </form>
        @endif
    </div>
@endsection
