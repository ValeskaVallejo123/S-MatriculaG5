@extends('layouts.app')

@section('title', 'Crear Grado')

@section('page-title', 'Nuevo Grado')

@section('topbar-actions')
    <a href="{{ route('grados.index') }}" class="btn-back"
        style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 800px;">

        <div class="card border-0 shadow-sm mb-3"
            style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3"
                        style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chalkboard-teacher text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Crear Nuevo Grado</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Ingrese la información del nuevo grado y
                            sección</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <form action="{{ route('grados.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div
                                style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-book-open" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Detalles del Grado</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label small fw-semibold" style="color: #003b73;">
                                    Nombre del Grado <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-layer-group position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select name="nombre" id="nombre"
                                        class="form-select ps-5 form-select-sm @error('nombre') is-invalid @enderror"
                                        required
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                        <option value="">Seleccione un grado</option>
                                        <option value="Primero" {{ old('nombre') == 'Primero' ? 'selected' : '' }}>Primero
                                        </option>
                                        <option value="Segundo" {{ old('nombre') == 'Segundo' ? 'selected' : '' }}>Segundo
                                        </option>
                                        <option value="Tercero" {{ old('nombre') == 'Tercero' ? 'selected' : '' }}>Tercero
                                        </option>
                                        <option value="Cuarto" {{ old('nombre') == 'Cuarto' ? 'selected' : '' }}>Cuarto
                                        </option>
                                        <option value="Quinto" {{ old('nombre') == 'Quinto' ? 'selected' : '' }}>Quinto
                                        </option>
                                        <option value="Sexto" {{ old('nombre') == 'Sexto' ? 'selected' : '' }}>Sexto</option>
                                    </select>
                                    @error('nombre')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="seccion" class="form-label small fw-semibold" style="color: #003b73;">
                                    Sección
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-tag position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" name="seccion" id="seccion" value="{{ old('seccion') }}"
                                        placeholder="Ej: A, B, Nocturna"
                                        class="form-control ps-5 form-control-sm @error('seccion') is-invalid @enderror"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">

                                    @error('seccion')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="nombre_maestro" class="form-label small fw-semibold" style="color: #003b73;">
                                    Nombre del Maestro Guía <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-user-tie position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" name="nombre_maestro" id="nombre_maestro"
                                        value="{{ old('nombre_maestro') }}"
                                        placeholder="Ingrese el nombre completo del maestro a cargo"
                                        class="form-control ps-5 form-control-sm @error('nombre_maestro') is-invalid @enderror"
                                        required
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">

                                    @error('nombre_maestro')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 pt-2 border-top" style="border-color: rgba(0, 80, 143, 0.15) !important;">
                        <label class="form-label small fw-semibold" style="color: #003b73;">
                            Seleccione la Jornada: <span style="color: #ef4444;">*</span>
                        </label>

                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jornada" id="jornadaMatutina"
                                    value="Matutina" {{ old('jornada', 'Matutina') == 'Matutina' ? 'checked' : '' }} required>
                                <label class="form-check-label small" for="jornadaMatutina">Matutina</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jornada" id="jornadaVespertina"
                                    value="Vespertina" {{ old('jornada') == 'Vespertina' ? 'checked' : '' }} required>
                                <label class="form-check-label small" for="jornadaVespertina">Vespertina</label>
                            </div>
                        </div>

                        @error('jornada')
                            <div class="text-danger small mt-1" style="font-size: 0.8rem;">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top" style="border-color: rgba(0, 80, 143, 0.15) !important;">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Crear Grado
                        </button>
                        <a href="{{ route('grados.index') }}" class="btn btn-sm fw-semibold flex-fill"
                            style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert border-0 mt-3 py-2 px-3"
            style="border-radius: 8px; background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
                <div>
                    <strong style="color: #00508f;">Nota:</strong>
                    <span class="text-muted"> Asegúrese de que el nombre del grado y la sección sean correctos.</span>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            /* Estilos del formulario de Estudiante adaptados */
            .form-control-sm,
            .form-select-sm {
                border-radius: 8px !important;
                /* Ligeramente más grande */
                border: 2px solid #bfd9ea !important;
                padding: 0.6rem 0.75rem 0.6rem 2.8rem !important;
                /* Espacio para el ícono */
                transition: all 0.3s ease;
                font-size: 0.875rem;
                height: auto !important;
                /* Ajuste para el padding */
            }

            .form-control-sm:focus,
            .form-select-sm:focus {
                border-color: #4ec7d2 !important;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.2) !important;
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

            .border-top {
                border-color: rgba(0, 80, 143, 0.15) !important;
            }

            /* Estilos para los radio buttons */
            .form-check-input:checked {
                background-color: #00508f;
                border-color: #00508f;
            }

            .form-check-input:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.2);
            }
        </style>
    @endpush
@endsection