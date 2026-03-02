@extends('layouts.app')

@section('title', 'Editar Matrícula')
@section('page-title', 'Editar Matrícula')

@section('topbar-actions')
    <a href="{{ route('matriculas.show', $matricula->id) }}" class="adm-btn-solid">
        <i class="fas fa-eye"></i> Ver Detalles
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* ─── Variables ─── */
:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --cyan-light: #e8f8f9;
    --cyan-border:#b2e8ed;
    --red:        #ef4444;
    --surface:    #f8fafc;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --muted:      #64748b;
    --subtle:     #94a3b8;
}

.edit-wrap {
    font-family: 'Inter', sans-serif;
    max-width: 960px;
    margin: 0 auto;
}

/* ─── Botón topbar ─── */
.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px;
    font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: #fff; border: none; text-decoration: none;
    transition: opacity .15s;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* ─── Alerts ─── */
.em-alert {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.1rem; border-radius: 10px;
    font-size: .84rem; margin-bottom: 1.25rem;
}
.em-alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
.em-alert-danger  { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
.em-alert-info    { background: var(--cyan-light); border: 1px solid var(--cyan-border); color: var(--blue-dark); }
.em-alert i       { margin-top: .05rem; flex-shrink: 0; }
.em-alert ul      { margin: .4rem 0 0 1rem; padding: 0; }

/* ─── Section cards ─── */
.em-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    overflow: hidden;
    margin-bottom: 1.25rem;
}

.em-card-header {
    display: flex; align-items: center; gap: .6rem;
    padding: .95rem 1.35rem;
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    font-size: .82rem; font-weight: 700; color: #fff;
}
.em-card-header i { color: var(--cyan); }

.em-card-header-light {
    display: flex; align-items: center; gap: .6rem;
    padding: .85rem 1.35rem;
    background: var(--cyan-light);
    border-bottom: 1.5px solid var(--cyan-border);
    font-size: .82rem; font-weight: 700; color: var(--blue-dark);
}
.em-card-header-light i { color: var(--cyan); }

.em-card-body { padding: 1.35rem; }

/* ─── Fields grid ─── */
.fields-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .85rem;
}
.fields-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
@media(max-width: 640px) {
    .fields-grid, .fields-grid.cols-3 { grid-template-columns: 1fr; }
}
.col-full { grid-column: 1 / -1; }

/* ─── Labels & inputs ─── */
.em-label {
    display: block;
    font-size: .72rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: var(--muted); margin-bottom: .4rem;
}
.em-label .req { color: var(--red); }

.em-input,
.em-select,
.em-textarea {
    width: 100%;
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: .6rem .85rem;
    font-size: .875rem; font-weight: 500; color: var(--text);
    transition: border-color .15s, box-shadow .15s;
    font-family: 'Inter', sans-serif;
    appearance: none;
}
.em-input:focus, .em-select:focus, .em-textarea:focus {
    outline: none;
    border-color: var(--cyan);
    box-shadow: 0 0 0 3px rgba(78,199,210,.15);
}
.em-input.readonly {
    background: #f1f5f9; color: var(--muted); cursor: not-allowed;
}
.em-input.is-invalid, .em-select.is-invalid, .em-textarea.is-invalid {
    border-color: var(--red);
    box-shadow: 0 0 0 3px rgba(239,68,68,.1);
}
.em-error { font-size: .75rem; color: var(--red); margin-top: .3rem; font-weight: 500; }

.em-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right .75rem center; padding-right: 2.5rem; }

.em-textarea { resize: vertical; min-height: 90px; }

/* ─── Select estado custom pills ─── */
.estado-select-wrap { position: relative; }

/* ─── Doc upload rows ─── */
.doc-row {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: .85rem 1rem;
    transition: border-color .15s;
}
.doc-row:hover { border-color: var(--cyan-border); }

