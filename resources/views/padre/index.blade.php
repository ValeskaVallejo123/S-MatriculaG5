@extends('layouts.app')

@section('title', 'Padres y Tutores')
@section('page-title', 'Gestión de Padres y Tutores')

@section('topbar-actions')
    <a href="{{ route('padres.create') }}" class="adm-btn-solid">
        <i class="fas fa-plus"></i> Agregar Nuevo Padre/Tutor
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.pad-wrap { font-family: 'Inter', sans-serif; }

.adm-btn-solid {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .6rem .75rem;
    border-radius: 7px;
    font-size: .83rem;
    font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none; transition: opacity .15s;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* ── Stats ── */
.pad-stats {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1rem; margin-bottom: 1.25rem;
}
@media(max-width:640px){ .pad-stats { grid-template-columns: 1fr; } }

.pad-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.pad-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pad-stat-icon i { font-size: 1.15rem; color: #fff; }
.pad-stat-lbl { font-size: .72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.pad-stat-num { font-size: 1.75rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* ── Toolbar ── */
.pad-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    flex-wrap: wrap; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.pad-search {
    display: flex; align-items: center; gap: .5rem;
    background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 8px;
    padding: .35rem .75rem; flex: 1; max-width: 320px;
}
.pad-search input {
    border: none; background: transparent; outline: none;
    font-size: .82rem; color: #0f172a; width: 100%;
}
.pad-search i { color: #94a3b8; font-size: .82rem; }

.pad-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
.pad-perpage select {
    padding: .3rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; color: #0f172a; background: #f8fafc; outline: none; cursor: pointer;
}
.pad-perpage select:focus { border-color: #4ec7d2; }

/* ── Card ── */
.pad-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.pad-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.pad-card-head i { color: #4ec7d2; font-size: 1rem; }
.pad-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

/* ── Table ── */
.pad-tbl { width: 100%; border-collapse: collapse; }
.pad-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.pad-tbl thead th.tc { text-align: center; }
.pad-tbl tbody td {
    padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.pad-tbl tbody td.tc { text-align: center; }
.pad-tbl tbody tr:last-child td { border-bottom: none; }
.pad-tbl tbody tr:hover { background: #fafbfc; }

/* Número */
.pad-num {
    width: 28px; height: 28px; border-radius: 6px;
    background: #f1f5f9; color: #64748b;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
}

/* Avatar */
.pad-av {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}
.pad-name { font-weight: 600; color: #0f172a; font-size: .83rem; }
.pad-sub  { font-size: .73rem; color: #64748b; }

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-blue   { background: #e8f8f9; color: #00508f; }
.b-green  { background: #ecfdf5; color: #059669; }
.b-red    { background: #fef2f2; color: #dc2626; }
.b-amber  { background: #fffbeb; color: #92400e; }
.b-gray   { background: #f1f5f9; color: #64748b; }

/* Hijos chips */
.hijo-chip {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .2rem .55rem; border-radius: 6px;
    background: #f0f9ff; color: #0369a1;
    font-size: .72rem; font-weight: 600;
    border: 1px solid #bae6fd; margin: .1rem;
}
.hijos-empty { font-size: .75rem; color: #cbd5e1; font-style: italic; }

/* Actions */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: #fff; }
.act-view { background: #f0fdf4; color: #059669; }
.act-view:hover { background: #059669; color: #fff; }

/* Empty */
.pad-empty { padding: 3.5rem 1rem; text-align: center; }
.pad-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
.pad-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

/* Footer */
.pad-footer {
    padding: .85rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa; flex-wrap: wrap; gap: .5rem;
}
.pad-pages { font-size: .78rem; color: #94a3b8; }

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
<div class="pad-wrap">

    {{-- Stats --}}
    <div class="pad-stats">
        <div class="pad-stat">
            <div class="pad-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="pad-stat-lbl">Total Padres</div>
                <div class="pad-stat-num">{{ $padres->total() }}</div>
            </div>
        </div>
        <div class="pad-stat">
            <div class="pad-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="pad-stat-lbl">Activos</div>
                {{-- ✅ CORREGIDO: estado es boolean (1/0), no string --}}
                <div class="pad-stat-num">{{ $padres->getCollection()->where('estado', 1)->count() }}</div>
            </div>
        </div>
        <div class="pad-stat">
            <div class="pad-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                <i class="fas fa-child"></i>
            </div>
            <div>
                <div class="pad-stat-lbl">Con Hijos Vinculados</div>
                <div class="pad-stat-num">{{ $padres->getCollection()->filter(fn($p) => $p->estudiantes->count() > 0)->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="pad-toolbar">
        <form method="GET" action="{{ route('padres.index') }}" style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;flex:1;">
            <div class="pad-search">
                <i class="fas fa-search"></i>
                <input type="text" name="buscar" placeholder="Buscar por nombre, DNI o correo..."
                       value="{{ request('buscar') }}">
            </div>
            <button type="submit" style="padding:.38rem .85rem;border-radius:7px;border:none;
                background:linear-gradient(135deg,#4ec7d2,#00508f);color:#fff;font-size:.8rem;
                font-weight:600;cursor:pointer;">
                <i class="fas fa-search"></i> Buscar
            </button>
            @if(request('buscar'))
                <a href="{{ route('padres.index') }}" style="font-size:.78rem;color:#64748b;text-decoration:none;">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            @endif
        </form>
        <div class="pad-perpage">
            <label>Mostrar:</label>
            <select onchange="cambiarPerPage(this.value)">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 15) == $op ? 'selected' : '' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <i class="fas fa-users"></i>
            <span>Lista de Padres y Tutores</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="pad-tbl">
                <thead>
                    <tr>
                        <th class="tc">#</th>
                        <th>Padre / Tutor</th>
                        <th>Contacto</th>
                        <th class="tc">Parentesco</th>
                        <th>Hijos Vinculados</th>
                        <th class="tc">Estado</th>
                        <th class="tc">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($padres as $index => $padre)
                    <tr>
                        {{-- Número --}}
                        <td class="tc">
                            <span class="pad-num">{{ $padres->firstItem() + $index }}</span>
                        </td>

                        {{-- Padre --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="pad-av">{{ strtoupper(substr($padre->nombre,0,1)) }}</div>
                                <div>
                                    <div class="pad-name">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                                    @if($padre->dni)
                                        <div class="pad-sub"><i class="fas fa-id-card" style="font-size:.65rem;"></i> {{ $padre->dni }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Contacto --}}
                        <td>
                            @if($padre->correo)
                                <div class="pad-sub"><i class="fas fa-envelope" style="color:#4ec7d2;font-size:.7rem;"></i> {{ $padre->correo }}</div>
                            @endif
                            @if($padre->telefono)
                                <div class="pad-sub"><i class="fas fa-phone" style="color:#4ec7d2;font-size:.7rem;"></i> {{ $padre->telefono }}</div>
                            @endif
                            @if(!$padre->correo && !$padre->telefono)
                                <span class="hijos-empty">Sin contacto</span>
                            @endif
                        </td>

                        {{-- Parentesco --}}
                        <td class="tc">
                            @php
                                $parentesco = match($padre->parentesco) {
                                    'padre'      => ['Padre',      'b-blue'],
                                    'madre'      => ['Madre',      'b-green'],
                                    'tutor_legal'=> ['Tutor Legal','b-amber'],
                                    'abuelo'     => ['Abuelo',     'b-gray'],
                                    'abuela'     => ['Abuela',     'b-gray'],
                                    default      => [ucfirst($padre->parentesco_otro ?? $padre->parentesco), 'b-gray'],
                                };
                            @endphp
                            <span class="bpill {{ $parentesco[1] }}">{{ $parentesco[0] }}</span>
                        </td>

                        {{-- Hijos --}}
                        <td>
                            @if($padre->estudiantes->count() > 0)
                                @foreach($padre->estudiantes as $estudiante)
                                    <span class="hijo-chip">
                                        <i class="fas fa-user-graduate" style="font-size:.6rem;"></i>
                                        {{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}
                                    </span>
                                @endforeach
                            @else
                                <span class="hijos-empty">Sin hijos vinculados</span>
                            @endif
                        </td>

                        {{-- Estado ✅ CORREGIDO: estado es boolean (1/0) --}}
                        <td class="tc">
                            @if($padre->estado)
                                <span class="bpill b-green">
                                    <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activo
                                </span>
                            @else
                                <span class="bpill b-red">
                                    <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactivo
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="tc">
                            <div style="display:inline-flex;gap:.4rem;align-items:center;">
                                <a href="{{ route('padres.show', $padre->id) }}"
                                   class="act-btn act-view" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('padres.edit', $padre->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del"
                                        data-route="{{ route('padres.destroy', $padre->id) }}"
                                        data-message="¿Estás seguro de eliminar a este padre/tutor?"
                                        data-name="{{ $padre->nombre }} {{ $padre->apellido }}"
                                        onclick="mostrarModalDeleteData(this)"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="pad-empty">
                                <i class="fas fa-users"></i>
                                <p>No hay padres/tutores registrados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer paginación --}}
        @if($padres->hasPages())
        <div class="pad-footer">
            <span class="pad-pages">
                Mostrando {{ $padres->firstItem() }}–{{ $padres->lastItem() }} de {{ $padres->total() }}
            </span>
            {{ $padres->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
function cambiarPerPage(valor) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', valor);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush
