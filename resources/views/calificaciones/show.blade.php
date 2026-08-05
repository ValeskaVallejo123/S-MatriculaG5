@extends('layouts.app')

@section('title', 'Detalle de Calificación')

@section('page-title', 'Calificaciones')

@section('topbar-actions')
    <a href="{{ route('calificaciones.edit', $calificacion) }}" class="btn fw-semibold ms-2"
       style="background: rgba(78,199,210,0.1); color: #00508f; border: 1.5px solid #4ec7d2; padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.9rem;">
        <i class="fas fa-edit me-1"></i> Editar
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 720px;">

    {{-- Info general --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-4 flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-user-graduate" style="color: #00508f; font-size: 0.9rem;"></i>
                    <span class="fw-semibold" style="color: #003b73;">
                        {{ $calificacion->estudiante->nombre_completo ?? '—' }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-book" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                    <span class="small text-muted">{{ $calificacion->materia->nombre ?? '—' }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-school" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                    <span class="small text-muted">{{ $calificacion->grado_nombre }} · {{ $calificacion->seccion }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-calendar-alt" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                    <span class="small text-muted">{{ $calificacion->periodo->nombre_periodo ?? $calificacion->periodo->nombre ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Parciales --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-4">
            <div class="row g-3 mb-3">
                @foreach([
                    ['1er Parcial',  $calificacion->primer_parcial,  '#00508f', 'rgba(0,80,143,0.06)',   'fa-chart-bar'],
                    ['2do Parcial',  $calificacion->segundo_parcial, '#4ec7d2', 'rgba(78,199,210,0.1)',  'fa-chart-bar'],
                    ['3er Parcial',  $calificacion->tercer_parcial,  '#00508f', 'rgba(0,80,143,0.06)',   'fa-chart-bar'],
                    ['Recuperación', $calificacion->recuperacion,    '#f57f17', 'rgba(255,193,7,0.1)',   'fa-redo'],
                ] as [$lbl, $val, $clr, $bg, $ico])
                <div class="col-md-3 col-6">
                    <div class="p-3 text-center rounded-3" style="background: {{ $bg }}; border: 1px solid {{ $clr }}22;">
                        <i class="fas {{ $ico }} mb-1" style="color: {{ $clr }}; font-size: 0.85rem;"></i>
                        <div class="small text-muted mb-1" style="font-size: 0.78rem;">{{ $lbl }}</div>
                        <div class="fw-bold" style="font-size: 1.4rem; color: {{ $clr }};">
                            {{ $val !== null ? number_format($val, 1) : '—' }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Nota Final --}}
            @php
                $nf    = $calificacion->nota_final;
                $color = $nf === null ? '#999' : ($nf >= 60 ? '#388e3c' : '#d32f2f');
                $bg    = $nf === null ? 'rgba(200,200,200,0.1)' : ($nf >= 60 ? 'rgba(76,175,80,0.08)' : 'rgba(244,67,54,0.08)');
                $txt   = $nf === null ? 'Pendiente' : ($nf >= 60 ? 'Aprobado' : 'Reprobado');
                $icon  = $nf === null ? 'fa-clock'  : ($nf >= 60 ? 'fa-check-circle' : 'fa-times-circle');
            @endphp
            <div class="d-flex align-items-center justify-content-between p-4 rounded-3"
                 style="background: {{ $bg }}; border: 2px solid {{ $color }}33;">
                <div>
                    <div class="small text-muted mb-1">Nota Final</div>
                    <div class="fw-bold" style="font-size: 2.5rem; color: {{ $color }}; line-height: 1;">
                        {{ $nf !== null ? number_format($nf, 1) : '—' }}
                    </div>
                </div>
                <span class="badge rounded-pill" style="background: {{ $bg }}; color: {{ $color }}; border: 1.5px solid {{ $color }}; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 600;">
                    <i class="fas {{ $icon }} me-1"></i>{{ $txt }}
                </span>
            </div>

            @if($calificacion->observacion)
                <div class="mt-3 p-3 rounded-3" style="background: rgba(0,80,143,0.04); border: 1px solid #e2e8f0;">
                    <span class="small fw-semibold" style="color: #003b73;">
                        <i class="fas fa-comment-alt me-1" style="color: #4ec7d2;"></i>Observación:
                    </span>
                    <p class="small text-muted mb-0 mt-1">{{ $calificacion->observacion }}</p>
                </div>
            @endif
        </div>

        <div class="card-footer bg-white border-0 py-2 px-4" style="border-top: 1px solid #f1f5f9;">
            <div class="d-flex justify-content-between">
                <span class="small text-muted">Registrado: {{ $calificacion->created_at?->format('d/m/Y H:i') }}</span>
                <span class="small text-muted">Actualizado: {{ $calificacion->updated_at?->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>

    {{-- Eliminar --}}
    <div class="d-flex justify-content-end">
        <form method="POST" action="{{ route('calificaciones.destroy', $calificacion) }}"
              data-confirm="¿Eliminar esta calificación definitivamente?">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm fw-semibold"
                    style="background: rgba(244,67,54,0.08); color: #d32f2f; border: 1px solid #ef9a9a; border-radius: 8px; padding: 0.4rem 1rem;">
                <i class="fas fa-trash me-1"></i>Eliminar calificación
            </button>
        </form>
    </div>

</div>

@push('styles')
<style>
    .btn-back:hover { background: #00508f !important; color: white !important; transform: translateY(-2px); }
</style>
@endpush
@endsection
