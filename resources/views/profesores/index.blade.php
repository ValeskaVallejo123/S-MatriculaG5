@extends('layouts.app')

@section('title', 'Profesores')
@section('page-title', 'Gestión de Profesores')

@section('topbar-actions')
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        <a href="{{ url()->previous() }}"
           style="background:white;color:#00508f;padding:.45rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:.5rem;font-size:.88rem;border:1.5px solid #00508f;transition:all .2s;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <a href="{{ route('profesores.create') }}"
           style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;padding:.45rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:.5rem;font-size:.88rem;box-shadow:0 2px 8px rgba(78,199,210,.3);">
            <i class="fas fa-plus"></i> Agregar Nuevo Profesor
        </a>
    </div>
@endsection

@push('styles')
<style>
:root {
    --navy:     #003b73;
    --blue:     #00508f;
    --teal:     #4ec7d2;
    --teal-s:   rgba(78,199,210,.11);
    --border:   #e8edf4;
    --bg:       #f5f8fc;
    --text:     #0d2137;
    --muted:    #6b7a90;
    --green:    #10b981;
    --amber:    #f59e0b;
    --red:      #ef4444;
    --r:        12px;
    --shadow:   0 1px 6px rgba(0,59,115,.07);
}

/* ══ STATS ══ */
.pr-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: .85rem; margin-bottom: 1.25rem;
}
@media(max-width:900px){ .pr-stats { grid-template-columns:repeat(2,1fr); } }
@media(max-width:500px){ .pr-stats { grid-template-columns:1fr 1fr; gap:.6rem; } }

.pr-stat {
    background: white; border-radius: var(--r);
    border: 1px solid var(--border);
    padding: 1rem 1.1rem;
    display: flex; align-items: center; gap: .85rem;
    box-shadow: var(--shadow);
    transition: transform .2s, box-shadow .2s;
    position: relative; overflow: hidden;
}
.pr-stat::before {
    content: ''; position: absolute;
    top: 0; left: 0; width: 4px; height: 100%;
    border-radius: 4px 0 0 4px;
}
.pr-stat-total::before   { background: var(--blue); }
.pr-stat-active::before  { background: var(--teal); }
.pr-stat-inactive::before { background: var(--amber); }
.pr-stat-license::before { background: var(--green); }
.pr-stat:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,59,115,.1); }

.pr-stat-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.05rem;
}
.pr-stat-total   .pr-stat-icon { background: rgba(0,80,143,.1);   color: var(--blue); }
.pr-stat-active  .pr-stat-icon { background: var(--teal-s);       color: var(--teal); }
.pr-stat-inactive .pr-stat-icon { background: rgba(245,158,11,.1); color: var(--amber); }
.pr-stat-license .pr-stat-icon { background: rgba(16,185,129,.1); color: var(--green); }

.pr-stat-lbl {
    font-size: .65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--muted); margin-bottom: .15rem;
}
.pr-stat-num { font-size: 1.65rem; font-weight: 800; color: var(--navy); line-height: 1; }
.pr-stat-sub { font-size: .7rem; color: var(--muted); margin-top: .1rem; }

/* ══ TOOLBAR ══ */
.pr-toolbar {
    background: white; border: 1px solid var(--border);
    border-radius: var(--r); padding: .85rem 1.2rem;
    margin-bottom: 1.1rem; display: flex;
    align-items: center; gap: 1rem; flex-wrap: wrap;
    box-shadow: var(--shadow);
}
.pr-search-form { display: flex; align-items: center; gap: .5rem; flex: 1; min-width: 220px; }
.pr-search-wrap { position: relative; flex: 1; }
.pr-search-wrap i {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    color: var(--blue); font-size: .82rem;
}
.pr-search {
    width: 100%; padding: .48rem 1rem .48rem 2.3rem;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .83rem; background: var(--bg);
    outline: none; font-family: inherit; color: var(--text);
    transition: border-color .2s, box-shadow .2s;
}
.pr-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

.pr-btn-sm {
    display: inline-flex; align-items: center; justify-content: center;
    padding: .42rem .85rem; border-radius: 7px;
    font-size: .8rem; font-weight: 600; cursor: pointer; border: 1.5px solid;
    transition: all .15s; white-space: nowrap; text-decoration: none; background: white;
}
.pr-btn-teal { border-color: var(--teal); color: var(--teal); }
.pr-btn-teal:hover { background: var(--teal); color: white; }
.pr-btn-red  { border-color: var(--red); color: var(--red); }
.pr-btn-red:hover  { background: var(--red); color: white; }

.pr-result-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .18rem .65rem; border-radius: 999px;
    font-size: .72rem; font-weight: 600;
    background: var(--teal-s); color: var(--blue);
    border: 1px solid rgba(78,199,210,.35);
}

/* ══ CARD HEADER ══ */
.pr-card-hd {
    background: linear-gradient(135deg, var(--navy), var(--blue));
    border-radius: var(--r) var(--r) 0 0;
    padding: .8rem 1.3rem;
    display: flex; align-items: center; gap: .55rem;
}
.pr-card-hd i    { color: var(--teal); font-size: .95rem; }
.pr-card-hd span { color: white; font-weight: 700; font-size: .9rem; }

/* ══ LISTA DE PROFESORES ══ */
.pr-list {
    background: white; border: 1px solid var(--border);
    border-top: none; border-radius: 0 0 var(--r) var(--r);
    box-shadow: var(--shadow); overflow: hidden;
}

.pr-row {
    display: flex; align-items: center; gap: 1rem;
    padding: .85rem 1.3rem;
    border-bottom: 1px solid #f0f4f9;
    transition: background .15s;
}
.pr-row:last-child { border-bottom: none; }
.pr-row:hover { background: #f7fbff; }

/* Avatar */
.pr-av {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--blue), var(--navy));
    border: 2px solid rgba(78,199,210,.4);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; color: white; font-size: 1rem;
}

/* Info */
.pr-name  { font-weight: 700; color: var(--navy); font-size: .9rem; line-height: 1.3; }
.pr-email { font-size: .75rem; color: var(--muted); margin-top: .1rem; }
.pr-dni   { font-size: .73rem; color: var(--muted); display: flex; align-items: center; gap: .25rem; }

/* Chips especialidad/contrato */
.pr-chip {
    display: inline-flex; align-items: center; gap: .22rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .69rem; font-weight: 600; white-space: nowrap;
}
.chip-teal { background: var(--teal-s); color: var(--blue); border:1px solid rgba(78,199,210,.3); }
.chip-navy { background: rgba(0,59,115,.07); color: var(--navy); border:1px solid rgba(0,59,115,.2); }

/* Estado */
.pr-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .7rem; font-weight: 700; white-space: nowrap;
}
.b-activo   { background: var(--teal-s); color: var(--blue); border:1px solid rgba(78,199,210,.4); }
.b-licencia { background: rgba(245,158,11,.12); color: #92400e; border:1px solid rgba(245,158,11,.35); }
.b-inactivo { background: #fee2e2; color: #991b1b; border:1px solid #fca5a5; }
.pr-dot { width:6px; height:6px; border-radius:50%; display:inline-block; flex-shrink:0; }
.dot-teal  { background: var(--teal); }
.dot-amber { background: var(--amber); }
.dot-red   { background: var(--red); }

/* Botones acción */
.act-btn {
    width: 31px; height: 31px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid; font-size: .78rem; background: white;
    cursor: pointer; transition: all .15s; text-decoration: none;
}
.act-view { border-color: var(--blue); color: var(--blue); }
.act-edit { border-color: var(--teal); color: var(--teal); }
.act-del  { border-color: var(--red);  color: var(--red); }
.act-view:hover { background: var(--blue); color: white; transform: translateY(-1px); }
.act-edit:hover { background: var(--teal); color: white; transform: translateY(-1px); }
.act-del:hover  { background: var(--red);  color: white; transform: translateY(-1px); }

/* Empty */
.pr-empty {
    padding: 3.5rem 1rem; text-align: center;
}
.pr-empty i { font-size: 2.5rem; color: #c5d0dc; display: block; margin-bottom: .85rem; }
.pr-empty h6 { color: var(--navy); font-weight: 700; margin-bottom: .35rem; }
.pr-empty p  { font-size: .83rem; color: var(--muted); margin-bottom: 1rem; }

/* Footer paginación */
.pr-footer {
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    padding: .8rem 1.3rem;
    background: var(--bg); border-top: 1px solid var(--border);
    border-radius: 0 0 var(--r) var(--r);
    font-size: .78rem; color: var(--muted);
}
.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 7px; margin: 0 2px;
    border: 1.5px solid var(--border);
    color: var(--blue); padding: .28rem .6rem; font-size: .8rem;
    transition: all .15s;
}
.pagination .page-link:hover { background: var(--teal-s); border-color: var(--teal); color: var(--navy); }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--teal), var(--blue));
    border-color: var(--teal); color: white;
    box-shadow: 0 2px 6px rgba(78,199,210,.35);
}
</style>
@endpush

