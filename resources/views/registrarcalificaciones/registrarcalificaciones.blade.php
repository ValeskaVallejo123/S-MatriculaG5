@extends('layouts.app')

@section('title', 'Registrar Calificaciones')
@section('page-title', 'Registrar Calificaciones')

@section('topbar-actions')
    <a href="{{ route('periodos-academicos.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.45rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1100px;">

        <!-- Header compacto -->
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg,#00508f 0%,#003b73 100%); border-radius:10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width:45px;height:45px;background:rgba(78,199,210,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-clipboard-list text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size:1.05rem;">Registrar Calificaciones</h5>
                        <p class="mb-0 opacity-90" style="font-size:0.82rem;">Selecciona curso y período para ingresar o editar notas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensajes flash -->
        @if(session('success'))
            <div class="alert border-0 mb-3 py-2 px-3" style="border-radius:8px; background: rgba(78,199,210,0.12); border-left:3px solid #4ec7d2;">
                <strong style="color:#00508f;">Éxito:</strong> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert border-0 mb-3 py-2 px-3" style="border-radius:8px; background: rgba(255,235,238,0.9); border-left:3px solid #f8d7da;">
                <strong style="color:#7a1a1a;">Errores:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li class="small" style="color:#7a1a1a;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card principal (estilo plantilla) -->
        <div class="card border-0 shadow-sm" style="border-radius:10px;">
            <div class="card-body p-3">

                <!-- Filtros -->
                <form method="GET" action="{{ route('registrarcalificaciones.index') }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="curso" class="form-label fw-semibold small mb-1" style="color:#003b73;">Curso</label>
                            <div class="position-relative">
                                <i class="fas fa-book position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem; z-index:10;"></i>
                                <select name="curso" id="curso" required
                                        class="form-select form-select-sm ps-5 @error('curso') is-invalid @enderror"
                                        style="border:2px solid #bfd9ea; border-radius:8px; padding:0.5rem 1rem 0.5rem 2.6rem;">
                                    <option value="">Seleccione un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ request('curso') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso') <div class="invalid-feedback" style="font-size:0.8rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="periodo" class="form-label fw-semibold small mb-1" style="color:#003b73;">Período Académico</label>
                            <div class="position-relative">
                                <i class="fas fa-calendar-alt position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem; z-index:10;"></i>
                                <select name="periodo" id="periodo" required
                                        class="form-select form-select-sm ps-5 @error('periodo') is-invalid @enderror"
                                        style="border:2px solid #bfd9ea; border-radius:8px; padding:0.5rem 1rem 0.5rem 2.6rem;">
                                    <option value="">Seleccione un período</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ request('periodo') == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->nombre_periodo ?? $periodo->nombre ?? $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('periodo') <div class="invalid-feedback" style="font-size:0.8rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top mt-3">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg,#004191 0%,#0b96b6 100%); color:white; border:none; padding:0.55rem; border-radius:8px; box-shadow:0 2px 8px rgba(4,64,120,0.12);">
                            <i class="fas fa-filter me-2"></i> Filtrar
                        </button>

                        <a href="{{ route('registrarcalificaciones.index') }}" class="btn btn-sm fw-semibold flex-fill" style="background:white; color:#00508f; border:2px solid #00508f; padding:0.55rem; border-radius:8px; text-decoration:none;">
                            <i class="fas fa-undo me-2"></i> Limpiar
                        </a>
                    </div>
                </form>

                <!-- Tabla de estudiantes -->
                @if(isset($estudiantes) && $estudiantes->count())
                    <form method="POST" action="{{ route('registrarcalificaciones.store') }}" class="mt-4">
                        @csrf

                        <!-- Hidden inputs para contexto -->
                        <input type="hidden" name="curso_id" value="{{ request('curso') }}">
                        <input type="hidden" name="periodo_academico_id" value="{{ request('periodo') }}">
                        <input type="hidden" name="materia_id" value="{{ request('materia') ?? '' }}">

                        <div class="table-responsive">
                            <table class="table" style="width:100%; border-collapse:collapse;">
                                <thead>
                                <tr style="background:rgba(78,199,210,0.08); color:#003b73;">
                                    <th class="px-3 py-2 text-start">Estudiante</th>
                                    <th class="px-3 py-2 text-start">Nota (0-100)</th>
                                    <th class="px-3 py-2 text-start">Observación (opcional)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    // $calificacionesExistentes debe ser proporcionado por el controlador: [estudiante_id => nota]
                                    $calificacionesExistentes = $calificacionesExistentes ?? [];
                                    $observacionesExistentes = $observacionesExistentes ?? [];
                                @endphp

                                @foreach($estudiantes as $estudiante)
                                    <tr style="border-bottom:1px solid #e6eef3;">
                                        <td class="px-3 py-2">
                                            {{ $estudiante->apellido ? $estudiante->apellido . ', ' : '' }}{{ $estudiante->nombre }}
                                        </td>

                                        <td class="px-3 py-2" style="min-width:160px;">
                                            <input type="number"
                                                   name="notas[{{ $estudiante->id }}]"
                                                   class="form-control form-control-sm @error('notas.'.$estudiante->id) is-invalid @enderror"
                                                   min="0" max="100" step="0.01"
                                                   value="{{ old('notas.'.$estudiante->id, $calificacionesExistentes[$estudiante->id] ?? '') }}"
                                                   style="border:2px solid #bfd9ea; border-radius:8px; padding:0.45rem 0.6rem;">
                                            @error('notas.'.$estudiante->id)
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </td>

                                        <td class="px-3 py-2">
                                            <input type="text"
                                                   name="observacion[{{ $estudiante->id }}]"
                                                   class="form-control form-control-sm"
                                                   maxlength="500"
                                                   value="{{ old('observacion.'.$estudiante->id, $observacionesExistentes[$estudiante->id] ?? '') }}"
                                                   placeholder="Observación (opcional)"
                                                   style="border:2px solid #bfd9ea; border-radius:8px; padding:0.45rem 0.6rem;">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-3">
                            <button type="submit" class="btn btn-sm fw-semibold" style="background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%); color:white; border:none; padding:0.55rem 1rem; border-radius:8px; box-shadow:0 2px 8px rgba(78,199,210,0.12);">
                                <i class="fas fa-save me-2"></i> Guardar Calificaciones
                            </button>
                        </div>
                    </form>
                @elseif(request()->has('curso') && request()->has('periodo'))
                    <div class="alert border-0 mt-4 py-2 px-3" style="border-radius:8px; background:rgba(255,249,230,0.7); border-left:3px solid #ffdd99;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-circle me-2" style="color:#6a4a00;"></i>
                            <div class="fw-semibold" style="color:#6a4a00;">No se encontraron estudiantes matriculados en este curso y período.</div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Nota compacta -->
        <div class="alert border-0 mt-3 py-2 px-3" style="border-radius:8px; background:rgba(78,199,210,0.08); border-left:3px solid #4ec7d2;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="color:#00508f;"></i>
                <div>
                    <strong style="color:#00508f;">Información importante:</strong>
                    <span class="text-muted"> Asegúrate de seleccionar curso y período antes de filtrar. Las notas deben estar entre 0 y 100.</span>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .form-control-sm, .form-select-sm {
            border-radius: 6px;
            border: 1.5px solid #e2e8f0;
            padding: 0.45rem 0.65rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control-sm:focus, .form-select-sm:focus {
            border-color: #4ec7d2;
            box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.12);
            outline: none;
        }

        .form-label {
            color: #003b73;
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
        }

        .btn:hover {
            transform: translateY(-3px);
            transition: all 0.25s ease;
        }

        .btn-back:hover {
            background: #00508f !important;
            color: white !important;
            transform: translateY(-3px);
        }

        .table th, .table td { vertical-align: middle; padding: 0.6rem; }
        @media (max-width:768px) {
            .d-flex.gap-2 { gap:0.5rem !important; }
        }
    </style>
@endpush
