@extends('layouts.app')

@section('title', 'Mis Estudiantes')
@section('page-title', 'Mis Estudiantes')

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

.me-wrap { width: 100%; box-sizing: border-box; }

/* ── HEADER ── */
.me-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 1.7rem;
    position: relative; overflow: hidden;
}
.me-header::before {
    content: ''; position: absolute; right: -50px; top: -50px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.me-header::after {
    content: ''; position: absolute; right: 100px; bottom: -45px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.me-header-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap;
}
.me-avatar {
    width: 80px; height: 80px; border-radius: 18px;
    border: 3px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(0,0,0,.25); flex-shrink: 0;
}
.me-avatar i { color: white; font-size: 2rem; }
.me-header h2 {
    font-size: 1.45rem; font-weight: 800; color: white;
    margin: 0 0 .5rem; text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.me-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
    margin-right: .4rem;
}

/* ── BODY ── */
.me-body {
    background: white;
    border: 1px solid var(--border);
    border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: 0 4px 16px rgba(0,59,115,.10);
    padding: 1.4rem 1.7rem;
    margin-bottom: 1.3rem;
}

/* ── BACK BTN ── */
.me-back {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .75rem; font-weight: 700; color: var(--muted);
    text-decoration: none; margin-bottom: 1.2rem;
    transition: color .15s;
}
.me-back:hover { color: var(--blue); text-decoration: none; }
.me-back i { font-size: .7rem; }

/* ── STATS ── */
.me-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .85rem;
    margin-bottom: 1.5rem;
}
.me-stat {
    background: #f5f8fc;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: .9rem 1rem;
    display: flex; align-items: center; gap: .75rem;
}
.me-stat-icon {
    width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, rgba(78,199,210,.18), rgba(0,80,143,.10));
    border: 1px solid rgba(78,199,210,.25);
}
.me-stat-icon i { color: var(--blue); font-size: .9rem; }
.me-stat-val  { font-size: 1.35rem; font-weight: 800; color: var(--blue-mid); line-height: 1; }
.me-stat-lbl  { font-size: .68rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-top: .15rem; }

/* ── SECTION TITLE ── */
.me-sec {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue); margin-bottom: .95rem;
    padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.15);
}
.me-sec i { color: var(--teal); }

/* ── SEARCH ── */
.me-search-wrap {
    position: relative; margin-bottom: 1rem;
}
.me-search {
    width: 100%; padding: .6rem 1rem .6rem 2.4rem;
    border: 1px solid var(--border); border-radius: 8px;
    font-size: .82rem; color: var(--blue-mid);
    background: #f9fbfd; outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.me-search:focus {
    border-color: rgba(78,199,210,.5);
    box-shadow: 0 0 0 3px rgba(78,199,210,.1);
    background: white;
}
.me-search-icon {
    position: absolute; left: .8rem; top: 50%; transform: translateY(-50%);
    color: var(--muted); font-size: .75rem; pointer-events: none;
}

