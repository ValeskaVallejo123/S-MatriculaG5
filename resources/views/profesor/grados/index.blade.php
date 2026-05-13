@extends('layouts.app')

@section('title', 'Mis Cursos')
@section('page-title', 'Mis Cursos')

@push('styles')
<style>
:root {
    --blue:     #00508f;
    --blue-mid: #003b73;
    --teal:     #4ec7d2;
    --border:   #e8edf4;
    --muted:    #6b7a90;
    --r:        14px;
}

.mc-wrap { width: 100%; box-sizing: border-box; }

/* ── HEADER ── */
.mc-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 1.5rem 1.7rem;
    position: relative; overflow: hidden;
}
.mc-header::before {
    content: ''; position: absolute; right: -50px; top: -50px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.mc-header::after {
    content: ''; position: absolute; right: 100px; bottom: -45px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.mc-header-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.2rem; flex-wrap: wrap;
}
.mc-avatar {
    width: 64px; height: 64px; border-radius: 14px;
    border: 2.5px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(0,0,0,.2); flex-shrink: 0;
}
.mc-avatar i { color: white; font-size: 1.6rem; }
.mc-header h2 {
    font-size: 1.3rem; font-weight: 800; color: white;
    margin: 0 0 .4rem; text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.mc-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .65rem; border-radius: 999px;
    font-size: .71rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
    margin-right: .35rem;
}

/* ── BODY ── */
.mc-body {
    background: white;
    border: 1px solid var(--border);
    border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: 0 4px 16px rgba(0,59,115,.10);
    padding: 1.4rem 1.7rem;
    margin-bottom: 1.3rem;
}

/* ── STATS ROW ── */
.mc-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .85rem;
    margin-bottom: 1.5rem;
}
.mc-stat {
    background: #f5f8fc;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: .9rem 1rem;
    display: flex; align-items: center; gap: .75rem;
}
.mc-stat-icon {
    width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, rgba(78,199,210,.18), rgba(0,80,143,.10));
    border: 1px solid rgba(78,199,210,.25);
}
.mc-stat-icon i { color: var(--blue); font-size: .9rem; }
.mc-stat-val {
    font-size: 1.35rem; font-weight: 800; color: var(--blue-mid); line-height: 1;
}
.mc-stat-lbl {
    font-size: .68rem; color: var(--muted); font-weight: 600;
    text-transform: uppercase; letter-spacing: .05em; margin-top: .15rem;
}

/* ── SECTION TITLE ── */
.mc-sec {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue); margin-bottom: .95rem;
    padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.15);
}
.mc-sec i { color: var(--teal); }

/* ── GRID DE CURSOS ── */
.mc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

/* ── CURSO CARD ── */
.mc-card {
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s, border-color .2s;
    background: white;
}
.mc-card:hover {
    box-shadow: 0 6px 24px rgba(0,80,143,.13);
    border-color: rgba(78,199,210,.5);
    transform: translateY(-2px);
}
.mc-card-top {
    background: linear-gradient(135deg, #002d5a 0%, #00508f 60%, #0077b6 100%);
    padding: 1rem 1.1rem .85rem;
    position: relative; overflow: hidden;
}
.mc-card-top::after {
    content: ''; position: absolute; right: -20px; top: -20px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(78,199,210,.12); pointer-events: none;
}
.mc-card-nivel {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: rgba(78,199,210,.9);
    margin-bottom: .25rem;
}
.mc-card-grado {
    font-size: 1.2rem; font-weight: 800; color: white; line-height: 1.1;
}
.mc-card-seccion {
    display: inline-flex; align-items: center; gap: .25rem;
    margin-top: .35rem;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 999px;
    padding: .15rem .55rem;
    font-size: .68rem; font-weight: 700; color: white;
}
.mc-card-body { padding: .9rem 1.1rem; }
.mc-materias-label {
    font-size: .63rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--muted); margin-bottom: .45rem;
}
.mc-materia-tag {
    display: inline-flex; align-items: center; gap: .25rem;
    background: linear-gradient(135deg, rgba(78,199,210,.12), rgba(0,80,143,.07));
    border: 1px solid rgba(78,199,210,.3);
    border-radius: 999px;
    padding: .2rem .65rem;
    font-size: .7rem; font-weight: 600; color: var(--blue-mid);
    margin: .15rem .15rem 0 0;
}
.mc-materia-tag i { color: var(--teal); font-size: .6rem; }
.mc-card-footer {
    border-top: 1px solid var(--border);
    padding: .6rem 1.1rem;
    display: flex; align-items: center; justify-content: space-between;
    background: #f9fbfd;
}
.mc-ver-btn {
    display: inline-flex; align-items: center; gap: .3rem;
    background: linear-gradient(135deg, var(--teal), var(--blue));
    color: white; padding: .3rem .85rem; border-radius: 6px;
    font-size: .7rem; font-weight: 700; text-decoration: none;
    transition: opacity .15s;
}
.mc-ver-btn:hover { opacity: .88; color: white; text-decoration: none; }
.mc-estudiantes {
    display: flex; align-items: center; gap: .35rem;
    font-size: .72rem; font-weight: 700; color: var(--blue-mid);
}
.mc-estudiantes i { color: var(--teal); font-size: .75rem; }
.mc-anio {
    font-size: .65rem; color: var(--muted);
    display: flex; align-items: center; gap: .25rem;
}
.mc-anio i { color: rgba(78,199,210,.6); font-size: .6rem; }

