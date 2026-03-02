@extends('layouts.app')

@section('title', 'Crear Observación')

@section('page-title', 'Nueva Observación')

@section('topbar-actions')
    <a href="{{ route('observaciones.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1200px;">

        <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-note-sticky text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Registro de Observación</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Complete la información (opcional)</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form action="{{ route('observaciones.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Estudiante</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="estudiante_id" class="form-label small fw-semibold" style="color: #003b73;">Estudiante</label>
                                <div class="position-relative">
                                    <i class="fas fa-users position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5" id="estudiante_id" name="estudiante_id" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem;">
                                        <option value="">Seleccione un estudiante (opcional)</option>
                                        @foreach($estudiantes as $est)
                                            <option value="{{ $est->id }}" {{ old('estudiante_id') == $est->id ? 'selected' : '' }}>{{ $est->nombreCompleto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Tipo de Observación</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tipo" class="form-label small fw-semibold" style="color: #003b73;">Tipo</label>
                                <div class="position-relative">
                                    <i class="fas fa-list-check position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5" id="tipo" name="tipo" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem;">
                                        <option value="">Sin definir</option>
                                        <option value="positivo" {{ old('tipo') == 'positivo' ? 'selected' : '' }}>Positivo</option>
                                        <option value="negativo" {{ old('tipo') == 'negativo' ? 'selected' : '' }}>Negativo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-alt" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Descripción</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="descripcion" class="form-label small fw-semibold" style="color: #003b73;">Descripción</label>
                                <div class="position-relative">
                                    <i class="fas fa-pen-to-square position-absolute" style="left: 12px; top: 12px; color: #00508f; font-size: 0.85rem;"></i>
                                    <textarea class="form-control ps-5" id="descripcion" name="descripcion" rows="4" placeholder="Escriba la descripción (opcional)" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; resize: none;">{{ old('descripcion') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Registrar Observación
                        </button>
                        <a href="{{ route('observaciones.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
