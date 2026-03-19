@extends('layouts.app')

@section('title', 'Nueva Sección')
@section('page-title', 'Crear Nueva Sección')

@section('topbar-actions')
    <a href="{{ route('secciones.index') }}"
       style="background:white; color:#00508f; padding:0.5rem 1.2rem; border-radius:8px;
              text-decoration:none; font-weight:600; display:inline-flex; align-items:center;
              gap:0.5rem; border:2px solid #00508f;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width:600px;">

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"
         style="border-radius:10px; border-left:4px solid #dc3545;">
        <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header text-white fw-bold"
             style="background:linear-gradient(135deg,#4ec7d2,#00508f);
                    border-radius:12px 12px 0 0; padding:1.2rem;">
            <i class="fas fa-plus-circle me-2"></i>Nueva Sección
        </div>
        <div class="card-body p-4">
            <form action="{{ route('secciones.store') }}" method="POST">
                @csrf

                {{-- Grado --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:#003b73;">
                        <i class="fas fa-graduation-cap me-1"></i>Grado *
                    </label>
                    <select name="grado" class="form-select" required
                            style="border-radius:8px; border:2px solid #bfd9ea;">
                        <option value="">— Seleccione un grado —</option>
                        @foreach($grados as $g)
                            <option value="{{ $g }}" {{ old('grado') === $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                    @error('grado')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Letra/Sección --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:#003b73;">
                        <i class="fas fa-chalkboard me-1"></i>Letra de Sección *
                    </label>
                    <select name="seccion" class="form-select" required
                            style="border-radius:8px; border:2px solid #bfd9ea;">
                        <option value="">— Seleccione —</option>
                        @foreach(['A','B','C','D'] as $letra)
                            <option value="{{ $letra }}" {{ old('seccion') === $letra ? 'selected' : '' }}>
                                Sección {{ $letra }}
                            </option>
                        @endforeach
                    </select>
                    @error('seccion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Capacidad --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color:#003b73;">
                        <i class="fas fa-users me-1"></i>Capacidad *
                    </label>
                    <input type="number" name="capacidad" class="form-control"
                           value="{{ old('capacidad', 30) }}"
                           min="1" max="60" required
                           style="border-radius:8px; border:2px solid #bfd9ea;">
                    @error('capacidad')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('secciones.index') }}"
                    class="btn btn-secondary" style="border-radius:8px;">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn text-white fw-semibold"
                            style="background:linear-gradient(135deg,#4ec7d2,#00508f);
                            border-radius:8px; border:none; padding:0.5rem 1.4rem;">
                        <i class="fas fa-save me-1"></i>Guardar Sección
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection