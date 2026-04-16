@extends('layouts.app')

@section('title', 'Consulta de Estudiantes por Curso')
@section('page-title', 'Cursos y Estudiantes')
@section('content-class', 'p-0')

@push('styles')
<style>
.cec-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.cec-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.cec-hero-left { display: flex; align-items: center; gap: 1rem; }
.cec-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cec-hero-icon i { font-size: 1.3rem; color: white; }
.cec-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.cec-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.cec-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.cec-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.cec-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

/* Body */
.cec-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Cards grid */
.cec-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1rem;
}
@media(max-width:580px) { .cec-grid { grid-template-columns: 1fr 1fr; } }
@media(max-width:380px) { .cec-grid { grid-template-columns: 1fr; } }

/* Course card */
.cec-card {
    background: white; border-radius: 12px; overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
    transition: box-shadow .2s, transform .2s;
    display: flex; flex-direction: column;
}
.cec-card:hover {
    box-shadow: 0 6px 24px rgba(0,59,115,.13);
    transform: translateY(-2px);
}
.cec-card-header {
    background: #003b73;
    padding: .85rem 1rem;
}
.cec-card-grado {
    font-size: .95rem; font-weight: 700; color: white; margin: 0 0 .2rem;
    display: flex; align-items: center; gap: .4rem;
}
.cec-card-grado i { color: #4ec7d2; font-size: .8rem; }
.cec-card-seccion {
    font-size: .72rem; color: rgba(255,255,255,.65);
    padding-left: 1.2rem;
}
.cec-card-body {
    padding: .9rem 1rem;
    display: flex; align-items: center; justify-content: space-between;
    flex: 1;
}
.cec-est-count {
    display: inline-flex; align-items: center; gap: .35rem;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; padding: .25rem .7rem; border-radius: 999px;
    font-size: .75rem; font-weight: 700;
}
.cec-btn-ver {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .32rem .65rem; border-radius: 7px;
    border: 1.5px solid #00508f; color: #00508f; background: white;
    font-size: .75rem; font-weight: 600; text-decoration: none; transition: all .2s;
}
.cec-btn-ver:hover { background: #eff6ff; color: #00508f; }

/* Empty */
.cec-empty {
    grid-column: 1/-1; text-align: center; padding: 3.5rem 1rem; color: #94a3b8;
}
.cec-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.cec-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0; }

/* Dark mode */
body.dark-mode .cec-wrap  { background: #0f172a; }
body.dark-mode .cec-card  { background: #1e293b; border-color: #334155; }
body.dark-mode .cec-card-body { background: #1e293b; }
body.dark-mode .cec-btn-ver { background: #0f172a; color: #4ec7d2; border-color: #4ec7d2; }
</style>
@endpush

@section('content')
<div class="cec-wrap">

    {{-- Hero --}}
    <div class="cec-hero">
        <div class="cec-hero-left">
            <div class="cec-hero-icon"><i class="fas fa-school"></i></div>
            <div>
                <h2 class="cec-hero-title">Cursos y Estudiantes</h2>
                <p class="cec-hero-sub">Listado de cursos con sus estudiantes matriculados</p>
            </div>
        </div>
        <div class="cec-stat">
            <div class="cec-stat-num">{{ $cursos->count() }}</div>
            <div class="cec-stat-lbl">Cursos</div>
        </div>
    </div>

    {{-- Body --}}
    <div class="cec-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="cec-grid">
            @forelse($cursos as $curso)
                <div class="cec-card">
                    <div class="cec-card-header">
                        <div class="cec-card-grado">
                            <i class="fas fa-chalkboard"></i>
                            {{ $curso->grado }}
                        </div>
                        <div class="cec-card-seccion">
                            <i class="fas fa-layer-group" style="margin-right:.25rem;"></i>
                            Sección {{ $curso->seccion }}
                        </div>
                    </div>
                    <div class="cec-card-body">
                        <span class="cec-est-count">
                            <i class="fas fa-user-graduate" style="font-size:.65rem;"></i>
                            {{ $curso->total_estudiantes }} Est.
                        </span>
                        <a href="{{ route('consultaestudiantesxcurso.show', [$curso->grado, $curso->seccion]) }}"
                           class="cec-btn-ver">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </div>
                </div>
            @empty
                <div class="cec-empty">
                    <i class="fas fa-school"></i>
                    <p>No hay cursos registrados</p>
                    <small>No hay estudiantes con grado y sección asignados.</small>
                </div>
            @endforelse
        </div>

    </div>{{-- /cec-body --}}
</div>
@endsection
