@extends('layouts.app')

@section('title', 'Asignación Profesor-Materia-Grado')
@section('page-title', 'Carga Docente Completa')

@section('topbar-actions')
    <a href="{{ route('profesor_materia_grado.create') }}"
       style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);color:white;
              padding:.6rem .75rem;border-radius:8px;text-decoration:none;font-weight:600;
              display:inline-flex;align-items:center;gap:.5rem;border:none;
              box-shadow:0 2px 8px rgba(78,199,210,0.3);font-size:0.83rem;">
        <i class="fas fa-plus"></i> Nueva Asignación
    </a>
@endsection

@push('styles')
<style>
:root {
    --blue-dark:   #003b73;
    --blue-mid:    #00508f;
    --teal:        #4ec7d2;
    --teal-light:  rgba(78,199,210,0.12);
    --border:      #e8edf4;
    --surface:     #f5f8fc;
    --text-main:   #0d2137;
    --text-muted:  #6b7a90;
    --radius-lg:   14px;
    --radius-sm:   7px;
    --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
    --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
}

.pmg-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
@media(max-width:768px){ .pmg-stats { grid-template-columns: 1fr; } }

.pmg-stat {
    background: white; border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    padding: 1.1rem 1.25rem;
    display: flex; align-items: center; gap: 1rem;
    box-shadow: var(--shadow-sm);
    transition: transform .2s, box-shadow .2s;
    position: relative; overflow: hidden;
}
.pmg-stat::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 4px; height: 100%; border-radius: 4px 0 0 4px;
}
.pmg-stat-1::before { background: var(--blue-mid); }
.pmg-stat-2::before { background: var(--teal); }
.pmg-stat-3::before { background: var(--blue-dark); }
.pmg-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

.pmg-stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.1rem;
}
.pmg-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
.pmg-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; }

.pmg-toolbar {
    background: white; border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: .9rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    box-shadow: var(--shadow-sm);
}
.pmg-search-wrap { position: relative; flex: 1; min-width: 220px; }
.pmg-search-wrap i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--blue-mid); font-size: .85rem; pointer-events: none;
}
.pmg-search {
    width: 100%; padding: .5rem 1rem .5rem 2.4rem;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: .85rem; background: var(--surface); outline: none;
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit; color: var(--text-main);
}
.pmg-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

.pmg-search-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: var(--radius-sm);
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    color: white; border: none; cursor: pointer; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(78,199,210,.3); transition: opacity .15s;
}
.pmg-search-btn:hover { opacity: .85; }

.pmg-count {
    display: flex; align-items: center; gap: .4rem;
    font-size: .82rem; flex-shrink: 0; margin-left: auto;
}

.pmg-card {
    background: white; border: 1px solid var(--border);
    border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);
}
.pmg-card-head {
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
    padding: .9rem 1.4rem; display: flex; align-items: center;
    justify-content: space-between;
}
.pmg-card-head-left { display: flex; align-items: center; gap: .6rem; }
.pmg-card-head i    { color: var(--teal); font-size: 1rem; }
.pmg-card-head span { color: white; font-weight: 700; font-size: .95rem; }
.pmg-card-count {
    color: white; font-size: .82rem; font-weight: 600;
    background: rgba(255,255,255,.15); padding: .25rem .75rem;
    border-radius: 999px; border: 1px solid rgba(255,255,255,.25);
}

