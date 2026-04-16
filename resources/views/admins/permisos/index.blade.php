@extends('layouts.app')

@section('title', 'Gestión de Permisos de Padres')
@section('page-title', 'Gestión de Permisos de Padres')
@section('content-class', 'p-0')

@push('styles')
<style>
.permisos-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.perm-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.perm-hero-left { display: flex; align-items: center; gap: 1rem; }
.perm-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.perm-hero-icon i { font-size: 1.3rem; color: white; }
.perm-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.perm-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

/* Stats badges */
.perm-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 90px;
}
.perm-stat-num  { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.perm-stat-lbl  { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

/* Toolbar */
.perm-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.perm-search {
    position: relative;
    flex: 1;
    max-width: 420px;
}
.perm-search i {
    position: absolute;
    left: 12px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .85rem;
}
.perm-search input {
    width: 100%;
    padding: .45rem 1rem .45rem 2.4rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: .875rem;
    transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
}
.perm-search input:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    outline: none;
    background: white;
}

/* Scrollable body */
.perm-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem 2rem;
}

/* Table card */
.perm-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.perm-table thead th {
    background: #003b73;
    color: white;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .75rem 1rem;
    border: none;
    white-space: nowrap;
}
.perm-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
.perm-table tbody tr:hover { background: rgba(78,199,210,.05); }
.perm-table tbody td { padding: .7rem 1rem; vertical-align: middle; }
.perm-table tbody tr:last-child { border-bottom: none; }

/* Avatar */
.p-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: .82rem; flex-shrink: 0;
}

/* Badges */
.badge-parentesco {
    background: rgba(78,199,210,.12);
    color: #00508f;
    border: 1px solid rgba(78,199,210,.4);
    border-radius: 6px;
    padding: .25rem .6rem;
    font-size: .73rem;
    font-weight: 600;
}
.badge-activo {
    background: rgba(78,199,210,.12);
    color: #00508f;
    border: 1px solid rgba(78,199,210,.4);
    border-radius: 20px;
    padding: .25rem .65rem;
    font-size: .73rem;
}
.badge-inactivo {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
    border-radius: 20px;
    padding: .25rem .65rem;
    font-size: .73rem;
}

/* Button */
.btn-configurar {
    display: inline-flex; align-items: center; gap: .4rem;
    border: 1.5px solid #00508f; color: #00508f; background: white;
    border-radius: 7px; padding: .3rem .85rem; font-size: .8rem; font-weight: 600;
    text-decoration: none; transition: all .2s;
}
.btn-configurar:hover {
    background: #00508f; color: white;
    box-shadow: 0 3px 10px rgba(0,80,143,.25);
    transform: translateY(-1px);
}

/* Paginación */
.perm-pag {
    padding: .75rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0;
    color: #00508f; font-size: .82rem; padding: .3rem .65rem; transition: all .2s;
}
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    border-color: #4ec7d2; color: white;
}

