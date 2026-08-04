@extends('layouts.app')

@section('title', 'Estudiantes por Curso')
@section('page-title', 'Gestión de Cursos y Estudiantes')

@push('styles')
<style>
    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --radius-lg: 14px; --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .cur-stats {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .cur-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .cur-stats { grid-template-columns: 1fr; } }

    .cur-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .cur-stat::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px; }
    .cs-cursos::before    { background: var(--teal); }
    .cs-estudiantes::before{ background: #10b981; }
    .cs-secciones::before  { background: #818cf8; }
    .cur-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .cur-stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.15rem; }
    .cs-cursos     .cur-stat-icon { background: var(--teal-light);      color: var(--teal); }
    .cs-estudiantes .cur-stat-icon{ background: rgba(16,185,129,.12);    color: #10b981; }
    .cs-secciones  .cur-stat-icon { background: rgba(129,140,248,.15);   color: #4f46e5; }

    .cur-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .cur-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .cur-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar búsqueda ── */
    .cur-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .cur-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .cur-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .cur-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: 7px;
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s; font-family: inherit; color: var(--text-main);
    }
    .cur-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .cur-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .cur-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

    /* ── Grid de cards ── */
    .cur-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
    }
    @media(max-width:480px){ .cur-grid { grid-template-columns: 1fr 1fr; } }
    @media(max-width:360px){ .cur-grid { grid-template-columns: 1fr; } }

    /* ── Card de curso ── */
    .cur-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform .18s, box-shadow .18s;
        display: flex; flex-direction: column;
    }
    .cur-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

    .cur-card-header {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
        padding: .9rem 1.1rem;
        display: flex; align-items: center; gap: .75rem;
    }
    .cur-num-badge {
        width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 2px solid var(--teal);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: var(--teal); font-size: 1rem;
    }
    .cur-card-grado { font-weight: 700; color: white; font-size: .88rem; line-height: 1.2; }
    .cur-card-sec   { font-size: .72rem; color: rgba(255,255,255,.6); margin-top: .15rem; }

    .cur-card-body { padding: .85rem 1.1rem; flex: 1; }

    .cur-est-count {
        display: flex; align-items: center; justify-content: space-between;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 8px; padding: .5rem .75rem;
    }
    .cur-est-label { font-size: .7rem; font-weight: 600; color: var(--text-muted); display: flex; align-items: center; gap: .35rem; }
    .cur-est-label i { color: var(--teal); font-size: .65rem; }
    .cur-est-num { font-size: .95rem; font-weight: 800; color: var(--blue-dark); }

    .cur-card-footer {
        padding: .75rem 1.1rem; border-top: 1px solid #f1f5f9; background: var(--surface);
    }
    .btn-ver-curso {
        width: 100%; padding: .42rem; border-radius: 8px; border: none;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: white; font-size: .78rem; font-weight: 700;
        font-family: inherit; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        text-decoration: none; transition: opacity .15s;
    }
    .btn-ver-curso:hover { opacity: .88; color: white; }

    /* Empty */
    .cur-empty {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 4rem 1rem;
        text-align: center; box-shadow: var(--shadow-sm);
    }
    .cur-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .cur-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .cur-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    /* Sin resultados de búsqueda */
    .cur-no-results { display: none; }
    .cur-no-results.show { display: block; }
</style>
@endpush

