@extends('layouts.app')

@section('title', 'Buscar Estudiante')
@section('page-title', 'Buscar Estudiante')

@section('topbar-actions')
    <a href="{{ route('estudiantes.create') }}" class="adm-btn-solid" style="text-decoration:none;">
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
    color: #fff; border: none; text-decoration: none; transition: opacity .15s; cursor: pointer;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #64748b; border: 1.5px solid #e2e8f0;
    text-decoration: none; transition: background .15s; cursor: pointer;
}
.adm-btn-outline:hover { background: #f1f5f9; color: #334155; }

/* ── Toolbar de búsqueda ── */
.est-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; margin-bottom: 1.25rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.est-toolbar-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.est-toolbar-head i { color: #4ec7d2; font-size: 1rem; }
.est-toolbar-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.est-toolbar-head small { color: rgba(255,255,255,.6); font-size: .78rem; margin-left: auto; }

.est-toolbar-body { padding: 1.25rem; }

.form-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1rem; }
@media(max-width:992px){ .form-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:576px){ .form-grid { grid-template-columns: 1fr; } }

.form-group label {
    display: flex; align-items: center; gap: .35rem;
    font-size: .78rem; font-weight: 600; color: #334155; margin-bottom: .4rem;
}
.form-group label i { color: #00508f; }
.form-group input,
.form-group select {
    width: 100%; padding: .48rem .85rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #0f172a; background: #f8fafc;
    outline: none; transition: border .15s; font-family: 'Inter', sans-serif;
}
.form-group input:focus,
.form-group select:focus {
    border-color: #4ec7d2; background: #fff;
    box-shadow: 0 0 0 3px rgba(78,199,210,.1);
}
.form-group input::placeholder { color: #94a3b8; }

.form-actions { display: flex; gap: .6rem; flex-wrap: wrap; }

/* ── Card de resultados ── */
.est-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.est-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between; gap: .6rem;
}
.est-card-head-left { display: flex; align-items: center; gap: .6rem; }
.est-card-head i { color: #4ec7d2; font-size: 1rem; }
.est-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

.results-badge {
    background: rgba(255,255,255,.18); color: #fff;
    padding: .22rem .85rem; border-radius: 999px; font-size: .75rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.25);
}

/* ── Tabla ── */
.est-tbl { width: 100%; border-collapse: collapse; }
.est-tbl thead th {
    background: #f8fafc; padding: .65rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.est-tbl thead th.tc { text-align: center; }
.est-tbl thead th.tr { text-align: right; }
.est-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.est-tbl tbody td.tc { text-align: center; }
.est-tbl tbody td.tr { text-align: right; }
.est-tbl tbody tr:last-child td { border-bottom: none; }
.est-tbl tbody tr { transition: background .12s; }
.est-tbl tbody tr:hover { background: #f8fafc; }

.est-num {
    width: 28px; height: 28px; border-radius: 6px;
    background: #f1f5f9; color: #64748b;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
}

.est-photo {
    width: 36px; height: 36px; border-radius: 50%;
    object-fit: cover; border: 2px solid #4ec7d2; display: block;
}
.est-photo-placeholder {
    width: 36px; height: 36px; border-radius: 50%;
    background: #e8f8f9; border: 2px solid #4ec7d2;
    display: flex; align-items: center; justify-content: center;
}

.est-name  { font-weight: 600; color: #0f172a; font-size: .83rem; }
.est-email { font-size: .73rem; color: #94a3b8; margin-top: .1rem; }
.est-dni   { font-family: monospace; font-size: .8rem; color: #00508f; }

.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-cyan   { background: #e8f8f9; color: #00508f; border: 1px solid #b2e8ed; }
.b-green  { background: #ecfdf5; color: #059669; }
.b-red    { background: #fef2f2; color: #dc2626; }
.b-orange { background: #fff7ed; color: #c2410c; }
.b-gray   { background: #f1f5f9; color: #64748b; }

.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #f0f9ff; color: #0369a1; }
.act-view:hover { background: #0369a1; color: #fff; }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover { background: #ef4444; color: #fff; }

/* Empty / inicial */
.est-empty { padding: 3.5rem 1rem; text-align: center; }
.est-empty-icon {
    width: 72px; height: 72px; border-radius: 16px;
    background: #f1f5f9; display: flex; align-items: center; justify-content: center;
    margin: 0 auto .85rem; font-size: 1.75rem; color: #94a3b8;
}
.est-empty h5 { color: #0f172a; font-weight: 700; margin-bottom: .4rem; font-size: .95rem; }
.est-empty p  { color: #94a3b8; font-size: .82rem; margin: 0 0 1rem; }

.tips-list { display: flex; flex-direction: column; gap: .5rem; max-width: 360px; margin: 0 auto; }
.tip-item {
    display: flex; align-items: center; gap: .6rem;
    padding: .55rem .9rem; background: #f8fafc; border-radius: 9px;
    color: #64748b; font-size: .8rem;
}
.tip-item i { color: #4ec7d2; }

/* Footer / paginación */
.est-footer {
    padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa; flex-wrap: wrap; gap: .5rem;
}
.est-pages { font-size: .78rem; color: #94a3b8; }

.pagination { margin: 0; gap: 3px; display: flex; }
.pagination .page-link {
    border-radius: 7px; padding: .3rem .65rem;
    font-size: .78rem; font-weight: 500;
    border: 1px solid #e2e8f0; color: #00508f; transition: all .15s; line-height: 1.4;
}
.pagination .page-link:hover { background: #e8f8f9; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: #fff;
}
.pagination .page-item.disabled .page-link { opacity: .45; }
</style>
@endpush

@section('content')
<div class="est-wrap" style="max-width:1400px; margin:0 auto;">

    {{-- ── Formulario de búsqueda ── --}}
    <div class="est-toolbar">
        <div class="est-toolbar-head">
            <i class="fas fa-search"></i>
            <span>Buscar Estudiante</span>
            <small>Ingresa al menos un criterio de búsqueda</small>
        </div>
        <div class="est-toolbar-body">
            <form action="{{ route('estudiantes.buscar') }}" method="GET">
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nombre o Apellido</label>
                        <input type="text" name="nombre"
                               placeholder="Ej: María López"
                               value="{{ request('nombre') }}">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i> DNI / Identidad</label>
                        <input type="text" name="dni"
                               placeholder="Ej: 0801-2010-12345"
                               value="{{ request('dni') }}">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-graduation-cap"></i> Grado</label>
                        <input type="text" name="grado"
                               placeholder="Ej: 5°"
                               value="{{ request('grado') }}">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Estado</label>
                        <select name="estado">
                            <option value="">Todos</option>
                            <option value="activo"     {{ request('estado') === 'activo'     ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo"   {{ request('estado') === 'inactivo'   ? 'selected' : '' }}>Inactivo</option>
                            <option value="retirado"   {{ request('estado') === 'retirado'   ? 'selected' : '' }}>Retirado</option>
                            <option value="suspendido" {{ request('estado') === 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="adm-btn-solid">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('estudiantes.buscar') }}" class="adm-btn-outline">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                    <a href="{{ route('estudiantes.index') }}" class="adm-btn-outline">
                        <i class="fas fa-list"></i> Ver todos
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Resultados ── --}}
    @if($busquedaRealizada ?? false)

        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-head-left">
                    <i class="fas fa-user-graduate"></i>
                    <span>Resultados de Búsqueda</span>
                </div>
                <span class="results-badge">
                    {{ $estudiantes->total() }}
                    {{ $estudiantes->total() == 1 ? 'encontrado' : 'encontrados' }}
                </span>
            </div>

            <div style="overflow-x:auto;">
                @if($estudiantes->count() > 0)
                <table class="est-tbl">
                    <thead>
                        <tr>
                            <th class="tc">#</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th class="tc">Grado</th>
                            <th class="tc">Sección</th>
                            <th class="tc">Estado</th>
                            <th class="tr">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $index => $est)
                        <tr>
                            <td class="tc">
                                <span class="est-num">{{ $estudiantes->firstItem() + $index }}</span>
                            </td>
                            <td>
                                @if($est->foto)
                                    <img src="{{ asset('storage/' . $est->foto) }}"
                                         class="est-photo" alt="Foto">
                                @else
                                    <div class="est-photo-placeholder">
                                        <i class="fas fa-user" style="color:#4ec7d2;font-size:.85rem;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="est-name">
                                    {{ trim(($est->nombre1 ?? '') . ' ' . ($est->nombre2 ?? '') . ' ' . ($est->apellido1 ?? '') . ' ' . ($est->apellido2 ?? '')) }}
                                </div>
                                @if($est->email ?? false)
                                    <div class="est-email">{{ $est->email }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="est-dni">{{ $est->dni ?? '—' }}</span>
                            </td>
                            <td class="tc">
                                <span class="bpill b-cyan">{{ $est->grado ?? '—' }}</span>
                            </td>
                            <td class="tc">
                                <span class="bpill b-cyan">{{ $est->seccion ?? '—' }}</span>
                            </td>
                            <td class="tc">
                                @php $estado = $est->estado ?? 'inactivo'; @endphp
                                @if($estado === 'activo')
                                    <span class="bpill b-green">
                                        <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
                                    </span>
                                @elseif($estado === 'suspendido')
                                    <span class="bpill b-orange">
                                        <i class="fas fa-circle" style="font-size:.4rem;"></i> Suspendido
                                    </span>
                                @elseif($estado === 'retirado')
                                    <span class="bpill b-gray">
                                        <i class="fas fa-circle" style="font-size:.4rem;"></i> Retirado
                                    </span>
                                @else
                                    <span class="bpill b-red">
                                        <i class="fas fa-circle" style="font-size:.4rem;"></i> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="tr">
                                <div style="display:inline-flex;gap:.35rem;align-items:center;">
                                    <a href="{{ route('estudiantes.show', $est->id) }}"
                                       class="act-btn act-view" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('estudiantes.edit', $est->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="act-btn act-del"
                                            data-route="{{ route('estudiantes.destroy', $est->id) }}"
                                            data-name="{{ ($est->nombre1 ?? '') }} {{ ($est->apellido1 ?? '') }}"
                                            onclick="mostrarModalDeleteData(this)"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($estudiantes->hasPages())
                <div class="est-footer">
                    <span class="est-pages">
                        Mostrando {{ $estudiantes->firstItem() }}–{{ $estudiantes->lastItem() }}
                        de {{ $estudiantes->total() }} estudiantes
                    </span>
                    {{ $estudiantes->appends(request()->query())->links() }}
                </div>
                @endif

                @else
                <div class="est-empty">
                    <div class="est-empty-icon"><i class="fas fa-search"></i></div>
                    <h5>Sin resultados</h5>
                    <p>No se encontró ningún estudiante con los criterios ingresados.<br>Intenta con otros datos.</p>
                    <a href="{{ route('estudiantes.buscar') }}" class="adm-btn-outline" style="margin:0 auto;">
                        <i class="fas fa-redo"></i> Nueva búsqueda
                    </a>
                </div>
                @endif
            </div>
        </div>

    @else
    {{-- Estado inicial --}}
    <div class="est-card">
        <div class="est-empty">
            <div class="est-empty-icon"
                 style="background:linear-gradient(135deg,rgba(0,80,143,.08),rgba(78,199,210,.12));">
                <i class="fas fa-user-graduate" style="color:#00508f;"></i>
            </div>
            <h5>Busca un estudiante</h5>
            <p>Completa el formulario con al menos un criterio<br>para encontrar estudiantes registrados.</p>
            <div class="tips-list">
                <div class="tip-item">
                    <i class="fas fa-lightbulb"></i>
                    <span>Puedes buscar por nombre, DNI, grado o estado</span>
                </div>
                <div class="tip-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Los resultados se mostrarán debajo del formulario</span>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection