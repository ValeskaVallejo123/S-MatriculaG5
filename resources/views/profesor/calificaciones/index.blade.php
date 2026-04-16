@extends('layouts.app')

@section('title', 'Mis Calificaciones')
@section('page-title', 'Mis Calificaciones')
@section('content-class', 'p-0')

@push('styles')
<style>
.pc-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.pc-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.pc-hero-left { display: flex; align-items: center; gap: 1rem; }
.pc-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pc-hero-icon i { font-size: 1.3rem; color: white; }
.pc-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.pc-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.pc-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.pc-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.pc-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

/* Body */
.pc-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Group section */
.pc-group {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
    margin-bottom: 1rem;
}
.pc-group-header {
    background: #003b73; padding: .75rem 1.1rem;
    display: flex; align-items: center; justify-content: space-between;
}
.pc-group-title {
    font-size: .82rem; font-weight: 700; color: white;
    display: flex; align-items: center; gap: .4rem;
}
.pc-group-title i { color: #4ec7d2; }
.pc-count-badge {
    background: rgba(78,199,210,.25); border: 1px solid rgba(78,199,210,.4);
    border-radius: 999px; padding: .15rem .6rem;
    font-size: .68rem; font-weight: 700; color: white;
}

/* Table */
.pc-tbl thead th {
    background: #f8fafc; color: #64748b; font-size: .68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .65rem 1rem;
    border-bottom: 1px solid #e2e8f0; border-top: none;
}
.pc-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.pc-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.pc-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .84rem; color: #334155; }
.pc-tbl tbody tr:last-child { border-bottom: none; }

.btn-ver {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .85rem; border-radius: 7px; font-size: .75rem; font-weight: 700;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; text-decoration: none; border: none; transition: opacity .15s;
}
.btn-ver:hover { opacity: .88; color: white; }

/* Empty */
.pc-empty { text-align: center; padding: 3.5rem 1rem; color: #94a3b8; }
.pc-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.pc-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0 0 .25rem; }
.pc-empty small { font-size: .8rem; }

/* Dark mode */
body.dark-mode .pc-wrap { background: #0f172a; }
body.dark-mode .pc-group { background: #1e293b; }
body.dark-mode .pc-tbl thead th { background: #1e293b; border-color: #334155; }
body.dark-mode .pc-tbl tbody td { color: #cbd5e1; }
body.dark-mode .pc-tbl tbody tr { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="pc-wrap">

    {{-- Hero --}}
    <div class="pc-hero">
        <div class="pc-hero-left">
            <div class="pc-hero-icon"><i class="fas fa-clipboard-check"></i></div>
            <div>
                <h2 class="pc-hero-title">Mis Calificaciones</h2>
                <p class="pc-hero-sub">
                    {{ $profesor->nombre ?? $profesor->nombre_completo ?? 'Profesor' }}
                    — Año {{ date('Y') }}
                </p>
            </div>
        </div>
        @if(!$grupos->isEmpty())
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <div class="pc-stat">
                    <div class="pc-stat-num">{{ $grupos->count() }}</div>
                    <div class="pc-stat-lbl">Grupos</div>
                </div>
                <div class="pc-stat">
                    <div class="pc-stat-num">{{ $grupos->flatten()->count() }}</div>
                    <div class="pc-stat-lbl">Materias</div>
                </div>
            </div>
        @endif
    </div>

    {{-- Body --}}
    <div class="pc-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($grupos->isEmpty())
            <div class="pc-group">
                <div class="pc-empty">
                    <i class="fas fa-inbox"></i>
                    <p>No tienes grupos asignados</p>
                    <small>Contacta al administrador para que te asigne grados y materias.</small>
                </div>
            </div>
        @else
            @foreach($grupos as $clave => $materias)
                @php
                    [$gradoId, $seccion] = explode('|', $clave);
                    $grado = $materias->first()->grado;
                @endphp
                <div class="pc-group">
                    <div class="pc-group-header">
                        <div class="pc-group-title">
                            <i class="fas fa-school"></i>
                            {{ $grado->numero ?? '' }}° Grado — Sección {{ $seccion }}
                            &nbsp;·&nbsp; {{ ucfirst($grado->nivel ?? '') }}
                        </div>
                        <span class="pc-count-badge">
                            {{ $materias->count() }} {{ $materias->count() == 1 ? 'materia' : 'materias' }}
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table pc-tbl mb-0">
                            <thead>
                                <tr>
                                    <th style="width:50px;text-align:center;">#</th>
                                    <th><i class="fas fa-book" style="color:#4ec7d2;margin-right:.3rem;"></i>Materia</th>
                                    <th><i class="fas fa-layer-group" style="color:#4ec7d2;margin-right:.3rem;"></i>Grado / Sección</th>
                                    <th style="text-align:center;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materias as $i => $asignacion)
                                    <tr>
                                        <td style="text-align:center;color:#94a3b8;font-size:.75rem;font-weight:600;">{{ $i + 1 }}</td>
                                        <td style="font-weight:700;color:#003b73;">
                                            {{ $asignacion->materia->nombre ?? 'Materia' }}
                                        </td>
                                        <td style="color:#64748b;font-size:.82rem;">
                                            {{ $grado->numero ?? '' }}° Grado · Sección {{ $seccion }}
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
                </div>
            @endforeach

            <div style="padding:.5rem 0;text-align:center;font-size:.72rem;color:#94a3b8;">
                <i class="fas fa-info-circle" style="color:#4ec7d2;margin-right:.3rem;"></i>
                Selecciona una materia para gestionar sus calificaciones
            </div>
        @endif

    </div>{{-- /pc-body --}}
</div>
@endsection
