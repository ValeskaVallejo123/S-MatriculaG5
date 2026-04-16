@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Estudiantes')
@section('content-class', 'p-0')

@push('styles')
<style>
.est-wrap { height: calc(100vh - 64px); display: flex; flex-direction: column; overflow: hidden; background: #f0f4f8; }

/* Hero */
.est-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.est-hero-left { display: flex; align-items: center; gap: 1rem; }
.est-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.est-hero-icon i { font-size: 1.3rem; color: white; }
.est-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.est-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.est-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.est-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.est-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }
.est-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.est-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar */
.est-toolbar {
    background: white; border-bottom: 1px solid #e8eef5;
    padding: .8rem 2rem; display: flex; align-items: center;
    gap: .75rem; flex-shrink: 0; flex-wrap: wrap;
}
.est-search-wrap { position: relative; flex: 1; min-width: 200px; max-width: 400px; }
.est-search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .8rem; pointer-events: none; }
.est-search {
    width: 100%; padding: .45rem 1rem .45rem 2.3rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .85rem;
    background: #f8fafc; transition: border-color .2s, box-shadow .2s;
}
.est-search:focus { border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12); outline: none; background: white; }
.est-select {
    padding: .45rem .85rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; background: #f8fafc; color: #003b73; cursor: pointer;
}
.est-select:focus { border-color: #4ec7d2; outline: none; }

/* Body */
.est-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.est-card { background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden; }
.est-tbl { width: 100%; border-collapse: collapse; }
.est-tbl thead th {
    background: #003b73; color: white; padding: .72rem 1rem;
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; border: none; white-space: nowrap;
}
.est-tbl thead th.tc { text-align: center; }
.est-tbl tbody td { padding: .72rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .84rem; color: #1e293b; vertical-align: middle; }
.est-tbl tbody td.tc { text-align: center; }
.est-tbl tbody tr:last-child td { border-bottom: none; }
.est-tbl tbody tr:hover td { background: rgba(78,199,210,.04); }
.est-tbl tbody tr.hidden { display: none; }

.row-num {
    width: 26px; height: 26px; border-radius: 7px;
    background: #f1f5f9; border: 1px solid #e2e8f0;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 700; color: #64748b;
}
.est-av {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: inline-flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: .9rem; flex-shrink: 0;
}
.est-av img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
.chip { display: inline-flex; align-items: center; padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 600; white-space: nowrap; }
.chip-teal  { background: rgba(78,199,210,.12); color: #00508f; border: 1px solid rgba(78,199,210,.35); }
.chip-blue  { background: rgba(0,80,143,.08); color: #003b73; border: 1px solid rgba(0,80,143,.2); }
.badge-activo   { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 999px; font-size: .72rem; font-weight: 700; background: rgba(78,199,210,.15); color: #00508f; border: 1px solid rgba(78,199,210,.4); }
.badge-inactivo { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 999px; font-size: .72rem; font-weight: 700; background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

.act-btn {
    width: 30px; height: 30px; border-radius: 7px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid; font-size: .78rem; background: white;
    cursor: pointer; transition: all .15s; text-decoration: none;
}
.act-view  { border-color: #00508f; color: #00508f; }
.act-edit  { border-color: #4ec7d2; color: #4ec7d2; }
.act-del   { border-color: #ef4444; color: #ef4444; }
.act-historial { border-color: #00508f; color: #00508f; }
.act-btn:hover { transform: translateY(-1px); }
.act-view:hover, .act-historial:hover { background: #00508f; color: white; }
.act-edit:hover  { background: #4ec7d2; color: white; }
.act-del:hover   { background: #ef4444; color: white; }

/* Paginación */
.est-pag { padding: .75rem 1.25rem; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem; }
.pagination { margin: 0; }
.pagination .page-link { border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0; color: #00508f; font-size: .82rem; padding: .3rem .65rem; transition: all .2s; }
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link { background: linear-gradient(135deg,#4ec7d2,#00508f); border-color: #4ec7d2; color: white; }

/* Dark mode */
body.dark-mode .est-wrap    { background: #0f172a; }
body.dark-mode .est-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .est-search  { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .est-card    { background: #1e293b; }
body.dark-mode .est-tbl tbody td { color: #cbd5e1; border-color: #334155; }
body.dark-mode .est-tbl tbody tr:hover td { background: rgba(78,199,210,.06); }
</style>
@endpush

@section('content')
<div class="est-wrap">

    {{-- Hero --}}
    <div class="est-hero">
        <div class="est-hero-left">
            <div class="est-hero-icon"><i class="fas fa-user-graduate"></i></div>
            <div>
                <h2 class="est-hero-title">Gestión de Estudiantes</h2>
                <p class="est-hero-sub">Registro y seguimiento del alumnado</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="est-stat">
                <div class="est-stat-num">{{ $totalEstudiantes }}</div>
                <div class="est-stat-lbl">Total</div>
            </div>
            <div class="est-stat">
                <div class="est-stat-num">{{ $totalActivos }}</div>
                <div class="est-stat-lbl">Activos</div>
            </div>
            <div class="est-stat">
                <div class="est-stat-num">{{ $totalInactivos }}</div>
                <div class="est-stat-lbl">Inactivos</div>
            </div>
            <div class="est-stat">
                <div class="est-stat-num">{{ $nuevosHoy }}</div>
                <div class="est-stat-lbl">Hoy</div>
            </div>
            <a href="{{ route('estudiantes.create') }}" class="est-btn-new ms-2">
                <i class="fas fa-plus"></i> Nuevo Estudiante
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="est-toolbar">
        <div class="est-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="est-search" placeholder="Buscar por nombre, DNI, grado…">
        </div>
        <div class="est-select">
            <label for="perPageSelect" class="me-1" style="font-size:.8rem;color:#64748b;">Mostrar:</label>
            <select id="perPageSelect" onchange="cambiarPerPage(this.value)" style="border:none;background:transparent;font-size:.8rem;color:#003b73;outline:none;cursor:pointer;">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>{{ $op }} / pág</option>
                @endforeach
            </select>
        </div>
        <small class="text-muted ms-auto" id="visibleCount"></small>
    </div>

    {{-- Body --}}
    <div class="est-body">

        <div class="est-card">
            <div class="table-responsive">
                <table class="est-tbl" id="studentsTable">
                    <thead>
                        <tr>
                            <th class="tc" style="width:50px;">#</th>
                            <th style="width:50px;"></th>
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
                            <td class="tc"><span class="row-num">{{ $estudiantes->firstItem() + $i }}</span></td>
                            <td>
                                <div class="est-av">
                                    @if($estudiante->foto)
                                        <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto">
                                    @else
                                        {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold" style="color:#003b73;font-size:.87rem;">{{ $estudiante->nombre_completo }}</div>
                                @if($estudiante->email)
                                    <div style="font-size:.73rem;color:#94a3b8;">{{ $estudiante->email }}</div>
                                @endif
                            </td>
                            <td><span style="font-family:monospace;font-size:.83rem;color:#00508f;">{{ $estudiante->dni }}</span></td>
                            <td class="tc"><span class="chip chip-teal">{{ $estudiante->grado }}</span></td>
                            <td class="tc"><span class="chip chip-blue">{{ $estudiante->seccion }}</span></td>
                            <td class="tc">
                                @if($estudiante->estado === 'activo')
                                    <span class="badge-activo"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activo</span>
                                @else
                                    <span class="badge-inactivo"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactivo</span>
                                @endif
                            </td>
                            <td class="tc">
                                <div style="display:inline-flex;gap:.3rem;">
                                    <a href="{{ route('superadmin.estudiantes.historial.show', $estudiante->id) }}" class="act-btn act-historial" title="Historial"><i class="fas fa-graduation-cap"></i></a>
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="act-btn act-view" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="act-btn act-edit" title="Editar"><i class="fas fa-pen"></i></a>
                                    <button type="button" class="act-btn act-del" title="Eliminar"
                                            onclick="mostrarModalDelete('{{ route('estudiantes.destroy', $estudiante->id) }}','¿Está seguro de eliminar a este estudiante?','{{ addslashes($estudiante->nombre_completo) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-user-graduate fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                                <div class="fw-semibold" style="color:#003b73;">No hay estudiantes registrados</div>
                                <small class="text-muted">Comienza registrando el primer estudiante</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($estudiantes->hasPages())
            <div class="est-pag">
                <small class="text-muted">{{ $estudiantes->firstItem() }}–{{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }} estudiantes</small>
                {{ $estudiantes->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input  = document.getElementById('searchInput');
    const tbody  = document.getElementById('tableBody');
    const counter = document.getElementById('visibleCount');
    if (!input || !tbody) return;

    input.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        const noRow = tbody.querySelector('.no-results-row');
        if (noRow) noRow.remove();
        let visible = 0;
        tbody.querySelectorAll('.student-row').forEach(function (row) {
            const match = term === '' || (row.dataset.search || '').includes(term);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        counter.textContent = term ? `${visible} resultado${visible !== 1 ? 's' : ''}` : '';
        if (visible === 0 && term !== '') {
            const tr = document.createElement('tr');
            tr.className = 'no-results-row';
            tr.innerHTML = `<td colspan="8" class="text-center py-5">
                <i class="fas fa-search fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                <div style="color:#003b73;font-weight:600;">Sin resultados para "<em>${term}</em>"</div>
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