/* ── TABLE ── */
.me-table-wrap { overflow-x: auto; }
.me-table { width: 100%; border-collapse: collapse; }
.me-table thead th {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--muted); background: #f5f8fc;
    padding: .75rem .85rem;
    border: 1px solid var(--border);
    text-align: left; white-space: nowrap;
}
.me-table thead th:first-child {
    background: linear-gradient(135deg, rgba(0,80,143,.08), rgba(78,199,210,.08));
    color: var(--blue-mid); width: 50px; text-align: center;
}
.me-table tbody tr {
    transition: background .15s;
}
.me-table tbody tr:hover td { background: #f0f7ff; }
.me-table tbody td {
    border: 1px solid var(--border);
    padding: .7rem .85rem;
    vertical-align: middle;
    font-size: .82rem; color: var(--blue-mid);
}
.me-table tbody td:first-child {
    text-align: center; font-size: .7rem;
    font-weight: 700; color: var(--muted);
    background: #f9fbfd;
}

/* nombre */
.me-nombre {
    font-weight: 700; color: var(--blue-mid);
    display: flex; align-items: center; gap: .5rem;
}
.me-nombre-avatar {
    width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(78,199,210,.2), rgba(0,80,143,.12));
    border: 1px solid rgba(78,199,210,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 800; color: var(--blue);
}

/* dni */
.me-dni {
    font-family: 'Courier New', monospace;
    font-size: .78rem; color: var(--muted);
    background: #f5f8fc; border: 1px solid var(--border);
    border-radius: 5px; padding: .15rem .45rem;
    display: inline-block;
}

/* sexo badge */
.me-sexo {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .18rem .55rem; border-radius: 999px;
    font-size: .65rem; font-weight: 700;
}
.me-sexo.m { background: rgba(0,80,143,.08); color: var(--blue); border: 1px solid rgba(0,80,143,.2); }
.me-sexo.f { background: rgba(78,199,210,.12); color: #0077b6; border: 1px solid rgba(78,199,210,.3); }

/* empty */
.me-empty {
    text-align: center; padding: 3rem 1rem; color: var(--muted);
}
.me-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: rgba(78,199,210,.35); }
.me-empty p  { font-size: .9rem; font-weight: 600; margin: 0 0 .25rem; }

/* materias tags */
.me-materia-tag {
    display: inline-flex; align-items: center; gap: .25rem;
    background: linear-gradient(135deg, rgba(78,199,210,.12), rgba(0,80,143,.07));
    border: 1px solid rgba(78,199,210,.3);
    border-radius: 999px;
    padding: .2rem .65rem;
    font-size: .7rem; font-weight: 600; color: var(--blue-mid);
    margin: .15rem .15rem 0 0;
}

@media(max-width: 768px) {
    .me-header { padding: 1.4rem 1.1rem; }
    .me-body   { padding: 1rem 1.1rem; }
    .me-avatar { width: 60px; height: 60px; }
    .me-avatar i { font-size: 1.5rem; }
    .me-header h2 { font-size: 1.1rem; }
    .me-stats { grid-template-columns: 1fr 1fr; }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="me-wrap">

    {{-- ── HEADER ── --}}
    <div class="me-header">
        <div class="me-header-inner">
            <div class="me-avatar">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h2>Mis Estudiantes</h2>
                <span class="me-badge">
                    <i class="fas fa-graduation-cap"></i>
                    {{ $grado }}° Grado — Sección {{ $seccion }}
                </span>
                <span class="me-badge">
                    <i class="fas fa-user-tie"></i>
                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                </span>
                <span class="me-badge">
                    <i class="fas fa-calendar"></i> {{ now()->format('Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="me-body">

        {{-- Volver --}}
        <a href="{{ route('profesor.mis-cursos') }}" class="me-back">
            <i class="fas fa-arrow-left"></i> Volver a Mis Cursos
        </a>

        {{-- Stats --}}
        <div class="me-stats">
            <div class="me-stat">
                <div class="me-stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div>
                    <div class="me-stat-val">{{ $estudiantes->count() }}</div>
                    <div class="me-stat-lbl">Estudiantes</div>
                </div>
            </div>
            <div class="me-stat">
                <div class="me-stat-icon"><i class="fas fa-venus-mars"></i></div>
                <div>
                    <div class="me-stat-val">
                        {{ $estudiantes->where('sexo', 'masculino')->count() }}M /
                        {{ $estudiantes->where('sexo', 'femenino')->count() }}F
                    </div>
                    <div class="me-stat-lbl">Por sexo</div>
                </div>
            </div>
            <div class="me-stat">
                <div class="me-stat-icon"><i class="fas fa-book-open"></i></div>
                <div>
                    <div class="me-stat-val">{{ count($materias) }}</div>
                    <div class="me-stat-lbl">Materias que imparto</div>
                </div>
            </div>
        </div>

        {{-- Materias que imparte --}}
        @if(count($materias) > 0)
            <div style="margin-bottom:1.2rem;">
                <div class="me-sec" style="margin-bottom:.6rem;">
                    <i class="fas fa-book"></i> Materias que imparto en este grado
                </div>
                @foreach($materias as $materia)
                    <span class="me-materia-tag">
                        <i class="fas fa-circle" style="font-size:.45rem;color:var(--teal);"></i>
                        {{ $materia }}
                    </span>
                @endforeach
            </div>
        @endif

        <div class="me-sec">
            <i class="fas fa-list"></i> Lista de Estudiantes
        </div>

        @if($estudiantes->isEmpty())
            <div class="me-empty">
                <i class="fas fa-user-slash"></i>
                <p>No hay estudiantes activos en este grado</p>
            </div>
        @else
            {{-- Buscador --}}
            <div class="me-search-wrap">
                <i class="fas fa-search me-search-icon"></i>
                <input type="text" class="me-search" id="buscador"
                    placeholder="Buscar por nombre o DNI...">
            </div>

            <div class="me-table-wrap">
                <table class="me-table" id="tablaEstudiantes">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-user" style="color:var(--teal);margin-right:.3rem;"></i>Nombre Completo</th>
                            <th><i class="fas fa-id-card" style="color:var(--teal);margin-right:.3rem;"></i>DNI</th>
                            <th><i class="fas fa-venus-mars" style="color:var(--teal);margin-right:.3rem;"></i>Sexo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $i => $estudiante)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <div class="me-nombre">
                                        <div class="me-nombre-avatar">
                                            {{ strtoupper(substr($estudiante->nombre1, 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1, 0, 1)) }}
                                        </div>
                                        {{ $estudiante->nombre1 }}
                                        {{ $estudiante->nombre2 }}
                                        {{ $estudiante->apellido1 }}
                                        {{ $estudiante->apellido2 }}
                                    </div>
                                </td>
                                <td>
                                    <span class="me-dni">{{ $estudiante->dni }}</span>
                                </td>
                                <td>
                                    @if($estudiante->sexo === 'masculino')
                                        <span class="me-sexo m">
                                            <i class="fas fa-mars" style="font-size:.6rem;"></i> Masculino
                                        </span>
                                    @elseif($estudiante->sexo === 'femenino')
                                        <span class="me-sexo f">
                                            <i class="fas fa-venus" style="font-size:.6rem;"></i> Femenino
                                        </span>
                                    @else
                                        <span style="color:var(--muted);font-size:.75rem;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>
</div>

<script>
document.getElementById('buscador').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tablaEstudiantes tbody tr').forEach(tr => {
        tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection
