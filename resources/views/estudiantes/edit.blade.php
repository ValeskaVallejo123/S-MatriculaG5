@extends('layouts.app')

@section('title', 'Editar Estudiante')
@section('page-title', 'Editar Estudiante')

@section('topbar-actions')
    <a href="{{ route('estudiantes.index') }}" class="adm-btn-outline">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.edit-wrap { font-family: 'Inter', sans-serif; max-width: 900px; margin: 0 auto; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #00508f; border: 1.5px solid #00508f;
    text-decoration: none; transition: all .15s;
}
.adm-btn-outline:hover { background: #eff6ff; }

.edit-header {
    background: linear-gradient(135deg, #00508f, #003b73);
    border-radius: 12px; padding: 1.25rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem;
}
.edit-header-left { display: flex; align-items: center; gap: .85rem; }
.edit-header-icon {
    width: 44px; height: 44px; border-radius: 10px;
    background: rgba(78,199,210,.25);
    display: flex; align-items: center; justify-content: center;
}
.edit-header-icon i { color: #fff; font-size: 1.2rem; }
.edit-header-title { color: #fff; font-weight: 700; font-size: 1rem; margin: 0; }
.edit-header-sub   { color: rgba(255,255,255,.7); font-size: .78rem; margin: 0; }
.edit-header-id {
    background: rgba(78,199,210,.2); color: rgba(255,255,255,.9);
    padding: .3rem .75rem; border-radius: 6px; font-size: .78rem; font-weight: 600;
}

.edit-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); overflow: hidden;
    margin-bottom: 1rem;
}
.edit-card-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }

.edit-section-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700; color: #00508f;
    padding-bottom: .6rem; border-bottom: 1.5px solid #e8f8f9;
    margin-bottom: .85rem;
}
.edit-section-title i { color: #4ec7d2; }

.fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
@media(max-width:600px){ .fields-grid { grid-template-columns: 1fr; } }

.field-group { display: flex; flex-direction: column; gap: .3rem; }
.field-group.full { grid-column: 1 / -1; }

.field-label {
    font-size: .75rem; font-weight: 700; color: #003b73; letter-spacing: .02em;
}
.field-label span { color: #ef4444; margin-left: 2px; }

.field-input, .field-select, .field-textarea {
    width: 100%; padding: .48rem .75rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .83rem; font-family: 'Inter', sans-serif;
    color: #0f172a; outline: none;
    transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
}
.field-input:focus, .field-select:focus, .field-textarea:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    background: #fff;
}
.field-input.is-invalid, .field-select.is-invalid, .field-textarea.is-invalid {
    border-color: #ef4444;
}
.field-textarea { resize: none; min-height: 70px; }
.field-hint  { font-size: .68rem; color: #94a3b8; margin-top: .15rem; }
.field-error { font-size: .72rem; color: #ef4444; margin-top: .2rem; }

.edit-footer { display: flex; gap: .6rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9; }
.footer-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; padding: .6rem .75rem; border-radius: 8px;
    font-size: .83rem; font-weight: 600; cursor: pointer;
    text-decoration: none; border: none; transition: all .15s;
}
.footer-btn:hover { transform: translateY(-1px); }
.btn-save   { background: linear-gradient(135deg,#4ec7d2,#00508f); color:#fff; box-shadow:0 2px 8px rgba(78,199,210,.3); }
.btn-save:hover { color:#fff; }
.btn-cancel { background:#fff; color:#64748b; border:1.5px solid #e2e8f0; }

.edit-note {
    display: flex; align-items: flex-start; gap: .5rem;
    background: rgba(78,199,210,.08); border-left: 3px solid #4ec7d2;
    border-radius: 8px; padding: .75rem 1rem;
    font-size: .8rem; color: #475569;
}
.edit-note i { color: #4ec7d2; margin-top: 1px; flex-shrink: 0; }
.edit-note strong { color: #00508f; }
</style>
@endpush

@section('content')
<div class="edit-wrap">

    <div class="edit-header">
        <div class="edit-header-left">
            <div class="edit-header-icon"><i class="fas fa-user-edit"></i></div>
            <div>
                <p class="edit-header-title">Editar Estudiante</p>
                <p class="edit-header-sub">Actualice la información necesaria</p>
            </div>
        </div>
        <span class="edit-header-id">ID: #{{ $estudiante->id }}</span>
    </div>

    <div class="edit-card">
        <div class="edit-card-body">
            <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Información Personal --}}
                <div>
                    <div class="edit-section-title">
                        <i class="fas fa-user"></i> Información Personal
                    </div>
                    <div class="fields-grid">

                        <div class="field-group">
                            <label class="field-label">Primer Nombre <span>*</span></label>
                            <input type="text" name="nombre1"
                                   value="{{ old('nombre1', $estudiante->nombre1) }}"
                                   class="field-input {{ $errors->has('nombre1') ? 'is-invalid' : '' }}"
                                   placeholder="Ej: Maria" required maxlength="50">
                            @error('nombre1')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Segundo Nombre</label>
                            <input type="text" name="nombre2"
                                   value="{{ old('nombre2', $estudiante->nombre2) }}"
                                   class="field-input {{ $errors->has('nombre2') ? 'is-invalid' : '' }}"
                                   placeholder="Ej: Guadalupe" maxlength="50">
                            @error('nombre2')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Primer Apellido <span>*</span></label>
                            <input type="text" name="apellido1"
                                   value="{{ old('apellido1', $estudiante->apellido1) }}"
                                   class="field-input {{ $errors->has('apellido1') ? 'is-invalid' : '' }}"
                                   placeholder="Ej: Gutierrez" required maxlength="50">
                            @error('apellido1')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Segundo Apellido</label>
                            <input type="text" name="apellido2"
                                   value="{{ old('apellido2', $estudiante->apellido2) }}"
                                   class="field-input {{ $errors->has('apellido2') ? 'is-invalid' : '' }}"
                                   placeholder="Ej: Flores" maxlength="50">
                            @error('apellido2')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">DNI <span>*</span></label>
                            <input type="text" name="dni"
                                   value="{{ old('dni', $estudiante->dni) }}"
                                   class="field-input {{ $errors->has('dni') ? 'is-invalid' : '' }}"
                                   placeholder="0000000000000" required
                                   pattern="[0-9]{13}" maxlength="13">
                            <span class="field-hint">13 dígitos sin guiones</span>
                            @error('dni')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Fecha de Nacimiento <span>*</span></label>
                            <input type="date" name="fecha_nacimiento"
                                   value="{{ old('fecha_nacimiento', \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('Y-m-d')) }}"
                                   class="field-input {{ $errors->has('fecha_nacimiento') ? 'is-invalid' : '' }}"
                                   required>
                            @error('fecha_nacimiento')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Sexo</label>
                            <select name="sexo" class="field-select {{ $errors->has('sexo') ? 'is-invalid' : '' }}">
                                <option value="">Seleccione</option>
                                <option value="masculino" {{ old('sexo', $estudiante->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino"  {{ old('sexo', $estudiante->sexo) == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('sexo')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Teléfono</label>
                            <input type="text" name="telefono"
                                   value="{{ old('telefono', $estudiante->telefono) }}"
                                   class="field-input {{ $errors->has('telefono') ? 'is-invalid' : '' }}"
                                   placeholder="00000000" maxlength="8">
                            <span class="field-hint">8 dígitos</span>
                            @error('telefono')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group full">
                            <label class="field-label">Dirección</label>
                            <textarea name="direccion"
                                      class="field-textarea {{ $errors->has('direccion') ? 'is-invalid' : '' }}"
                                      placeholder="Dirección completa del estudiante"
                                      maxlength="200">{{ old('direccion', $estudiante->direccion) }}</textarea>
                            @error('direccion')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>

                {{-- Información Académica --}}
                <div>
                    <div class="edit-section-title">
                        <i class="fas fa-graduation-cap"></i> Información Académica
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:.75rem;">

                        <div class="field-group">
                            <label class="field-label">Grado <span>*</span></label>
                            <select name="grado" class="field-select {{ $errors->has('grado') ? 'is-invalid' : '' }}" required>
                                <option value="">Seleccione</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}" {{ old('grado', $estudiante->grado) == $grado ? 'selected' : '' }}>
                                        {{ $grado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grado')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Sección <span>*</span></label>
                            <select name="seccion" class="field-select {{ $errors->has('seccion') ? 'is-invalid' : '' }}" required>
                                <option value="">Seleccione</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion }}" {{ old('seccion', $estudiante->seccion) == $seccion ? 'selected' : '' }}>
                                        {{ $seccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seccion')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Estado <span>*</span></label>
                            <select name="estado" class="field-select {{ $errors->has('estado') ? 'is-invalid' : '' }}" required>
                                <option value="activo"   {{ old('estado', $estudiante->estado) == 'activo'   ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $estudiante->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>

                {{-- Observaciones --}}
                <div>
                    <div class="edit-section-title">
                        <i class="fas fa-clipboard"></i> Información Adicional
                    </div>
                    <div class="field-group">
                        <label class="field-label">Observaciones</label>
                        <textarea name="observaciones"
                                  class="field-textarea {{ $errors->has('observaciones') ? 'is-invalid' : '' }}"
                                  placeholder="Alergias, condiciones médicas, notas especiales..."
                                  maxlength="500">{{ old('observaciones', $estudiante->observaciones) }}</textarea>
                        @error('observaciones')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Botones --}}
                <div class="edit-footer">
                    <button type="submit" class="footer-btn btn-save">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('estudiantes.index') }}" class="footer-btn btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

    <div class="edit-note">
        <i class="fas fa-info-circle"></i>
        <span><strong>Importante:</strong> Los campos con <span style="color:#ef4444;">*</span> son obligatorios. Los cambios se aplican inmediatamente.</span>
    </div>

</div>
@endsection