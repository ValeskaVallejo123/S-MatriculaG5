@extends('layouts.app')

@section('title', 'Editar Padre/Tutor')

@section('page-title', 'Editar Padre/Tutor')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .pe-wrap { font-family: 'Inter', sans-serif; }

    /* Topbar cancel */
    .pe-btn-cancel {
        background: white; color: #ef4444; padding: 0.5rem 1.2rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 0.5rem;
        border: 2px solid #ef4444; box-shadow: 0 2px 8px rgba(239,68,68,0.15); transition: all 0.3s;
    }
    .pe-btn-cancel:hover { background: #fef2f2; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(239,68,68,0.25); color: #ef4444; }

    /* Banner */
    .pe-hero {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 60%, #003b73 100%);
        border-radius: 14px; padding: 1.5rem 2rem; margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 1.25rem;
        box-shadow: 0 6px 24px rgba(0,59,115,0.18);
    }
    .pe-hero-icon {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center;
        border: 2px solid rgba(255,255,255,0.35); flex-shrink: 0;
    }
    .pe-hero-icon i { font-size: 1.5rem; color: white; }
    .pe-hero-title { font-size: 1.35rem; font-weight: 700; color: white; margin: 0 0 0.2rem; }
    .pe-hero-sub { color: rgba(255,255,255,0.75); font-size: 0.85rem; margin: 0; }

    /* Cards */
    .pe-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,59,115,0.09); margin-bottom: 1.25rem; overflow: hidden; }
    .pe-card-head { background: #003b73; padding: 0.9rem 1.5rem; }
    .pe-card-head h5 { color: white; font-weight: 700; font-size: 0.95rem; margin: 0; display: flex; align-items: center; gap: 0.6rem; }
    .pe-card-head h5 i { color: #4ec7d2; }
    .pe-card-body { background: white; padding: 1.5rem; }

    /* Error alert */
    .pe-error-alert {
        background: #fef2f2; border: 1px solid #fca5a5; border-radius: 10px;
        color: #991b1b; padding: 1rem 1.25rem; margin-bottom: 1.25rem;
        display: flex; align-items: flex-start; gap: 0.75rem;
    }
    .pe-error-alert i { font-size: 1.1rem; margin-top: 2px; flex-shrink: 0; }
    .pe-error-alert ul { margin: 0.5rem 0 0; padding-left: 1.25rem; }

    /* Form labels */
    .pe-label {
        font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; color: #003b73; margin-bottom: 0.4rem; display: block;
    }
    .pe-label .req { color: #ef4444; margin-left: 2px; }

    /* Inputs */
    .pe-input, .pe-select, .pe-textarea {
        width: 100%; border: 2px solid #bfd9ea; border-radius: 8px;
        padding: 0.5rem 0.85rem; font-size: 0.92rem; color: #1e293b;
        background: white; transition: border-color 0.2s, box-shadow 0.2s;
        font-family: 'Inter', sans-serif;
    }
    .pe-input:focus, .pe-select:focus, .pe-textarea:focus {
        border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,0.15); outline: none;
    }
    .pe-input.is-invalid, .pe-select.is-invalid, .pe-textarea.is-invalid { border-color: #ef4444; }

    /* Actions footer */
    .pe-actions {
        background: white; border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,59,115,0.09);
        padding: 1rem 1.5rem;
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 1.5rem;
    }
    .pe-btn-discard {
        border: 2px solid #ef4444; color: #ef4444; background: white;
        border-radius: 8px; padding: 0.5rem 1.5rem; font-weight: 600; font-size: 0.9rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;
    }
    .pe-btn-discard:hover { background: #fef2f2; color: #ef4444; transform: translateY(-1px); }

    .pe-btn-save {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        color: white; border: none; border-radius: 8px;
        padding: 0.55rem 1.8rem; font-weight: 700; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 0.5rem;
        box-shadow: 0 2px 10px rgba(78,199,210,0.35); cursor: pointer; transition: all 0.2s;
    }
    .pe-btn-save:hover { transform: translateY(-2px); box-shadow: 0 5px 18px rgba(0,80,143,0.35); }
</style>
@endpush

@section('content')
<div class="pe-wrap container-fluid px-4">

    {{-- Banner --}}
    <div class="pe-hero">
        <div class="pe-hero-icon"><i class="fas fa-user-edit"></i></div>
        <div>
            <h2 class="pe-hero-title">Editando: {{ $padre->nombre }} {{ $padre->apellido }}</h2>
            <p class="pe-hero-sub">
                <i class="fas fa-id-card me-1"></i> {{ $padre->dni ?? 'Sin DNI' }}
                &nbsp;·&nbsp;
                <i class="fas fa-users me-1"></i> {{ ucfirst(str_replace('_', ' ', $padre->parentesco)) }}
            </p>
        </div>
    </div>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="pe-error-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" onclick="this.parentElement.remove()"
                    style="margin-left:auto; background:none; border:none; color:#991b1b; font-size:1.2rem; cursor:pointer; flex-shrink:0; line-height:1;">&times;</button>
        </div>
    @endif

    <form action="{{ route('padres.update', $padre->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Datos Personales --}}
        <div class="pe-card">
            <div class="pe-card-head">
                <h5><i class="fas fa-id-card"></i> Datos Personales</h5>
            </div>
            <div class="pe-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="pe-label" for="nombre">Nombre <span class="req">*</span></label>
                        <input type="text" id="nombre" name="nombre"
                               class="pe-input @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $padre->nombre) }}" required>
                        @error('nombre')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="pe-label" for="apellido">Apellido <span class="req">*</span></label>
                        <input type="text" id="apellido" name="apellido"
                               class="pe-input @error('apellido') is-invalid @enderror"
                               value="{{ old('apellido', $padre->apellido) }}" required>
                        @error('apellido')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="pe-label" for="dni">DNI / Identidad</label>
                        <input type="text" id="dni" name="dni"
                               class="pe-input @error('dni') is-invalid @enderror"
                               value="{{ old('dni', $padre->dni) }}" maxlength="20">
                        @error('dni')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="pe-label" for="parentesco">Parentesco <span class="req">*</span></label>
                        <select id="parentesco" name="parentesco"
                                class="pe-select @error('parentesco') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach(['padre'=>'Padre','madre'=>'Madre','tutor_legal'=>'Tutor Legal','abuelo'=>'Abuelo','abuela'=>'Abuela','tio'=>'Tío','tia'=>'Tía','otro'=>'Otro'] as $val => $label)
                                <option value="{{ $val }}" {{ old('parentesco', $padre->parentesco) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('parentesco')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="pe-label" for="estado">Estado <span class="req">*</span></label>
                        <select id="estado" name="estado"
                                class="pe-select @error('estado') is-invalid @enderror" required>
                            <option value="1" {{ old('estado', $padre->estado) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado', $padre->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12" id="otro-parentesco-div"
                         style="display:{{ old('parentesco', $padre->parentesco) == 'otro' ? 'block' : 'none' }};">
                        <label class="pe-label" for="parentesco_otro">Especifique el Parentesco</label>
                        <input type="text" id="parentesco_otro" name="parentesco_otro"
                               class="pe-input @error('parentesco_otro') is-invalid @enderror"
                               value="{{ old('parentesco_otro', $padre->parentesco_otro) }}" maxlength="50">
                        @error('parentesco_otro')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Datos de Contacto --}}
        <div class="pe-card">
            <div class="pe-card-head">
                <h5><i class="fas fa-phone"></i> Datos de Contacto</h5>
            </div>
            <div class="pe-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="pe-label" for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo"
                               class="pe-input @error('correo') is-invalid @enderror"
                               value="{{ old('correo', $padre->correo) }}">
                        @error('correo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="pe-label" for="telefono">Teléfono Principal</label>
                        <input type="text" id="telefono" name="telefono"
                               class="pe-input @error('telefono') is-invalid @enderror"
                               value="{{ old('telefono', $padre->telefono) }}" maxlength="15">
                        @error('telefono')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="pe-label" for="telefono_secundario">Teléfono Secundario</label>
                        <input type="text" id="telefono_secundario" name="telefono_secundario"
                               class="pe-input @error('telefono_secundario') is-invalid @enderror"
                               value="{{ old('telefono_secundario', $padre->telefono_secundario) }}" maxlength="15">
                        @error('telefono_secundario')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="pe-label" for="direccion">Dirección</label>
                        <textarea id="direccion" name="direccion" rows="2"
                                  class="pe-textarea @error('direccion') is-invalid @enderror">{{ old('direccion', $padre->direccion) }}</textarea>
                        @error('direccion')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Información Laboral --}}
        <div class="pe-card">
            <div class="pe-card-head">
                <h5><i class="fas fa-briefcase"></i> Información Laboral</h5>
            </div>
            <div class="pe-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="pe-label" for="ocupacion">Ocupación</label>
                        <input type="text" id="ocupacion" name="ocupacion"
                               class="pe-input @error('ocupacion') is-invalid @enderror"
                               value="{{ old('ocupacion', $padre->ocupacion) }}" maxlength="100">
                        @error('ocupacion')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="pe-label" for="lugar_trabajo">Lugar de Trabajo</label>
                        <input type="text" id="lugar_trabajo" name="lugar_trabajo"
                               class="pe-input @error('lugar_trabajo') is-invalid @enderror"
                               value="{{ old('lugar_trabajo', $padre->lugar_trabajo) }}" maxlength="100">
                        @error('lugar_trabajo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="pe-label" for="telefono_trabajo">Teléfono de Trabajo</label>
                        <input type="text" id="telefono_trabajo" name="telefono_trabajo"
                               class="pe-input @error('telefono_trabajo') is-invalid @enderror"
                               value="{{ old('telefono_trabajo', $padre->telefono_trabajo) }}" maxlength="15">
                        @error('telefono_trabajo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Observaciones --}}
        <div class="pe-card">
            <div class="pe-card-head">
                <h5><i class="fas fa-clipboard"></i> Observaciones</h5>
            </div>
            <div class="pe-card-body">
                <label class="pe-label" for="observaciones">Observaciones Adicionales</label>
                <textarea id="observaciones" name="observaciones" rows="3"
                          class="pe-textarea @error('observaciones') is-invalid @enderror">{{ old('observaciones', $padre->observaciones) }}</textarea>
                @error('observaciones')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Botones --}}
        <div class="pe-actions">
            <a href="{{ route('padres.show', $padre->id) }}" class="pe-btn-discard">
                <i class="fas fa-times"></i> Descartar Cambios
            </a>
            <button type="submit" class="pe-btn-save">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('parentesco').addEventListener('change', function () {
    document.getElementById('otro-parentesco-div').style.display =
        this.value === 'otro' ? 'block' : 'none';
});
</script>
@endpush
