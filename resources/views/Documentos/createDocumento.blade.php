@extends('layouts.app')

@section('title', 'Subir Expediente Digital')
@section('page-title', 'Subir Expediente Digital')

@section('content-class', 'p-0')

@push('styles')
<style>
.content-wrapper.p-0 {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.doc-create-wrapper {
    height: 100%;
    display: flex;
    overflow: hidden;
}

.doc-form-panel {
    flex: 1;
    overflow-y: auto;
    padding: 2rem 2.5rem;
    background: #f8fafc;
}


.doc-field-card {
    background: white;
    border-radius: 12px;
    padding: 1.4rem;
    box-shadow: 0 1px 4px rgba(0,59,115,.07);
    margin-bottom: 1.25rem;
    border: 1px solid #e8eef5;
}

.doc-section-title {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: #4ec7d2; margin-bottom: 1.1rem;
    padding-bottom: .45rem; border-bottom: 1px solid #f1f5f9;
}

.file-zone {
    border: 2px dashed #bfd9ea;
    border-radius: 10px;
    padding: 1.25rem .75rem;
    text-align: center;
    transition: border-color .2s, background .2s;
    cursor: pointer;
}
.file-zone:hover { border-color: #4ec7d2; background: rgba(78,199,210,.04); }
.file-zone input[type="file"] { display: none; }
.file-zone label { cursor: pointer; display: block; }

body.dark-mode .doc-form-panel  { background: #0f172a !important; }
body.dark-mode .doc-field-card  { background: #1e293b !important; border-color: #334155 !important; }
body.dark-mode .doc-section-title { color: #4ec7d2 !important; border-bottom-color: #334155 !important; }
body.dark-mode .file-zone { border-color: #334155 !important; }
</style>
@endpush

@section('content')
<div class="doc-create-wrapper">

    {{-- Panel izquierdo: formulario --}}
    <div class="doc-form-panel">

        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Estudiante --}}
            <div class="doc-field-card">
                <div class="doc-section-title"><i class="fas fa-user-graduate me-1"></i>Estudiante</div>
                <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                <div class="d-flex align-items-center gap-3 p-3"
                     style="background:#f0f9fa;border:2px solid #4ec7d2;border-radius:9px;">
                    <div style="width:48px;height:48px;background:linear-gradient(135deg,#4ec7d2,#00508f);
                                border-radius:11px;display:flex;align-items:center;justify-content:center;
                                color:white;font-weight:800;font-size:1.1rem;flex-shrink:0;">
                        {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1) . substr($estudiante->apellido1 ?? '', 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold" style="color:#003b73;font-size:.95rem;">
                            {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                            {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                        </div>
                        <small style="color:#64748b;">
                            <i class="fas fa-id-card me-1"></i>{{ $estudiante->dni ?? '—' }}
                            &nbsp;·&nbsp;
                            <i class="fas fa-graduation-cap me-1"></i>{{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Fila 1: Foto + Acta + Calificaciones --}}
            <div class="row g-4 mb-0">
                {{-- Foto --}}
                <div class="col-lg-4">
                    <div class="doc-field-card">
                        <div class="doc-section-title"><i class="fas fa-camera me-1"></i>Foto del Estudiante</div>
                        <div class="file-zone mb-2" onclick="document.getElementById('input-foto').click()">
                            <label>
                                <img id="preview-foto" src="#" alt="Preview"
                                     class="rounded d-none mb-2"
                                     style="width:80px;height:80px;object-fit:cover;border:2px solid #4ec7d2;">
                                <div id="placeholder-foto">
                                    <i class="fas fa-user-circle fa-2x mb-2" style="color:#cbd5e1;display:block;"></i>
                                    <span style="font-size:.78rem;color:#94a3b8;">Haz clic para seleccionar</span><br>
                                    <span style="font-size:.72rem;color:#cbd5e1;">JPG, PNG — máx. 2MB</span>
                                </div>
                            </label>
                            <input type="file" name="foto" id="input-foto"
                                   class="@error('foto') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png">
                        </div>
                        <small class="text-muted" style="font-size:.72rem;">Opcional</small>
                        @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Acta de nacimiento --}}
                <div class="col-lg-4">
                    <div class="doc-field-card">
                        <div class="doc-section-title"><i class="fas fa-file-alt me-1"></i>Acta de Nacimiento</div>
                        <div class="file-zone mb-2" onclick="document.getElementById('input-acta').click()">
                            <label>
                                <i class="fas fa-file-pdf fa-2x mb-2" style="color:#ef4444;opacity:.4;display:block;"></i>
                                <span id="nombre-acta" style="font-size:.78rem;color:#94a3b8;">Haz clic para seleccionar</span><br>
                                <span style="font-size:.72rem;color:#cbd5e1;">PDF, JPG, PNG — máx. 5MB</span>
                            </label>
                            <input type="file" name="acta_nacimiento" id="input-acta"
                                   class="@error('acta_nacimiento') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                        <small class="text-danger" style="font-size:.72rem;">* Obligatorio</small>
                        @error('acta_nacimiento')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Calificaciones --}}
                <div class="col-lg-4">
                    <div class="doc-field-card">
                        <div class="doc-section-title"><i class="fas fa-star me-1"></i>Calificaciones Anteriores</div>
                        <div class="file-zone mb-2" onclick="document.getElementById('input-cal').click()">
                            <label>
                                <i class="fas fa-file-invoice fa-2x mb-2" style="color:#059669;opacity:.4;display:block;"></i>
                                <span id="nombre-cal" style="font-size:.78rem;color:#94a3b8;">Haz clic para seleccionar</span><br>
                                <span style="font-size:.72rem;color:#cbd5e1;">PDF, JPG, PNG — máx. 5MB</span>
                            </label>
                            <input type="file" name="calificaciones" id="input-cal"
                                   class="@error('calificaciones') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                        <small class="text-danger" style="font-size:.72rem;">* Obligatorio</small>
                        @error('calificaciones')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Fila 2: Tarjeta padre + Constancia médica --}}
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="doc-field-card">
                        <div class="doc-section-title"><i class="fas fa-id-card me-1"></i>Tarjeta Identidad del Padre</div>
                        <div class="file-zone mb-2" onclick="document.getElementById('input-tid').click()">
                            <label>
                                <i class="fas fa-id-card fa-2x mb-2" style="color:#00508f;opacity:.4;display:block;"></i>
                                <span id="nombre-tid" style="font-size:.78rem;color:#94a3b8;">Haz clic para seleccionar</span><br>
                                <span style="font-size:.72rem;color:#cbd5e1;">PDF, JPG, PNG — máx. 5MB</span>
                            </label>
                            <input type="file" name="tarjeta_identidad_padre" id="input-tid"
                                   class="@error('tarjeta_identidad_padre') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <small class="text-muted" style="font-size:.72rem;">Opcional</small>
                        @error('tarjeta_identidad_padre')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="doc-field-card">
                        <div class="doc-section-title"><i class="fas fa-notes-medical me-1"></i>Constancia Médica</div>
                        <div class="file-zone mb-2" onclick="document.getElementById('input-med').click()">
                            <label>
                                <i class="fas fa-file-medical fa-2x mb-2" style="color:#f59e0b;opacity:.4;display:block;"></i>
                                <span id="nombre-med" style="font-size:.78rem;color:#94a3b8;">Haz clic para seleccionar</span><br>
                                <span style="font-size:.72rem;color:#cbd5e1;">PDF, JPG, PNG — máx. 5MB</span>
                            </label>
                            <input type="file" name="constancia_medica" id="input-med"
                                   class="@error('constancia_medica') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <small class="text-muted" style="font-size:.72rem;">Opcional</small>
                        @error('constancia_medica')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-3 align-items-center mt-1">
                <button type="submit"
                        style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;
                               padding:.6rem 2rem;border-radius:9px;font-weight:700;font-size:.9rem;
                               box-shadow:0 2px 10px rgba(78,199,210,.3);cursor:pointer;">
                    <i class="fas fa-cloud-upload-alt me-2"></i>Guardar Expediente
                </button>
                <a href="{{ route('documentos.index') }}"
                   style="color:#64748b;font-size:.85rem;text-decoration:none;font-weight:600;">
                    Cancelar
                </a>
            </div>

        </form>
    </div>


</div>
@endsection

@push('scripts')
<script>
// Preview foto
document.getElementById('input-foto').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        document.getElementById('preview-foto').src = URL.createObjectURL(file);
        document.getElementById('preview-foto').classList.remove('d-none');
        document.getElementById('placeholder-foto').style.display = 'none';
    }
});

// Mostrar nombre de archivo seleccionado
[
    ['input-acta', 'nombre-acta'],
    ['input-cal',  'nombre-cal'],
    ['input-tid',  'nombre-tid'],
    ['input-med',  'nombre-med'],
].forEach(([inputId, labelId]) => {
    document.getElementById(inputId).addEventListener('change', function () {
        const span = document.getElementById(labelId);
        if (this.files[0]) {
            span.textContent = this.files[0].name;
            span.style.color = '#00508f';
            span.style.fontWeight = '600';
        }
    });
});
</script>
@endpush
