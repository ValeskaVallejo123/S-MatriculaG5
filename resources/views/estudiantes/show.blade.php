@extends('layouts.app')

@section('title', 'Detalles del Estudiante')
@section('page-title', 'Detalles del Estudiante')

@section('topbar-actions')
    <a href="{{ route('padres.buscar', ['estudiante_id' => $estudiante->id]) }}" class="adm-btn-solid">
        <i class="fas fa-link"></i> Vincular Padre/Tutor
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.show-wrap { font-family: 'Inter', sans-serif; max-width: 900px; margin: 0 auto; }

.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* ── Profile header ── */
.profile-header {
    background: linear-gradient(135deg, #00508f, #003b73);
    border-radius: 12px 12px 0 0;
    padding: 1.5rem;
    display: flex; align-items: center; gap: 1.25rem;
}
.profile-avatar {
    width: 72px; height: 72px; border-radius: 12px;
    object-fit: cover; border: 3px solid #4ec7d2;
    flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,.2);
}
.profile-avatar-placeholder {
    width: 72px; height: 72px; border-radius: 12px;
    background: rgba(255,255,255,.15); border: 3px solid #4ec7d2;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.75rem; font-weight: 800; color: #fff;
}
.profile-name { font-size: 1.3rem; font-weight: 700; color: #fff; margin: 0 0 .25rem; }
.profile-sub  { font-size: .85rem; color: rgba(255,255,255,.75); margin: 0; }

.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .3rem .8rem; border-radius: 999px;
    font-size: .75rem; font-weight: 700; white-space: nowrap;
}
.b-active   { background: #fff; color: #00508f; border: 2px solid #4ec7d2; }
.b-inactive { background: #fff; color: #dc2626; border: 2px solid #ef4444; }
.b-cyan     { background: #e8f8f9; color: #00508f; border: 1px solid #b2e8ed; font-size: .72rem; font-weight: 600; padding: .2rem .6rem; border-radius: 999px; }

/* ── Card body ── */
.show-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    overflow: hidden;
}
.show-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }

/* ── Section ── */
.show-section-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700; color: #00508f;
    padding-bottom: .6rem; border-bottom: 1.5px solid #e8f8f9;
    margin-bottom: .85rem;
}
.show-section-title i { color: #4ec7d2; }

/* ── Fields grid ── */
.fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
.fields-grid.full { grid-template-columns: 1fr; }
@media(max-width:600px){ .fields-grid { grid-template-columns: 1fr; } }

.field-box {
    background: #f8fafc; border-radius: 8px;
    border-left: 3px solid #4ec7d2;
    padding: .65rem .85rem;
}
.field-label {
    font-size: .67rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #94a3b8; margin-bottom: .2rem;
}
.field-value { font-size: .88rem; font-weight: 600; color: #0f172a; }
.field-value.mono { font-family: monospace; color: #00508f; }
.field-value.empty { color: #cbd5e1; font-weight: 400; font-style: italic; }

/* ── Padres vinculados ── */
.padre-card {
    background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
    padding: 1rem; display: flex; align-items: center; gap: .85rem;
    justify-content: space-between;
}
.padre-avatar {
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: 1rem;
}
.padre-name { font-weight: 600; color: #0f172a; font-size: .85rem; }
.padre-sub  { font-size: .75rem; color: #64748b; margin-top: .1rem; }
.padre-empty {
    text-align: center; padding: 1.5rem; color: #94a3b8;
    background: #f8fafc; border-radius: 10px; border: 1.5px dashed #e2e8f0;
}
.padre-empty i { display: block; font-size: 1.5rem; margin-bottom: .5rem; color: #cbd5e1; }

.btn-desvincular {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .3rem .7rem; border-radius: 6px; font-size: .75rem; font-weight: 600;
    background: #fef2f2; color: #ef4444; border: 1px solid #fecaca;
    cursor: pointer; transition: all .15s; text-decoration: none;
}
.btn-desvincular:hover { background: #ef4444; color: #fff; }

/* ── Footer actions ── */
.show-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #f1f5f9;
    background: #fafafa;
    display: flex; gap: .6rem;
}
.footer-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; padding: .55rem .75rem; border-radius: 8px;
    font-size: .82rem; font-weight: 600; cursor: pointer;
    text-decoration: none; border: none; transition: all .15s;
}
.footer-btn:hover { transform: translateY(-1px); }
.btn-edit-f  { background: linear-gradient(135deg, #4ec7d2, #00508f); color: #fff; box-shadow: 0 2px 8px rgba(78,199,210,.3); }
.btn-edit-f:hover { color: #fff; }
.btn-back-f  { background: #fff; color: #00508f; border: 1.5px solid #00508f; }
.btn-back-f:hover { background: #eff6ff; }
.btn-del-f   { background: #fff; color: #ef4444; border: 1.5px solid #ef4444; }
.btn-del-f:hover { background: #fef2f2; }
</style>
@endpush

@section('content')
<div class="show-wrap">

    {{-- Profile header --}}
    <div class="profile-header">
        @if($estudiante->foto)
            <img src="{{ asset('storage/' . $estudiante->foto) }}"
                 class="profile-avatar"
                 alt="Foto de {{ $estudiante->nombre_completo }}">
        @else
            <div class="profile-avatar-placeholder">
                {{ strtoupper(substr($estudiante->nombre1, 0, 1) . substr($estudiante->apellido1, 0, 1)) }}
            </div>
        @endif

        <div>
            <p class="profile-name">{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}</p>
            <p class="profile-sub">DNI: {{ $estudiante->dni ?: '—' }}</p>
        </div>

        @if($estudiante->estado === 'activo')
            <span class="bpill b-active"><i class="fas fa-circle" style="font-size:.4rem;"></i> Activo</span>
        @else
            <span class="bpill b-inactive"><i class="fas fa-circle" style="font-size:.4rem;"></i> Inactivo</span>
        @endif
    </div>
    {{-- FIN header --}}

    {{-- Card body --}}
    <div class="show-card">
        <div class="show-body">

            {{-- Información Personal --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-user"></i> Información Personal
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Primer Nombre</div>
                        <div class="field-value">{{ $estudiante->nombre1 ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Segundo Nombre</div>
                        <div class="field-value {{ !$estudiante->nombre2 ? 'empty' : '' }}">
                            {{ $estudiante->nombre2 ?: 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Primer Apellido</div>
                        <div class="field-value">{{ $estudiante->apellido1 ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Segundo Apellido</div>
                        <div class="field-value {{ !$estudiante->apellido2 ? 'empty' : '' }}">
                            {{ $estudiante->apellido2 ?: 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">DNI</div>
                        <div class="field-value mono">{{ $estudiante->dni ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Fecha de Nacimiento</div>
                        <div class="field-value">
                            {{ $estudiante->fecha_nacimiento
                                ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')
                                : 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Sexo</div>
                        <div class="field-value {{ !$estudiante->sexo ? 'empty' : '' }}">
                            {{ $estudiante->sexo ? ucfirst($estudiante->sexo) : 'No registrado' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-address-book"></i> Información de Contacto
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Email</div>
                        <div class="field-value {{ !$estudiante->email ? 'empty' : '' }}">
                            {{ $estudiante->email ?: 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Teléfono</div>
                        <div class="field-value {{ !$estudiante->telefono ? 'empty' : '' }}">
                            {{ $estudiante->telefono ?: 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box" style="grid-column: 1 / -1;">
                        <div class="field-label">Dirección</div>
                        <div class="field-value {{ !$estudiante->direccion ? 'empty' : '' }}">
                            {{ $estudiante->direccion ?: 'No registrado' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información Académica --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-graduation-cap"></i> Información Académica
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Grado</div>
                        <div class="field-value">{{ $estudiante->grado }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Sección</div>
                        <div class="field-value">{{ $estudiante->seccion }}</div>
                    </div>
                </div>
            </div>

            {{-- PADRES VINCULADOS --}}
            <div>
                <div class="show-section-title" style="justify-content: space-between;">
                    <span style="display:flex;align-items:center;gap:.5rem;">
                        <i class="fas fa-user-friends"></i> Padres / Tutores Vinculados
                    </span>
                    <a href="{{ route('padres.buscar', ['estudiante_id' => $estudiante->id]) }}"
                       style="font-size:.75rem;font-weight:600;color:#4ec7d2;text-decoration:none;">
                        <i class="fas fa-plus"></i> Vincular
                    </a>
                </div>

                @if($estudiante->padres && $estudiante->padres->count() > 0)
                    <div style="display:flex;flex-direction:column;gap:.65rem;">
                        @foreach($estudiante->padres as $padre)
                        <div class="padre-card">
                            <div style="display:flex;align-items:center;gap:.85rem;">
                                <div class="padre-avatar">{{ strtoupper(substr($padre->nombre, 0, 1)) }}</div>
                                <div>
                                    <div class="padre-name">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                                    <div class="padre-sub">
                                        <span class="b-cyan">{{ ucfirst($padre->parentesco) }}</span>
                                        @if($padre->telefono)
                                            &nbsp;· <i class="fas fa-phone" style="font-size:.65rem;"></i> {{ $padre->telefono }}
                                        @endif
                                        @if($padre->correo)
                                            &nbsp;· <i class="fas fa-envelope" style="font-size:.65rem;"></i> {{ $padre->correo }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- Botón desvincular --}}
                            <form action="{{ route('padres.desvincular') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="padre_id" value="{{ $padre->id }}">
                                <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                                <button type="submit" class="btn-desvincular"
                                        onclick="return confirm('¿Desvincular a {{ $padre->nombre }} {{ $padre->apellido }}?')">
                                    <i class="fas fa-unlink"></i> Desvincular
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="padre-empty">
                        <i class="fas fa-user-slash"></i>
                        <p style="margin:0;font-size:.85rem;">No hay padres/tutores vinculados</p>
                        <a href="{{ route('padres.buscar', ['estudiante_id' => $estudiante->id]) }}"
                           class="adm-btn-solid" style="margin-top:.75rem;display:inline-flex;">
                            <i class="fas fa-link"></i> Vincular ahora
                        </a>
                    </div>
                @endif
            </div>

            {{-- Observaciones (condicional) --}}
            @if($estudiante->observaciones)
            <div>
                <div class="show-section-title">
                    <i class="fas fa-clipboard"></i> Observaciones
                </div>
                <div class="field-box">
                    <div class="field-value" style="line-height:1.6;">{{ $estudiante->observaciones }}</div>
                </div>
            </div>
            @endif

            {{-- Datos del Sistema --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-clock"></i> Datos del Sistema
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Fecha de Registro</div>
                        <div class="field-value">
                            {{ $estudiante->created_at ? $estudiante->created_at->format('d/m/Y H:i') : '—' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Última Actualización</div>
                        <div class="field-value">
                            {{ $estudiante->updated_at ? $estudiante->updated_at->format('d/m/Y H:i') : '—' }}
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Footer acciones --}}
        <div class="show-footer">
            <a href="{{ route('estudiantes.edit', $estudiante) }}" class="footer-btn btn-edit-f">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('estudiantes.index') }}" class="footer-btn btn-back-f">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button type="button" onclick="confirmDelete()" class="footer-btn btn-del-f">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>

    </div>

    {{-- Form oculto eliminar --}}
    <form id="delete-form" action="{{ route('estudiantes.destroy', $estudiante) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

</div>

{{-- Modal confirmar eliminación --}}
<div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px; border:none; overflow:hidden;">

            {{-- Header --}}
            <div class="modal-header border-0" style="background:rgba(239,68,68,.08); padding:1.2rem;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:40px; height:40px; background:rgba(239,68,68,.15);
                                border-radius:10px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444; font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0 fw-bold" id="deleteModalLabel"
                            style="color:#003b73; font-size:.95rem;">Confirmar Eliminación</h5>
                        <p class="mb-0 small text-muted">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body" style="padding:1.25rem 1.5rem;">
                <p class="mb-1" style="color:#003b73;font-size:.88rem;">
                    ¿Estás seguro de eliminar a <strong>{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}</strong>?
                </p>
            </div>

            <div class="modal-footer border-0" style="background:#f8fafc;padding:.85rem 1.5rem;">
                <button type="button" class="footer-btn btn-back-f" data-bs-dismiss="modal" style="flex:0;padding:.45rem 1.1rem;">
                    Cancelar
                </button>
                <button type="button" onclick="submitDelete()" class="footer-btn btn-edit-f"
                        style="flex:0;padding:.45rem 1.1rem;background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 2px 8px rgba(239,68,68,.3);">
                    Sí, Eliminar
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let deleteModal;
document.addEventListener('DOMContentLoaded', function () {
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
});
function confirmDelete() { deleteModal.show(); }
function submitDelete()  { document.getElementById('delete-form').submit(); }
</script>
@endpush
