@extends('layouts.app')

@section('topbar-actions')

    @php
        $gradoSeleccionado = request('grado_id');
    @endphp

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

        <a href="{{route('registrarcalificaciones.ver')}}"
           class="btn"
           style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
       color:white;border:none;border-radius:8px;font-weight:600;">
            <i class="fas fa-eye me-1"></i>
            Ver Calificaciones
        </a>

        <a href="{{ $rutaDashboard }}"
           class="btn"
           style="border:2px solid #00508f;color:#00508f;border-radius:8px;font-weight:600;">
            <i class="fas fa-arrow-left me-1"></i>
            Volver
        </a>

    </div>

@endsection


@section('content')

    <div class="container-fluid px-4 py-3">

        <!-- HEADER -->
        <div class="card border-0 shadow-sm mb-4"
             style="border-radius:12px;background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">

            <div class="card-body p-3">

                <div class="d-flex align-items-center">

                    <div class="me-3"
                         style="width:48px;height:48px;border-radius:10px;
                     background:rgba(255,255,255,0.2);
                     display:flex;align-items:center;justify-content:center;">

                        <i class="fas fa-clipboard-check text-white"></i>

                    </div>

                    <div class="text-white">

                        <h5 class="mb-0 fw-bold">
                            Registrar Calificaciones
                        </h5>

                        <p class="mb-0 opacity-90" style="font-size:0.85rem;">
                            Seleccione un curso para registrar las notas de los estudiantes
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- SELECCIONAR CURSO -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">

            <div class="card-body">

                <label class="form-label fw-semibold mb-2"
                       style="color:#003b73;">

                    Seleccione Curso

                </label>

                <form method="GET"
                      action="{{ route('registrarcalificaciones.index') }}">

                    <div class="position-relative">

                        <select name="grado_id"
                                class="form-select"
                                style="border:2px solid #bfd9ea;border-radius:8px;"
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


        @if(request()->filled('grado_id'))

            <form action="{{ route('registrarcalificaciones.store') }}" method="POST">

                @csrf

                <input type="hidden"
                       name="grado_id"
                       value="{{ request('grado_id') }}">


                <!-- DATOS GENERALES -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3" style="color:#003b73;">
                            <i class="fas fa-cogs me-2"></i>
                            Información de la Calificación
                        </h6>


                        <div class="row">

                            <!-- PROFESOR -->
                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-semibold small">Profesor</label>

                                <select name="profesor_id"
                                        class="form-select"
                                        style="border:2px solid #bfd9ea;border-radius:8px;"
                                        required>

                                    <option value="">Seleccione profesor</option>

                                    @foreach($profesores as $profesor)

                                        <option value="{{ $profesor->id }}">
                                            {{ $profesor->apellido }},
                                            {{ $profesor->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <!-- MATERIA -->
                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-semibold small">Materia</label>

                                <select name="materia_id"
                                        class="form-select"
                                        style="border:2px solid #bfd9ea;border-radius:8px;"
                                        required>

                                    <option value="">Seleccione materia</option>

                                    @foreach($materias as $materia)

                                        <option value="{{ $materia->id }}">
                                            {{ $materia->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <!-- PERIODO -->
                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-semibold small">
                                    Periodo Académico
                                </label>

                                <select name="periodo_academico_id"
                                        class="form-select"
                                        style="border:2px solid #bfd9ea;border-radius:8px;"
                                        required>

                                    <option value="">Seleccione periodo</option>

                                    @foreach($periodos as $periodo)

                                        <option value="{{ $periodo->id }}">
                                            {{ $periodo->nombre_periodo }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- TABLA DE ESTUDIANTES -->

                <div class="card border-0 shadow-sm" style="border-radius:12px;">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3" style="color:#003b73;">
                            <i class="fas fa-users me-2"></i>
                            Estudiantes del Curso
                        </h6>


                        @if($estudiantes->isEmpty())

                            <div class="alert alert-warning">
                                No hay estudiantes en este curso.
                            </div>

                        @else

                            <div class="table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead style="background:#003b73;color:white;">

                                    <tr>
                                        <th>Estudiante</th>
                                        <th style="width:150px;">Nota</th>
                                        <th>Observación</th>
                                    </tr>

                                    </thead>

                                    <tbody>

                                    @foreach($estudiantes as $estudiante)

                                        <tr>

                                            <td>

                                                <strong>
                                                    {{ $estudiante->apellido1 }}
                                                    {{ $estudiante->apellido2 }},
                                                    {{ $estudiante->nombre1 }}
                                                    {{ $estudiante->nombre2 }}
                                                </strong>

                                            </td>

                                            <td>

                                                <input type="number"
                                                       name="notas[{{ $estudiante->id }}]"
                                                       class="form-control"
                                                       min="0"
                                                       max="100"
                                                       step="0.01"
                                                       style="border:2px solid #bfd9ea;border-radius:8px;">

                                            </td>

                                            <td>

                                                <input type="text"
                                                       name="observacion[{{ $estudiante->id }}]"
                                                       class="form-control"
                                                       style="border:2px solid #bfd9ea;border-radius:8px;">

                                            </td>

                                        </tr>

                                    @endforeach

                                    </tbody>

                                </table>

                            </div>


                            <div class="text-end mt-3">

                                <button type="submit"
                                        class="btn"
                                        style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
color:white;border:none;border-radius:8px;font-weight:600;padding:8px 18px;">

                                    <i class="fas fa-save me-1"></i>
                                    Guardar Calificaciones

                                </button>

                            </div>

                        @endif

                    </div>

                </div>

            </form>

        @endif

    </div>

@endsection