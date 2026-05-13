@extends('layouts.app')

@section('title', 'Alumnos por Grado y Sección')
@section('page-title', 'Alumnos por Grado y Sección')

@section('topbar-actions')
    <a href="{{ route('secciones.index') }}" class="btn-back"
       style="background: #f1f5f9; color: #003b73; padding: 0.5rem 1.2rem; border-radius: 8px;
              text-decoration: none; font-weight: 600; display: inline-flex; align-items: center;
              gap: 0.5rem; border: 1.5px solid #d0dce8; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1300px;">

    @foreach($gradosSecciones as $grado => $secciones)

    {{-- ── BLOQUE DE GRADO ───────────────────────────────────────────── --}}
    <div class="mb-5">

        {{-- Encabezado del grado --}}
        <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
                        border-radius: 12px; display: flex; align-items: center; justify-content: center;
                        flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,59,115,0.25);">
                <span class="text-white fw-bold" style="font-size: 1.1rem;">{{ $grado }}</span>
            </div>
            <div>
                <h4 class="mb-0 fw-bold" style="color: #003b73;">Grado {{ $grado }}</h4>
                <small class="text-muted">
                    {{ $secciones->sum(fn($s) => $s->matriculas->count()) }} alumnos en total
                </small>
            </div>
            <hr class="flex-grow-1 ms-2" style="border-color: #d0dce8;">
        </div>

        {{-- Columnas A / B / C --}}
        <div class="row g-3">
            @foreach($secciones as $seccion)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">

                    {{-- Header de sección --}}
                    <div class="card-header border-0 py-2 px-3"
                         style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 text-white fw-bold">
                                <i class="fas fa-chalkboard me-2"></i>Sección {{ $seccion->letra }}
                            </h6>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge" style="background: rgba(255,255,255,0.2); color: white; font-size: 0.75rem;">
                                    {{ $seccion->matriculas->count() }}/{{ $seccion->capacidad }}
                                </span>
                                @if($seccion->capacidadRestante() > 0)
                                    <span class="badge" style="background: rgba(40,167,69,0.9); color: white; font-size: 0.7rem;">
                                        {{ $seccion->capacidadRestante() }} libre{{ $seccion->capacidadRestante() != 1 ? 's' : '' }}
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(220,53,69,0.9); color: white; font-size: 0.7rem;">
                                        Llena
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Barra de capacidad --}}
                        @php $porcentaje = $seccion->capacidad > 0 ? ($seccion->matriculas->count() / $seccion->capacidad) * 100 : 0; @endphp
                        <div class="mt-2" style="background: rgba(255,255,255,0.2); border-radius: 4px; height: 4px;">
                            <div style="width: {{ min($porcentaje, 100) }}%; height: 100%; border-radius: 4px;
                                        background: {{ $porcentaje >= 100 ? '#ff4757' : ($porcentaje >= 80 ? '#ffa502' : 'white') }};
                                        transition: width 0.4s ease;"></div>
                        </div>
                    </div>

                    {{-- Lista de alumnos --}}
                    <div class="card-body p-0">
                        @forelse($seccion->matriculas as $matricula)
                        <div class="d-flex align-items-center gap-2 px-3 py-2 alumno-row"
                             style="border-bottom: 1px solid #f0f4f8; transition: background 0.15s ease;">

                            {{-- Avatar inicial --}}
                            <div style="width: 34px; height: 34px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                        border-radius: 8px; display: flex; align-items: center; justify-content: center;
                                        flex-shrink: 0; font-size: 0.8rem; font-weight: 700; color: white;">
                                {{ strtoupper(substr($matricula->estudiante->nombre ?? 'N', 0, 1) . substr($matricula->estudiante->apellido ?? 'A', 0, 1)) }}
                            </div>

                            {{-- Nombre y DNI --}}
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.85rem;">
                                    {{ $matricula->estudiante->nombre ?? 'N/A' }}
                                    {{ $matricula->estudiante->apellido ?? '' }}
                                </p>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    <i class="fas fa-id-card me-1"></i>{{ $matricula->estudiante->dni ?? 'Sin DNI' }}
                                </small>
                            </div>

                            {{-- Estado matrícula --}}
                            @if($matricula->estado === 'aprobada')
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 0.85rem;" title="Aprobada"></i>
                            @elseif($matricula->estado === 'pendiente')
                                <i class="fas fa-clock" style="color: #ffc107; font-size: 0.85rem;" title="Pendiente"></i>
                            @else
                                <i class="fas fa-times-circle" style="color: #dc3545; font-size: 0.85rem;" title="Rechazada"></i>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash mb-2" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                            <p class="text-muted mb-0 small">Sin alumnos asignados</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Footer de la card --}}
                    <div class="card-footer border-0 py-2 px-3" style="background: #f8fafc;">
                        <a href="{{ route('secciones.alumnos', $seccion->id) }}"
                           class="btn btn-sm w-100"
                           style="background: white; border: 1.5px solid #4ec7d2; color: #00508f;
                                  border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-list me-1"></i> Ver detalle
                        </a>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>

    @endforeach

</div>

<style>
.alumno-row:hover {
    background: #f0f8ff;
}
</style>
@endsection