@section('content')
<div>

    {{-- ══ STATS ══ --}}
    <div class="pr-stats">
        <div class="pr-stat pr-stat-total">
            <div class="pr-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="pr-stat-lbl">Total</div>
                <div class="pr-stat-num">{{ $profesores->total() }}</div>
                <div class="pr-stat-sub">Profesores</div>
            </div>
        </div>
        <div class="pr-stat pr-stat-active">
            <div class="pr-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="pr-stat-lbl">Activos</div>
                <div class="pr-stat-num">{{ $profesores->getCollection()->where('estado','activo')->count() }}</div>
                <div class="pr-stat-sub">En servicio</div>
            </div>
        </div>
        <div class="pr-stat pr-stat-inactive">
            <div class="pr-stat-icon"><i class="fas fa-user-slash"></i></div>
            <div>
                <div class="pr-stat-lbl">Inactivos</div>
                <div class="pr-stat-num">{{ $profesores->getCollection()->where('estado','inactivo')->count() }}</div>
                <div class="pr-stat-sub">Suspendidos</div>
            </div>
        </div>
        <div class="pr-stat pr-stat-license">
            <div class="pr-stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <div class="pr-stat-lbl">En Licencia</div>
                <div class="pr-stat-num">{{ $profesores->getCollection()->where('estado','licencia')->count() }}</div>
                <div class="pr-stat-sub">Temporal</div>
            </div>
        </div>
    </div>

    {{-- ══ TOOLBAR ══ --}}
    <div class="pr-toolbar">
        <form action="{{ route('profesores.index') }}" method="GET" class="pr-search-form">
            <div class="pr-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                       class="pr-search" placeholder="Buscar por nombre, DNI, email...">
            </div>
            <button type="submit" class="pr-btn-sm pr-btn-teal">
                <i class="fas fa-search"></i>
            </button>
            @if(request('busqueda'))
                <a href="{{ route('profesores.index') }}" class="pr-btn-sm pr-btn-red">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>

        @if(request('busqueda'))
            <div style="font-size:.8rem;color:var(--muted);">
                @if($profesores->total() > 0)
                    <span>{{ $profesores->total() }} resultado(s) para</span>
                    <span class="pr-result-badge">{{ request('busqueda') }}</span>
                @else
                    <span style="color:var(--red);"><i class="fas fa-exclamation-circle me-1"></i>Sin resultados para "<strong>{{ request('busqueda') }}</strong>"</span>
                @endif
            </div>
        @endif
    </div>

    {{-- ══ LISTA ══ --}}
    <div class="pr-card-hd">
        <i class="fas fa-list-ul"></i>
        <span>Lista de Profesores</span>
    </div>

    <div class="pr-list">
        @forelse($profesores as $profesor)
        <div class="pr-row">

            {{-- Avatar --}}
            <div class="pr-av">
                {{ strtoupper(substr($profesor->nombre ?? '', 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
            </div>

            {{-- Nombre + contacto --}}
            <div style="flex:2;min-width:0;">
                <div class="pr-name">{{ $profesor->nombre_completo }}</div>
                <div style="display:flex;flex-wrap:wrap;gap:.4rem;align-items:center;margin-top:.15rem;">
                    @if($profesor->email)
                        <span class="pr-email"><i class="fas fa-envelope" style="font-size:.63rem;opacity:.55;"></i> {{ $profesor->email }}</span>
                    @endif
                    @if($profesor->dni)
                        <span class="pr-dni"><i class="fas fa-id-card" style="font-size:.63rem;opacity:.55;"></i> {{ $profesor->dni }}</span>
                    @endif
                </div>
            </div>

            {{-- Especialidad --}}
            <div style="flex:1;min-width:110px;">
                <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);margin-bottom:.25rem;">Especialidad</div>
                @if($profesor->especialidad)
                    <span class="pr-chip chip-teal"><i class="fas fa-book" style="font-size:.6rem;"></i> {{ $profesor->especialidad }}</span>
                @else
                    <span style="font-size:.78rem;color:#c5d0dc;font-style:italic;">—</span>
                @endif
            </div>

            {{-- Contrato --}}
            <div style="flex:1;min-width:100px;">
                <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);margin-bottom:.25rem;">Contrato</div>
                @if($profesor->tipo_contrato)
                    <span class="pr-chip chip-navy"><i class="fas fa-file-contract" style="font-size:.6rem;"></i> {{ ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) }}</span>
                @else
                    <span style="font-size:.78rem;color:#c5d0dc;font-style:italic;">—</span>
                @endif
            </div>

            {{-- Estado --}}
            <div style="flex-shrink:0;">
                @if($profesor->estado === 'activo')
                    <span class="pr-badge b-activo"><span class="pr-dot dot-teal"></span> Activo</span>
                @elseif($profesor->estado === 'licencia')
                    <span class="pr-badge b-licencia"><span class="pr-dot dot-amber"></span> Licencia</span>
                @else
                    <span class="pr-badge b-inactivo"><span class="pr-dot dot-red"></span> Inactivo</span>
                @endif
            </div>

            {{-- Solo botón Ver --}}
            <div style="flex-shrink:0;">
                <a href="{{ route('profesores.show', $profesor->id) }}" class="act-btn act-view" title="Ver detalle">
                    <i class="fas fa-eye"></i>
                </a>
            </div>

        </div>
        @empty
        <div class="pr-empty">
            @if(request('busqueda'))
                <i class="fas fa-search"></i>
                <h6>Sin resultados</h6>
                <p>No se encontró ningún profesor con "<strong>{{ request('busqueda') }}</strong>"</p>
                <div style="display:flex;gap:.5rem;justify-content:center;">
                    <a href="{{ route('profesores.index') }}" class="pr-btn-sm pr-btn-teal">
                        <i class="fas fa-list me-1"></i> Ver todos
                    </a>
                </div>
            @else
                <i class="fas fa-chalkboard-teacher"></i>
                <h6>No hay profesores registrados</h6>
                <p>Comienza agregando el primer profesor al sistema</p>
                <a href="{{ route('profesores.create') }}"
                   style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.2rem;background:linear-gradient(135deg,var(--teal),var(--blue));color:white;border-radius:9px;text-decoration:none;font-weight:600;font-size:.83rem;box-shadow:0 2px 8px rgba(78,199,210,.3);">
                    <i class="fas fa-plus"></i> Nuevo Profesor
                </a>
            @endif
        </div>
        @endforelse

        {{-- Paginación --}}
        @if($profesores->hasPages())
        <div class="pr-footer">
            <span>Mostrando {{ $profesores->firstItem() }}–{{ $profesores->lastItem() }} de {{ $profesores->total() }}</span>
            {{ $profesores->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ══ MODAL ELIMINAR ══ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" style="border-radius:14px;border:none;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.15);">

            <div class="modal-header border-0" style="background:rgba(239,68,68,.07);padding:1.2rem 1.4rem;">
                <div style="display:flex;align-items:center;gap:.7rem;">
                    <div style="width:42px;height:42px;background:rgba(239,68,68,.15);border-radius:10px;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold" style="color:var(--navy);font-size:.93rem;">Confirmar Eliminación</h6>
                        <p class="mb-0 small" style="color:var(--muted);">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="padding:1.2rem 1.4rem;">
                <p style="color:var(--text);font-size:.87rem;margin:0;">
                    ¿Estás seguro de eliminar al profesor
                    <strong id="profesorNombre" style="color:var(--red);"></strong>?
                </p>
                <p class="mt-2 mb-0" style="font-size:.78rem;color:var(--muted);">
                    Se perderán todos los datos asociados a este profesor.
                </p>
            </div>

            <div class="modal-footer border-0" style="background:var(--bg);padding:.85rem 1.4rem;gap:.5rem;">
                <button type="button" data-bs-dismiss="modal"
                        style="padding:.42rem 1.1rem;border-radius:9px;border:1.5px solid var(--blue);
                               background:white;color:var(--blue);font-size:.82rem;font-weight:600;cursor:pointer;">
                    Cancelar
                </button>
                <button type="button" onclick="submitDelete()"
                        style="padding:.42rem 1.25rem;border-radius:9px;border:none;cursor:pointer;
                               background:linear-gradient(135deg,#ef4444,#dc2626);color:white;
                               font-size:.82rem;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;
                               box-shadow:0 2px 10px rgba(239,68,68,.3);">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let deleteFormId = '';

function confirmDelete(id, nombre) {
    deleteFormId = 'delete-form-' + id;
    document.getElementById('profesorNombre').textContent = nombre;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function submitDelete() {
    if (deleteFormId) document.getElementById(deleteFormId).submit();
}
</script>
@endpush
