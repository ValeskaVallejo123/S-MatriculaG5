@extends('layouts.app')

@section('title', 'Panel del Profesor')
@section('page-title', 'Panel del Profesor')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

.pd-wrap { font-family: 'Inter', sans-serif; }

/* ── HERO ── */
.pd-hero {
    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 55%, #003b73 100%);
    border-radius: 14px; padding: 2rem 2rem; margin-bottom: 1.5rem;
    position: relative; overflow: hidden;
    box-shadow: 0 6px 24px rgba(0,59,115,.2);
}
.pd-hero::before {
    content: ''; position: absolute; right: -60px; top: -60px;
    width: 220px; height: 220px; border-radius: 50%;
    background: rgba(255,255,255,.06); pointer-events: none;
}
.pd-hero::after {
    content: ''; position: absolute; right: 120px; bottom: -55px;
    width: 140px; height: 140px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.pd-hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
}
.pd-hero-avatar {
    width: 72px; height: 72px; border-radius: 18px;
    background: rgba(255,255,255,.15); backdrop-filter: blur(6px);
    border: 2.5px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(0,0,0,.2);
}
.pd-hero-avatar i { color: #fff; font-size: 1.9rem; }
.pd-hero-name { font-size: 1.5rem; font-weight: 800; color: #fff; margin: 0 0 .5rem; }
.pd-hero-pill {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .7rem; border-radius: 999px; font-size: .72rem; font-weight: 700;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); color: #fff;
    margin-right: .4rem;
}

/* ── STATS ── */
.pd-stats {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
.pd-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.2rem; display: flex; align-items: center; gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); position: relative; overflow: hidden;
    transition: transform .18s, box-shadow .18s;
}
.pd-stat:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,59,115,.12); }
.pd-stat::before {
    content: ''; position: absolute;
    top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px;
}
.pd-s1::before { background: #4ec7d2; }
.pd-s2::before { background: #00508f; }
.pd-s3::before { background: #f59e0b; }
.pd-s4::before { background: #10b981; }
.pd-stat-icon {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.1rem;
}
.pd-s1 .pd-stat-icon { background: rgba(78,199,210,.12);  color: #4ec7d2; }
.pd-s2 .pd-stat-icon { background: rgba(0,80,143,.1);     color: #00508f; }
.pd-s3 .pd-stat-icon { background: rgba(245,158,11,.1);   color: #f59e0b; }
.pd-s4 .pd-stat-icon { background: rgba(16,185,129,.1);   color: #10b981; }
.pd-stat-lbl { font-size: .67rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #94a3b8; margin-bottom: .1rem; }
.pd-stat-num { font-size: 1.7rem; font-weight: 800; color: #0f172a; line-height: 1; }
.pd-stat-sub { font-size: .71rem; color: #94a3b8; margin-top: .1rem; }

/* ── SECTION TITLE ── */
.pd-sec {
    display: flex; align-items: center; gap: .5rem;
    font-size: .73rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: #00508f; margin-bottom: 1rem;
    padding-bottom: .55rem; border-bottom: 2px solid rgba(78,199,210,.15);
}
.pd-sec i { color: #4ec7d2; }

/* ── QUICK ACCESS ── */
.pd-quick {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: .9rem; margin-bottom: 1.5rem;
}
.pd-qcard {
    border-radius: 12px; text-decoration: none; overflow: hidden;
    transition: transform .2s, box-shadow .2s; display: block;
}
.pd-qcard:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,59,115,.22); text-decoration: none; }
.pd-qcard-inner {
    padding: 1.4rem 1rem; text-align: center;
    display: flex; flex-direction: column; align-items: center; gap: .55rem;
}
.pd-qcard-inner i   { font-size: 1.85rem; color: #fff; }
.pd-qcard-inner span { font-size: .78rem; font-weight: 700; color: #fff; line-height: 1.2; }
.qc-1 { background: linear-gradient(135deg, #4ec7d2, #00508f); }
.qc-2 { background: linear-gradient(135deg, #00508f, #003b73); }
.qc-3 { background: linear-gradient(135deg, #003b73, #00508f); }
.qc-4 { background: linear-gradient(135deg, #00508f, #4ec7d2); }

/* ── CARDS ── */
.pd-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.pd-card-head {
    background: #003b73; padding: .8rem 1.2rem;
    display: flex; align-items: center; gap: .55rem;
}
.pd-card-head i   { color: #4ec7d2; font-size: .95rem; }
.pd-card-head span { color: #fff; font-weight: 700; font-size: .9rem; }
.pd-card-body { padding: 1.1rem 1.2rem; }

/* ── GRID BOTTOM ── */
.pd-bottom { display: grid; grid-template-columns: 1.6fr 1fr; gap: 1.1rem; margin-bottom: 1.5rem; }

/* ── CLASES TABLE ── */
.pd-tbl { width: 100%; border-collapse: collapse; }
.pd-tbl thead th {
    background: #f8fafc; padding: .55rem .9rem;
    font-size: .68rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.pd-tbl tbody td {
    padding: .6rem .9rem; border-bottom: 1px solid #f1f5f9;
    font-size: .81rem; color: #334155; vertical-align: middle;
}
.pd-tbl tbody tr:last-child td { border-bottom: none; }
.pd-tbl tbody tr:hover { background: #fafbfc; }

/* ── BPILL ── */
.bpill {
    display: inline-flex; align-items: center; gap: .2rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .69rem; font-weight: 600; white-space: nowrap;
}
.b-teal   { background: #e8f8f9; color: #00508f; }
.b-blue   { background: #eff6ff; color: #1d4ed8; }
.b-green  { background: #dcfce7; color: #166534; }

/* ── ESTUDIANTES LIST ── */
.pd-est-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .6rem 0; border-bottom: 1px solid #f1f5f9;
}
.pd-est-item:last-child { border-bottom: none; }
.pd-est-avatar {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
}
.pd-est-avatar i { color: #fff; font-size: .85rem; }
.pd-est-name { font-size: .82rem; font-weight: 600; color: #0f172a; }
.pd-est-sub  { font-size: .71rem; color: #94a3b8; }

/* ── EMPTY ── */
.pd-empty { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
.pd-empty i { font-size: 1.8rem; display: block; margin-bottom: .5rem; color: #cbd5e1; }
.pd-empty p { font-size: .82rem; margin: 0; }

/* ── INFO BANNER ── */
.pd-info-bar {
    background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #4ec7d2;
    border-radius: 12px; padding: 1rem 1.3rem;
    display: flex; align-items: center; gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.pd-info-bar > i { color: #4ec7d2; font-size: 1.4rem; flex-shrink: 0; }
.pd-info-bar h6  { font-size: .84rem; font-weight: 700; color: #003b73; margin: 0 0 .15rem; }
.pd-info-bar p   { font-size: .77rem; color: #94a3b8; margin: 0; }

/* ── RESPONSIVE ── */
@media(max-width: 992px) {
    .pd-stats  { grid-template-columns: repeat(2, 1fr); }
    .pd-quick  { grid-template-columns: repeat(2, 1fr); }
    .pd-bottom { grid-template-columns: 1fr; }
}
@media(max-width: 576px) {
    .pd-stats  { grid-template-columns: 1fr 1fr; }
    .pd-hero   { padding: 1.4rem 1.2rem; }
    .pd-hero-name { font-size: 1.15rem; }
}
</style>
@endpush

@section('content')
<div class="pd-wrap container-fluid px-4">

    {{-- ── HERO ── --}}
    <div class="pd-hero">
        <div class="pd-hero-inner">
            <div class="pd-hero-avatar">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="pd-hero-name">Bienvenido, {{ auth()->user()->name }}</div>
                <span class="pd-hero-pill"><i class="fas fa-user-tie"></i> Profesor</span>
                <span class="pd-hero-pill"><i class="fas fa-calendar"></i> {{ now()->format('Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="pd-stats">
        <div class="pd-stat pd-s1">
            <div class="pd-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="pd-stat-lbl">Mis Estudiantes</div>
                <div class="pd-stat-num">{{ $totalEstudiantes }}</div>
                <div class="pd-stat-sub">Asignados</div>
            </div>
        </div>
        <div class="pd-stat pd-s2">
            <div class="pd-stat-icon"><i class="fas fa-book-open"></i></div>
            <div>
                <div class="pd-stat-lbl">Mis Cursos</div>
                <div class="pd-stat-num">{{ $totalClases }}</div>
                <div class="pd-stat-sub">Activos</div>
            </div>
        </div>
        <div class="pd-stat pd-s3">
            <div class="pd-stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="pd-stat-lbl">Calificaciones</div>
                <div class="pd-stat-num">{{ $tareasPendientes }}</div>
                <div class="pd-stat-sub">Pendientes</div>
            </div>
        </div>
        <div class="pd-stat pd-s4">
            <div class="pd-stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div>
                <div class="pd-stat-lbl">Clases Hoy</div>
                <div class="pd-stat-num">{{ $clasesHoy }}</div>
                <div class="pd-stat-sub">Programadas</div>
            </div>
        </div>
    </div>

    {{-- ── ACCESOS RÁPIDOS ── --}}
    <div class="pd-sec"><i class="fas fa-rocket"></i> Accesos Rápidos</div>
    <div class="pd-quick">
        <a href="{{ route('profesor.mis-cursos') }}" class="pd-qcard qc-1">
            <div class="pd-qcard-inner">
                <i class="fas fa-users"></i>
                <span>Mis Estudiantes</span>
            </div>
        </a>
        <a href="{{ route('profesor.mis-cursos') }}" class="pd-qcard qc-2">
            <div class="pd-qcard-inner">
                <i class="fas fa-book"></i>
                <span>Mis Cursos</span>
            </div>
        </a>
        <a href="{{ route('profesor.calificaciones.index') }}" class="pd-qcard qc-3">
            <div class="pd-qcard-inner">
                <i class="fas fa-clipboard-check"></i>
                <span>Calificaciones</span>
            </div>
        </a>
        <a href="{{ route('profesor.miHorario') }}" class="pd-qcard qc-4">
            <div class="pd-qcard-inner">
                <i class="fas fa-calendar-alt"></i>
                <span>Mi Horario</span>
            </div>
        </a>
    </div>

    {{-- ── PANELES INFERIORES ── --}}
    <div class="pd-bottom">

        {{-- Mis Clases --}}
        <div class="pd-card">
            <div class="pd-card-head">
                <i class="fas fa-chalkboard"></i>
                <span>Mis Clases Asignadas</span>
            </div>
            <div style="overflow-x:auto;">
                @if(!empty($misClases))
                <table class="pd-tbl">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Grado</th>
                            <th style="text-align:center;">Sección</th>
                            <th style="text-align:center;">Estudiantes</th>
                            <th>Horario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($misClases as $clase)
                        <tr>
                            <td style="font-weight:600;color:#0f172a;">
                                <i class="fas fa-book-open" style="color:#4ec7d2;margin-right:.4rem;font-size:.8rem;"></i>
                                {{ $clase['nombre'] }}
                            </td>
                            <td>{{ $clase['grado'] }}</td>
                            <td style="text-align:center;">
                                <span class="bpill b-teal">{{ $clase['seccion'] }}</span>
                            </td>
                            <td style="text-align:center;">
                                <span class="bpill b-blue">
                                    <i class="fas fa-users"></i> {{ $clase['estudiantes'] }}
                                </span>
                            </td>
                            <td style="color:#64748b;font-size:.77rem;">
                                <i class="fas fa-clock" style="color:#4ec7d2;margin-right:.3rem;"></i>
                                {{ $clase['horario'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="pd-empty">
                    <i class="fas fa-chalkboard"></i>
                    <p>No hay clases asignadas</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Estudiantes Destacados --}}
        <div class="pd-card">
            <div class="pd-card-head">
                <i class="fas fa-star"></i>
                <span>Estudiantes Activos</span>
            </div>
            <div class="pd-card-body">
                @forelse($estudiantesDestacados as $est)
                <div class="pd-est-item">
                    <div class="pd-est-avatar">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <div class="pd-est-name">
                            {{ $est->nombre1 }} {{ $est->apellido1 }}
                        </div>
                        <div class="pd-est-sub">
                            @isset($est->grado_numero)
                                {{ $est->grado_numero }}° {{ ucfirst($est->grado_nivel) }} — Sec. {{ $est->grado_seccion }}
                            @else
                                {{ $est->estado ?? 'Activo' }}
                            @endisset
                        </div>
                    </div>
                </div>
                @empty
                <div class="pd-empty">
                    <i class="fas fa-users"></i>
                    <p>No hay estudiantes registrados</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ── INFO BAR ── --}}
    <div class="pd-info-bar">
        <i class="fas fa-info-circle"></i>
        <div>
            <h6>Portal en Construcción</h6>
            <p>Las funcionalidades completas del portal de profesores estarán disponibles próximamente.</p>
        </div>
    </div>

</div>
@endsection