/* ── EMPTY STATE ── */
.mc-empty {
    text-align: center; padding: 3.5rem 1rem; color: var(--muted);
}
.mc-empty i {
    font-size: 2.8rem; display: block;
    margin-bottom: .75rem; color: rgba(78,199,210,.35);
}
.mc-empty p  { font-size: .9rem; font-weight: 600; margin: 0 0 .25rem; }
.mc-empty small { font-size: .78rem; }

@media(max-width: 768px) {
    .mc-header  { padding: 1.2rem 1.1rem; }
    .mc-body    { padding: 1rem 1.1rem; }
    .mc-avatar  { width: 52px; height: 52px; }
    .mc-avatar i { font-size: 1.3rem; }
    .mc-header h2 { font-size: 1.1rem; }
    .mc-stats   { grid-template-columns: 1fr 1fr; }
}
@media(max-width: 480px) {
    .mc-stats { grid-template-columns: 1fr; }
    .mc-grid  { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="mc-wrap">

    {{-- HEADER --}}
    <div class="mc-header">
        <div class="mc-header-inner">
            <div class="mc-avatar">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <h2>Mis Cursos</h2>
                <span class="mc-badge">
                    <i class="fas fa-user-tie"></i>
                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                </span>
                <span class="mc-badge">
                    <i class="fas fa-calendar"></i> {{ now()->format('Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div class="mc-body">

        @if($gradosAgrupados->isEmpty())
            <div class="mc-empty">
                <i class="fas fa-chalkboard"></i>
                <p>No tienes cursos asignados</p>
                <small>Cuando el administrador te asigne grados y materias, aparecerán aquí.</small>
            </div>
        @else

            {{-- STATS --}}
            <div class="mc-stats">
                <div class="mc-stat">
                    <div class="mc-stat-icon"><i class="fas fa-chalkboard"></i></div>
                    <div>
                        <div class="mc-stat-val">{{ $totalCursos }}</div>
                        <div class="mc-stat-lbl">Cursos / Grados</div>
                    </div>
                </div>
                <div class="mc-stat">
                    <div class="mc-stat-icon"><i class="fas fa-book-open"></i></div>
                    <div>
                        <div class="mc-stat-val">{{ $totalMaterias }}</div>
                        <div class="mc-stat-lbl">Materias</div>
                    </div>
                </div>
                <div class="mc-stat">
                    <div class="mc-stat-icon"><i class="fas fa-user-graduate"></i></div>
                    <div>
                        <div class="mc-stat-val">{{ $totalEstudiantes }}</div>
                        <div class="mc-stat-lbl">Estudiantes</div>
                    </div>
                </div>
            </div>

            <div class="mc-sec">
                <i class="fas fa-th-large"></i> Grados Asignados
            </div>

            {{-- GRID --}}
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
                                <i class="fas fa-book" style="color:var(--teal);"></i>
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
                            <span class="mc-estudiantes">
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
</div>
@endsection
