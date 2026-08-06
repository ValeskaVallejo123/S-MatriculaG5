@extends('layouts.app')

@section('title', 'Perfil del Profesor')
@section('page-title', 'Perfil del Profesor')


@push('styles')
<style>
:root {
    --navy:     #003b73;
    --blue:     #00508f;
    --teal:     #4ec7d2;
    --teal-s:   rgba(78,199,210,.1);
    --border:   #e8edf4;
    --bg:       #f5f8fc;
    --text:     #0d2137;
    --muted:    #6b7a90;
    --green:    #10b981;
    --amber:    #f59e0b;
    --red:      #ef4444;
    --r:        14px;
    --shadow:   0 2px 16px rgba(0,59,115,.09);
}

.pf { width: 100%; }

/* ══ HERO ══ */
.pf-hero {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem;
    position: relative; overflow: hidden;
}
.pf-hero::after {
    content: ''; position: absolute;
    right: -50px; top: -50px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.pf-hero::before {
    content: ''; position: absolute;
    right: 100px; bottom: -45px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.pf-hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap;
}
.pf-av {
    width: 80px; height: 80px; border-radius: 18px; flex-shrink: 0;
    border: 3px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; font-weight: 800; color: white;
    box-shadow: 0 6px 20px rgba(0,0,0,.25);
}
.pf-info { flex: 1; min-width: 0; }
.pf-name {
    font-size: 1.45rem; font-weight: 800; color: white;
    margin: 0 0 .4rem; line-height: 1.2;
    text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.pf-tags { display: flex; flex-wrap: wrap; gap: .4rem; }
.pf-tag {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .65rem; border-radius: 999px;
    background: rgba(255,255,255,.14); color: rgba(255,255,255,.92);
    font-size: .72rem; font-weight: 600;
    border: 1px solid rgba(255,255,255,.18);
}
.pf-status {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .95rem; border-radius: 999px;
    font-size: .76rem; font-weight: 700; flex-shrink: 0;
}
.st-on  { background: white; color: var(--blue);  border: 2px solid var(--teal); }
.st-off { background: white; color: #dc2626;       border: 2px solid var(--red); }
.st-lic { background: white; color: #92400e;       border: 2px solid var(--amber); }
.pf-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
.dot-t { background: var(--teal); }
.dot-r { background: var(--red); }
.dot-a { background: var(--amber); }

/* ══ BODY ══ */
.pf-body {
    background: white;
    border: 1px solid var(--border); border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: var(--shadow);
}

/* ══ SECTION ══ */
.pf-sec { padding: 1.4rem 1.7rem; border-bottom: 1px solid #f0f4f9; }
.pf-sec:last-of-type { border-bottom: none; }

.pf-sec-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700; color: var(--blue);
    text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: .95rem; padding-bottom: .55rem;
    border-bottom: 2px solid var(--teal-s);
}
.pf-sec-title i { color: var(--teal); font-size: .88rem; }

/* ══ GRID ══ */
.pf-grid   { display: grid; grid-template-columns: repeat(2,1fr); gap: .7rem; }
.pf-grid-3 { grid-template-columns: repeat(3,1fr); }
@media(max-width:620px){ .pf-grid, .pf-grid-3 { grid-template-columns: 1fr; } }

/* ══ FIELD ══ */
.pf-field {
    background: var(--bg); border-radius: 10px;
    border-left: 3px solid var(--teal); padding: .68rem .9rem;
    transition: border-color .15s, box-shadow .15s;
}
.pf-field:hover { border-left-color: var(--blue); box-shadow: 0 2px 8px rgba(0,80,143,.06); }
.pf-lbl {
    font-size: .63rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted); margin-bottom: .22rem;
    display: flex; align-items: center; gap: .28rem;
}
.pf-val  { font-size: .88rem; font-weight: 600; color: var(--text); line-height: 1.4; }
.pf-val.mono {
    font-family: 'Courier New', monospace; font-size: .85rem; color: var(--blue);
    background: rgba(0,80,143,.07); padding: .15rem .45rem; border-radius: 5px; display: inline-block;
}
.pf-val.nil  { color: #c5d0dc; font-weight: 400; font-style: italic; font-size: .82rem; }
.pf-sub { font-size: .7rem; color: var(--teal); font-weight: 600; margin-top: .18rem; }

/* chip */
.chip {
    display: inline-flex; align-items: center; gap: .22rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
}
.chip-t { background: var(--teal-s); color: var(--blue); border: 1px solid rgba(78,199,210,.3); }
.chip-n { background: rgba(0,59,115,.07); color: var(--navy); border: 1px solid rgba(0,59,115,.15); }
.chip-a { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }

/* ══ FOOTER ══ */
.pf-footer {
    display: flex; gap: .6rem; flex-wrap: wrap;
    padding: 1.1rem 1.7rem;
    background: var(--bg); border-top: 1px solid var(--border);
    border-radius: 0 0 var(--r) var(--r);
}
.pf-btn {
    flex: 1; min-width: 100px;
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .6rem .75rem; border-radius: 9px;
    font-size: .83rem; font-weight: 600;
    cursor: pointer; text-decoration: none; border: none; transition: all .2s;
}
.pf-btn:hover { transform: translateY(-2px); }
.b-edit { background: linear-gradient(135deg, var(--teal), var(--blue)); color: white; box-shadow: 0 2px 10px rgba(78,199,210,.3); }
.b-edit:hover { color: white; box-shadow: 0 4px 16px rgba(78,199,210,.4); }
.b-back { background: white; color: var(--blue); border: 1.5px solid var(--blue); }
.b-back:hover { background: #eff6ff; color: var(--blue); }
.b-del  { background: white; color: var(--red); border: 1.5px solid var(--red); }
.b-del:hover  { background: #fef2f2; }
</style>
@endpush

@section('content')
<div class="pf">

    {{-- ══ HERO ══ --}}
    <div class="pf-hero">
        <div class="pf-hero-inner">

            <div class="pf-av">
                {{ strtoupper(substr($profesor->nombre ?? '', 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
            </div>

            <div class="pf-info">
                <h2 class="pf-name">{{ $profesor->nombre_completo }}</h2>
                <div class="pf-tags">
                    @if($profesor->especialidad)
                        <span class="pf-tag"><i class="fas fa-book"></i> {{ $profesor->especialidad }}</span>
                    @endif
                    @if($profesor->dni)
                        <span class="pf-tag"><i class="fas fa-id-card"></i> {{ $profesor->dni }}</span>
                    @endif
                    @if($profesor->tipo_contrato)
                        <span class="pf-tag"><i class="fas fa-file-contract"></i> {{ ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) }}</span>
                    @endif
                    @if($profesor->fecha_contratacion)
                        <span class="pf-tag"><i class="fas fa-calendar-check"></i> {{ \Carbon\Carbon::parse($profesor->fecha_contratacion)->diffForHumans() }}</span>
                    @endif
                </div>
            </div>

            @if($profesor->estado === 'activo')
                <span class="pf-status st-on"><span class="pf-dot dot-t"></span> Activo</span>
            @elseif($profesor->estado === 'licencia')
                <span class="pf-status st-lic"><span class="pf-dot dot-a"></span> Licencia</span>
            @else
                <span class="pf-status st-off"><span class="pf-dot dot-r"></span> Inactivo</span>
            @endif

        </div>
    </div>

    {{-- ══ BODY ══ --}}
    <div class="pf-body">

        {{-- Personal --}}
        <div class="pf-sec">
            <div class="pf-sec-title"><i class="fas fa-user"></i> Información Personal</div>
            <div class="pf-grid">
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-font"></i> Nombre</div>
                    <div class="pf-val">{{ $profesor->nombre ?: '—' }}</div>
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-font"></i> Apellido</div>
                    <div class="pf-val">{{ $profesor->apellido ?: '—' }}</div>
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-id-card"></i> DNI</div>
                    <div class="pf-val mono">{{ $profesor->dni ?: '—' }}</div>
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-calendar"></i> Fecha de Nacimiento</div>
                    @if($profesor->fecha_nacimiento)
                        <div class="pf-val">{{ \Carbon\Carbon::parse($profesor->fecha_nacimiento)->format('d/m/Y') }}</div>
                        <div class="pf-sub">{{ \Carbon\Carbon::parse($profesor->fecha_nacimiento)->age }} años</div>
                    @else
                        <div class="pf-val nil">No registrada</div>
                    @endif
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-venus-mars"></i> Género</div>
                    <div class="pf-val {{ !$profesor->genero ? 'nil' : '' }}">
                        {{ $profesor->genero ? ucfirst($profesor->genero) : 'No registrado' }}
                    </div>
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-phone"></i> Teléfono</div>
                    <div class="pf-val {{ !$profesor->telefono ? 'nil' : '' }}">
                        {{ $profesor->telefono ?: 'No registrado' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Contacto --}}
        <div class="pf-sec">
            <div class="pf-sec-title"><i class="fas fa-address-book"></i> Contacto</div>
            <div class="pf-grid">
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-envelope"></i> Email</div>
                    <div class="pf-val {{ !$profesor->email ? 'nil' : '' }}">{{ $profesor->email ?: 'No registrado' }}</div>
                </div>
                <div class="pf-field" style="grid-column:span 1;">
                    <div class="pf-lbl"><i class="fas fa-map-marker-alt"></i> Dirección</div>
                    <div class="pf-val {{ !$profesor->direccion ? 'nil' : '' }}">{{ $profesor->direccion ?: 'No registrada' }}</div>
                </div>
            </div>
        </div>

        {{-- Académico --}}
        <div class="pf-sec">
            <div class="pf-sec-title"><i class="fas fa-graduation-cap"></i> Información Académica</div>
            <div class="pf-grid">
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-book"></i> Especialidad</div>
                    <div class="pf-val">
                        @if($profesor->especialidad)
                            <span class="chip chip-t"><i class="fas fa-book" style="font-size:.6rem;"></i> {{ $profesor->especialidad }}</span>
                        @else
                            <span class="pf-val nil">No especificada</span>
                        @endif
                    </div>
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-university"></i> Nivel Académico</div>
                    <div class="pf-val {{ !$profesor->nivel_academico ? 'nil' : '' }}">
                        {{ $profesor->nivel_academico ? ucfirst($profesor->nivel_academico) : 'No especificado' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Laboral --}}
        <div class="pf-sec">
            <div class="pf-sec-title"><i class="fas fa-briefcase"></i> Información Laboral</div>
            <div class="pf-grid pf-grid-3">
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-calendar-plus"></i> Fecha Contratación</div>
                    @if($profesor->fecha_contratacion)
                        <div class="pf-val">{{ \Carbon\Carbon::parse($profesor->fecha_contratacion)->format('d/m/Y') }}</div>
                        <div class="pf-sub">{{ \Carbon\Carbon::parse($profesor->fecha_contratacion)->diffForHumans() }}</div>
                    @else
                        <div class="pf-val nil">No registrada</div>
                    @endif
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-file-contract"></i> Tipo de Contrato</div>
                    <div class="pf-val">
                        @if($profesor->tipo_contrato)
                            @php
                                $tc = $profesor->tipo_contrato;
                                $chipClass = match($tc) {
                                    'tiempo_completo' => 'chip-t',
                                    'medio_tiempo'    => 'chip-n',
                                    'por_horas'       => 'chip-a',
                                    default           => 'chip-n',
                                };
                            @endphp
                            <span class="chip {{ $chipClass }}">{{ ucwords(str_replace('_', ' ', $tc)) }}</span>
                        @else
                            <span class="pf-val nil">No especificado</span>
                        @endif
                    </div>
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-toggle-on"></i> Estado</div>
                    <div class="pf-val">
                        @if($profesor->estado === 'activo')
                            <span class="pf-status st-on" style="font-size:.7rem;padding:.2rem .7rem;">
                                <span class="pf-dot dot-t"></span> Activo
                            </span>
                        @elseif($profesor->estado === 'licencia')
                            <span class="pf-status st-lic" style="font-size:.7rem;padding:.2rem .7rem;">
                                <span class="pf-dot dot-a"></span> Licencia
                            </span>
                        @else
                            <span class="pf-status st-off" style="font-size:.7rem;padding:.2rem .7rem;">
                                <span class="pf-dot dot-r"></span> Inactivo
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Sistema --}}
        <div class="pf-sec">
            <div class="pf-sec-title"><i class="fas fa-database"></i> Datos del Sistema</div>
            <div class="pf-grid">
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-calendar-plus"></i> Fecha de Registro</div>
                    <div class="pf-val">{{ $profesor->created_at?->format('d/m/Y H:i') ?? '—' }}</div>
                </div>
                <div class="pf-field">
                    <div class="pf-lbl"><i class="fas fa-sync-alt"></i> Última Actualización</div>
                    <div class="pf-val">{{ $profesor->updated_at?->format('d/m/Y H:i') ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="pf-footer">
            <a href="{{ route('profesores.edit', $profesor->id) }}" class="pf-btn b-edit">
                <i class="fas fa-pen"></i> Editar
            </a>
            <button type="button" onclick="confirmDelete()" class="pf-btn b-del">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>

    </div>{{-- /pf-body --}}
</div>{{-- /pf --}}

<form id="delete-form" action="{{ route('profesores.destroy', $profesor->id) }}" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

{{-- Modal eliminar --}}
<div id="deleteModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" style="border-radius:14px;border:none;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.15);">

            <div class="modal-header border-0" style="background:rgba(239,68,68,.07);padding:1.2rem 1.4rem;">
                <div style="display:flex;align-items:center;gap:.75rem;">
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
                <p style="color:var(--text);font-size:.87rem;margin:0 0 .4rem;">
                    ¿Estás seguro de eliminar al profesor
                    <strong style="color:var(--red);">{{ e($profesor->nombre_completo) }}</strong>?
                </p>
                <p style="font-size:.78rem;color:var(--muted);margin:0;">
                    Se perderán todos los datos asociados permanentemente.
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
                    <i class="fas fa-trash"></i> Sí, Eliminar
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let deleteModal;
document.addEventListener('DOMContentLoaded', () => {
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
});
function confirmDelete() { deleteModal.show(); }
function submitDelete()  { document.getElementById('delete-form').submit(); }
</script>
@endpush
