@extends('layouts.app')

@section('title', 'Editar Profesor')
@section('page-title', 'Editar Profesor')


@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.adm-wrap { font-family: 'Inter', sans-serif; max-width: 900px; margin: 0 auto; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #00508f; border: 1.5px solid #4ec7d2;
    text-decoration: none; transition: background .15s;
}
.adm-btn-outline:hover { background: #e8f8f9; color: #00508f; }

/* ── Banner del profesor ── */
.prof-banner {
    background: linear-gradient(135deg, rgba(78,199,210,.08), rgba(0,80,143,.05));
    border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.4rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.prof-banner-av {
    width: 50px; height: 50px; border-radius: 11px; flex-shrink: 0;
    background: linear-gradient(135deg, #00508f, #003b73);
    border: 2.5px solid #4ec7d2;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: 1.2rem;
}
.prof-banner-name { font-weight: 700; color: #003b73; font-size: 1rem; margin-bottom: .3rem; }
.prof-banner-badges { display: flex; gap: .4rem; flex-wrap: wrap; }
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .2rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-blue { background: rgba(78,199,210,.18); color: #00508f; border: 1px solid #4ec7d2; }
.b-dark { background: rgba(0,80,143,.12); color: #003b73; border: 1px solid #00508f; }

/* ── Card del formulario ── */
.adm-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.adm-card-head i   { color: #4ec7d2; font-size: 1rem; }
.adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.adm-card-body { padding: 1.75rem; }

/* ── Secciones del formulario ── */
.form-section { margin-bottom: 1.75rem; }
.form-section:last-of-type { margin-bottom: 1.25rem; }

.section-header {
    display: flex; align-items: center; gap: .65rem;
    margin-bottom: 1.1rem; padding-bottom: .65rem;
    border-bottom: 1.5px solid #f1f5f9;
}
.section-icon {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
}
.section-icon i { color: #fff; font-size: .85rem; }
.section-title { font-weight: 700; color: #003b73; font-size: .93rem; margin: 0; }

/* ── Grid de campos ── */
.fields-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;
}
@media(max-width:600px){ .fields-grid { grid-template-columns: 1fr; } }
.field-full { grid-column: 1 / -1; }

/* ── Campos ── */
.field-group { display: flex; flex-direction: column; }
.field-label {
    font-size: .78rem; font-weight: 600; color: #334155;
    margin-bottom: .38rem; display: flex; align-items: center; gap: .3rem;
}
.field-label i { color: #00508f; font-size: .72rem; }
.field-label .req { color: #ef4444; }
.field-hint { font-size: .71rem; color: #94a3b8; margin-top: .28rem; }

.field-inner { position: relative; }
.field-inner .fi {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .8rem; pointer-events: none; z-index: 1;
}
.field-inner.ta-field .fi { top: .75rem; transform: none; }

.f-input, .f-select, .f-textarea {
    width: 100%;
    padding: .52rem .85rem .52rem 2.2rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .84rem; color: #0f172a;
    background: #f8fafc; outline: none;
    font-family: 'Inter', sans-serif;
    transition: border-color .15s, background .15s, box-shadow .15s;
}
.f-textarea {
    padding-top: .65rem; resize: vertical; min-height: 72px;
}
.f-input:focus, .f-select:focus, .f-textarea:focus {
    border-color: #4ec7d2; background: #fff;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
}
.f-input.is-invalid, .f-select.is-invalid { border-color: #ef4444 !important; }
.f-input.is-invalid:focus, .f-select.is-invalid:focus {
    border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.1);
}
.f-error {
    font-size: .73rem; color: #ef4444; margin-top: .28rem;
    display: flex; align-items: center; gap: .3rem;
}
.f-error i { font-size: .68rem; }

/* ── Botones de acción ── */
.form-actions {
    display: flex; justify-content: flex-end; gap: .65rem;
    padding-top: 1.25rem; border-top: 1px solid #f1f5f9; flex-wrap: wrap;
}
.btn-cancel {
    padding: .5rem 1.35rem; border-radius: 8px;
    border: 1.5px solid #e2e8f0; background: #fff; color: #64748b;
    font-size: .84rem; font-weight: 600; cursor: pointer;
    font-family: 'Inter', sans-serif; text-decoration: none;
    display: inline-flex; align-items: center; gap: .4rem; transition: all .15s;
}
.btn-cancel:hover { border-color: #94a3b8; background: #f8fafc; color: #475569; }

.btn-save {
    padding: .5rem 1.35rem; border-radius: 8px; border: none;
    background: linear-gradient(135deg, #4ec7d2, #00508f); color: #fff;
    font-size: .84rem; font-weight: 600; cursor: pointer;
    font-family: 'Inter', sans-serif;
    display: inline-flex; align-items: center; gap: .4rem;
    box-shadow: 0 2px 8px rgba(78,199,210,.3); transition: opacity .15s;
}
.btn-save:hover { opacity: .88; }
</style>
@endpush

@section('content')
<div class="adm-wrap">

    {{-- Banner del profesor --}}
    <div class="prof-banner">
        <div class="prof-banner-av">
            {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
        </div>
        <div>
            <div class="prof-banner-name">{{ $profesor->nombre_completo }}</div>
            <div class="prof-banner-badges">
                @if($profesor->email)
                    <span class="bpill b-blue"><i class="fas fa-envelope"></i> {{ $profesor->email }}</span>
                @endif
                @if($profesor->especialidad)
                    <span class="bpill b-dark"><i class="fas fa-book"></i> {{ $profesor->especialidad }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-user-edit"></i>
            <span>Editar Datos del Profesor</span>
        </div>
        <div class="adm-card-body">

            <form action="{{ route('profesores.update', $profesor) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ── 1. Información Personal ── --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-user"></i></div>
                        <h6 class="section-title">Información Personal</h6>
                    </div>
                    <div class="fields-grid">

                        {{-- Nombre --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-user"></i> Nombre <span class="req">*</span>
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-user fi"></i>
                                <input type="text" name="nombre" id="nombre"
                                       class="f-input @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $profesor->nombre) }}"
                                       placeholder="Ej: Juan Carlos">
                            </div>
                            @error('nombre')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Apellido --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-user"></i> Apellido <span class="req">*</span>
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-user fi"></i>
                                <input type="text" name="apellido" id="apellido"
                                       class="f-input @error('apellido') is-invalid @enderror"
                                       value="{{ old('apellido', $profesor->apellido) }}"
                                       placeholder="Ej: Pérez García">
                            </div>
                            @error('apellido')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DNI --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-id-card"></i> DNI <span class="req">*</span>
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-id-card fi"></i>
                                <input type="text" name="dni" id="dni"
                                       class="f-input @error('dni') is-invalid @enderror"
                                       value="{{ old('dni', $profesor->dni) }}"
                                       placeholder="Ej: 0801199512345" maxlength="13">
                            </div>
                            @error('dni')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @else
                                <div class="field-hint"><i class="fas fa-info-circle"></i> 13 dígitos sin guiones</div>
                            @enderror
                        </div>

                        {{-- Fecha de Nacimiento --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-calendar"></i> Fecha de Nacimiento
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-calendar fi"></i>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                       class="f-input @error('fecha_nacimiento') is-invalid @enderror"
                                       value="{{ old('fecha_nacimiento', $profesor->fecha_nacimiento) }}">
                            </div>
                            @error('fecha_nacimiento')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Género --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-venus-mars"></i> Género
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-venus-mars fi"></i>
                                <select name="genero" id="genero"
                                        class="f-select @error('genero') is-invalid @enderror">
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ old('genero', $profesor->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino"  {{ old('genero', $profesor->genero) == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro"      {{ old('genero', $profesor->genero) == 'otro'      ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            @error('genero')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-phone"></i> Teléfono
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-phone fi"></i>
                                <input type="text" name="telefono" id="telefono"
                                       class="f-input @error('telefono') is-invalid @enderror"
                                       value="{{ old('telefono', $profesor->telefono) }}"
                                       placeholder="Ej: 9876-5432">
                            </div>
                            @error('telefono')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ── 2. Información de Contacto ── --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-envelope"></i></div>
                        <h6 class="section-title">Información de Contacto</h6>
                    </div>
                    <div class="fields-grid">

                        {{-- Email --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-envelope"></i> Email <span class="req">*</span>
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-envelope fi"></i>
                                <input type="email" name="email" id="email"
                                       class="f-input @error('email') is-invalid @enderror"
                                       value="{{ old('email', $profesor->email) }}"
                                       placeholder="profesor@ejemplo.com">
                            </div>
                            @error('email')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-map-marker-alt"></i> Dirección
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-map-marker-alt fi"></i>
                                <input type="text" name="direccion" id="direccion"
                                       class="f-input @error('direccion') is-invalid @enderror"
                                       value="{{ old('direccion', $profesor->direccion) }}"
                                       placeholder="Ej: Barrio El Centro, Calle Principal">
                            </div>
                            @error('direccion')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ── 3. Información Académica ── --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-graduation-cap"></i></div>
                        <h6 class="section-title">Información Académica</h6>
                    </div>
                    <div class="fields-grid">

                        {{-- Especialidad --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-book"></i> Especialidad <span class="req">*</span>
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-book fi"></i>
                                <input type="text" name="especialidad" id="especialidad"
                                       class="f-input @error('especialidad') is-invalid @enderror"
                                       value="{{ old('especialidad', $profesor->especialidad) }}"
                                       placeholder="Ej: Matemáticas, Español, Ciencias">
                            </div>
                            @error('especialidad')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nivel Académico --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-certificate"></i> Nivel Académico
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-certificate fi"></i>
                                <select name="nivel_academico" id="nivel_academico"
                                        class="f-select @error('nivel_academico') is-invalid @enderror">
                                    <option value="">Seleccionar...</option>
                                    <option value="bachillerato" {{ old('nivel_academico', $profesor->nivel_academico) == 'bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                    <option value="licenciatura" {{ old('nivel_academico', $profesor->nivel_academico) == 'licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                                    <option value="maestria"     {{ old('nivel_academico', $profesor->nivel_academico) == 'maestria'     ? 'selected' : '' }}>Maestría</option>
                                    <option value="doctorado"    {{ old('nivel_academico', $profesor->nivel_academico) == 'doctorado'    ? 'selected' : '' }}>Doctorado</option>
                                </select>
                            </div>
                            @error('nivel_academico')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ── 4. Información Laboral ── --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-briefcase"></i></div>
                        <h6 class="section-title">Información Laboral</h6>
                    </div>
                    <div class="fields-grid">

                        {{-- Fecha de Contratación --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-calendar-check"></i> Fecha de Contratación
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-calendar-check fi"></i>
                                <input type="date" name="fecha_contratacion" id="fecha_contratacion"
                                       class="f-input @error('fecha_contratacion') is-invalid @enderror"
                                       value="{{ old('fecha_contratacion', $profesor->fecha_contratacion) }}">
                            </div>
                            @error('fecha_contratacion')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tipo de Contrato --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-file-contract"></i> Tipo de Contrato
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-file-contract fi"></i>
                                <select name="tipo_contrato" id="tipo_contrato"
                                        class="f-select @error('tipo_contrato') is-invalid @enderror">
                                    <option value="">Seleccionar...</option>
                                    <option value="tiempo_completo" {{ old('tipo_contrato', $profesor->tipo_contrato) == 'tiempo_completo' ? 'selected' : '' }}>Tiempo Completo</option>
                                    <option value="medio_tiempo"    {{ old('tipo_contrato', $profesor->tipo_contrato) == 'medio_tiempo'    ? 'selected' : '' }}>Medio Tiempo</option>
                                    <option value="por_horas"       {{ old('tipo_contrato', $profesor->tipo_contrato) == 'por_horas'       ? 'selected' : '' }}>Por Horas</option>
                                </select>
                            </div>
                            @error('tipo_contrato')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-toggle-on"></i> Estado <span class="req">*</span>
                            </label>
                            <div class="field-inner">
                                <i class="fas fa-toggle-on fi"></i>
                                <select name="estado" id="estado"
                                        class="f-select @error('estado') is-invalid @enderror">
                                    <option value="activo"   {{ old('estado', $profesor->estado) == 'activo'   ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado', $profesor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="licencia" {{ old('estado', $profesor->estado) == 'licencia' ? 'selected' : '' }}>En Licencia</option>
                                </select>
<<<<<<< HEAD
=======
                                @error('estado')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
>>>>>>> origin/main
                            </div>
                            @error('estado')
                                <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ── Botones ── --}}
                <div class="form-actions">
                    <a href="{{ route('profesores.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Actualizar Profesor
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection