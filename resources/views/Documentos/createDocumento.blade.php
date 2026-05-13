@extends('layouts.app')

@section('content')
    <div class="container py-5" style="max-width: 900px;">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-folder-plus me-2"></i>Subir Nuevo Expediente Digital
                </h5>
            </div>
            <div class="card-body p-4">
                {{-- Formulario apuntando al método store del controlador --}}
                <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Selección de Estudiante --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-primary">Seleccionar Estudiante *</label>
                        <select name="estudiante_id" id="estudiante_id" required
                                class="form-select @error('estudiante_id') is-invalid @enderror"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; height: 45px;">
                            <option value="" selected disabled>Seleccione al alumno de la lista...</option>

                            @forelse($estudiantes as $est)
                                <option value="{{ $est->id }}" {{ old('estudiante_id') == $est->id ? 'selected' : '' }}>
                                    {{-- Usamos las columnas nombre1, nombre2, apellido1, apellido2 --}}
                                    {{ $est->nombre1 }} {{ $est->nombre2 }} {{ $est->apellido1 }} {{ $est->apellido2 }}
                                </option>
                            @empty
                                <option value="" disabled>⚠️ No hay estudiantes registrados en el sistema</option>
                            @endforelse
                        </select>
                        @error('estudiante_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        {{-- Foto del Estudiante --}}
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Foto Estudiante (JPG/PNG) *</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/*" required style="border: 2px solid #bfd9ea;">
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Acta de Nacimiento --}}
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Acta Nacimiento (PDF/JPG)</label>
                            <input type="file" name="acta_nacimiento" class="form-control"
                                   accept=".pdf,.jpg,.png" required style="border: 2px solid #bfd9ea;">
                        </div>

                        {{-- Calificaciones --}}
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Calificaciones (PDF/JPG)</label>
                            <input type="file" name="calificaciones" class="form-control"
                                   accept=".pdf,.jpg,.png" required style="border: 2px solid #bfd9ea;">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm"
                                style="background: linear-gradient(to right, #4ec7d2, #00508f); border: none; border-radius: 8px;">
                            <i class="fas fa-cloud-upload-alt me-2"></i>GUARDAR EXPEDIENTE
                        </button>
                        <a href="{{ route('documentos.index') }}" class="btn btn-light border py-2 fw-bold" style="border-radius: 8px;">
                            CANCELAR
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script para asegurar que el selector funcione si usas librerías de terceros --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var select = document.getElementById('estudiante_id');
            if (window.jQuery && jQuery.fn.select2) {
                $(select).select2('destroy');
            }
        });
    </script>
@endsection
