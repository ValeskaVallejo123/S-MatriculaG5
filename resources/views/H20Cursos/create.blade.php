@extends('layouts.app')

@section('title', 'Nuevo Curso')
@section('page-title', 'Crear Nuevo Curso')

@section('topbar-actions')
    <a href="{{ route('h20cursos.index') }}" class="btn-back"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 900px;">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-book"></i> Formulario de Nuevo Curso
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('h20cursos.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- Nombre del Curso -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold" style="color: #003b73;">
                                <i class="fas fa-chalkboard text-primary"></i> Nombre del Curso *
                            </label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre') }}"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cupo Máximo -->
                        <div class="col-md-6">
                            <label for="cupo_maximo" class="form-label fw-semibold" style="color: #003b73;">
                                <i class="fas fa-users text-success"></i> Cupo Máximo *
                            </label>
                            <input type="number"
                                   class="form-control @error('cupo_maximo') is-invalid @enderror"
                                   id="cupo_maximo"
                                   name="cupo_maximo"
                                   value="{{ old('cupo_maximo') }}"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            @error('cupo_maximo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sección -->
                        <div class="col-md-6">
                            <label for="seccion" class="form-label fw-semibold" style="color: #003b73;">
                                <i class="fas fa-list-ol text-info"></i> Sección *
                            </label>
                            <select class="form-select @error('seccion') is-invalid @enderror"
                                    id="seccion"
                                    name="seccion"
                                    required
                                    style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                                <option value="">Seleccionar sección...</option>
                                <option value="A" {{ old('seccion') == 'A' ? 'selected' : '' }}>Sección A</option>
                                <option value="B" {{ old('seccion') == 'B' ? 'selected' : '' }}>Sección B</option>
                                <option value="C" {{ old('seccion') == 'C' ? 'selected' : '' }}>Sección C</option>
                                <option value="D" {{ old('seccion') == 'D' ? 'selected' : '' }}>Sección D</option>
                            </select>
                            @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success fw-semibold"
                                style="padding: 0.6rem 1.4rem; border-radius: 8px;">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="{{ route('h20cursos.index') }}" class="btn btn-secondary fw-semibold"
                           style="padding: 0.6rem 1.4rem; border-radius: 8px;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
