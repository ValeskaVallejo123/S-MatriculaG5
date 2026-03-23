@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
<div style="display:flex;gap:.5rem;flex-wrap:wrap;">
    <a href="{{ route('estudiantes.create') }}"
       style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);color:white;padding:.6rem .75rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.5rem;border:none;box-shadow:0 2px 8px rgba(78,199,210,0.3);font-size:0.83rem;">
        <i class="fas fa-plus"></i> Agregar Nuevo Estudiante
    </a>
</div>
@endsection

@push('styles')
<style>
/* ── Variables ── */
:root {
    --blue-dark:   #003b73;
    --blue-mid:    #00508f;
    --teal:        #4ec7d2;
    --teal-light:  rgba(78,199,210,0.12);
    --border:      #e8edf4;
    --surface:     #f5f8fc;
    --text-main:   #0d2137;
    --text-muted:  #6b7a90;
    --green:       #10b981;
    --amber:       #f59e0b;
    --red:         #ef4444;
    --purple:      #8b5cf6;
    --radius-lg:   14px;
    --radius-md:   10px;
    --radius-sm:   7px;
    --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
    --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
}

/* ── Stats ── */
.est-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
@media(max-width:900px){ .est-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:540px){ .est-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

.est-stat {
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    padding: 1.1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--shadow-sm);
    transition: transform .2s, box-shadow .2s;
    position: relative;
    overflow: hidden;
}
.est-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
    border-radius: 4px 0 0 4px;
}
.est-stat-total::before   { background: var(--green); }
.est-stat-active::before  { background: var(--teal); }
.est-stat-inactive::before{ background: var(--amber); }
.est-stat-new::before     { background: var(--purple); }
.est-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

.est-stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.15rem;
}
.est-stat-total   .est-stat-icon { background: rgba(16,185,129,.12);  color: var(--green); }
.est-stat-active  .est-stat-icon { background: var(--teal-light);     color: var(--teal); }
.est-stat-inactive .est-stat-icon{ background: rgba(245,158,11,.12);  color: var(--amber); }
.est-stat-new     .est-stat-icon { background: rgba(139,92,246,.12);  color: var(--purple); }

.est-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
.est-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
.est-stat-sub { font-size: .73rem; color: var(--text-muted); }

/* ── Toolbar ── */
.est-toolbar {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: .9rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    box-shadow: var(--shadow-sm);
}
.est-search-wrap { position: relative; flex: 1; min-width: 220px; }
.est-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; }
.est-search {
    width: 100%; padding: .5rem 1rem .5rem 2.4rem;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: .85rem; background: var(--surface); outline: none;
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit; color: var(--text-main);
}
.est-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

.est-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
.est-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

.est-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
.est-perpage label { white-space: nowrap; font-weight: 500; }
.est-perpage select {
    padding: .3rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; font-family: inherit; color: #0f172a;
    background: #f8fafc; outline: none; cursor: pointer; transition: border-color .2s;
}
.est-perpage select:focus { border-color: #4ec7d2; }

/* ── Tabla card ── */
.est-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.est-card-head {
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
    padding: .9rem 1.4rem;
    display: flex; align-items: center; gap: .6rem;
}
.est-card-head i    { color: var(--teal); font-size: 1rem; }
.est-card-head span { color: white; font-weight: 700; font-size: .95rem; }

.est-tbl { width: 100%; border-collapse: collapse; }
.est-tbl thead th {
    background: var(--surface); padding: .65rem 1rem;
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--text-muted);
    border-bottom: 1.5px solid var(--border); white-space: nowrap;
}
.est-tbl thead th.tc { text-align: center; }
.est-tbl tbody td { padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .84rem; color: var(--text-main); vertical-align: middle; }
.est-tbl tbody td.tc { text-align: center; }
.est-tbl tbody tr:last-child td { border-bottom: none; }
.est-tbl tbody tr { transition: background .15s; }
.est-tbl tbody tr:hover { background: #f7fbff; }
.est-tbl tbody tr.hidden { display: none; }

.row-num {
    width: 26px; height: 26px; border-radius: 7px;
    background: var(--surface); border: 1px solid var(--border);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 700; color: var(--text-muted);
}

.est-av {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    display: inline-flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: .9rem; flex-shrink: 0;
    border: 2px solid rgba(78,199,210,.3);
}
.est-av img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
.est-name  { font-weight: 600; color: var(--blue-dark); font-size: .88rem; }
.est-email { font-size: .73rem; color: var(--text-muted); margin-top: .1rem; }

.est-dni {
    font-family: 'Courier New', monospace;
    font-size: .82rem; color: var(--blue-mid); font-weight: 600;
    background: rgba(0,80,143,.06); padding: .2rem .5rem;
    border-radius: 5px; white-space: nowrap;
}

.chip { display: inline-flex; align-items: center; padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 600; white-space: nowrap; }
.chip-teal { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
.chip-blue { background: rgba(0,80,143,.08); color: var(--blue-dark); border: 1px solid rgba(0,80,143,.2); }

.badge-estado { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-activo   { background: rgba(78,199,210,.15); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.4); }
.badge-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
.dot-teal { background: var(--teal); }
.dot-red  { background: var(--red); }

.act-btn {
    width: 30px; height: 30px; border-radius: 7px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid; font-size: .78rem;
    background: white; cursor: pointer;
    transition: all .15s; text-decoration: none;
}
.act-view  { border-color: var(--blue-mid); color: var(--blue-mid); }
.act-edit  { border-color: var(--teal);     color: var(--teal); }
.act-del   { border-color: var(--red);      color: var(--red); }
.act-view:hover  { background: var(--blue-mid); color: white; transform: translateY(-1px); }
.act-edit:hover  { background: var(--teal);     color: white; transform: translateY(-1px); }
.act-del:hover   { background: var(--red);      color: white; transform: translateY(-1px); }

.est-empty { padding: 4rem 1rem; text-align: center; }
.est-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
.est-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
.est-empty p  { font-size: .83rem; color: var(--text-muted); margin-bottom: 1.25rem; }

.est-footer {
    padding: .85rem 1.25rem;
    border-top: 1px solid var(--border);
    background: var(--surface);
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
}
.est-footer-info { font-size: .78rem; color: var(--text-muted); }

.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 7px; margin: 0 2px;
    border: 1.5px solid var(--border);
    color: var(--blue-mid);
    padding: .28rem .6rem; font-size: .82rem; transition: all .15s;
}
.pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); color: var(--blue-dark); }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    border-color: var(--teal); color: white;
    box-shadow: 0 2px 6px rgba(78,199,210,.35);
}

