@extends('layouts.app')

@section('topbar-actions')

    @php
        $usuario = auth()->user();
        $rutaDashboard = match($usuario->rol->nombre ?? '') {
            'Administrador'       => route('admin.dashboard'),
            'Super Administrador' => route('superadmin.dashboard'),
            'Profesor'            => route('profesor.dashboard'),
            'Estudiante'          => route('estudiante.dashboard'),
            'Padre'               => route('padre.dashboard'),
            default               => route('dashboard'),
        };
    @endphp

    <div style="display:flex; gap:10px;">

        <a href="{{ route('registrarcalificaciones.ver') }}"
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

        {{-- ✅ ALERTAS DE ÉXITO / ERROR --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


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
                        <h5 class="mb-0 fw-bold">Registrar Calificaciones</h5>

                        {{-- ✅ Mensaje personalizado si es profesor --}}
                        <p class="mb-0 opacity-90" style="font-size:0.85rem;">
                            @if($profesorActual)
                                Prof. <strong>{{ $profesorActual->nombre }}
                                {{ $profesorActual->apellido }}</strong>
                                — Solo sus grados y materias asignadas
                            @else
                                Seleccione un curso para registrar las notas de los estudiantes
                            @endif
                        </p>
                    </div>

                </div>

            </div>

        </div>


        <!-- SELECCIONAR CURSO -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">

            <div class="card-body">

                <label class="form-label fw-semibold mb-2" style="color:#003b73;">
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

                {{-- ✅ Aviso si el profesor no tiene grados asignados --}}
                @if($grados->isEmpty())
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No tienes grados asignados. Contacta al administrador.
                    </div>
                @endif

            </div>

        </div>


        @if(request()->filled('grado_id'))

            <form action="{{ route('registrarcalificaciones.store') }}" method="POST">

                @csrf

                <input type="hidden" name="grado_id" value="{{ request('grado_id') }}">

                {{-- ✅ Si es profesor, su ID va oculto automáticamente --}}
                @if($profesorActual)
                    <input type="hidden"
                           name="profesor_id"
                           value="{{ $profesorActual->id }}">
                @endif


                <!-- DATOS GENERALES -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3" style="color:#003b73;">
                            <i class="fas fa-cogs me-2"></i>
                            Información de la Calificación
                        </h6>

                        <div class="row">

                            <!-- ✅ PROFESOR -->
                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-semibold small">Profesor</label>

                                @if($profesorActual)
                                    {{-- Profesor logueado: campo visual bloqueado, no editable --}}
                                    <div class="form-control"
                                         style="border:2px solid #bfd9ea;border-radius:8px;
                                                background:#f0f7ff;color:#003b73;font-weight:600;">
                                        <i class="fas fa-user-tie me-2 text-muted"></i>
                                        {{ $profesorActual->apellido }},
                                        {{ $profesorActual->nombre }}
                                    </div>
                                @else
                                    {{-- Admin: puede elegir cualquier profesor --}}
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
                                @endif

                            </div>


                            <!-- ✅ MATERIA — solo las del profesor en este grado -->
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

                                @if($materias->isEmpty())
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Sin materias asignadas en este grado.
                                    </small>
                                @endif

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
                                                           class="form-control nota-input"
                                                           min="0"
                                                           max="100"
                                                           step="0.01"
                                                           placeholder="0.00"
                                                           style="border:2px solid #bfd9ea;border-radius:8px;">
                                                </td>

                                                <td>
                                                    <input type="text"
                                                           name="observacion[{{ $estudiante->id }}]"
                                                           class="form-control"
                                                           placeholder="Opcional..."
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
                                               color:white;border:none;border-radius:8px;
                                               font-weight:600;padding:8px 18px;">
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


    {{-- ✅ Color en tiempo real: verde = aprobado, rojo = reprobado --}}
    <style>
        .nota-input:focus {
            border-color: #4ec7d2 !important;
            box-shadow: 0 0 0 3px rgba(78,199,210,0.2);
        }
        .nota-aprobado { border-color: #28a745 !important; background: #f0fff4 !important; }
        .nota-reprobado { border-color: #dc3545 !important; background: #fff5f5 !important; }
    </style>

    <script>
        document.querySelectorAll('.nota-input').forEach(function (input) {
            input.addEventListener('input', function () {
                this.classList.remove('nota-aprobado', 'nota-reprobado');
                const val = parseFloat(this.value);
                if (!isNaN(val) && this.value !== '') {
                    this.classList.add(val >= 60 ? 'nota-aprobado' : 'nota-reprobado');
                }
            });
        });
    </script>

@endsection