@section('content')
<div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;color:#065f46;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#065f46;font-size:1.2rem;cursor:pointer;">&times;</button>
    </div>
    @endif

    {{-- ── STATS ── --}}
    @php
        $totalCursos     = count($cursos);
        $totalEstudiantes = $cursos->sum('total_estudiantes');
        $secciones        = $cursos->pluck('seccion')->unique()->count();
    @endphp
    <div class="cur-stats">
        <div class="cur-stat cs-cursos">
            <div class="cur-stat-icon"><i class="fas fa-chalkboard"></i></div>
            <div>
                <div class="cur-stat-lbl">Total Cursos</div>
                <div class="cur-stat-num">{{ $totalCursos }}</div>
                <div class="cur-stat-sub">Registrados</div>
            </div>
        </div>
        <div class="cur-stat cs-estudiantes">
            <div class="cur-stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div>
                <div class="cur-stat-lbl">Estudiantes</div>
                <div class="cur-stat-num">{{ $totalEstudiantes }}</div>
                <div class="cur-stat-sub">Matriculados</div>
            </div>
        </div>
        <div class="cur-stat cs-secciones">
            <div class="cur-stat-icon"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="cur-stat-lbl">Secciones</div>
                <div class="cur-stat-num">{{ $secciones }}</div>
                <div class="cur-stat-sub">Disponibles</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="cur-toolbar">
        <div class="cur-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="curSearch" class="cur-search"
                   placeholder="Buscar por grado o sección...">
        </div>
        <div class="cur-badge-info">
            <span>
                <i class="fas fa-chalkboard" style="color:var(--blue-mid);"></i>
                <strong id="visibleCount" style="color:var(--blue-mid);">{{ $totalCursos }}</strong>
                <span style="color:var(--text-muted);">Cursos</span>
            </span>
            <span>
                <i class="fas fa-user-graduate" style="color:#10b981;"></i>
                <strong style="color:#10b981;">{{ $totalEstudiantes }}</strong>
                <span style="color:var(--text-muted);">Alumnos</span>
            </span>
        </div>
    </div>

    {{-- ── GRID ── --}}
    @if($cursos->isNotEmpty())
        <div class="cur-grid" id="curGrid">
            @foreach($cursos as $curso)
            @php
                // Extraer número del grado para el badge (ej: "Primer Grado" → "1")
                $numMap = ['Primer'=>'1','Segundo'=>'2','Tercero'=>'3','Cuarto'=>'4',
                           'Quinto'=>'5','Sexto'=>'6','Séptimo'=>'7','Octavo'=>'8','Noveno'=>'9'];
                $numGrado = '?';
                foreach($numMap as $palabra => $num) {
                    if(str_starts_with($curso->grado, $palabra)) { $numGrado = $num; break; }
                }
            @endphp
            <div class="cur-card"
                 data-search="{{ strtolower($curso->grado . ' ' . $curso->seccion) }}">

                <div class="cur-card-header">
                    <div class="cur-num-badge">{{ $numGrado }}</div>
                    <div>
                        <div class="cur-card-grado">{{ $curso->grado }}</div>
                        <div class="cur-card-sec">Sección {{ $curso->seccion }}</div>
                    </div>
                </div>

                <div class="cur-card-body">
                    <div class="cur-est-count">
                        <span class="cur-est-label">
                            <i class="fas fa-user-graduate"></i> Estudiantes
                        </span>
                        <span class="cur-est-num">{{ $curso->total_estudiantes }}</span>
                    </div>
                </div>

                <div class="cur-card-footer">
                    <a href="{{ route('consultaestudiantesxcurso.show', [$curso->grado, $curso->seccion]) }}"
                       class="btn-ver-curso">
                        <i class="fas fa-eye"></i> Ver Lista
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Sin resultados de búsqueda --}}
        <div class="cur-no-results cur-empty" id="noResults">
            <i class="fas fa-search"></i>
            <h6>Sin resultados</h6>
            <p>No se encontraron cursos que coincidan con tu búsqueda</p>
        </div>

    @else
        <div class="cur-empty">
            <i class="fas fa-school"></i>
            <h6>No hay cursos registrados</h6>
            <p>No hay estudiantes con grado y sección asignados.</p>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input        = document.getElementById('curSearch');
    const grid         = document.getElementById('curGrid');
    const noResults    = document.getElementById('noResults');
    const visibleCount = document.getElementById('visibleCount');
    if (!input || !grid) return;

    input.addEventListener('input', function () {
        const term  = this.value.toLowerCase().trim();
        const cards = grid.querySelectorAll('.cur-card');
        let visible = 0;

        cards.forEach(function (card) {
            const match = !term || card.dataset.search.includes(term);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        if (visibleCount) visibleCount.textContent = visible;
        if (noResults) noResults.classList.toggle('show', visible === 0 && term !== '');
    });
});
</script>
@endpush