.no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }

/* ── RESPONSIVE ── */
@media(max-width: 768px) {
    .est-toolbar { flex-direction: column; align-items: stretch; gap: .75rem; }
    .est-search-wrap { min-width: unset; }
    .est-badge-info { justify-content: center; flex-wrap: wrap; gap: .75rem; }
    .est-tbl thead th:nth-child(2), .est-tbl tbody td:nth-child(2),
    .est-tbl thead th:nth-child(6), .est-tbl tbody td:nth-child(6) { display: none; }
    .est-tbl thead th, .est-tbl tbody td { padding: .55rem .65rem; font-size: .78rem; }
    .est-footer { flex-direction: column; align-items: center; text-align: center; gap: .75rem; }
}
@media(max-width: 480px) {
    .est-stats { grid-template-columns: repeat(2,1fr); gap: .65rem; }
    .est-stat { padding: .85rem .9rem; gap: .75rem; }
    .est-stat-num { font-size: 1.45rem; }
    .est-stat-icon { width: 38px; height: 38px; font-size: .95rem; }
    .est-tbl thead th:nth-child(4), .est-tbl tbody td:nth-child(4) { display: none; }
    .est-name  { font-size: .82rem; }
    .est-email { display: none; }
    .act-btn   { width: 26px; height: 26px; font-size: .72rem; }
    .chip      { font-size: .65rem; padding: .18rem .5rem; }
}
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="est-stats">
        <div class="est-stat est-stat-total">
            <div class="est-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="est-stat-lbl">Total</div>
                <div class="est-stat-num">{{ $totalEstudiantes }}</div>
                <div class="est-stat-sub">Estudiantes</div>
            </div>
        </div>
        <div class="est-stat est-stat-active">
            <div class="est-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="est-stat-lbl">Activos</div>
                <div class="est-stat-num">{{ $totalActivos }}</div>
                <div class="est-stat-sub">En el sistema</div>
            </div>
        </div>
        <div class="est-stat est-stat-inactive">
            <div class="est-stat-icon"><i class="fas fa-user-slash"></i></div>
            <div>
                <div class="est-stat-lbl">Inactivos</div>
                <div class="est-stat-num">{{ $totalInactivos }}</div>
                <div class="est-stat-sub">Suspendidos</div>
            </div>
        </div>
        <div class="est-stat est-stat-new">
            <div class="est-stat-icon"><i class="fas fa-user-plus"></i></div>
            <div>
                <div class="est-stat-lbl">Nuevos Hoy</div>
                <div class="est-stat-num">{{ $nuevosHoy }}</div>
                <div class="est-stat-sub">Registrados</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="est-toolbar">
        <div class="est-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="est-search"
                   placeholder="Buscar por nombre, DNI, grado...">
        </div>
        <div class="est-badge-info">
            <span>
                <i class="fas fa-users" style="color:var(--blue-mid);"></i>
                <strong id="visibleCount" style="color:var(--blue-mid);">{{ $totalEstudiantes }}</strong>
                <span style="color:var(--text-muted);">Total</span>
            </span>
            <span>
                <i class="fas fa-check-circle" style="color:var(--teal);"></i>
                <strong style="color:var(--teal);">{{ $totalActivos }}</strong>
                <span style="color:var(--text-muted);">Activos</span>
            </span>
        </div>
        <div class="est-perpage">
            <label for="perPageSelect"><i class="fas fa-list-ol" style="color:#4ec7d2;"></i> Mostrar:</label>
            <select id="perPageSelect" onchange="cambiarPerPage(this.value)">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ── TABLA ── --}}
    <div class="est-card">
        <div class="est-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Lista de Estudiantes</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="est-tbl" id="studentsTable">
                <thead>
                    <tr>
                        <th class="tc" style="width:50px;">#</th>
                        <th style="width:50px;">Foto</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th class="tc">Grado</th>
                        <th class="tc">Sección</th>
                        <th class="tc">Estado</th>
                        <th class="tc">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($estudiantes as $i => $estudiante)
                    <tr class="student-row"
                        data-search="{{ strtolower(($estudiante->nombre1 ?? '') . ' ' . ($estudiante->nombre2 ?? '') . ' ' . ($estudiante->apellido1 ?? '') . ' ' . ($estudiante->apellido2 ?? '') . ' ' . ($estudiante->dni ?? '') . ' ' . ($estudiante->grado ?? '') . ' ' . ($estudiante->seccion ?? '')) }}">

                        <td class="tc">
                            <span class="row-num">{{ $estudiantes->firstItem() + $i }}</span>
                        </td>

                        {{-- Foto --}}
                        <td>
                            <div class="est-av">
                                @if($estudiante->foto)
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto">
                                @else
                                    {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}
                                @endif
                            </div>
                        </td>

                        {{-- Nombre --}}
                        <td>
                            <div class="est-name">{{ $estudiante->nombre_completo }}</div>
                            @if($estudiante->email)
                                <div class="est-email">{{ $estudiante->email }}</div>
                            @endif
                        </td>

                        {{-- DNI --}}
                        <td><span class="est-dni">{{ $estudiante->dni }}</span></td>

                        {{-- Grado --}}
                        <td class="tc">
                            <span class="chip chip-teal">{{ $estudiante->grado }}</span>
                        </td>

                        {{-- Sección --}}
                        <td class="tc">
                            <span class="chip chip-blue">{{ $estudiante->seccion }}</span>
                        </td>

                        {{-- Estado --}}
                        <td class="tc">
                            @if($estudiante->estado === 'activo')
                                <span class="badge-estado badge-activo">
                                    <span class="dot dot-teal"></span> Activo
                                </span>
                            @else
                                <span class="badge-estado badge-inactivo">
                                    <span class="dot dot-red"></span> Inactivo
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="tc">
                            <div style="display:inline-flex;gap:.35rem;align-items:center;">
                                <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                   class="act-btn act-view" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del" title="Eliminar"
                                        onclick="mostrarModalDelete(
                                            '{{ route('estudiantes.destroy', $estudiante->id) }}',
                                            '¿Está seguro de eliminar este estudiante? Esta acción no se puede deshacer.',
                                            '{{ addslashes($estudiante->nombre_completo) }}'
                                        )">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="est-empty">
                                <i class="fas fa-user-graduate"></i>
                                <h6>No hay estudiantes registrados</h6>
                                <p>Comienza agregando el primer estudiante al sistema</p>
                                <a href="{{ route('estudiantes.create') }}"
                                   style="display:inline-flex;align-items:center;gap:.5rem;padding:.55rem 1.3rem;background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border-radius:9px;text-decoration:none;font-weight:600;font-size:.85rem;box-shadow:0 2px 8px rgba(78,199,210,.3);">
                                    <i class="fas fa-plus"></i> Registrar Estudiante
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer / paginación --}}
        @if($estudiantes->hasPages())
        <div class="est-footer">
            <span class="est-footer-info">
                Mostrando {{ $estudiantes->firstItem() }}–{{ $estudiantes->lastItem() }}
                de {{ $estudiantes->total() }} estudiantes
            </span>
            {{ $estudiantes->links() }}
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

        tbody.querySelectorAll('.student-row').forEach(function (row) {
            const texto = row.dataset.search || row.textContent.toLowerCase();
            const match = term === '' || texto.includes(term);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        if (visibleCount) visibleCount.textContent = visible;

        if (visible === 0 && term !== '') {
            const tr = document.createElement('tr');
            tr.className = 'no-results-row';
            tr.innerHTML = `<td colspan="8" style="text-align:center;padding:3rem 1rem;">
                <i class="fas fa-search" style="font-size:1.75rem;color:#cbd5e1;display:block;margin-bottom:.75rem;"></i>
                <p style="color:#94a3b8;margin:0;font-size:.85rem;">
                    Sin resultados para <strong style="color:#0d2137;">"${term}"</strong>
                </p>
            </td>`;
            tbody.appendChild(tr);
        }
    });
});

function cambiarPerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush