@extends('layouts.app')

@section('title', 'Editar Período Académico')
@section('page-title', 'Editar Período Académico')

@section('topbar-actions')
    <a href="{{ route('periodos-academicos.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 900px;">

        <!-- Header compacto -->
        <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-alt text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Período Académico</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice la información del período</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario compacto -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form method="POST" action="{{ route('periodos-academicos.update', $periodo->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-info-circle" style="color: white; font-size: 0.95rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Datos del Período</h6>
                        </div>

                        <div class="row g-3">
                            <!-- Nombre del período -->
                            <div class="col-md-6">
                                <label for="nombre_periodo" class="form-label small fw-semibold" style="color: #003b73;">
                                    Nombre del período <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-tag position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text"
                                           class="form-control ps-5 form-control-sm @error('nombre_periodo') is-invalid @enderror"
                                           id="nombre_periodo"
                                           name="nombre_periodo"
                                           value="{{ old('nombre_periodo', $periodo->nombre_periodo) }}"
                                           placeholder="Ej: Primer Trimestre"
                                           required
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('nombre_periodo')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tipo -->
                            <div class="col-md-6">
                                <label for="tipo" class="form-label small fw-semibold" style="color: #003b73;">
                                    Tipo de período <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-list position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <select name="tipo"
                                            id="tipo"
                                            class="form-select form-select-sm ps-5 @error('tipo') is-invalid @enderror"
                                            required
                                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.55rem 1rem 0.55rem 2.8rem; transition: all 0.3s ease;">
                                        <option value="">Seleccione</option>
                                        <option value="clases" {{ old('tipo', $periodo->tipo) == 'clases' ? 'selected' : '' }}>Clases</option>
                                        <option value="vacaciones" {{ old('tipo', $periodo->tipo) == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                                        <option value="examenes" {{ old('tipo', $periodo->tipo) == 'examenes' ? 'selected' : '' }}>Exámenes</option>
                                    </select>
                                    @error('tipo')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha inicio -->
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label small fw-semibold" style="color: #003b73;">
                                    Fecha de inicio <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-calendar-alt position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="date"
                                           class="form-control ps-5 form-control-sm @error('fecha_inicio') is-invalid @enderror"
                                           id="fecha_inicio"
                                           name="fecha_inicio"
                                           value="{{ old('fecha_inicio', \Carbon\Carbon::parse($periodo->fecha_inicio)->format('Y-m-d')) }}"
                                           required
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.55rem 1rem 0.55rem 2.8rem; transition: all 0.3s ease;">
                                    @error('fecha_inicio')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha fin -->
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label small fw-semibold" style="color: #003b73;">
                                    Fecha de fin <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-calendar-check position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="date"
                                           class="form-control ps-5 form-control-sm @error('fecha_fin') is-invalid @enderror"
                                           id="fecha_fin"
                                           name="fecha_fin"
                                           value="{{ old('fecha_fin', \Carbon\Carbon::parse($periodo->fecha_fin)->format('Y-m-d')) }}"
                                           required
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.55rem 1rem 0.55rem 2.8rem; transition: all 0.3s ease;">
                                    @error('fecha_fin')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones compactos -->
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Actualizar período
                        </button>

                        <a href="{{ route('periodos-academicos.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nota compacta -->
        <div class="alert border-0 mt-2 py-2 px-3" style="border-radius: 8px; background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
                <div>
                    <strong style="color: #00508f;">Información importante:</strong>
                    <span class="text-muted"> Verifique todos los datos. Las fechas deben ser válidas y la combinación nombre + periodo no debe repetirse.</span>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
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

            small.text-muted {
                font-size: 0.7rem;
                display: block;
                margin-top: 0.15rem;
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

            .border-top {
                border-color: rgba(0, 80, 143, 0.08) !important;
            }

            .position-relative .fas {
                pointer-events: none;
            }
        </style>
    @endpush
@endsection
