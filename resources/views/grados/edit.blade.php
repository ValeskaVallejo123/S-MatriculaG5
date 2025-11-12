@extends('layouts.app')

@section('title', 'Editar Grado')

@section('page-title', 'Editar Grado')

@section('topbar-actions')
    <a href="{{ route('grados.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver a Grados
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 800px;">

    <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book-reader text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Grado</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice la información del grado: **{{ $grado->nombre }} - {{ $grado->seccion }}**</p>
                    </div>
                </div>
                <div style="background: rgba(78, 199, 210, 0.2); padding: 0.4rem 0.8rem; border-radius: 6px;">
                    <p class="text-white mb-0 small fw-semibold" style="font-size: 0.8rem;">ID: #{{ $grado->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-4">
            <form action="{{ route('grados.update', $grado) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <h6 class="mb-3 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-school me-2" style="font-size: 0.9rem;"></i>Detalles del Grado
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold small mb-1">
                                Nombre del Grado <span class="text-danger">*</span>
                            </label>
                            <select name="nombre" id="nombre"
                                    class="form-select form-select-sm @error('nombre') is-invalid @enderror"
                                    required>
                                <option value="">Seleccione un grado</option>
                                {{-- Opciones de Grado --}}
                                @php
                                    $opcionesGrados = ['Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto'];
                                @endphp
                                @foreach($opcionesGrados as $opcion)
                                    <option value="{{ $opcion }}" {{ old('nombre', $grado->nombre) == $opcion ? 'selected' : '' }}>
                                        {{ $opcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nombre')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="seccion" class="form-label fw-semibold small mb-1">
                                Sección
                            </label>
                            <input type="text" name="seccion" id="seccion"
                                   class="form-control form-control-sm @error('seccion') is-invalid @enderror"
                                   placeholder="Ej: A, B, C, Única"
                                   value="{{ old('seccion', $grado->seccion) }}">
                            @error('seccion')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="nombre_maestro" class="form-label fw-semibold small mb-1">
                                Nombre del Maestro <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre_maestro" id="nombre_maestro"
                                   class="form-control form-control-sm @error('nombre_maestro') is-invalid @enderror"
                                   placeholder="Ingrese el nombre completo del maestro"
                                   value="{{ old('nombre_maestro', $grado->nombre_maestro) }}"
                                   required>
                            @error('nombre_maestro')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="mb-3 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-clock me-2" style="font-size: 0.9rem;"></i>Jornada <span class="text-danger">*</span>
                    </h6>

                    <div class="d-flex gap-4">
                        <div class="form-check form-check-inline">
                            <input type="radio" name="jornada" id="jornada_matutina" value="Matutina"
                                   class="form-check-input @error('jornada') is-invalid @enderror"
                                   {{ old('jornada', $grado->jornada) == 'Matutina' ? 'checked' : '' }}
                                   required>
                            <label class="form-check-label small fw-semibold" for="jornada_matutina">Jornada Matutina</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="jornada" id="jornada_vespertina" value="Vespertina"
                                   class="form-check-input @error('jornada') is-invalid @enderror"
                                   {{ old('jornada', $grado->jornada) == 'Vespertina' ? 'checked' : '' }}
                                   required>
                            <label class="form-check-label small fw-semibold" for="jornada_vespertina">Jornada Vespertina</label>
                        </div>
                    </div>
                    @error('jornada')
                        <div class="text-danger small mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 pt-3 border-top">
                    <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-save me-1"></i>Actualizar Grado
                    </button>
                    <a href="{{ route('grados.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="alert border-0 mt-2 py-2 px-3" style="border-radius: 8px; background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
            <div>
                <strong style="color: #00508f;">Importante:</strong>
                <span class="text-muted"> Asegúrese de que todos los campos requeridos estén llenos antes de actualizar.</span>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* Estilos copiados del edit de estudiante */
    .form-control-sm, .form-select-sm {
        border-radius: 6px;
        border: 1.5px solid #e2e8f0;
        padding: 0.5rem 0.75rem;
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }

    .form-control-sm:focus, .form-select-sm:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
    }

    .form-label {
        color: #003b73;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }

    button[type="submit"]:hover {
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    .border-bottom {
        border-color: rgba(0, 80, 143, 0.15) !important;
    }

    /* Estilo para los radio buttons */
    .form-check-input {
        border-radius: 50% !important;
    }
</style>
@endpush
@endsection