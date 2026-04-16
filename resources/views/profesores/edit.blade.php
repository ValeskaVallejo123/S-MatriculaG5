@extends('layouts.app')

@section('title', 'Editar Profesor')
@section('page-title', 'Editar Profesor')

@section('content-class', 'p-0')

@push('styles')
<style>
.content-wrapper.p-0 {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.prof-edit-panel {
    flex: 1;
    overflow-y: auto;
    padding: 2rem 2.5rem;
    background: #f8fafc;
}

/* Banner */
.prof-banner {
    display: flex; align-items: center; gap: 1rem;
    padding: .9rem 1.25rem; margin-bottom: 1.25rem;
    background: linear-gradient(135deg, #003b73, #00508f);
    border-radius: 12px;
}
.prof-banner-av {
    width: 46px; height: 46px; border-radius: 11px; flex-shrink: 0;
    background: rgba(255,255,255,.15); border: 2px solid rgba(78,199,210,.6);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: white; font-size: 1.1rem;
}
.prof-banner-name   { font-weight: 700; color: white; font-size: .95rem; margin-bottom: .25rem; }
.prof-banner-badges { display: flex; gap: .4rem; flex-wrap: wrap; }
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .18rem .6rem; border-radius: 999px;
    font-size: .68rem; font-weight: 600; white-space: nowrap;
}
.b-teal { background: rgba(78,199,210,.25); color: #e0f9fb; border: 1px solid rgba(78,199,210,.4); }
.b-white { background: rgba(255,255,255,.15); color: rgba(255,255,255,.85); border: 1px solid rgba(255,255,255,.2); }

/* Field cards */
.f-card {
    background: white; border: 1px solid #e8eef5;
    border-radius: 12px; padding: 1.4rem;
    box-shadow: 0 1px 4px rgba(0,59,115,.06);
    margin-bottom: 1.25rem;
}
.f-card-title {
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: #00508f;
    margin-bottom: 1.1rem; padding-bottom: .45rem;
    border-bottom: 1px solid #e8f4fb;
    display: flex; align-items: center; gap: .4rem;
}

/* Labels & inputs */
.f-label {
    font-size: .72rem; font-weight: 700; color: #334155;
    margin-bottom: .35rem; display: flex; align-items: center; gap: .28rem;
    text-transform: uppercase; letter-spacing: .04em;
}
.f-label i { color: #00508f; font-size: .68rem; }
.f-label .req { color: #ef4444; }
.f-hint { font-size: .68rem; color: #94a3b8; margin-top: .25rem; }

.fi-wrap { position: relative; }
.fi-wrap .fi-icon {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .78rem; pointer-events: none; z-index: 1;
}
.f-input, .f-select {
    width: 100%; padding: .5rem .85rem .5rem 2.15rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .84rem; color: #0f172a; background: #f8fafc;
    outline: none; transition: border-color .15s, box-shadow .15s, background .15s;
}
.f-input:focus, .f-select:focus {
    border-color: #4ec7d2; background: white;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
}
.f-input.is-invalid, .f-select.is-invalid { border-color: #ef4444 !important; }
.f-error {
    font-size: .72rem; color: #ef4444; margin-top: .25rem;
    display: flex; align-items: center; gap: .28rem;
}

body.dark-mode .prof-edit-panel { background: #0f172a !important; }
body.dark-mode .f-card          { background: #1e293b !important; border-color: #334155 !important; }
body.dark-mode .f-card-title    { color: #4ec7d2 !important; border-bottom-color: #334155 !important; }
body.dark-mode .f-input,
body.dark-mode .f-select        { background: #0f172a !important; border-color: #334155 !important; color: #e2e8f0 !important; }
body.dark-mode .f-label         { color: #94a3b8 !important; }
</style>
@endpush

@section('content')
<div class="prof-edit-panel">

    {{-- Banner --}}
    <div class="prof-banner">
        <div class="prof-banner-av">
            {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
        </div>
        <div>
            <div class="prof-banner-name">{{ $profesor->nombre_completo }}</div>
            <div class="prof-banner-badges">
                @if($profesor->email)
                    <span class="bpill b-teal"><i class="fas fa-envelope"></i> {{ $profesor->email }}</span>
                @endif
                @if($profesor->especialidad)
                    <span class="bpill b-white"><i class="fas fa-book"></i> {{ $profesor->especialidad }}</span>
                @endif
            </div>
        </div>
    </div>

    <form action="{{ route('profesores.update', $profesor) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Información Personal --}}
        <div class="f-card">
            <div class="f-card-title"><i class="fas fa-user"></i> Información Personal</div>
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="f-label"><i class="fas fa-user"></i> Nombre <span class="req">*</span></div>
                    <div class="fi-wrap">
                        <i class="fas fa-user fi-icon"></i>
                        <input type="text" name="nombre" class="f-input @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $profesor->nombre) }}" placeholder="Ej: Juan Carlos">
                    </div>
                    @error('nombre')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
                <div class="col-lg-6">
                    <div class="f-label"><i class="fas fa-user"></i> Apellido <span class="req">*</span></div>
                    <div class="fi-wrap">
                        <i class="fas fa-user fi-icon"></i>
                        <input type="text" name="apellido" class="f-input @error('apellido') is-invalid @enderror"
                               value="{{ old('apellido', $profesor->apellido) }}" placeholder="Ej: Pérez García">
                    </div>
                    @error('apellido')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
                <div class="col-lg-4">
                    <div class="f-label"><i class="fas fa-id-card"></i> DNI <span class="req">*</span></div>
                    <div class="fi-wrap">
                        <i class="fas fa-id-card fi-icon"></i>
                        <input type="text" name="dni" class="f-input @error('dni') is-invalid @enderror"
                               value="{{ old('dni', $profesor->dni) }}" placeholder="Ej: 0801199512345" maxlength="13">
                    </div>
                    @error('dni')
                        <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @else
                        <div class="f-hint"><i class="fas fa-info-circle"></i> 13 dígitos sin guiones</div>
                    @enderror
                </div>
                <div class="col-lg-4">
                    <div class="f-label"><i class="fas fa-calendar"></i> Fecha de Nacimiento</div>
                    <div class="fi-wrap">
                        <i class="fas fa-calendar fi-icon"></i>
                        <input type="date" name="fecha_nacimiento" class="f-input @error('fecha_nacimiento') is-invalid @enderror"
                               value="{{ old('fecha_nacimiento', $profesor->fecha_nacimiento) }}">
                    </div>
                    @error('fecha_nacimiento')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
                <div class="col-lg-4">
                    <div class="f-label"><i class="fas fa-venus-mars"></i> Género</div>
                    <div class="fi-wrap">
                        <i class="fas fa-venus-mars fi-icon"></i>
                        <select name="genero" class="f-select @error('genero') is-invalid @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="masculino" {{ old('genero', $profesor->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino"  {{ old('genero', $profesor->genero) == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                            <option value="otro"      {{ old('genero', $profesor->genero) == 'otro'      ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    @error('genero')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Contacto --}}
        <div class="f-card">
            <div class="f-card-title"><i class="fas fa-envelope"></i> Información de Contacto</div>
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="f-label"><i class="fas fa-envelope"></i> Email <span class="req">*</span></div>
                    <div class="fi-wrap">
                        <i class="fas fa-envelope fi-icon"></i>
                        <input type="email" name="email" class="f-input @error('email') is-invalid @enderror"
                               value="{{ old('email', $profesor->email) }}" placeholder="profesor@ejemplo.com">
                    </div>
                    @error('email')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
                <div class="col-lg-4">
                    <div class="f-label"><i class="fas fa-phone"></i> Teléfono</div>
                    <div class="fi-wrap">
                        <i class="fas fa-phone fi-icon"></i>
                        <input type="text" name="telefono" class="f-input @error('telefono') is-invalid @enderror"
                               value="{{ old('telefono', $profesor->telefono) }}" placeholder="Ej: 9876-5432">
                    </div>
                    @error('telefono')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
                <div class="col-lg-4">
                    <div class="f-label"><i class="fas fa-map-marker-alt"></i> Dirección</div>
                    <div class="fi-wrap">
                        <i class="fas fa-map-marker-alt fi-icon"></i>
                        <input type="text" name="direccion" class="f-input @error('direccion') is-invalid @enderror"
                               value="{{ old('direccion', $profesor->direccion) }}" placeholder="Ej: Barrio El Centro">
                    </div>
                    @error('direccion')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Académico + Laboral --}}
        <div class="row g-0" style="gap:1.25rem;display:flex;flex-wrap:wrap;margin-bottom:1.25rem;">
            <div style="flex:1;min-width:280px;">
                <div class="f-card" style="margin-bottom:0;">
                    <div class="f-card-title"><i class="fas fa-graduation-cap"></i> Información Académica</div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="f-label"><i class="fas fa-book"></i> Especialidad <span class="req">*</span></div>
                            <div class="fi-wrap">
                                <i class="fas fa-book fi-icon"></i>
                                <input type="text" name="especialidad" class="f-input @error('especialidad') is-invalid @enderror"
                                       value="{{ old('especialidad', $profesor->especialidad) }}" placeholder="Ej: Matemáticas">
                            </div>
                            @error('especialidad')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <div class="f-label"><i class="fas fa-certificate"></i> Nivel Académico</div>
                            <div class="fi-wrap">
                                <i class="fas fa-certificate fi-icon"></i>
                                <select name="nivel_academico" class="f-select @error('nivel_academico') is-invalid @enderror">
                                    <option value="">Seleccionar...</option>
                                    <option value="bachillerato" {{ old('nivel_academico', $profesor->nivel_academico) == 'bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                    <option value="licenciatura" {{ old('nivel_academico', $profesor->nivel_academico) == 'licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                                    <option value="maestria"     {{ old('nivel_academico', $profesor->nivel_academico) == 'maestria'     ? 'selected' : '' }}>Maestría</option>
                                    <option value="doctorado"    {{ old('nivel_academico', $profesor->nivel_academico) == 'doctorado'    ? 'selected' : '' }}>Doctorado</option>
                                </select>
                            </div>
                            @error('nivel_academico')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex:1;min-width:280px;">
                <div class="f-card" style="margin-bottom:0;">
                    <div class="f-card-title"><i class="fas fa-briefcase"></i> Información Laboral</div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="f-label"><i class="fas fa-calendar-check"></i> Fecha de Contratación</div>
                            <div class="fi-wrap">
                                <i class="fas fa-calendar-check fi-icon"></i>
                                <input type="date" name="fecha_contratacion" class="f-input @error('fecha_contratacion') is-invalid @enderror"
                                       value="{{ old('fecha_contratacion', $profesor->fecha_contratacion) }}">
                            </div>
                            @error('fecha_contratacion')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <div class="f-label"><i class="fas fa-file-contract"></i> Tipo de Contrato</div>
                            <div class="fi-wrap">
                                <i class="fas fa-file-contract fi-icon"></i>
                                <select name="tipo_contrato" class="f-select @error('tipo_contrato') is-invalid @enderror">
                                    <option value="">Seleccionar...</option>
                                    <option value="tiempo_completo" {{ old('tipo_contrato', $profesor->tipo_contrato) == 'tiempo_completo' ? 'selected' : '' }}>Tiempo Completo</option>
                                    <option value="medio_tiempo"    {{ old('tipo_contrato', $profesor->tipo_contrato) == 'medio_tiempo'    ? 'selected' : '' }}>Medio Tiempo</option>
                                    <option value="por_horas"       {{ old('tipo_contrato', $profesor->tipo_contrato) == 'por_horas'       ? 'selected' : '' }}>Por Horas</option>
                                </select>
                            </div>
                            @error('tipo_contrato')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <div class="f-label"><i class="fas fa-toggle-on"></i> Estado <span class="req">*</span></div>
                            <div class="fi-wrap">
                                <i class="fas fa-toggle-on fi-icon"></i>
                                <select name="estado" class="f-select @error('estado') is-invalid @enderror">
                                    <option value="activo"   {{ old('estado', $profesor->estado) == 'activo'   ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado', $profesor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="licencia" {{ old('estado', $profesor->estado) == 'licencia' ? 'selected' : '' }}>En Licencia</option>
                                </select>
                            </div>
                            @error('estado')<div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-3 align-items-center mt-1 mb-2">
            <button type="submit"
                    style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;
                           padding:.6rem 2rem;border-radius:9px;font-weight:700;font-size:.9rem;
                           box-shadow:0 2px 10px rgba(78,199,210,.3);cursor:pointer;">
                <i class="fas fa-save me-2"></i>Actualizar Profesor
            </button>
            <a href="{{ route('profesores.index') }}"
               style="color:#64748b;font-size:.85rem;text-decoration:none;font-weight:600;">
                Cancelar
            </a>
        </div>

    </form>
</div>
@endsection
