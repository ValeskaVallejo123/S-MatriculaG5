@extends('layouts.app')

@section('title', 'Buscar Padre/Tutor')
@section('page-title', 'Vincular Padre con Estudiante')

@section('topbar-actions')
    <a href="{{ route('padres.create') }}"
       style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;padding:.45rem 1.1rem;
              border-radius:8px;font-weight:600;font-size:.85rem;border:none;text-decoration:none;
              display:inline-flex;align-items:center;gap:.4rem;">
        <i class="fas fa-plus"></i> Nuevo Padre/Tutor
    </a>
@endsection

@push('styles')
<style>
.buscar-wrap { font-family: 'Inter', sans-serif; }

.b-card {
    background: white; border: 1px solid #e2e8f0;
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,59,115,.06);
    margin-bottom: 1.25rem;
}
.b-card-head {
    background: #f8fafc; padding: .75rem 1.25rem;
    border-bottom: 1px solid #e8eef5;
    display: flex; align-items: center; gap: .55rem;
}
.b-card-head i { color: #4ec7d2; font-size: .9rem; }
.b-card-head span { font-size: .72rem; font-weight: 700; text-transform: uppercase;
                    letter-spacing: .07em; color: #00508f; }
.b-card-body { padding: 1.25rem; }

.est-banner {
    display: flex; align-items: center; gap: 1rem;
    padding: .85rem 1.25rem;
    background: linear-gradient(135deg, #003b73, #00508f);
    border-radius: 12px; margin-bottom: 1.25rem;
}
.est-av {
    width: 44px; height: 44px; border-radius: 11px; flex-shrink: 0;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 1.1rem;
    border: 2px solid rgba(78,199,210,.5);
}
.est-label { font-size: .68rem; color: rgba(255,255,255,.7); font-weight: 600;
             text-transform: uppercase; letter-spacing: .06em; margin-bottom: .15rem; }
.est-name  { font-size: .95rem; font-weight: 700; color: white; line-height: 1.3; }
.est-meta  { font-size: .75rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.b-label {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #003b73; margin-bottom: .35rem;
    display: flex; align-items: center; gap: .3rem;
}
.b-input {
    width: 100%; padding: .5rem .85rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .875rem; outline: none; transition: border-color .2s;
    background: white; color: #1e293b;
}
.b-input:focus { border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12); }
.b-input::placeholder { color: #94a3b8; }

.btn-buscar {
    background: linear-gradient(135deg,#4ec7d2,#00508f); color: white; border: none;
    padding: .5rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: .875rem;
    display: inline-flex; align-items: center; gap: .4rem; cursor: pointer; transition: opacity .15s;
}
.btn-buscar:hover { opacity: .9; }
.btn-cancelar {
    color: #64748b; background: white; border: 1.5px solid #e2e8f0;
    padding: .5rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: .875rem;
    display: inline-flex; align-items: center; gap: .4rem; text-decoration: none; transition: all .15s;
}
.btn-cancelar:hover { background: #f8fafc; color: #374151; }

.res-badge {
    display: inline-flex; align-items: center;
    padding: .2rem .7rem; border-radius: 999px;
    background: rgba(78,199,210,.12); color: #00508f;
    font-size: .72rem; font-weight: 700; border: 1px solid rgba(78,199,210,.3);
}

.parent-row {
    display: flex; align-items: center; gap: 1rem;
    padding: .85rem 1rem;
    border: 1px solid #e8eef5; border-radius: 10px;
    margin-bottom: .65rem; transition: all .15s;
    background: white;
}
.parent-row:last-child { margin-bottom: 0; }
.parent-row:hover { border-color: #4ec7d2; box-shadow: 0 2px 8px rgba(78,199,210,.1); }

.parent-av {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: white; font-size: .95rem;
}
.parent-name { font-size: .87rem; font-weight: 700; color: #0f172a; }
.parent-sub  { display: flex; flex-wrap: wrap; gap: .35rem; margin-top: .25rem; }
.parent-pill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .15rem .55rem; border-radius: 999px; font-size: .68rem; font-weight: 600;
    background: rgba(78,199,210,.1); color: #00508f; border: 1px solid rgba(78,199,210,.25);
}
.parent-contact { font-size: .73rem; color: #64748b; display: flex; align-items: center; gap: .25rem; }

.btn-vincular {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .38rem .9rem; border-radius: 7px; font-size: .78rem; font-weight: 600;
    background: linear-gradient(135deg,#10b981,#059669); color: white; border: none;
    cursor: pointer; white-space: nowrap; flex-shrink: 0; transition: opacity .15s;
}
.btn-vincular:hover { opacity: .9; }

.initial-hint {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1rem;
    background: #f8fafc; border: 1.5px dashed #e2e8f0; border-radius: 10px;
    font-size: .83rem; color: #94a3b8;
}
.initial-hint i { color: #cbd5e1; font-size: 1rem; flex-shrink: 0; }

.no-results {
    display: flex; align-items: center; gap: .75rem;
    padding: .85rem 1rem;
    background: #f8fafc; border: 1.5px dashed #e2e8f0; border-radius: 10px;
    justify-content: space-between;
}
.no-results-left { display: flex; align-items: center; gap: .65rem; }
.no-results-left i { color: #cbd5e1; font-size: 1rem; }
.no-results-left span { font-size: .83rem; color: #94a3b8; font-weight: 500; }

/* Modal */
.modal-vincular-overlay {
    position: fixed; inset: 0;
    background: rgba(0,45,90,.55); backdrop-filter: blur(4px);
    display: none; align-items: center; justify-content: center; z-index: 9999;
}
.modal-vincular-overlay.show { display: flex; }
.modal-vincular {
    background: white; border-radius: 16px; width: 90%; max-width: 420px;
    box-shadow: 0 24px 60px rgba(0,45,90,.3); overflow: hidden;
    animation: sysModalIn .18s ease;
}
@keyframes sysModalIn { from { opacity:0; transform:scale(.95) } to { opacity:1; transform:scale(1) } }

.modal-head {
    background: linear-gradient(135deg,#003b73,#00508f);
    padding: 1.1rem 1.4rem;
    display: flex; align-items: center; justify-content: space-between;
}
.modal-head-left { display: flex; align-items: center; gap: .75rem; }
.modal-head-icon {
    width: 38px; height: 38px; background: rgba(78,199,210,.25);
    border-radius: 9px; display: flex; align-items: center; justify-content: center;
}
.modal-head-icon i { color: #4ec7d2; font-size: .95rem; }
.modal-head-title { font-size: .95rem; font-weight: 700; color: white; }
.modal-head-sub   { font-size: .65rem; color: #4ec7d2; font-weight: 700;
                    text-transform: uppercase; letter-spacing: .07em; }
.modal-close {
    width: 30px; height: 30px; background: rgba(255,255,255,.15); border: none;
    border-radius: 7px; color: white; cursor: pointer; font-size: .9rem;
    display: flex; align-items: center; justify-content: center;
}

.modal-body { padding: 1.4rem; }
.modal-preview {
    background: #f8fafc; border-radius: 10px; padding: .85rem;
    margin-bottom: 1rem; border: 1px solid #e8eef5;
}
.modal-preview-item {
    display: flex; align-items: center; gap: .65rem;
    padding: .55rem .7rem; background: white; border-radius: 8px;
    margin-bottom: .45rem; font-size: .83rem; font-weight: 600; color: #0f172a;
    border: 1px solid #f1f5f9;
}
.modal-preview-item:last-child { margin-bottom: 0; }
.modal-preview-item i {
    width: 30px; height: 30px; border-radius: 7px; flex-shrink: 0;
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: .75rem;
}
.modal-preview-sep { text-align: center; color: #4ec7d2; font-size: .75rem; margin: .3rem 0; }
.modal-msg { font-size: .82rem; color: #64748b; text-align: center; margin-bottom: 0; }

.modal-footer { padding: .9rem 1.4rem 1.4rem; display: flex; gap: .65rem; }
.modal-btn {
    flex: 1; padding: .55rem; border-radius: 9px; font-size: .83rem;
    font-weight: 600; cursor: pointer; border: none;
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
}
.modal-btn-cancel { background: #f1f5f9; color: #64748b; border: 1.5px solid #e2e8f0; }
.modal-btn-cancel:hover { background: #e2e8f0; }
.modal-btn-confirm {
    background: linear-gradient(135deg,#4ec7d2,#00508f); color: white;
    box-shadow: 0 2px 8px rgba(78,199,210,.3);
}
.modal-btn-confirm:hover { opacity: .9; }
</style>
@endpush

@section('content')
<div class="buscar-wrap container-fluid px-4">

    {{-- Banner estudiante --}}
    @if(isset($estudiante) && $estudiante)
    <div class="est-banner">
        <div class="est-av"><i class="fas fa-user-graduate"></i></div>
        <div>
            <div class="est-label">Vincular padre/tutor para</div>
            <div class="est-name">{{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}</div>
            <div class="est-meta">
                <i class="fas fa-graduation-cap me-1"></i>{{ $estudiante->grado }} &nbsp;·&nbsp;
                <i class="fas fa-id-badge me-1"></i>ID: {{ $estudiante->id }}
            </div>
        </div>
    </div>
    @endif

    {{-- Formulario --}}
    <div class="b-card">
        <div class="b-card-head">
            <i class="fas fa-search"></i>
            <span>Búsqueda</span>
        </div>
        <div class="b-card-body">
            <form action="{{ route('padres.buscar') }}" method="GET">
                @if(isset($estudiante) && $estudiante)
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                @endif
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="b-label"><i class="fas fa-user"></i> Nombre o Apellido</div>
                        <input type="text" name="nombre" class="b-input"
                               placeholder="Ej: Juan Pérez" value="{{ request('nombre') }}">
                    </div>
                    <div class="col-md-4">
                        <div class="b-label"><i class="fas fa-id-card"></i> DNI / Identidad</div>
                        <input type="text" name="dni" class="b-input"
                               placeholder="Ej: 0801-1990-12345" value="{{ request('dni') }}">
                    </div>
                    <div class="col-md-4">
                        <div class="b-label"><i class="fas fa-phone"></i> Teléfono</div>
                        <input type="text" name="telefono" class="b-input"
                               placeholder="Ej: 9999-9999" value="{{ request('telefono') }}">
                    </div>
                </div>
                <div style="display:flex;gap:.65rem;flex-wrap:wrap;">
                    <button type="submit" class="btn-buscar">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ isset($estudiante) ? route('estudiantes.show', $estudiante->id) : route('padres.index') }}"
                       class="btn-cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Resultados --}}
    @if(request()->anyFilled(['nombre', 'dni', 'telefono']))
        <div class="b-card">
            <div class="b-card-head" style="justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:.55rem;">
                    <i class="fas fa-list"></i>
                    <span>Resultados</span>
                </div>
                <span class="res-badge">{{ $padres->count() }} {{ $padres->count() == 1 ? 'encontrado' : 'encontrados' }}</span>
            </div>
            <div class="b-card-body">
                @if($padres->count() > 0)
                    @foreach($padres as $padre)
                    <div class="parent-row">
                        <div class="parent-av">
                            {{ strtoupper(substr($padre->nombre, 0, 1)) }}{{ strtoupper(substr($padre->apellido, 0, 1)) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="parent-name">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                            <div class="parent-sub">
                                <span class="parent-pill"><i class="fas fa-user-tag"></i> {{ ucfirst($padre->parentesco ?? '—') }}</span>
                                @if($padre->dni)
                                    <span class="parent-contact"><i class="fas fa-id-card"></i> {{ $padre->dni }}</span>
                                @endif
                                @if($padre->telefono)
                                    <span class="parent-contact"><i class="fas fa-phone"></i> {{ $padre->telefono }}</span>
                                @endif
                                @if($padre->correo)
                                    <span class="parent-contact"><i class="fas fa-envelope"></i> {{ $padre->correo }}</span>
                                @endif
                            </div>
                        </div>
                        @if(isset($estudiante) && $estudiante)
                            <button type="button" class="btn-vincular"
                                    onclick="abrirModal({{ $padre->id }}, '{{ addslashes($padre->nombre . ' ' . $padre->apellido) }}', {{ $estudiante->id }}, '{{ addslashes($estudiante->nombre1 . ' ' . $estudiante->apellido1) }}')">
                                <i class="fas fa-link"></i> Vincular
                            </button>
                        @else
                            <a href="{{ route('padres.show', $padre->id) }}"
                               style="display:inline-flex;align-items:center;gap:.35rem;padding:.38rem .9rem;
                                      border-radius:7px;font-size:.78rem;font-weight:600;text-decoration:none;
                                      background:#e8f4fb;color:#00508f;border:1px solid #bfd9ea;
                                      white-space:nowrap;flex-shrink:0;">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @endif
                    </div>
                    @endforeach
                @else
                    <div class="no-results">
                        <div class="no-results-left">
                            <i class="fas fa-search"></i>
                            <span>No se encontraron padres/tutores con esos criterios</span>
                        </div>
                        <a href="{{ route('padres.create') }}"
                           style="display:inline-flex;align-items:center;gap:.35rem;padding:.38rem .9rem;
                                  background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
                                  border-radius:7px;text-decoration:none;font-weight:600;font-size:.78rem;
                                  white-space:nowrap;flex-shrink:0;">
                            <i class="fas fa-plus"></i> Registrar nuevo
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="initial-hint">
            <i class="fas fa-search"></i>
            <span>Ingresa al menos un criterio para buscar padres o tutores registrados en el sistema.</span>
        </div>
    @endif

</div>

{{-- Modal --}}
<div class="modal-vincular-overlay" id="modalVincular"
     onclick="if(event.target===this)cerrarModal()">
    <div class="modal-vincular">
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-head-icon"><i class="fas fa-link"></i></div>
                <div>
                    <div class="modal-head-sub">Acción</div>
                    <div class="modal-head-title">Confirmar Vinculación</div>
                </div>
            </div>
            <button class="modal-close" onclick="cerrarModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-preview">
                <div class="modal-preview-item">
                    <i class="fas fa-user-tie"></i>
                    <span id="modalPadreNombre"></span>
                </div>
                <div class="modal-preview-sep"><i class="fas fa-link"></i></div>
                <div class="modal-preview-item">
                    <i class="fas fa-user-graduate"></i>
                    <span id="modalEstudianteNombre"></span>
                </div>
            </div>
            <p class="modal-msg">¿Deseas vincular este padre/tutor con el estudiante?</p>
        </div>
        <form id="formVincular" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="estudiante_id" id="formEstudianteId">
        </form>
        <div class="modal-footer">
            <button type="button" class="modal-btn modal-btn-cancel" onclick="cerrarModal()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="button" class="modal-btn modal-btn-confirm"
                    onclick="document.getElementById('formVincular').submit()">
                <i class="fas fa-check"></i> Confirmar
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function abrirModal(padreId, padreNombre, estudianteId, estudianteNombre) {
    document.getElementById('modalPadreNombre').textContent      = padreNombre;
    document.getElementById('modalEstudianteNombre').textContent = estudianteNombre;
    document.getElementById('formEstudianteId').value            = estudianteId;
    document.getElementById('formVincular').action               = `/padres/${padreId}/vincular`;
    document.getElementById('modalVincular').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function cerrarModal() {
    document.getElementById('modalVincular').classList.remove('show');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });
</script>
@endpush
