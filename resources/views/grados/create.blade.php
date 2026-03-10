@extends('layouts.app')

@section('title', 'Nuevo Grado')

@section('page-title', 'Crear Nuevo Grado')

@section('topbar-actions')
    <a href="{{ route('superadmin.grados.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-graduation-cap"></i> Formulario de Nuevo Grado
            </h5>
        </div>
        <div class="card-body p-4">

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert"
                 style="border-radius: 8px; border-left: 4px solid #ef4444;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('superadmin.grados.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="nivel" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-layer-group text-primary"></i> Nivel Educativo *
                        </label>
                        <select class="form-select @error('nivel') is-invalid @enderror"
                                id="nivel"
                                name="nivel"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar nivel...</option>
                            <option value="primaria"   {{ old('nivel') === 'primaria'   ? 'selected' : '' }}>
                                Primaria (1° - 6° Grado)
                            </option>
                            <option value="secundaria" {{ old('nivel') === 'secundaria' ? 'selected' : '' }}>
                                Secundaria (7° - 9° Grado)
                            </option>
                        </select>
                        @error('nivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="numero" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-sort-numeric-up text-success"></i> Número de Grado *
                        </label>
                        <select class="form-select @error('numero') is-invalid @enderror"
                                id="numero"
                                name="numero"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar grado...</option>
                            @for($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ old('numero') == $i ? 'selected' : '' }}>
                                    {{ $i }}° Grado
                                </option>
                            @endfor
                        </select>
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                            @foreach(['A','B','C','D'] as $sec)
                                <option value="{{ $sec }}" {{ old('seccion') === $sec ? 'selected' : '' }}>
                                    Sección {{ $sec }}
                                </option>
                            @endforeach
                        </select>
                        @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="anio_lectivo" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-calendar-alt text-warning"></i> Año Lectivo *
                        </label>
                        <input type="number"
                               class="form-control @error('anio_lectivo') is-invalid @enderror"
                               id="anio_lectivo"
                               name="anio_lectivo"
                               value="{{ old('anio_lectivo', date('Y')) }}"
                               min="2020" max="2100" required
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        @error('anio_lectivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="capacidad" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-users text-secondary"></i> Capacidad de Sección *
                        </label>
                        <input type="number"
                               class="form-control @error('capacidad') is-invalid @enderror"
                               id="capacidad"
                               name="capacidad"
                               value="{{ old('capacidad', 30) }}"
                               min="1" max="60" required
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        @error('capacidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch mb-2" style="padding-left: 3.5rem;">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="activo"
                                   name="activo"
                                   value="1"
                                   {{ old('activo', true) ? 'checked' : '' }}
                                   style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            <label class="form-check-label fw-semibold" for="activo"
                                   style="color: #003b73; margin-left: 0.5rem;">
                                <i class="fas fa-toggle-on text-success"></i> Grado Activo
                            </label>
                        </div>
                    </div>
                </div>

                <div id="info-primaria" class="alert mt-4 d-none d-flex align-items-start"
                     style="border-radius: 8px; border-left: 4px solid #10b981; background: rgba(16,185,129,0.08);">
                    <i class="fas fa-magic me-2 mt-1" style="color: #10b981;"></i>
                    <div>
                        <strong style="color: #065f46;">Asignación automática:</strong>
                        <p class="mb-0 small text-muted">
                            Al guardar se asignarán automáticamente las materias base de Primaria.
                        </p>
                    </div>
                </div>

                <div id="info-secundaria" class="alert mt-4 d-none d-flex align-items-start"
                     style="border-radius: 8px; border-left: 4px solid #4ec7d2; background: rgba(78,199,210,0.1);">
                    <i class="fas fa-info-circle me-2 mt-1" style="color: #00508f;"></i>
                    <div>
                        <strong style="color: #003b73;">Secundaria:</strong>
                        <p class="mb-0 small text-muted">
                            Después de guardar podrás asignar las materias manualmente.
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.7rem; font-weight: 600; border: none;">
                        <i class="fas fa-save"></i> Guardar Grado
                    </button>
                    <a href="{{ route('superadmin.grados.index') }}" class="btn flex-fill"
                       style="background: white; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0.7rem; font-weight: 600;">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection