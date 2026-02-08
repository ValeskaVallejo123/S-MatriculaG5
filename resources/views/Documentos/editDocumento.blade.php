@extends('layouts.app')

@section('title', 'Editar Documentos')

@section('page-title', 'Editar Documentos')

@section('topbar-actions')
    <a href="{{ route('documentos.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 900px;">

        {{-- Cabecera con degradado --}}
        <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-edit text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Expediente</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice los archivos del estudiante seleccionado</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Selección de Estudiante --}}
                    <div class="mb-4">
                        <label for="estudiante_id" class="form-label small fw-bold" style="color: #003b73;">Estudiante Asociado *</label>
                        <div class="position-relative">
                            <i class="fas fa-graduation-cap position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #00508f; z-index: 10;"></i>
                            <select name="estudiante_id" id="estudiante_id" class="form-select ps-5 @error('estudiante_id') is-invalid @enderror" required style="border: 2px solid #bfd9ea; border-radius: 8px; height: 48px;">
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}" {{ $documento->estudiante_id == $estudiante->id ? 'selected' : '' }}>
                                        {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estudiante_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Sección de Fotografía --}}
                    <div class="mb-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-camera" style="color: #00508f;"></i>
                            <h6 class="mb-0 fw-bold" style="color: #003b73;">Fotografía del Estudiante</h6>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                @if($documento->foto)
                                    <img src="{{ asset('storage/' . $documento->foto) }}" class="rounded shadow-sm" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #4ec7d2;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; border: 2px dashed #bfd9ea;">
                                        <i class="fas fa-user text-muted fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9 mt-3 mt-md-0">
                                <label class="form-label small fw-semibold">Reemplazar Fotografía</label>
                                <div class="position-relative">
                                    <i class="fas fa-upload position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #00508f;"></i>
                                    <input type="file" name="foto" accept="image/jpeg,image/png" class="form-control ps-5 @error('foto') is-invalid @enderror" style="border: 2px solid #bfd9ea; border-radius: 8px; height: 45px; padding-top: 10px;">
                                    <small class="text-muted d-block mt-1"><i class="fas fa-info-circle me-1"></i>Deje vacío para conservar la actual. JPG o PNG (Máx 5MB).</small>
                                    @error('foto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Documentos Adicionales --}}
                    <div class="mb-4 pt-3 border-top">
                        <div class="row g-4">
                            {{-- Acta de Nacimiento --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003b73;">Acta de Nacimiento</label>
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $documento->acta_nacimiento) }}" target="_blank" class="btn btn-sm btn-outline-info w-100 py-2" style="border-radius: 8px;">
                                        <i class="fas fa-eye me-1"></i> Ver archivo actual
                                    </a>
                                </div>
                                <input type="file" name="acta_nacimiento" accept=".pdf,.jpg,.png" class="form-control @error('acta_nacimiento') is-invalid @enderror" style="border: 2px solid #bfd9ea; border-radius: 8px;">
                                @error('acta_nacimiento') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Calificaciones --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" style="color: #003b73;">Calificaciones</label>
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $documento->calificaciones) }}" target="_blank" class="btn btn-sm btn-outline-info w-100 py-2" style="border-radius: 8px;">
                                        <i class="fas fa-eye me-1"></i> Ver archivo actual
                                    </a>
                                </div>
                                <input type="file" name="calificaciones" accept=".pdf,.jpg,.png" class="form-control @error('calificaciones') is-invalid @enderror" style="border: 2px solid #bfd9ea; border-radius: 8px;">
                                @error('calificaciones') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Botones Finales --}}
                    <div class="d-flex gap-3 pt-3 border-top">
                        <button type="submit" class="btn fw-bold flex-fill text-white shadow-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border: none; padding: 0.9rem; border-radius: 10px;">
                            <i class="fas fa-sync-alt me-2"></i> ACTUALIZAR EXPEDIENTE
                        </button>
                        <a href="{{ route('documentos.index') }}" class="btn fw-bold flex-fill shadow-sm" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.9rem; border-radius: 10px;">
                            CANCELAR
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .form-select:focus, .form-control:focus {
                border-color: #4ec7d2 !important;
                box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.2) !important;
            }
            .ps-5 { padding-left: 3rem !important; }
            .btn { transition: all 0.3s ease; }
            .btn:hover { transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
            img { transition: all 0.3s ease; }
            img:hover { transform: scale(1.05); }
        </style>
    @endpush
@endsection
