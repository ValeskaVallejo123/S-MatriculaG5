@extends('layouts.app')

@section('title', 'Estudiantes del Curso')
@section('page-title', 'Estudiantes del Curso')
@section('content-class', 'p-0')

@push('styles')
<style>
.ces-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.ces-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.ces-hero-left { display: flex; align-items: center; gap: 1rem; }
.ces-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ces-hero-icon i { font-size: 1.3rem; color: white; }
.ces-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.ces-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.ces-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.ces-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.ces-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }
.ces-back-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.ces-back-btn:hover { background: #f0f4f8; color: #003b73; }

/* Body */
.ces-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Table card */
.ces-table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
}
.ces-tbl thead th {
    background: #003b73; color: white; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem; border: none;
}
.ces-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.ces-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.ces-tbl tbody td { padding: .72rem 1rem; vertical-align: middle; font-size: .84rem; color: #334155; }
.ces-tbl tbody tr:last-child { border-bottom: none; }

.ces-nombre {
    display: flex; align-items: center; gap: .5rem;
    font-weight: 700; color: #003b73;
}
.ces-avatar {
    width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; font-weight: 800; color: white;
}

/* Dark mode */
body.dark-mode .ces-wrap { background: #0f172a; }
body.dark-mode .ces-table-card { background: #1e293b; }
body.dark-mode .ces-tbl tbody td { color: #cbd5e1; }
body.dark-mode .ces-tbl tbody tr { border-color: #334155; }
body.dark-mode .ces-nombre { color: #e2e8f0; }
</style>
@endpush

@section('content')
<div class="ces-wrap">

    {{-- Hero --}}
    <div class="ces-hero">
        <div class="ces-hero-left">
            <div class="ces-hero-icon"><i class="fas fa-users"></i></div>
            <div>
                <h2 class="ces-hero-title">{{ $grado }} — Sección {{ $seccion }}</h2>
                <p class="ces-hero-sub">Listado de estudiantes matriculados en este curso</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="ces-stat">
                <div class="ces-stat-num">{{ $estudiantes->count() }}</div>
                <div class="ces-stat-lbl">Estudiantes</div>
            </div>
            <a href="{{ route('consultaestudiantesxcurso.index') }}" class="ces-back-btn">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    {{-- Body --}}
    <div class="ces-body">

        <div class="ces-table-card">
            @if($estudiantes->isEmpty())
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-inbox fa-2x" style="display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                    <p style="font-size:.9rem;font-weight:600;color:#003b73;margin:0;">
                        No hay estudiantes en este curso
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table ces-tbl mb-0">
                        <thead>
                            <tr>
                                <th style="width:50px;text-align:center;">#</th>
                                <th>Estudiante</th>
                                <th>DNI</th>
                                <th>Fecha Nacimiento</th>
                                <th style="text-align:center;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $i => $estudiante)
                                <tr>
                                    <td style="text-align:center;color:#94a3b8;font-size:.78rem;font-weight:700;">
                                        {{ $i + 1 }}
                                    </td>
                                    <td>
                                        <div class="ces-nombre">
                                            <div class="ces-avatar">
                                                {{ strtoupper(substr($estudiante->nombre1, 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1, 0, 1)) }}
                                            </div>
                                            {{ $estudiante->apellido1 }}
                                            {{ $estudiante->apellido2 }},
                                            {{ $estudiante->nombre1 }}
                                            {{ $estudiante->nombre2 }}
                                        </div>
                                    </td>
                                    <td style="font-family:monospace;font-size:.8rem;color:#64748b;">
                                        {{ $estudiante->dni ?? 'N/A' }}
                                    </td>
                                    <td style="color:#64748b;font-size:.82rem;">
                                        {{ $estudiante->fecha_nacimiento
                                            ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')
                                            : 'N/A' }}
                                    </td>
                                    <td style="text-align:center;">
                                        @if($estudiante->estado == 'activo')
                                            <span style="background:rgba(34,197,94,.1);color:#16a34a;
                                                         border:1px solid #86efac;border-radius:999px;
                                                         padding:.22rem .65rem;font-size:.72rem;font-weight:700;">
                                                Activo
                                            </span>
                                        @else
                                            <span style="background:rgba(100,116,139,.1);color:#64748b;
                                                         border:1px solid #cbd5e1;border-radius:999px;
                                                         padding:.22rem .65rem;font-size:.72rem;font-weight:700;">
                                                {{ ucfirst($estudiante->estado ?? 'N/A') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>{{-- /ces-body --}}
</div>
@endsection
