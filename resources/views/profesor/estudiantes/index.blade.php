@extends('layouts.app')

@section('title', 'Mis Estudiantes')
@section('page-title', 'Mis Estudiantes')
@section('content-class', 'p-0')

@push('styles')
<style>
.me-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.me-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.me-hero-left { display: flex; align-items: center; gap: 1rem; }
.me-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.me-hero-icon i { font-size: 1.3rem; color: white; }
.me-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.me-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.me-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.me-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.me-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }
.me-back-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.me-back-btn:hover { background: #f0f4f8; color: #003b73; }

/* Body */
.me-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Table card */
.me-table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
    margin-top: 1rem;
}

/* Materias section */
.me-materias-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    padding: 1rem 1.25rem; margin-bottom: 1rem;
}
.me-materias-label {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: #64748b; margin-bottom: .5rem;
}
.me-materia-tag {
    display: inline-flex; align-items: center; gap: .25rem;
    background: rgba(78,199,210,.1); border: 1px solid rgba(78,199,210,.3);
    border-radius: 999px; padding: .2rem .65rem;
    font-size: .7rem; font-weight: 600; color: #003b73;
    margin: .15rem .15rem 0 0;
}
.me-materia-tag i { color: #4ec7d2; font-size: .6rem; }

/* Toolbar */
.me-toolbar {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    padding: .75rem 1rem;
}
.me-search-wrap { position: relative; }
.me-search {
    width: 100%; padding: .45rem 1rem .45rem 2.2rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #334155; background: white; outline: none;
    transition: border-color .2s;
}
.me-search:focus { border-color: #4ec7d2; }
.me-search-icon {
    position: absolute; left: .75rem; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .75rem; pointer-events: none;
}

/* Table */
.me-tbl thead th {
    background: #003b73; color: white; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem; border: none;
}
.me-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.me-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.me-tbl tbody td { padding: .72rem 1rem; vertical-align: middle; font-size: .84rem; color: #334155; }
.me-tbl tbody tr:last-child { border-bottom: none; }

/* Nombre con avatar */
.me-nombre {
    display: flex; align-items: center; gap: .5rem;
    font-weight: 700; color: #003b73;
}
.me-nombre-avatar {
    width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(78,199,210,.2), rgba(0,80,143,.12));
    border: 1px solid rgba(78,199,210,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; font-weight: 800; color: #003b73;
}
.me-dni {
    font-family: 'Courier New', monospace; font-size: .78rem;
    color: #64748b; background: #f5f8fc; border: 1px solid #e2e8f0;
    border-radius: 5px; padding: .1rem .4rem; display: inline-block;
}
.me-sexo {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .18rem .55rem; border-radius: 999px;
    font-size: .68rem; font-weight: 700;
}
.me-sexo.m { background: rgba(0,80,143,.08); color: #00508f; border: 1px solid rgba(0,80,143,.2); }
.me-sexo.f { background: rgba(78,199,210,.12); color: #0077b6; border: 1px solid rgba(78,199,210,.3); }

/* Stats row */
.me-stats-row {
    display: flex; gap: .75rem; flex-wrap: wrap; margin-bottom: 1rem;
}
.me-stat-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    padding: .75rem 1.1rem;
    display: flex; align-items: center; gap: .65rem;
    min-width: 140px;
}
.me-stat-icon {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(78,199,210,.18), rgba(0,80,143,.10));
    border: 1px solid rgba(78,199,210,.25);
    display: flex; align-items: center; justify-content: center;
}
.me-stat-icon i { color: #00508f; font-size: .85rem; }
.me-stat-val { font-size: 1.1rem; font-weight: 800; color: #003b73; line-height: 1; }
.me-stat-desc { font-size: .65rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-top: .1rem; }

/* Empty */
.me-empty { text-align: center; padding: 3.5rem 1rem; color: #94a3b8; }
.me-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.me-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0; }

/* Dark mode */
body.dark-mode .me-wrap { background: #0f172a; }
body.dark-mode .me-table-card,
body.dark-mode .me-materias-card,
body.dark-mode .me-toolbar,
body.dark-mode .me-stat-card { background: #1e293b; }
body.dark-mode .me-tbl tbody td { color: #cbd5e1; }
body.dark-mode .me-tbl tbody tr { border-color: #334155; }
body.dark-mode .me-nombre { color: #e2e8f0; }
body.dark-mode .me-materia-tag { background: rgba(78,199,210,.08); color: #cbd5e1; }
body.dark-mode .me-stat-val { color: #e2e8f0; }
body.dark-mode .me-search { background: #0f172a; border-color: #334155; color: #cbd5e1; }
</style>
@endpush

@section('content')
<div class="me-wrap">

    {{-- Hero --}}
    <div class="me-hero">
        <div class="me-hero-left">
            <div class="me-hero-icon"><i class="fas fa-users"></i></div>
            <div>
                <h2 class="me-hero-title">Mis Estudiantes</h2>
                <p class="me-hero-sub">
                    {{ $grado }}° Grado — Sección {{ $seccion }}
                    &nbsp;·&nbsp;
                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                </p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="me-stat">
                <div class="me-stat-num">{{ $estudiantes->count() }}</div>
                <div class="me-stat-lbl">Estudiantes</div>
            </div>
            <div class="me-stat">
                <div class="me-stat-num">{{ count($materias) }}</div>
                <div class="me-stat-lbl">Materias</div>
            </div>
            <a href="{{ route('profesor.mis-cursos') }}" class="me-back-btn">
                <i class="fas fa-arrow-left"></i> Mis Cursos
            </a>
        </div>
    </div>

    {{-- Body --}}
    <div class="me-body">

        {{-- Stats row --}}
        <div class="me-stats-row">
            <div class="me-stat-card">
                <div class="me-stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div>
                    <div class="me-stat-val">{{ $estudiantes->count() }}</div>
                    <div class="me-stat-desc">Total estudiantes</div>
                </div>
            </div>
            <div class="me-stat-card">
                <div class="me-stat-icon"><i class="fas fa-mars"></i></div>
                <div>
                    <div class="me-stat-val">{{ $estudiantes->where('sexo', 'masculino')->count() }}</div>
                    <div class="me-stat-desc">Masculino</div>
                </div>
            </div>
            <div class="me-stat-card">
                <div class="me-stat-icon"><i class="fas fa-venus"></i></div>
                <div>
                    <div class="me-stat-val">{{ $estudiantes->where('sexo', 'femenino')->count() }}</div>
                    <div class="me-stat-desc">Femenino</div>
                </div>
            </div>
        </div>

        {{-- Materias --}}
        @if(count($materias) > 0)
            <div class="me-materias-card">
                <div class="me-materias-label">
                    <i class="fas fa-book" style="color:#4ec7d2;margin-right:.3rem;"></i>
                    Materias que imparto en este grado
                </div>
                @foreach($materias as $materia)
                    <span class="me-materia-tag">
                        <i class="fas fa-circle"></i>
                        {{ $materia }}
                    </span>
                @endforeach
            </div>
        @endif

        @if($estudiantes->isEmpty())
            <div class="me-table-card">
                <div class="me-empty">
                    <i class="fas fa-user-slash"></i>
                    <p>No hay estudiantes activos en este grado</p>
                </div>
            </div>
        @else
            {{-- Search --}}
            <div class="me-toolbar">
                <div class="me-search-wrap">
                    <i class="fas fa-search me-search-icon"></i>
                    <input type="text" class="me-search" id="buscador"
                           placeholder="Buscar por nombre o DNI...">
                </div>
            </div>

            <div class="me-table-card">
                <div class="table-responsive">
                    <table class="table me-tbl mb-0" id="tablaEstudiantes">
                        <thead>
                            <tr>
                                <th style="width:50px;text-align:center;">#</th>
                                <th><i class="fas fa-user" style="color:#4ec7d2;margin-right:.3rem;"></i>Nombre Completo</th>
                                <th><i class="fas fa-id-card" style="color:#4ec7d2;margin-right:.3rem;"></i>DNI</th>
                                <th><i class="fas fa-venus-mars" style="color:#4ec7d2;margin-right:.3rem;"></i>Sexo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $i => $estudiante)
                                <tr>
                                    <td style="text-align:center;font-size:.78rem;color:#94a3b8;font-weight:700;">{{ $i + 1 }}</td>
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
                                            <span style="color:#94a3b8;font-size:.75rem;">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>{{-- /me-body --}}
</div>

@push('scripts')
<script>
document.getElementById('buscador').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tablaEstudiantes tbody tr').forEach(tr => {
        tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush
@endsection
