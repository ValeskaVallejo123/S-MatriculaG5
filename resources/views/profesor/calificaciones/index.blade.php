@extends('layouts.app')

@section('title', 'Calificaciones')
@section('page-title', 'Calificaciones')


@push('styles')
<style>
.sm-sec-title {
    display:flex;align-items:center;gap:.5rem;
    font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
    color:#00508f;margin-bottom:.75rem;padding-bottom:.5rem;
    border-bottom:2px solid rgba(78,199,210,.15);
}
.sm-sec-title i { color:#4ec7d2; }

.grado-badge {
    display:inline-flex;align-items:center;gap:.35rem;
    padding:.28rem .85rem;border-radius:999px;
    font-size:.72rem;font-weight:700;
    background:rgba(255,255,255,.15);color:white;
    border:1px solid rgba(255,255,255,.35);
}

/* Tabla materias */
.mat-table { width:100%;border-collapse:collapse; }
.mat-table thead th {
    font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
    color:#6b7a90;background:#f5f8fc;padding:.65rem 1rem;
    border:1px solid #e8edf4;white-space:nowrap;
}
.mat-table tbody td {
    padding:.65rem 1rem;border:1px solid #e8edf4;vertical-align:middle;
    font-size:.82rem;
}
.mat-table tbody tr:hover td { background:rgba(78,199,210,.04); }

.mat-nombre { font-weight:700;color:#003b73; }
.mat-grado  { font-size:.72rem;color:#6b7a90; }

.btn-ver {
    display:inline-flex;align-items:center;gap:.35rem;
    padding:.35rem .85rem;border-radius:7px;font-size:.78rem;font-weight:600;
    background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
    text-decoration:none;border:none;transition:all .2s;
}
.btn-ver:hover { opacity:.88;transform:translateY(-1px);color:white; }
</style>
@endpush

@section('content')
<div style="width:100%;">

    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-left:4px solid #16a34a;
                    border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;
                    font-size:.85rem;color:#15803d;display:flex;align-items:center;gap:.5rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem;position:relative;overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:72px;height:72px;border-radius:16px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-clipboard-check" style="color:white;font-size:1.9rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.35rem;font-weight:800;color:white;margin:0 0 .5rem;
                           text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Mis Calificaciones
                </h2>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <span class="grado-badge">
                        <i class="fas fa-user-tie"></i>
                        {{ $profesor->nombre ?? $profesor->nombre_completo ?? 'Profesor' }}
                    </span>
                    @if(!$grupos->isEmpty())
                        <span class="grado-badge">
                            <i class="fas fa-chalkboard"></i> {{ $grupos->count() }} grupo(s)
                        </span>
                        <span class="grado-badge">
                            <i class="fas fa-book-open"></i> {{ $grupos->flatten()->count() }} materia(s)
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.4rem 1.7rem;">

            @if($grupos->isEmpty())
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-inbox" style="font-size:3rem;display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                    <p style="font-size:.9rem;font-weight:600;margin:0 0 .3rem;color:#64748b;">
                        No tienes grupos asignados
                    </p>
                    <small>Contacta al administrador para que te asigne grados y materias.</small>
                </div>
            @else

                @foreach($grupos as $clave => $materias)
                    @php
                        [$gradoId, $seccion] = explode('|', $clave);
                        $grado = $materias->first()->grado;
                    @endphp

                    @if(!$loop->first)
                        <div style="margin:1.5rem 0;border-top:1px solid rgba(78,199,210,.12);"></div>
                    @endif

                    <div class="sm-sec-title">
                        <i class="fas fa-school"></i>
                        {{ $grado->numero ?? '' }}° {{ $grado->seccion ?? '' }} —
                        {{ ucfirst($grado->nivel ?? '') }}
                        <span style="margin-left:auto;font-size:.7rem;font-weight:600;letter-spacing:0;
                                     text-transform:none;background:rgba(78,199,210,.12);color:#007b8a;
                                     padding:.18rem .65rem;border-radius:999px;">
                            {{ $materias->count() }} {{ $materias->count()==1?'materia':'materias' }}
                        </span>
                    </div>

                    <div style="overflow-x:auto;">
                        <table class="mat-table">
                            <thead>
                                <tr>
                                    <th style="width:3rem;text-align:center;">#</th>
                                    <th><i class="fas fa-book me-1" style="color:#4ec7d2;"></i> Materia</th>
                                    <th><i class="fas fa-layer-group me-1" style="color:#4ec7d2;"></i> Grado / Sección</th>
                                    <th style="text-align:center;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materias as $i => $asignacion)
                                <tr>
                                    <td style="text-align:center;color:#94a3b8;font-size:.75rem;font-weight:600;">
                                        {{ $i + 1 }}
                                    </td>
                                    <td>
                                        <span class="mat-nombre">
                                            {{ $asignacion->materia->nombre ?? 'Materia' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="mat-grado">
                                            {{ $grado->numero ?? '' }}° Grado · Sección {{ $seccion }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('profesor.calificaciones.listar', [
                                                'gradoId'   => $gradoId,
                                                'seccion'   => $seccion,
                                                'materiaId' => $asignacion->materia_id,
                                            ]) }}" class="btn-ver">
                                            <i class="fas fa-list-alt"></i> Ver calificaciones
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @endforeach

            @endif
        </div>

        {{-- Footer --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;
                    padding:.85rem 1.7rem;background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;font-size:.72rem;color:#94a3b8;">
            <span>
                <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                Selecciona una materia para gestionar sus calificaciones
            </span>
            <span>
                <i class="fas fa-calendar me-1" style="color:#4ec7d2;"></i>
                Año lectivo {{ date('Y') }}
            </span>
        </div>

    </div>
</div>
@endsection
