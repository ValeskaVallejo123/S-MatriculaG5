@extends('layouts.app')

@section('title', 'Detalles del Profesor')
@section('page-title', 'Detalles del Profesor')

@section('topbar-actions')
    <a href="{{ route('profesores.index') }}" class="adm-btn-outline">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.show-wrap { font-family: 'Inter', sans-serif; max-width: 900px; margin: 0 auto; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #00508f; border: 1.5px solid #00508f;
    text-decoration: none; transition: all .15s;
}
.adm-btn-outline:hover { background: #eff6ff; }

.profile-header {
    background: linear-gradient(135deg, #00508f, #003b73);
    border-radius: 12px 12px 0 0;
    padding: 1.5rem;
    display: flex; align-items: center; gap: 1.25rem;
}
.profile-avatar-placeholder {
    width: 64px; height: 64px; border-radius: 12px;
    background: rgba(255,255,255,.15); border: 3px solid #4ec7d2;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.6rem; font-weight: 800; color: #fff;
}
.profile-name { font-size: 1.2rem; font-weight: 700; color: #fff; margin: 0 0 .35rem; }
.profile-badges { display: flex; gap: .4rem; flex-wrap: wrap; }
.profile-badge {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .72rem; font-weight: 600;
    background: rgba(255,255,255,.15); color: #fff;
}

.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .3rem .8rem; border-radius: 999px;
    font-size: .75rem; font-weight: 700; white-space: nowrap;
}
.b-active   { background: #fff; color: #00508f; border: 2px solid #4ec7d2; }
.b-inactive { background: #fff; color: #dc2626; border: 2px solid #ef4444; }
.b-license  { background: #fff; color: #92400e; border: 2px solid #fde68a; }

.show-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    overflow: hidden; margin-bottom: 0;
}
.show-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }

.show-section-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700; color: #00508f;
    padding-bottom: .6rem; border-bottom: 1.5px solid #e8f8f9;
    margin-bottom: .85rem;
}
.show-section-title i { color: #4ec7d2; }

.fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
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
.field-value.mono  { font-family: monospace; color: #00508f; }
.field-value.empty { color: #cbd5e1; font-weight: 400; font-style: italic; }
.field-value.sub   { font-size: .75rem; color: #4ec7d2; font-weight: 600; margin-top: .15rem; }

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
.btn-back-f:hover { background: #eff6ff; color: #00508f; }
.btn-del-f   { background: #fff; color: #ef4444; border: 1.5px solid #ef4444; }
.btn-del-f:hover { background: #fef2f2; }
</style>
@endpush

@section('content')
<div class="show-wrap">

    {{-- Profile header --}}
    <div class="profile-header">
        <div class="profile-avatar-placeholder">
            {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
        </div>
        <div class="flex-grow-1">
            <p class="profile-name">{{ $profesor->nombre_completo }}</p>
            <div class="profile-badges">
                @if($profesor->especialidad)
                <span class="profile-badge"><i class="fas fa-book"></i> {{ $profesor->especialidad }}</span>
                @endif
                @if($profesor->dni)
                <span class="profile-badge"><i class="fas fa-id-card"></i> {{ $profesor->dni }}</span>
                @endif
            </div>
        </div>
        @if($profesor->estado === 'activo')
            <span class="bpill b-active"><i class="fas fa-circle" style="font-size:.4rem;"></i> Activo</span>
        @elseif($profesor->estado === 'licencia')
            <span class="bpill b-license"><i class="fas fa-clock" style="font-size:.75rem;"></i> Licencia</span>
        @else
            <span class="bpill b-inactive"><i class="fas fa-circle" style="font-size:.4rem;"></i> Inactivo</span>
        @endif
    </div>

    <div class="show-card">
        <div class="show-body">

            {{-- Información Personal --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-user"></i> Información Personal
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Nombre</div>
                        <div class="field-value">{{ $profesor->nombre ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Apellido</div>
                        <div class="field-value">{{ $profesor->apellido ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">DNI</div>
                        <div class="field-value mono">{{ $profesor->dni ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Fecha de Nacimiento</div>
                        @if($profesor->fecha_nacimiento)
                            <div class="field-value">{{ \Carbon\Carbon::parse($profesor->fecha_nacimiento)->format('d/m/Y') }}</div>
                            <div class="field-value sub">{{ \Carbon\Carbon::parse($profesor->fecha_nacimiento)->age }} años</div>
                        @else
                            <div class="field-value empty">No registrada</div>
                        @endif
                    </div>
                    <div class="field-box">
                        <div class="field-label">Género</div>
                        <div class="field-value {{ !$profesor->genero ? 'empty' : '' }}">
                            {{ $profesor->genero ? ucfirst($profesor->genero) : 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Teléfono</div>
                        <div class="field-value {{ !$profesor->telefono ? 'empty' : '' }}">
                            {{ $profesor->telefono ?: 'No registrado' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-envelope"></i> Información de Contacto
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Email</div>
                        <div class="field-value {{ !$profesor->email ? 'empty' : '' }}">
                            {{ $profesor->email ?: 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Dirección</div>
                        <div class="field-value {{ !$profesor->direccion ? 'empty' : '' }}">
                            {{ $profesor->direccion ?: 'No registrada' }}
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
                        <div class="field-label">Especialidad</div>
                        <div class="field-value {{ !$profesor->especialidad ? 'empty' : '' }}">
                            {{ $profesor->especialidad ?: 'No especificada' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Nivel Académico</div>
                        <div class="field-value {{ !$profesor->nivel_academico ? 'empty' : '' }}">
                            {{ $profesor->nivel_academico ? ucfirst($profesor->nivel_academico) : 'No especificado' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información Laboral --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-briefcase"></i> Información Laboral
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Fecha de Contratación</div>
                        @if($profesor->fecha_contratacion)
                            <div class="field-value">{{ \Carbon\Carbon::parse($profesor->fecha_contratacion)->format('d/m/Y') }}</div>
                            <div class="field-value sub">{{ \Carbon\Carbon::parse($profesor->fecha_contratacion)->diffForHumans() }}</div>
                        @else
                            <div class="field-value empty">No registrada</div>
                        @endif
                    </div>
                    <div class="field-box">
                        <div class="field-label">Tipo de Contrato</div>
                        <div class="field-value {{ !$profesor->tipo_contrato ? 'empty' : '' }}">
                            {{ $profesor->tipo_contrato ? ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) : 'No especificado' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Datos del Sistema --}}
            <div>
                <div class="show-section-title">
                    <i class="fas fa-clock"></i> Datos del Sistema
                </div>
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Fecha de Registro</div>
                        <div class="field-value">{{ $profesor->created_at ? $profesor->created_at->format('d/m/Y H:i') : '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Última Actualización</div>
                        <div class="field-value">{{ $profesor->updated_at ? $profesor->updated_at->format('d/m/Y H:i') : '—' }}</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer acciones --}}
        <div class="show-footer">
            <a href="{{ route('profesores.edit', $profesor->id) }}" class="footer-btn btn-edit-f">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('profesores.index') }}" class="footer-btn btn-back-f">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button type="button" onclick="confirmDelete()" class="footer-btn btn-del-f">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    </div>

    <form id="delete-form" action="{{ route('profesores.destroy', $profesor) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

</div>

{{-- Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;overflow:hidden;">
            <div class="modal-header border-0" style="background:rgba(239,68,68,.08);padding:1.2rem;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:40px;height:40px;background:rgba(239,68,68,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0 fw-bold" style="color:#003b73;font-size:.95rem;">Confirmar Eliminación</h5>
                        <p class="mb-0 small text-muted">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1.25rem 1.5rem;">
                <p class="mb-1" style="color:#003b73;font-size:.88rem;">
                    ¿Estás seguro de eliminar al profesor <strong>{{ $profesor->nombre_completo }}</strong>?
                </p>
                <p class="text-muted small mb-0">Se perderán todos los datos asociados permanentemente.</p>
            </div>
            <div class="modal-footer border-0" style="background:#f8fafc;padding:.85rem 1.5rem;">
                <button type="button" class="footer-btn btn-back-f" data-bs-dismiss="modal" style="flex:0;padding:.45rem 1.1rem;">Cancelar</button>
                <button type="button" onclick="submitDelete()" class="footer-btn" style="flex:0;padding:.45rem 1.1rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;border-radius:8px;font-size:.82rem;font-weight:600;cursor:pointer;">
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