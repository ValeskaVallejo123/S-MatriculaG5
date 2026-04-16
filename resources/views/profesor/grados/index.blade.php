@extends('layouts.app')

@section('title', 'Mis Cursos')
@section('page-title', 'Mis Cursos')
@section('content-class', 'p-0')

@push('styles')
<style>
.mc-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.mc-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.mc-hero-left { display: flex; align-items: center; gap: 1rem; }
.mc-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.mc-hero-icon i { font-size: 1.3rem; color: white; }
.mc-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.mc-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.mc-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.mc-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.mc-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

/* Body */
.mc-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Cards grid */
.mc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.2rem;
}
@media(max-width:580px) { .mc-grid { grid-template-columns: 1fr; } }

/* Card */
.mc-card {
    background: white; border-radius: 12px; overflow: hidden;
    border: 1px solid #e2e8f0; box-shadow: 0 2px 12px rgba(0,59,115,.07);
    transition: box-shadow .2s, transform .2s;
}
.mc-card:hover {
    box-shadow: 0 6px 24px rgba(0,80,143,.13);
    border-color: rgba(78,199,210,.5);
    transform: translateY(-2px);
}
.mc-card-top {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #0077b6 100%);
    padding: 1rem 1.1rem .85rem; position: relative; overflow: hidden;
}
.mc-card-top::after {
    content: ''; position: absolute; right: -20px; top: -20px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(78,199,210,.12); pointer-events: none;
}
.mc-card-nivel {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: rgba(78,199,210,.9); margin-bottom: .25rem;
}
.mc-card-grado { font-size: 1.2rem; font-weight: 800; color: white; line-height: 1.1; }
.mc-card-seccion {
    display: inline-flex; align-items: center; gap: .25rem; margin-top: .35rem;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 999px; padding: .15rem .55rem;
    font-size: .68rem; font-weight: 700; color: white;
}
.mc-card-body { padding: .9rem 1.1rem; }
.mc-materias-label {
    font-size: .63rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: #94a3b8; margin-bottom: .45rem;
}
.mc-materia-tag {
    display: inline-flex; align-items: center; gap: .25rem;
    background: rgba(78,199,210,.1); border: 1px solid rgba(78,199,210,.3);
    border-radius: 999px; padding: .2rem .65rem;
    font-size: .7rem; font-weight: 600; color: #003b73;
    margin: .15rem .15rem 0 0;
}
.mc-materia-tag i { color: #4ec7d2; font-size: .6rem; }
.mc-card-footer {
    border-top: 1px solid #e2e8f0; padding: .6rem 1.1rem;
    display: flex; align-items: center; justify-content: space-between;
    background: #f9fbfd;
}
.mc-est-count {
    display: flex; align-items: center; gap: .35rem;
    font-size: .75rem; font-weight: 700; color: #003b73;
}
.mc-est-count i { color: #4ec7d2; }
.mc-ver-btn {
    display: inline-flex; align-items: center; gap: .3rem;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; padding: .3rem .85rem; border-radius: 6px;
    font-size: .72rem; font-weight: 700; text-decoration: none; transition: opacity .15s;
}
.mc-ver-btn:hover { opacity: .88; color: white; }

/* Empty */
.mc-empty { text-align: center; padding: 3.5rem 1rem; color: #94a3b8; }
.mc-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.mc-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0 0 .25rem; }
.mc-empty small { font-size: .8rem; }

/* Dark mode */
body.dark-mode .mc-wrap { background: #0f172a; }
body.dark-mode .mc-card { background: #1e293b; border-color: #334155; }
body.dark-mode .mc-card-body { background: #1e293b; }
body.dark-mode .mc-card-footer { background: #1e293b; border-color: #334155; }
body.dark-mode .mc-materia-tag { background: rgba(78,199,210,.08); color: #cbd5e1; }
body.dark-mode .mc-est-count { color: #cbd5e1; }
</style>
@endpush

@section('content')
<div class="mc-wrap">

    {{-- Hero --}}
    <div class="mc-hero">
        <div class="mc-hero-left">
            <div class="mc-hero-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <h2 class="mc-hero-title">Mis Cursos</h2>
                <p class="mc-hero-sub">
                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                    — Año {{ now()->format('Y') }}
                </p>
            </div>
        </div>
        @if(!$gradosAgrupados->isEmpty())
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <div class="mc-stat">
                    <div class="mc-stat-num">{{ $totalCursos }}</div>
                    <div class="mc-stat-lbl">Cursos</div>
                </div>
                <div class="mc-stat">
                    <div class="mc-stat-num">{{ $totalMaterias }}</div>
                    <div class="mc-stat-lbl">Materias</div>
                </div>
                <div class="mc-stat">
                    <div class="mc-stat-num">{{ $totalEstudiantes }}</div>
                    <div class="mc-stat-lbl">Estudiantes</div>
                </div>
            </div>
        @endif
    </div>

    {{-- Body --}}
    <div class="mc-body">
        @if($gradosAgrupados->isEmpty())
            <div class="mc-empty">
                <i class="fas fa-chalkboard"></i>
                <p>No tienes cursos asignados</p>
                <small>Cuando el administrador te asigne grados y materias, aparecerán aquí.</small>
            </div>
        @else
            <div class="mc-grid">
                @foreach($gradosAgrupados as $gradoId => $materias)
                    @php $grado = $materias->first(); @endphp
                    <div class="mc-card">
                        <div class="mc-card-top">
                            <div class="mc-card-nivel">{{ $grado->nivel }}</div>
                            <div class="mc-card-grado">{{ $grado->numero }}° Grado</div>
                            <span class="mc-card-seccion">
                                <i class="fas fa-layer-group" style="font-size:.55rem;"></i>
                                Sección {{ $grado->seccion }}
                            </span>
                        </div>
                        <div class="mc-card-body">
                            <div class="mc-materias-label">
                                <i class="fas fa-book" style="color:#4ec7d2;"></i>
                                Materias que imparto
                            </div>
                            @foreach($materias as $m)
                                <span class="mc-materia-tag">
                                    <i class="fas fa-circle"></i>
                                    {{ $m->materia_nombre }}
                                </span>
                            @endforeach
                        </div>
                        <div class="mc-card-footer">
                            <span class="mc-est-count">
                                <i class="fas fa-users"></i>
                                {{ $grado->total_estudiantes }} estudiantes
                            </span>
                            <a href="{{ route('profesor.mis-estudiantes', ['grado' => $grado->numero, 'seccion' => $grado->seccion]) }}"
                               class="mc-ver-btn">
                                <i class="fas fa-eye"></i> Ver estudiantes
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