.doc-row-top {
    display: flex; align-items: center; gap: .6rem;
    margin-bottom: .55rem;
}
.doc-icon {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .78rem;
}
.doc-label-text { font-size: .82rem; font-weight: 700; color: var(--blue-dark); }
.doc-current {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .72rem; color: #16a34a; font-weight: 600;
    background: #f0fdf4; border: 1px solid #86efac;
    border-radius: 999px; padding: .15rem .55rem;
    text-decoration: none;
}
.doc-current:hover { background: #dcfce7; color: #15803d; }
.doc-hint { font-size: .7rem; color: var(--subtle); margin-top: .3rem; }

/* ─── Footer ─── */
.em-footer {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.1rem 1.35rem;
    display: flex; gap: .75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.em-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; padding: .62rem .75rem; border-radius: 9px;
    font-size: .85rem; font-weight: 700; cursor: pointer;
    text-decoration: none; border: none;
    transition: all .15s; font-family: 'Inter', sans-serif;
}
.em-btn:hover { transform: translateY(-1px); }
.btn-save   { background: linear-gradient(135deg, var(--cyan), var(--blue-mid)); color: #fff; box-shadow: 0 2px 10px rgba(78,199,210,.35); }
.btn-save:hover { color: #fff; }
.btn-cancel { background: #fff; color: var(--blue-dark); border: 1.5px solid var(--blue-dark); }
.btn-cancel:hover { background: #eff6ff; color: var(--blue-dark); }

/* ─── Badge estado ─── */
.badge-estado {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
}
.badge-pendiente  { background: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
.badge-aprobada   { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
.badge-rechazada  { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
.badge-cancelada  { background: #f1f5f9; color: var(--muted);  border: 1px solid var(--border); }

/* ─── Motivo rechazo animation ─── */
#motivo-rechazo-container {
    overflow: hidden;
    transition: max-height .25s ease, opacity .25s ease;
    max-height: 0; opacity: 0;
}
#motivo-rechazo-container.visible {
    max-height: 120px; opacity: 1;
}
</style>
@endpush

@section('content')
<div class="edit-wrap">

    {{-- Alerts --}}
    @if(session('success'))
    <div class="em-alert em-alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="em-alert em-alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('matriculas.update', $matricula->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ══════════════════════════════════════
             SECCIÓN 1 · Información de la Matrícula
        ══════════════════════════════════════ --}}
        <div class="em-card">
            <div class="em-card-header">
                <i class="fas fa-clipboard-check"></i>
                Información de la Matrícula
            </div>
            <div class="em-card-body">
                <div class="fields-grid cols-3">

                    {{-- Código --}}
                    <div>
                        <label class="em-label" for="codigo_matricula">
                            <i class="fas fa-barcode"></i> Código
                        </label>
                        <input type="text" class="em-input readonly" id="codigo_matricula" name="codigo_matricula"
                            value="{{ old('codigo_matricula', $matricula->codigo_matricula) }}" readonly>
                    </div>

                    {{-- Año Lectivo --}}
                    <div>
                        <label class="em-label" for="anio_lectivo">
                            <i class="fas fa-calendar-alt"></i> Año Lectivo <span class="req">*</span>
                        </label>
                        <input type="text" class="em-input @error('anio_lectivo') is-invalid @enderror"
                            id="anio_lectivo" name="anio_lectivo"
                            value="{{ old('anio_lectivo', $matricula->anio_lectivo) }}"
                            placeholder="2025">
                        @error('anio_lectivo')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label class="em-label" for="fecha_matricula">
                            <i class="fas fa-calendar"></i> Fecha de Matrícula <span class="req">*</span>
                        </label>
                        <input type="date" class="em-input @error('fecha_matricula') is-invalid @enderror"
                            id="fecha_matricula" name="fecha_matricula"
                            value="{{ old('fecha_matricula', $matricula->fecha_matricula ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('Y-m-d') : '') }}">
                        @error('fecha_matricula')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="em-label" for="estado">
                            <i class="fas fa-flag"></i> Estado <span class="req">*</span>
                        </label>
                        <div class="estado-select-wrap">
                            <select class="em-select @error('estado') is-invalid @enderror" id="estado" name="estado">
                                <option value="pendiente"  {{ old('estado', $matricula->estado) === 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada"   {{ old('estado', $matricula->estado) === 'aprobada'   ? 'selected' : '' }}>Aprobada</option>
                                <option value="rechazada"  {{ old('estado', $matricula->estado) === 'rechazada'  ? 'selected' : '' }}>Rechazada</option>
                                <option value="cancelada"  {{ old('estado', $matricula->estado) === 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                        @error('estado')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Motivo Rechazo (oculto si no aplica) --}}
                    <div id="motivo-rechazo-container" class="{{ old('estado', $matricula->estado) === 'rechazada' ? 'visible' : '' }}">
                        <label class="em-label" for="motivo_rechazo">
                            <i class="fas fa-exclamation-triangle"></i> Motivo del Rechazo
                        </label>
                        <input type="text" class="em-input @error('motivo_rechazo') is-invalid @enderror"
                            id="motivo_rechazo" name="motivo_rechazo"
                            value="{{ old('motivo_rechazo', $matricula->motivo_rechazo) }}"
                            placeholder="Especificar motivo...">
                        @error('motivo_rechazo')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-full">
                        <label class="em-label" for="observaciones">
                            <i class="fas fa-sticky-note"></i> Observaciones
                        </label>
                        <textarea class="em-textarea @error('observaciones') is-invalid @enderror"
                            id="observaciones" name="observaciones"
                            placeholder="Agregar observaciones adicionales...">{{ old('observaciones', $matricula->observaciones) }}</textarea>
                        @error('observaciones')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             SECCIÓN 2 · Documentos Adjuntos
        ══════════════════════════════════════ --}}
        <div class="em-card">
            <div class="em-card-header-light">
                <i class="fas fa-paperclip"></i>
                Documentos Adjuntos
            </div>
            <div class="em-card-body">

                <div class="em-alert em-alert-info" style="margin-bottom:1.1rem;">
                    <i class="fas fa-info-circle"></i>
                    <span>Solo sube nuevos archivos si deseas reemplazar los existentes. Los archivos actuales se mantendrán si no subes ninguno nuevo.</span>
                </div>

                <div class="fields-grid">

                    {{-- Foto del Estudiante --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-camera"></i></div>
                            <div>
                                <div class="doc-label-text">Foto del Estudiante</div>
                                @if($matricula->foto_estudiante)
                                    <a href="{{ asset('storage/' . $matricula->foto_estudiante) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file" class="em-input @error('foto_estudiante') is-invalid @enderror"
                            id="foto_estudiante" name="foto_estudiante" accept="image/*"
                            style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> JPG, PNG · Máx. 2MB</div>
                        @error('foto_estudiante')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Acta de Nacimiento --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-file-alt"></i></div>
                            <div>
                                <div class="doc-label-text">Acta de Nacimiento</div>
                                @if($matricula->acta_nacimiento)
                                    <a href="{{ asset('storage/' . $matricula->acta_nacimiento) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file" class="em-input @error('acta_nacimiento') is-invalid @enderror"
                            id="acta_nacimiento" name="acta_nacimiento" accept=".pdf,image/*"
                            style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> PDF, JPG, PNG · Máx. 5MB</div>
                        @error('acta_nacimiento')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Certificado de Estudios --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-certificate"></i></div>
                            <div>
                                <div class="doc-label-text">Certificado de Estudios</div>
                                @if($matricula->certificado_estudios)
                                    <a href="{{ asset('storage/' . $matricula->certificado_estudios) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file" class="em-input @error('certificado_estudios') is-invalid @enderror"
                            id="certificado_estudios" name="certificado_estudios" accept=".pdf,image/*"
                            style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> PDF, JPG, PNG · Máx. 5MB</div>
                        @error('certificado_estudios')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Constancia de Conducta --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-award"></i></div>
                            <div>
                                <div class="doc-label-text">Constancia de Conducta</div>
                                @if($matricula->constancia_conducta)
                                    <a href="{{ asset('storage/' . $matricula->constancia_conducta) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file" class="em-input @error('constancia_conducta') is-invalid @enderror"
                            id="constancia_conducta" name="constancia_conducta" accept=".pdf,image/*"
                            style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> PDF, JPG, PNG · Máx. 5MB</div>
                        @error('constancia_conducta')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- DNI Estudiante --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-id-card"></i></div>
                            <div>
                                <div class="doc-label-text">DNI del Estudiante</div>
                                @if($matricula->foto_dni_estudiante)
                                    <a href="{{ asset('storage/' . $matricula->foto_dni_estudiante) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file" class="em-input @error('foto_dni_estudiante') is-invalid @enderror"
                            id="foto_dni_estudiante" name="foto_dni_estudiante" accept="image/*"
                            style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> JPG, PNG · Máx. 2MB</div>
                        @error('foto_dni_estudiante')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- DNI Padre --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-id-card-alt"></i></div>
                            <div>
                                <div class="doc-label-text">DNI del Padre/Tutor</div>
                                @if($matricula->foto_dni_padre)
                                    <a href="{{ asset('storage/' . $matricula->foto_dni_padre) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file" class="em-input @error('foto_dni_padre') is-invalid @enderror"
                            id="foto_dni_padre" name="foto_dni_padre" accept="image/*"
                            style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> JPG, PNG · Máx. 2MB</div>
                        @error('foto_dni_padre')<div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             Footer · Botones de acción
        ══════════════════════════════════════ --}}
        <div class="em-footer">
            <button type="submit" class="em-btn btn-save">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a href="{{ route('matriculas.show', $matricula->id) }}" class="em-btn btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const estadoSelect = document.getElementById('estado');
    const motivoContainer = document.getElementById('motivo-rechazo-container');

    estadoSelect.addEventListener('change', function () {
        if (this.value === 'rechazada') {
            motivoContainer.classList.add('visible');
        } else {
            motivoContainer.classList.remove('visible');
            document.getElementById('motivo_rechazo').value = '';
        }
    });
});
</script>
@endpush