/* Dark mode */
body.dark-mode .permisos-wrap  { background: #0f172a; }
body.dark-mode .perm-toolbar   { background: #1e293b; border-color: #334155; }
body.dark-mode .perm-search input { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .perm-table-card { background: #1e293b; }
body.dark-mode .perm-table tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .perm-table tbody td { color: #cbd5e1; }
body.dark-mode .perm-table tbody tr { border-color: #334155; }
body.dark-mode .perm-pag { border-color: #334155; }
body.dark-mode .badge-parentesco, body.dark-mode .badge-activo { background: rgba(78,199,210,.1); }
body.dark-mode .btn-configurar { background: #0f172a; color: #4ec7d2; border-color: #4ec7d2; }
body.dark-mode .btn-configurar:hover { background: #4ec7d2; color: #003b73; }
</style>
@endpush

@section('content')
<div class="permisos-wrap">

    {{-- Hero --}}
    <div class="perm-hero">
        <div class="perm-hero-left">
            <div class="perm-hero-icon"><i class="fas fa-shield-alt"></i></div>
            <div>
                <h2 class="perm-hero-title">Permisos de Padres y Tutores</h2>
                <p class="perm-hero-sub">Configura el acceso de cada padre/tutor a la información de sus hijos</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="perm-stat">
                <div class="perm-stat-num">{{ $padres->total() }}</div>
                <div class="perm-stat-lbl">Total</div>
            </div>
            <div class="perm-stat">
                <div class="perm-stat-num">{{ $padres->getCollection()->where('estado', 1)->count() }}</div>
                <div class="perm-stat-lbl">Activos</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="perm-toolbar">
        <div class="perm-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Buscar por nombre, DNI, correo…">
        </div>
        <small class="text-muted ms-auto" id="resultCount"></small>
    </div>

    {{-- Body --}}
    <div class="perm-body">

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert"
                 style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert"
                 style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tabla --}}
        <div class="perm-table-card">
            <div class="table-responsive">
                <table class="table perm-table mb-0" id="permisosTable">
                    <thead>
                        <tr>
                            <th>Padre / Tutor</th>
                            <th>DNI</th>
                            <th>Parentesco</th>
                            <th>Contacto</th>
                            <th>Hijos</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($padres as $padre)
                        <tr class="padre-row">
                            {{-- Nombre --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="p-avatar">
                                        {{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($padre->apellido ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color:#003b73;font-size:.88rem;">
                                            {{ $padre->nombre }} {{ $padre->apellido }}
                                        </div>
                                        @if($padre->correo)
                                            <small class="text-muted" style="font-size:.73rem;">{{ $padre->correo }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- DNI --}}
                            <td>
                                <span class="font-monospace" style="color:#00508f;font-size:.85rem;">
                                    {{ $padre->dni ?? '—' }}
                                </span>
                            </td>

                            {{-- Parentesco --}}
                            <td>
                                <span class="badge-parentesco">{{ $padre->parentesco_formateado }}</span>
                            </td>

                            {{-- Contacto --}}
                            <td>
                                @if($padre->telefono)
                                    <small class="d-block" style="color:#475569;font-size:.78rem;">
                                        <i class="fas fa-phone me-1" style="color:#4ec7d2;"></i>{{ $padre->telefono }}
                                    </small>
                                @endif
                                @if(!$padre->telefono && !$padre->correo)
                                    <small class="text-muted fst-italic" style="font-size:.78rem;">Sin contacto</small>
                                @endif
                            </td>

                            {{-- Hijos --}}
                            <td>
                                <span class="badge-parentesco">
                                    <i class="fas fa-child me-1"></i>
                                    {{ $padre->estudiantes->count() }}
                                    {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td>
                                @if($padre->estado)
                                    <span class="badge-activo">
                                        <i class="fas fa-circle me-1" style="font-size:.4rem;color:#4ec7d2;vertical-align:middle;"></i>Activo
                                    </span>
                                @else
                                    <span class="badge-inactivo">
                                        <i class="fas fa-circle me-1" style="font-size:.4rem;vertical-align:middle;"></i>Inactivo
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="text-end">
                                <a href="{{ route('admin.permisos.configurar', $padre->id) }}" class="btn-configurar">
                                    <i class="fas fa-sliders-h"></i> Configurar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                                <div class="fw-semibold" style="color:#003b73;">No hay padres registrados</div>
                                <small class="text-muted">No se encontraron resultados</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($padres->hasPages())
            <div class="perm-pag">
                <small class="text-muted">
                    {{ $padres->firstItem() }} – {{ $padres->lastItem() }} de {{ $padres->total() }} registros
                </small>
                {{ $padres->links() }}
            </div>
            @endif
        </div>

    </div>{{-- /perm-body --}}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input   = document.getElementById('searchInput');
    const counter = document.getElementById('resultCount');
    const rows    = document.querySelectorAll('#permisosTable .padre-row');
    let noRow     = null;
    const tbody   = document.querySelector('#permisosTable tbody');

    input.addEventListener('keyup', function () {
        const term = this.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach(function (row) {
            const match = row.textContent.toLowerCase().includes(term);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        // Fila de sin resultados
        if (noRow) noRow.remove(), noRow = null;
        if (visible === 0 && term !== '') {
            noRow = document.createElement('tr');
            noRow.innerHTML = `<td colspan="7" class="text-center py-5">
                <i class="fas fa-search fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                <div class="fw-semibold" style="color:#003b73;">Sin resultados para "<em>${term}</em>"</div>
                <small class="text-muted">Intenta con otro término</small>
            </td>`;
            tbody.appendChild(noRow);
        }

        counter.textContent = term ? `${visible} resultado${visible !== 1 ? 's' : ''}` : '';
    });
});
</script>
@endpush
