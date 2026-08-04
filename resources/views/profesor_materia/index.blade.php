@extends('layouts.app')

@section('title', 'Asignación Maestros')
@section('page-title', 'Asignación de Maestros')

@section('topbar-actions')
    <a href="{{ route('profesor_materia_grado.create') }}" class="pm-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="pm-btn-text">Nueva Asignación</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .pm-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .pm-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width:600px) {
        .pm-btn-text { display: none; }
        .pm-topbar-btn { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark:  #003b73; --blue-mid: #00508f;
        --teal:       #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border:     #e8edf4; --surface: #f5f8fc;
        --text-main:  #0d2137; --text-muted: #6b7a90;
        --green:      #10b981; --radius-lg: 14px; --radius-sm: 7px;
        --shadow-sm:  0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:  0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .pm-stats {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .pm-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .pm-stats { grid-template-columns: 1fr; } }

    .pm-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .pm-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .ps-prof::before   { background: var(--teal); }
    .ps-asign::before  { background: var(--green); }
    .ps-grupos::before { background: #818cf8; }
    .pm-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .pm-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .ps-prof   .pm-stat-icon { background: var(--teal-light);      color: var(--teal); }
    .ps-asign  .pm-stat-icon { background: rgba(16,185,129,.12);    color: var(--green); }
    .ps-grupos .pm-stat-icon { background: rgba(129,140,248,.15);   color: #4f46e5; }

    .pm-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .pm-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .pm-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .pm-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .pm-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .pm-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .pm-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s; font-family: inherit; color: var(--text-main);
    }
    .pm-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .pm-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .pm-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

    /* ── Tabla card ── */
    .pm-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .pm-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .pm-card-head i    { color: var(--teal); font-size: 1rem; }
    .pm-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    .pm-tbl { width: 100%; border-collapse: collapse; }
    .pm-tbl thead th {
        background: var(--surface); padding: .65rem 1rem;
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .pm-tbl thead th.tc { text-align: center; }
    .pm-tbl thead th.tr { text-align: right; }
    .pm-tbl tbody td { padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .84rem; color: var(--text-main); vertical-align: middle; }
    .pm-tbl tbody td.tc { text-align: center; }
    .pm-tbl tbody td.tr { text-align: right; }
    .pm-tbl tbody tr:last-child td { border-bottom: none; }
    .pm-tbl tbody tr { transition: background .15s; }
    .pm-tbl tbody tr:hover { background: #f7fbff; }
    .pm-tbl tbody tr.hidden { display: none; }

    .pm-av {
        width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: inline-flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: .9rem;
        border: 2px solid rgba(78,199,210,.3);
    }
    .pm-name { font-weight: 600; color: var(--blue-dark); font-size: .88rem; }
    .pm-sub  { font-size: .73rem; color: var(--text-muted); margin-top: .1rem; }

    /* Chips */
    .grado-chip {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .2rem .55rem; border-radius: 6px; font-size: .7rem; font-weight: 600;
        background: rgba(0,80,143,.06); color: var(--blue-dark);
        border: 1px solid rgba(0,80,143,.15); margin: .1rem;
    }
    .grado-chip i { font-size: .6rem; color: var(--teal); }

    .materia-chip {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .2rem .55rem; border-radius: 6px; font-size: .7rem; font-weight: 600;
        background: var(--teal-light); color: var(--blue-mid);
        border: 1px solid rgba(78,199,210,.25); margin: .1rem;
    }
    .materia-chip i { font-size: .6rem; }

    .count-badge {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; border-radius: 7px; font-size: .78rem; font-weight: 700;
        background: var(--teal-light); color: var(--blue-mid);
        border: 1px solid rgba(78,199,210,.35);
    }

    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .78rem;
        background: white; cursor: pointer; transition: all .15s; text-decoration: none;
    }
    .act-edit  { border-color: var(--teal); color: var(--teal); }
    .act-del   { border-color: #ef4444;     color: #ef4444; }
    .act-edit:hover { background: var(--teal); color: white; transform: translateY(-1px); }
    .act-del:hover  { background: #ef4444;     color: white; transform: translateY(-1px); }

    .pm-empty { padding: 4rem 1rem; text-align: center; }
    .pm-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .pm-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .pm-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    .pm-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    }
    .pm-footer-info { font-size: .78rem; color: var(--text-muted); }

    .pagination { margin: 0; }
    .pagination .page-link {
        border-radius: 7px; margin: 0 2px; border: 1.5px solid var(--border);
        color: var(--blue-mid); padding: .28rem .6rem; font-size: .82rem; transition: all .15s;
    }
    .pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); color: var(--blue-dark); }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        border-color: var(--teal); color: white; box-shadow: 0 2px 6px rgba(78,199,210,.35);
    }

    .no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }

    @media(max-width:768px) {
        .pm-toolbar { flex-direction: column; align-items: stretch; gap: .75rem; }
        .pm-tbl thead th:nth-child(2), .pm-tbl tbody td:nth-child(2) { display: none; }
        .pm-footer { flex-direction: column; align-items: center; gap: .75rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="pm-stats">
        <div class="pm-stat ps-prof">
            <div class="pm-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="pm-stat-lbl">Profesores</div>
                <div class="pm-stat-num">{{ $totalProfesores }}</div>
                <div class="pm-stat-sub">Con asignaciones</div>
            </div>
        </div>
        <div class="pm-stat ps-asign">
            <div class="pm-stat-icon"><i class="fas fa-list-alt"></i></div>
            <div>
                <div class="pm-stat-lbl">Total Asignaciones</div>
                <div class="pm-stat-num">{{ $totalAsignaciones }}</div>
                <div class="pm-stat-sub">Registradas</div>
            </div>
        </div>
        <div class="pm-stat ps-grupos">
            <div class="pm-stat-icon"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="pm-stat-lbl">Grupos</div>
                <div class="pm-stat-num">{{ $asignaciones->count() }}</div>
                <div class="pm-stat-sub">En esta página</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="pm-toolbar">
        <div class="pm-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="pm-search"
                   placeholder="Buscar por nombre de profesor o materia...">
        </div>
        <div class="pm-badge-info">
            <span>
                <i class="fas fa-chalkboard-teacher" style="color:var(--blue-mid);"></i>
                <strong id="visibleCount" style="color:var(--blue-mid);">{{ $asignaciones->count() }}</strong>
                <span style="color:var(--text-muted);">Visible</span>
            </span>
        </div>
    </div>

    {{-- ── TABLA ── --}}
    <div class="pm-card">
        <div class="pm-card-head">
            <i class="fas fa-user-tag"></i>
            <span>Asignaciones Profesor — Materia</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="pm-tbl" id="profesorMateriaTable">
                <thead>
                    <tr>
                        <th style="width:50px;"></th>
                        <th>Profesor</th>
                        <th>Grados</th>
                        <th>Materias Asignadas</th>
                        <th class="tc">Total</th>
                        <th class="tr">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($asignaciones as $asignacion)
                    @php
                        $nombreProfesor = ($asignacion->profesor->nombre ?? '') . ' ' . ($asignacion->profesor->apellido ?? '');
                        $materiasNombres = $asignacion->materiasGrupos->map(fn($mg) => $mg->materia->nombre ?? '')->implode(' ');
                    @endphp
                    <tr class="pm-row"
                        data-search="{{ strtolower($nombreProfesor . ' ' . $materiasNombres) }}">

                        <td>
                            <div class="pm-av">
                                {{ strtoupper(substr($asignacion->profesor->nombre ?? 'P', 0, 1)) }}
                            </div>
                        </td>

                        <td>
                            <div class="pm-name">{{ $nombreProfesor }}</div>
                            @if($asignacion->profesor->especialidad ?? false)
                                <div class="pm-sub">{{ $asignacion->profesor->especialidad }}</div>
                            @endif
                        </td>

                        <td>
                            @php
                                $gradosUnicos = $asignacion->materiasGrupos
                                    ->map(fn($mg) => $mg->grado->numero . '° ' . ucfirst($mg->grado->nivel ?? '') . ' — Sec. ' . $mg->seccion)
                                    ->unique();
                            @endphp
                            @if($gradosUnicos->isNotEmpty())
                                <div style="display:flex;flex-wrap:wrap;">
                                    @foreach($gradosUnicos->take(3) as $g)
                                        <span class="grado-chip">
                                            <i class="fas fa-layer-group"></i> {{ $g }}
                                        </span>
                                    @endforeach
                                    @if($gradosUnicos->count() > 3)
                                        <span class="grado-chip" style="background:#f1f5f9;color:#64748b;">
                                            +{{ $gradosUnicos->count() - 3 }} más
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>

                        <td>
                            @if($asignacion->materiasGrupos->isNotEmpty())
                                <div style="display:flex;flex-wrap:wrap;">
                                    @foreach($asignacion->materiasGrupos->take(4) as $mg)
                                        <span class="materia-chip">
                                            <i class="fas fa-book"></i> {{ $mg->materia->nombre ?? '—' }}
                                        </span>
                                    @endforeach
                                    @if($asignacion->materiasGrupos->count() > 4)
                                        <span class="materia-chip" style="background:#f1f5f9;color:#64748b;border-color:#e2e8f0;">
                                            +{{ $asignacion->materiasGrupos->count() - 4 }} más
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;font-style:italic;">Sin materias</span>
                            @endif
                        </td>

                        <td class="tc">
                            <span class="count-badge">{{ $asignacion->materiasGrupos->count() }}</span>
                        </td>

                        <td class="tr">
                            <div style="display:inline-flex;gap:.35rem;">
                                <a href="{{ route('profesor_materia_grado.edit', $asignacion->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                               <button type="button"
        class="act-btn act-del" title="Eliminar"
        onclick="mostrarModalDelete(
            '{{ route('profesor_materia_grado.destroy', $asignacion->id) }}',
            '{{ addslashes(trim($nombreProfesor)) }}'
        )">
    <i class="fas fa-trash"></i>
</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="pm-empty">
                                <i class="fas fa-user-tag"></i>
                                <h6>No hay asignaciones registradas</h6>
                                <p>Comienza asignando materias a los profesores</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($asignaciones, 'hasPages') && $asignaciones->hasPages())
            <div class="pm-footer">
                <span class="pm-footer-info">
                    Mostrando {{ $asignaciones->firstItem() }}–{{ $asignaciones->lastItem() }}
                    de {{ $asignaciones->total() }} asignaciones
                </span>
                {{ $asignaciones->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input        = document.getElementById('searchInput');
    const tbody        = document.getElementById('tableBody');
    const visibleCount = document.getElementById('visibleCount');

    if (!input || !tbody) return;

    input.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        const noRow = tbody.querySelector('.no-results-row');
        if (noRow) noRow.remove();

        let visible = 0;
        tbody.querySelectorAll('.pm-row').forEach(function (row) {
            const texto = row.dataset.search || row.textContent.toLowerCase();
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
    });
});
</script>
@endpush