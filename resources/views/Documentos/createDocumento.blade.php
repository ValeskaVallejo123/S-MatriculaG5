@extends('layouts.app')

@section('title', 'Subir Expediente')
@section('page-title', 'Subir Nuevo Expediente Digital')

@section('content')
    <div class="container py-4" style="max-width: 950px;">

        {{-- Botón Volver --}}
        <div class="mb-4">
            <a href="{{ route('documentos.index') }}" class="btn btn-light shadow-sm fw-bold text-muted" style="border-radius: 10px; padding: 10px 20px;">
                <i class="fas fa-arrow-left me-2"></i> Volver al Listado
            </a>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
            {{-- Encabezado con el degradado de tu sistema --}}
            <div class="card-header border-0 py-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); color: white;">
                <div class="d-flex align-items-center">
                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="fas fa-file-upload" style="color: #00508f; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Formulario de Registro</h5>
                        <small class="opacity-75">Complete todos los campos marcados con asterisco (*)</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" id="formExpediente">
                    @csrf

                    <div class="row">
                        {{-- Selección de Estudiante --}}
                        <div class="col-12 mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">1. Seleccionar Estudiante *</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0;">
                                <span class="input-group-text bg-white border-0"><i class="fas fa-user-graduate text-primary"></i></span>
                                <select name="estudiante_id" id="estudiante_id" required
                                        class="form-select border-0 @error('estudiante_id') is-invalid @enderror"
                                        style="height: 55px; font-weight: 500;">
                                    <option value="" selected disabled>Buscar alumno en la base de datos...</option>
                                    @foreach($estudiantes as $est)
                                        <option value="{{ $est->id }}" {{ old('estudiante_id') == $est->id ? 'selected' : '' }}>
                                            {{ strtoupper($est->nombre1) }} {{ strtoupper($est->nombre2) }} {{ strtoupper($est->apellido1) }} {{ strtoupper($est->apellido2) }} — DNI: {{ $est->dni }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('estudiante_id') <div class="text-danger small mt-1 ps-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 mb-2">
                            <label class="form-label small fw-bold text-uppercase text-muted">2. Documentación Digital *</label>
                        </div>

                        {{-- Sección de Archivos con diseño de Dropzone simulado --}}
                        <div class="col-md-4 mb-4">
                            <div class="file-upload-wrapper">
                                <label class="small fw-bold mb-2 d-block">Foto de Perfil</label>
                                <div class="upload-area" onclick="document.getElementById('foto').click()">
                                    <i class="fas fa-camera mb-2"></i>
                                    <p class="mb-0 small">JPG o PNG</p>
                                    <input type="file" name="foto" id="foto" class="d-none" accept="image/*" required onchange="updateFileName(this)">
                                    <div class="file-name mt-2 text-primary fw-bold small"></div>
                                </div>
                                @error('foto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="file-upload-wrapper">
                                <label class="small fw-bold mb-2 d-block">Acta de Nacimiento</label>
                                <div class="upload-area" onclick="document.getElementById('acta_nacimiento').click()">
                                    <i class="fas fa-id-card mb-2"></i>
                                    <p class="mb-0 small">PDF o Imagen</p>
                                    <input type="file" name="acta_nacimiento" id="acta_nacimiento" class="d-none" accept=".pdf,.jpg,.png" required onchange="updateFileName(this)">
                                    <div class="file-name mt-2 text-primary fw-bold small"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="file-upload-wrapper">
                                <label class="small fw-bold mb-2 d-block">Calificaciones</label>
                                <div class="upload-area" onclick="document.getElementById('calificaciones').click()">
                                    <i class="fas fa-file-invoice mb-2"></i>
                                    <p class="mb-0 small">PDF o Imagen</p>
                                    <input type="file" name="calificaciones" id="calificaciones" class="d-none" accept=".pdf,.jpg,.png" required onchange="updateFileName(this)">
                                    <div class="file-name mt-2 text-primary fw-bold small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Acciones Finales --}}
                    <div class="row mt-4 pt-3 border-top">
                        <div class="col-md-6 mb-2">
                            <button type="submit" class="btn w-100 py-3 fw-bold text-white shadow-sm btn-save"
                                    style="background: linear-gradient(to right, #4ec7d2, #00508f); border: none; border-radius: 12px; font-size: 1.1rem;">
                                <i class="fas fa-cloud-upload-alt me-2"></i> GUARDAR EXPEDIENTE
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('documentos.index') }}" class="btn btn-light border w-100 py-3 fw-bold text-muted" style="border-radius: 12px; font-size: 1.1rem;">
                                CANCELAR REGISTRO
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .upload-area {
            border: 2px dashed #bfd9ea;
            border-radius: 12px;
            padding: 30px 15px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #64748b;
        }
        .upload-area:hover {
            border-color: #4ec7d2;
            background: #f0f9ff;
            color: #00508f;
        }
        .upload-area i {
            font-size: 1.8rem;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,80,143,0.3) !important;
        }
        .form-select:focus {
            box-shadow: none;
            border-color: #4ec7d2;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Función para mostrar el nombre del archivo seleccionado en el diseño
        function updateFileName(input) {
            const fileName = input.files[0].name;
            const display = input.parentElement.querySelector('.file-name');
            const icon = input.parentElement.querySelector('i');

            display.innerText = fileName;
            icon.classList.remove('fa-camera', 'fa-id-card', 'fa-file-invoice');
            icon.classList.add('fa-check-circle');
            input.parentElement.style.borderColor = "#4ec7d2";
            input.parentElement.style.background = "#f0f9ff";
        }
    </script>
@endpush
