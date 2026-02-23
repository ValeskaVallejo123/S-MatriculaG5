@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
    <a href="{{ route('estudiantes.create') }}" class="adm-btn-solid">
        <i class="fas fa-plus"></i> Nuevo Estudiante
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.est-wrap { font-family: 'Inter', sans-serif; }

.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none; transition: opacity .15s;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* ── Toolbar ── */
.est-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.est-search-wrap { position: relative; flex: 1; max-width: 380px; }
.est-search-wrap i {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .82rem; pointer-events: none;
}
.est-search {
    width: 100%; padding: .42rem .75rem .42rem 2rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; font-family: 'Inter', sans-serif;
    color: #0f172a; outline: none; transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
}
.est-search:focus { border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12); background: #fff; }

.est-total {
    display: flex; align-items: center; gap: .4rem;
    font-size: .8rem; color: #64748b; white-space: nowrap;
}
.est-total strong { color: #003b73; font-weight: 700; }

/* ── Table card ── */
.est-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.est-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.est-card-head i { color: #4ec7d2; font-size: 1rem; }
.est-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

/* ── Table ── */
.est-tbl { width: 100%; border-collapse: collapse; }

.est-tbl thead th {
    background: #f8fafc;
    padding: .65rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.est-tbl thead th.tc { text-align: center; }
.est-tbl thead th.tr { text-align: right; }

.est-tbl tbody td {
    padding: .7rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155;
    vertical-align: middle;
}
.est-tbl tbody td.tc { text-align: center; }
.est-tbl tbody td.tr { text-align: right; }
.est-tbl tbody tr:last-child td { border-bottom: none; }
.est-tbl tbody tr { transition: background .12s; }
.est-tbl tbody tr:hover { background: #f8fafc; }

/* Photo */
.est-photo {
    width: 36px; height: 36px; border-radius: 50%;
    object-fit: cover; border: 2px solid #4ec7d2;
    display: block;
}

/* Name */
.est-name { font-weight: 600; color: #0f172a; font-size: .83rem; }
.est-email { font-size: .73rem; color: #94a3b8; margin-top: .1rem; }

/* DNI monospace */
.est-dni { font-family: monospace; font-size: .8rem; color: #00508f; }

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-cyan   { background: #e8f8f9; color: #00508f; border: 1px solid #b2e8ed; }
.b-green  { background: #ecfdf5; color: #059669; }
.b-red    { background: #fef2f2; color: #dc2626; }

/* Action buttons */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none;
    transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #f0f9ff; color: #0369a1; }
.act-view:hover { background: #0369a1; color: #fff; }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: #fff; }

/* ── Empty ── */
.est-empty { padding: 3.5rem 1rem; text-align: center; }
.est-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
.est-empty p { color: #94a3b8; font-size: .85rem; margin: .25rem 0 1rem; }

/* ── Pagination ── */
.est-footer {
    padding: .85rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa;
}
.est-pages { font-size: .78rem; color: #94a3b8; }

.pagination { margin: 0; gap: 3px; display: flex; }
.pagination .page-link {
    border-radius: 7px; padding: .3rem .65rem;
    font-size: .78rem; font-weight: 500;
    border: 1px solid #e2e8f0; color: #00508f;
    transition: all .15s; line-height: 1.4;
}
.pagination .page-link:hover { background: #e8f8f9; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: #fff;
}
.pagination .page-item.disabled .page-link { opacity: .45; }

/* ── No results row ── */
.no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }
</style>
@endpush

@section('content')
<div class="est-wrap">

    {{-- Toolbar --}}
    <div class="est-toolbar">
        <div class="est-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="est-search" placeholder="Buscar por nombre, DNI, grado...">
        </div>
        <div class="est-total">
            <i class="fas fa-users" style="color:#4ec7d2;"></i>
            <span><strong>{{ $estudiantes->total() }}</strong> estudiantes</span>
        </div>
    </div>

    {{-- Table card --}}
    <div class="est-card">
        <div class="est-card-head">
            <i class="fas fa-user-graduate"></i>
            <span>Lista de Estudiantes</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="est-tbl" id="studentsTable">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th class="tc">Grado</th>
                        <th class="tc">Sección</th>
                        <th class="tc">Estado</th>
                        <th class="tr">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($estudiantes as $estudiante)
                    <tr class="student-row">
                        <td>
                            <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                 class="est-photo" alt="Foto">
                        </td>
                        <td>
                            <div class="est-name">{{ $estudiante->nombre_completo }}</div>
                            @if($estudiante->email)
                            <div class="est-email">{{ $estudiante->email }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="est-dni">{{ $estudiante->dni }}</span>
                        </td>
                        <td class="tc">
                            <span class="bpill b-cyan">{{ $estudiante->grado }}</span>
                        </td>
                        <td class="tc">
                            <span class="bpill b-cyan">{{ $estudiante->seccion }}</span>
                        </td>
                        <td class="tc">
                            @if($estudiante->estado === 'activo')
                                <span class="bpill b-green">
                                    <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
                                </span>
                            @else
                                <span class="bpill b-red">
                                    <i class="fas fa-circle" style="font-size:.4rem;"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="tr">
                            <div style="display:inline-flex;gap:.35rem;align-items:center;">
                                <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                   class="act-btn act-view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del btn-delete-estudiante"
                                        data-url="{{ route('estudiantes.destroy', $estudiante->id) }}"
                                        data-nombre="{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="est-empty">
                                <i class="fas fa-user-graduate"></i>
                                <p>No hay estudiantes registrados</p>
                                <a href="{{ route('estudiantes.create') }}" class="adm-btn-solid">
                                    <i class="fas fa-plus"></i> Registrar Estudiante
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer paginación --}}
        @if($estudiantes->hasPages())
        <div class="est-footer">
            <span class="est-pages">
                Mostrando {{ $estudiantes->firstItem() }}–{{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }}
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
    const searchInput = document.getElementById('searchInput');
    const tbody       = document.getElementById('tableBody');
    const rows        = tbody.querySelectorAll('.student-row');

    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach(row => {
            const match = row.textContent.toLowerCase().includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        // Quitar fila "sin resultados" previa
        const prev = tbody.querySelector('.no-results-row');
        if (prev) prev.remove();

        if (visible === 0 && q !== '') {
            const tr = document.createElement('tr');
            tr.className = 'no-results-row';
            tr.innerHTML = `<td colspan="7">
                <i class="fas fa-search" style="color:#cbd5e1;font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                Sin resultados para "<strong>${q}</strong>"
            </td>`;
            tbody.appendChild(tr);
        }
    });
});
</script>
@endpush