.pmg-tbl { width: 100%; border-collapse: collapse; }
.pmg-tbl thead th {
    background: var(--surface); padding: .65rem 1rem;
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--text-muted);
    border-bottom: 1.5px solid var(--border); white-space: nowrap;
}
.pmg-tbl thead th.tc { text-align: center; }
.pmg-tbl tbody td {
    padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .84rem; color: var(--text-main); vertical-align: middle;
}
.pmg-tbl tbody td.tc { text-align: center; }
.pmg-tbl tbody tr:last-child td { border-bottom: none; }
.pmg-tbl tbody tr { transition: background .15s; }
.pmg-tbl tbody tr:hover { background: #f7fbff; }
.pmg-tbl tbody tr.hidden { display: none; }

.row-num {
    width: 26px; height: 26px; border-radius: 7px;
    background: var(--surface); border: 1px solid var(--border);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 700; color: var(--text-muted);
}

.prof-av {
    width: 36px; height: 36px; border-radius: 9px;
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    display: inline-flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: .85rem; flex-shrink: 0;
}
.prof-name { font-weight: 600; color: var(--blue-dark); font-size: .88rem; }

.chip { display: inline-flex; align-items: center; gap: .3rem; padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 600; white-space: nowrap; }
.chip-teal { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
.chip-blue { background: rgba(0,80,143,.08); color: var(--blue-dark); border: 1px solid rgba(0,80,143,.2); }

.act-btn {
    width: 30px; height: 30px; border-radius: 7px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid; font-size: .78rem;
    background: white; cursor: pointer;
    transition: all .15s; text-decoration: none;
}
.act-edit { border-color: var(--teal); color: var(--teal); }
.act-del  { border-color: #ef4444;    color: #ef4444; }
.act-edit:hover { background: var(--teal); color: white; transform: translateY(-1px); }
.act-del:hover  { background: #ef4444;    color: white; transform: translateY(-1px); }

.pmg-empty { padding: 4rem 1rem; text-align: center; }
.pmg-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
.pmg-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
.pmg-empty p  { font-size: .83rem; color: var(--text-muted); margin-bottom: 1.25rem; }

.no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }

@media(max-width:768px) {
    .pmg-toolbar { flex-direction: column; align-items: stretch; }
    .pmg-search-wrap { min-width: unset; }
    .pmg-count { margin-left: 0; }
    .pmg-tbl thead th, .pmg-tbl tbody td { padding: .55rem .65rem; font-size: .78rem; }
}
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="pmg-stats">
        <div class="pmg-stat pmg-stat-1">
            <div class="pmg-stat-icon" style="background:rgba(0,80,143,.1);">
                <i class="fas fa-chalkboard-teacher" style="color:var(--blue-mid);"></i>
            </div>
            <div>
                <div class="pmg-stat-lbl">Profesores Asignados</div>
                <div class="pmg-stat-num">{{ $totalProfesores }}</div>
            </div>
        </div>
        <div class="pmg-stat pmg-stat-2">
            <div class="pmg-stat-icon" style="background:var(--teal-light);">
                <i class="fas fa-list-alt" style="color:var(--teal);"></i>
            </div>
            <div>
                <div class="pmg-stat-lbl">Total Asignaciones</div>
                <div class="pmg-stat-num">{{ $totalAsignaciones }}</div>
            </div>
        </div>
        <div class="pmg-stat pmg-stat-3">
            <div class="pmg-stat-icon" style="background:rgba(0,59,115,.1);">
                <i class="fas fa-school" style="color:var(--blue-dark);"></i>
            </div>
            <div>
                <div class="pmg-stat-lbl">Grupos Cubiertos</div>
                <div class="pmg-stat-num">{{ $asignaciones->sum(fn($g) => $g->count()) }}</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="pmg-toolbar">
        <div class="pmg-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="pmg-search"
                   placeholder="Buscar profesor, materia o grado..."
                   autocomplete="off">
        </div>

        {{-- Botón lupa azul --}}
        <button type="button" id="searchBtn" class="pmg-search-btn" title="Buscar">
            <i class="fas fa-search" style="font-size:.85rem;"></i>
        </button>

        <div class="pmg-count">
            <i class="fas fa-list-ul" style="color:var(--blue-mid);"></i>
            <strong id="visibleCount" style="color:var(--blue-mid);">{{ $totalAsignaciones }}</strong>
            <span style="color:var(--text-muted);">asignaciones</span>
        </div>
    </div>

    {{-- ── TABLA ── --}}
    <div class="pmg-card">
        <div class="pmg-card-head">
            <div class="pmg-card-head-left">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Carga Docente Completa</span>
            </div>
            <span class="pmg-card-count">{{ $totalAsignaciones }} registros</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="pmg-tbl" id="pmgTable">
                <thead>
                    <tr>
                        <th class="tc" style="width:50px;">#</th>
                        <th>Profesor</th>
                        <th>Materia</th>
                        <th>Grado</th>
                        <th class="tc">Sección</th>
                        <th class="tc">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @php $i = 1; @endphp
                    @forelse($asignaciones as $profesorId => $items)
                        @foreach($items as $asignacion)
                        <tr class="pmg-row">
                            <td class="tc">
                                <span class="row-num">{{ $i++ }}</span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:.65rem;">
                                    <div class="prof-av">
                                        {{ strtoupper(substr($asignacion->profesor->nombre ?? 'P', 0, 1)) }}
                                    </div>
                                    <div class="prof-name">
                                        {{ $asignacion->profesor->nombre_completo
                                            ?? ($asignacion->profesor->nombre . ' ' . $asignacion->profesor->apellido) }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="chip chip-teal">
                                    <i class="fas fa-book" style="font-size:.65rem;"></i>
                                    {{ $asignacion->materia->nombre ?? '—' }}
                                </span>
                            </td>
                            <td style="color:var(--text-main);font-size:.84rem;">
                                {{ $asignacion->grado->nombre ?? '—' }}
                            </td>
                            <td class="tc">
                                <span class="chip chip-blue">
                                    {{ $asignacion->seccion }}
                                </span>
                            </td>
                            <td class="tc">
                                <div style="display:inline-flex;gap:.35rem;align-items:center;">
                                    <a href="{{ route('profesor_materia_grado.edit', $asignacion->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('profesor_materia_grado.destroy', $asignacion->id) }}"
                                          style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                                class="act-btn act-del" title="Eliminar"
                                                onclick="mostrarModalDelete(
                                                    '{{ route('profesor_materia_grado.destroy', $asignacion->id) }}',
                                                    '¿Estás seguro de eliminar esta asignación? Esta acción no se puede deshacer.',
                                                    '{{ addslashes(($asignacion->profesor->nombre ?? '') . ' — ' . ($asignacion->materia->nombre ?? '')) }}'
                                                )">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="pmg-empty">
                                <i class="fas fa-inbox"></i>
                                <h6>No hay asignaciones registradas</h6>
                                <p>Comienza creando la primera asignación profesor-materia-grado</p>
                                <a href="{{ route('profesor_materia_grado.create') }}"
                                   style="display:inline-flex;align-items:center;gap:.5rem;
                                          padding:.55rem 1.3rem;
                                          background:linear-gradient(135deg,#4ec7d2,#00508f);
                                          color:white;border-radius:9px;text-decoration:none;
                                          font-weight:600;font-size:.85rem;
                                          box-shadow:0 2px 8px rgba(78,199,210,.3);">
                                    <i class="fas fa-plus"></i> Nueva Asignación
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input        = document.getElementById('searchInput');
    const tbody        = document.getElementById('tableBody');
    const visibleCount = document.getElementById('visibleCount');
    const searchBtn    = document.getElementById('searchBtn');

    if (!input || !tbody) return;

    function filtrar() {
        const term = input.value.toLowerCase().trim();

        const noRow = tbody.querySelector('.no-results-row');
        if (noRow) noRow.remove();

        let visible = 0;

        tbody.querySelectorAll('.pmg-row').forEach(function (row) {
            const texto = row.textContent.toLowerCase();
            const match = term === '' || texto.includes(term);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        if (visibleCount) visibleCount.textContent = visible;

        if (visible === 0 && term !== '') {
            const tr = document.createElement('tr');
            tr.className = 'no-results-row';
            tr.innerHTML = `<td colspan="6" style="text-align:center;padding:3rem 1rem;">
                <i class="fas fa-search" style="font-size:1.75rem;color:#cbd5e1;display:block;margin-bottom:.75rem;"></i>
                <p style="color:#94a3b8;margin:0;font-size:.85rem;">
                    Sin resultados para <strong style="color:#0d2137;">"${term}"</strong>
                </p>
            </td>`;
            tbody.appendChild(tr);
        }
    }

    // Filtrar al escribir
    input.addEventListener('input', filtrar);

    // Botón lupa azul
    searchBtn.addEventListener('click', function () {
        filtrar();
        input.focus();
    });

    // Limpiar con Escape
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            this.value = '';
            filtrar();
        }
    });
});
</script>
@endpush