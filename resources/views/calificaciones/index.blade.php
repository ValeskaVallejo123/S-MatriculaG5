@extends('layouts.app')

@section('title', 'Gestión de Calificaciones')

@section('page-title', 'Calificaciones')

@section('topbar-actions')
    <a href="{{ route('calificaciones.create') }}" class="btn fw-semibold ms-2" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3); padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.9rem;">
        <i class="fas fa-plus me-1"></i> Nueva Calificación
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3" style="border-radius: 10px; border-left: 4px solid #388e3c !important;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Resumen --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-book" style="color: #00508f; font-size: 0.9rem;"></i>
                        <span class="small"><strong style="color: #00508f;">{{ $calificaciones->count() }}</strong> <span class="text-muted">Registros</span></span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle" style="color: #388e3c; font-size: 0.9rem;"></i>
                        <span class="small"><strong style="color: #388e3c;">{{ $calificaciones->where('nota_final', '>=', 60)->count() }}</strong> <span class="text-muted">Aprobados</span></span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-times-circle" style="color: #d32f2f; font-size: 0.9rem;"></i>
                        <span class="small"><strong style="color: #d32f2f;">{{ $calificaciones->where('nota_final', '<', 60)->whereNotNull('nota_final')->count() }}</strong> <span class="text-muted">Reprobados</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">#</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Estudiante</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Materia</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Grado / Sección</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">1er P.</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">2do P.</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">3er P.</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Recup.</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Nota Final</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Estado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($calificaciones as $cal)
                            @php
                                $nf    = $cal->nota_final;
                                $bg    = $nf === null ? 'rgba(200,200,200,0.15)' : ($nf >= 60 ? 'rgba(76,175,80,0.1)'  : 'rgba(244,67,54,0.1)');
                                $color = $nf === null ? '#999'                   : ($nf >= 60 ? '#388e3c'               : '#d32f2f');
                                $txt   = $nf === null ? 'Pendiente'              : ($nf >= 60 ? 'Aprobado'              : 'Reprobado');
                                $icon  = $nf === null ? 'fa-clock'               : ($nf >= 60 ? 'fa-check-circle'       : 'fa-times-circle');
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="px-3 py-2 text-muted small">{{ $cal->id }}</td>
                                <td class="px-3 py-2">
                                    <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                        {{ $cal->estudiante->nombre_completo ?? $cal->nombre_alumno ?? '—' }}
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="small text-muted">{{ $cal->materia->nombre ?? '—' }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge" style="background: rgba(78,199,210,0.15); color: #00508f; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                        {{ $cal->grado_nombre ?? '—' }} {{ $cal->seccion ? '· ' . $cal->seccion : '' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center small">{{ $cal->primer_parcial  ?? '—' }}</td>
                                <td class="px-3 py-2 text-center small">{{ $cal->segundo_parcial ?? '—' }}</td>
                                <td class="px-3 py-2 text-center small">{{ $cal->tercer_parcial  ?? '—' }}</td>
                                <td class="px-3 py-2 text-center small">{{ $cal->recuperacion    ?? '—' }}</td>
                                <td class="px-3 py-2 text-center">
                                    <span class="fw-bold" style="color: {{ $color }}; font-size: 1rem;">
                                        {{ $nf !== null ? number_format($nf, 1) : '—' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="badge rounded-pill" style="background: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $color }}; padding: 0.3rem 0.7rem; font-size: 0.75rem; font-weight: 600;">
                                        <i class="fas {{ $icon }} me-1" style="font-size: 0.65rem;"></i>{{ $txt }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a href="{{ route('calificaciones.show', $cal) }}"
                                           class="btn btn-sm" title="Ver"
                                           style="background: rgba(0,80,143,0.08); color: #00508f; border: 1px solid #00508f; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                            <i class="fas fa-eye" style="font-size: 0.75rem;"></i>
                                        </a>
                                        <a href="{{ route('calificaciones.edit', $cal) }}"
                                           class="btn btn-sm" title="Editar"
                                           style="background: rgba(78,199,210,0.1); color: #00508f; border: 1px solid #4ec7d2; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                            <i class="fas fa-edit" style="font-size: 0.75rem;"></i>
                                        </a>
                                        <form method="POST" action="{{ route('calificaciones.destroy', $cal) }}"
                                              onsubmit="return confirm('¿Eliminar esta calificación?')" class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm" title="Eliminar"
                                                    style="background: rgba(244,67,54,0.08); color: #d32f2f; border: 1px solid #ef9a9a; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                                <i class="fas fa-trash" style="font-size: 0.75rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block" style="color: #00508f; opacity: 0.4;"></i>
                                    <span style="color: #003b73;" class="fw-semibold">No hay calificaciones registradas</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .table tbody tr:hover { background-color: rgba(191,217,234,0.08); }
    .btn-back:hover { background: #00508f !important; color: white !important; transform: translateY(-2px); }
</style>
@endpush
@endsection
