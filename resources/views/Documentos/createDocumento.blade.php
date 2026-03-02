@extends('layouts.app')

@section('content')
    <div class="container py-5" style="max-width: 900px;">

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="fas fa-folder-open text-primary fs-4"></i>
                    </div>
                    <h5 class="fw-bold mb-0" style="color: #003b73;">Subir Expediente Digital</h5>
                </div>

                <div class="alert border-0 p-4 mb-4" style="background-color: #f0f9fa; border-radius: 10px;">
                    <h6 class="fw-bold small mb-3" style="color: #00508f;">
                        <i class="fas fa-clipboard-check me-2"></i>Documentos que deberá presentar:
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 small"><i class="fas fa-check-circle text-info me-2"></i>Foto del estudiante (formato JPG/PNG)</li>
                        <li class="mb-2 small"><i class="fas fa-check-circle text-info me-2"></i>Acta de nacimiento (PDF/JPG/PNG)</li>
                        <li class="small"><i class="fas fa-check-circle text-info me-2"></i>Calificaciones del año anterior (PDF/JPG/PNG)</li>
                    </ul>
                </div>

                <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: #003b73;">Seleccionar Estudiante</label>
                        <select name="estudiante_id" required class="form-select @error('estudiante_id') is-invalid @enderror" style="border: 2px solid #bfd9ea; border-radius: 8px; height: 45px;">
                            <option value="">Seleccione al alumno...</option>
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}" {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                                    {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('estudiante_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Foto Estudiante</label>
                            <div class="mb-2 text-center" style="min-height: 90px;">
                                <img id="preview-foto" src="#" alt="Previsualización" class="rounded shadow-sm d-none" style="width: 85px; height: 85px; object-fit: cover; border: 2px solid #4ec7d2;">
                                <div id="placeholder-foto" class="rounded bg-light d-flex align-items-center justify-content-center mx-auto" style="width: 85px; height: 85px; border: 2px dashed #bfd9ea;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            </div>
                            <input type="file" name="foto" id="input-foto" class="form-control @error('foto') is-invalid @enderror" accept=".jpg,.png" required style="border: 2px solid #bfd9ea;">
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Acta Nacimiento</label>
                            <div class="mb-2 text-center" style="min-height: 90px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-pdf fa-3x text-danger opacity-25"></i>
                            </div>
                            <input type="file" name="acta_nacimiento" class="form-control @error('acta_nacimiento') is-invalid @enderror" accept=".pdf,.jpg,.png" required style="border: 2px solid #bfd9ea;">
                            @error('acta_nacimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Calificaciones</label>
                            <div class="mb-2 text-center" style="min-height: 90px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-invoice fa-3x text-success opacity-25"></i>
                            </div>
                            <input type="file" name="calificaciones" class="form-control @error('calificaciones') is-invalid @enderror" accept=".pdf,.jpg,.png" required style="border: 2px solid #bfd9ea;">
                            @error('calificaciones') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="background: linear-gradient(to right, #4ec7d2, #00508f); border: none; border-radius: 8px; letter-spacing: 1px;">
                        <i class="fas fa-cloud-upload-alt me-2"></i>GUARDAR EXPEDIENTE
                    </button>
                </form>

                <div class="alert border-0 mt-4 p-3" style="background-color: #f8fafc; border-left: 4px solid #4ec7d2;">
                    <p class="mb-0 small text-muted">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Recuerde: Los archivos no deben exceder los **5MB** para asegurar una subida correcta.
                    </p>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3">
            <a href="{{ route('matriculas.index') }}" class="btn btn-outline-secondary flex-fill fw-bold py-2" style="border-radius: 8px;">
                <i class="fas fa-arrow-left me-2"></i>Volver a Matrícula
            </a>
            <a href="{{ route('documentos.index') }}" class="btn btn-light border flex-fill fw-bold py-2" style="border-radius: 8px; color: #64748b;">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
        </div>
    </div>

    {{-- Script para Previsualización en Tiempo Real --}}
    <script>
        document.getElementById('input-foto').onchange = evt => {
            const [file] = document.getElementById('input-foto').files
            if (file) {
                const preview = document.getElementById('preview-foto');
                const placeholder = document.getElementById('placeholder-foto');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
        }
    </script>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> dev/valeska
