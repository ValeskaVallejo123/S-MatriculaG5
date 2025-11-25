@extends('layouts.app')

@section('title', 'Buscar Registro')
@section('page-title', 'Buscar Registro de Estudiante')

@section('topbar-actions')
    <a href="{{ route('estudiantes.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.45rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 900px;">

        <!-- Header compacto -->
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg,#00508f 0%,#003b73 100%); border-radius:10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width:45px;height:45px;background:rgba(78,199,210,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-search text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size:1.05rem;">Buscar Registro de Estudiante</h5>
                        <p class="mb-0 opacity-90" style="font-size:0.82rem;">Encuentra rápidamente el expediente del estudiante</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card principal -->
        <div class="card border-0 shadow-sm" style="border-radius:10px;">
            <div class="card-body p-3">

                <!-- Formulario (estilado como plantilla) -->
                <form method="GET" action="{{ route('buscarregistro') }}">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold small mb-1" style="color:#003b73;">Nombre completo</label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem; z-index:10;"></i>
                            <input type="text"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ request('nombre') }}"
                                   placeholder="Ej: Juan Pérez"
                                   class="form-control form-control-sm ps-5 @error('nombre') is-invalid @enderror"
                                   style="border:2px solid #bfd9ea; border-radius:8px; padding:0.55rem 1rem 0.55rem 2.6rem;"
                                   autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="dni" class="form-label fw-semibold small mb-1" style="color:#003b73;">Buscar por DNI</label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem; z-index:10;"></i>
                            <input type="text"
                                   id="dni"
                                   name="dni"
                                   value="{{ request('dni') }}"
                                   pattern="\d{4}-\d{4}-\d{5}"
                                   placeholder="Ej: 0801-1990-12345"
                                   class="form-control form-control-sm ps-5 @error('dni') is-invalid @enderror"
                                   style="border:2px solid #bfd9ea; border-radius:8px; padding:0.55rem 1rem 0.55rem 2.6rem;"
                                   autocomplete="off">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex gap-2 pt-2 border-top mt-3">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg,#004191 0%,#0b96b6 100%); color:white; border:none; padding:0.55rem; border-radius:8px; box-shadow:0 2px 8px rgba(4,64,120,0.12);">
                            <i class="fas fa-search me-2"></i> Buscar solicitud
                        </button>

                        <a href="{{ route('buscarregistro') }}" class="btn btn-sm fw-semibold flex-fill" style="background:white; color:#00508f; border:2px solid #00508f; padding:0.55rem; border-radius:8px; text-decoration:none;">
                            <i class="fas fa-undo me-2"></i> Limpiar
                        </a>
                    </div>
                </form>

                <!-- Resultados -->
                @if(isset($busquedaRealizada) && $busquedaRealizada)
                    <div class="mt-4">
                        @forelse($resultados as $estudiante)
                            <div class="mb-3">
                                <div class="text-center mb-3">
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-semibold small
                                    @if($estudiante->estado === 'activo')" style="background:#e6ffef;color:#0f5132;border-radius:999px;"@elseif($estudiante->estado === 'inactivo') " style="background:#fff2f2;color:#7a1a1a;border-radius:999px;"@else " style="background:#fff8e1;color:#6a4a00;border-radius:999px;"@endif">
                                    Estado: {{ ucfirst($estudiante->estado) }}
                                </div>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                                <h6 class="text-[#49769F] fw-bold mb-3">👤 Datos del estudiante</h6>
                                <div class="row g-2">
                                    <div class="col-12 col-sm-6"><strong>Nombre:</strong> {{ $estudiante->nombre }}</div>
                                    <div class="col-12 col-sm-6"><strong>Apellido:</strong> {{ $estudiante->apellido }}</div>
                                    <div class="col-12 col-sm-6"><strong>DNI:</strong> {{ $estudiante->dni }}</div>
                                    <div class="col-12 col-sm-6"><strong>Correo:</strong> {{ $estudiante->email ?? 'No registrado' }}</div>
                                    <div class="col-12 col-sm-6"><strong>Teléfono:</strong> {{ $estudiante->telefono ?? 'No registrado' }}</div>
                                    <div class="col-12 col-sm-6"><strong>Fecha de nacimiento:</strong> {{ optional($estudiante->fecha_nacimiento)->format('d/m/Y') ?? 'No registrada' }}</div>
                                    <div class="col-12 col-sm-6"><strong>Grado:</strong> {{ $estudiante->grado }}</div>
                                    <div class="col-12 col-sm-6"><strong>Sección:</strong> {{ $estudiante->seccion }}</div>
                                    <div class="col-12"><strong>Dirección:</strong> {{ $estudiante->direccion ?? 'No registrada' }}</div>
                                    <div class="col-12"><strong>Observaciones:</strong> {{ $estudiante->observaciones ?? 'Sin observaciones' }}</div>
                                </div>

                                @if($estudiante->foto)
                                    <div class="mt-3 text-center">
                                        <p class="fw-semibold mb-2">Foto del estudiante</p>
                                        <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto de {{ $estudiante->nombre }}" class="w-28 h-28 object-cover rounded-lg border mx-auto">
                                    </div>
                                @endif
                            </div>
                    </div>
                    @empty
                        <div class="mt-3 alert border-0 py-2 px-3" style="border-radius:8px;background:rgba(255,235,238,0.6);border-left:3px solid #f8d7da;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-circle me-2" style="color:#7a1a1a;"></i>
                                <div class="fw-semibold" style="color:#7a1a1a;">No se encontró ningún registro con esos datos. Verifique e intente nuevamente.</div>
                            </div>
                        </div>
                    @endforelse
            </div>
            @endif

        </div>
    </div>

    <!-- Nota compacta -->
    <div class="alert border-0 mt-3 py-2 px-3" style="border-radius:8px; background:rgba(78,199,210,0.08); border-left:3px solid #4ec7d2; font-size:0. nine rem;">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle me-2 mt-1" style="color:#00508f;"></i>
            <div>
                <strong style="color:#00508f;">Información importante:</strong>
                <span class="text-muted"> Usa nombre completo o DNI para obtener resultados más precisos.</span>
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
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }
        .form-control-sm:focus { border-color: #4ec7d2; box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.12); }
        .form-label { color:#003b73; font-size:0.85rem; margin-bottom:0.3rem; }
        .btn:hover { transform: translateY(-2px); transition: all 0.25s ease; }
        .btn-back:hover { background:#00508f !important; color:white !important; transform:translateY(-2px); }
        .border-top { border-color: rgba(0,80,143,0.08) !important; }
        .position-relative .fas { pointer-events: none; left:12px; position:absolute; }
        .alert .text-muted { font-size:0.85rem; color:#6b7280; }
        @media (max-width:768px){ .d-flex.gap-2 { gap:0.5rem !important; } }
    </style>
@endpush
