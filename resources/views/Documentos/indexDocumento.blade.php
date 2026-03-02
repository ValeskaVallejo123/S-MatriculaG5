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
    <div class="container" style="max-width: 1200px;">

<<<<<<< HEAD
        <!-- Header compacto -->
        <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-edit text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Documentos</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice los datos y documentos del estudiante</p>
                    </div>
=======
        {{-- Mensajes de Notificación --}}
        @if(session('success'))
            <div class="alert border-0 mb-3" style="background: rgba(76, 175, 80, 0.1); border-left: 3px solid #4caf50 !important; border-radius: 8px;">
                <div class="d-flex align-items-start">
                    <i class="fas fa-check-circle me-2 mt-1" style="font-size: 0.9rem; color: #4caf50;"></i>
                    <strong style="color: #2e7d32;">{{ session('success') }}</strong>
>>>>>>> josue_matriculag5
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <!-- Formulario compacto -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Información del estudiante -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Foto del Estudiante</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center mb-3">
                                    @if($documento->foto && file_exists(storage_path('app/public/' . $documento->foto)))
                                        <img src="{{ asset('storage/' . $documento->foto) }}"
                                             alt="Foto del estudiante"
                                             class="rounded"
                                             style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #4ec7d2;">
                                    @else
                                        <div class="text-muted" style="font-size: 0.9rem;">No hay foto</div>
                                    @endif
                                </div>
                                <label for="foto" class="form-label small fw-semibold" style="color: #003b73;">
                                    Foto del Estudiante
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-image position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <input type="file"
                                           accept=".jpg,.png"
                                           class="form-control ps-5 @error('foto') is-invalid @enderror"
                                           id="foto"
                                           name="foto"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <p class="text-muted small mt-1" style="font-size: 0.75rem;">JPG o PNG (máx. 5 MB)</p>
                                    @error('foto')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentos -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Documentos Requeridos</h6>
                        </div>

                        <div class="row g-3">
                            <!-- Acta de Nacimiento -->
                            <div class="col-md-6">
                                <label for="acta_nacimiento" class="form-label small fw-semibold" style="color: #003b73;">
                                    Acta de Nacimiento
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-file-pdf position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <input type="file"
                                           accept=".jpg,.png,.pdf"
                                           class="form-control ps-5 @error('acta_nacimiento') is-invalid @enderror"
                                           id="acta_nacimiento"
                                           name="acta_nacimiento"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <p class="text-muted small mt-1" style="font-size: 0.75rem;">JPG, PNG o PDF (máx. 5 MB)</p>
                                    @error('acta_nacimiento')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Calificaciones -->
                            <div class="col-md-6">
                                <label for="calificaciones" class="form-label small fw-semibold" style="color: #003b73;">
                                    Calificaciones
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-file-pdf position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <input type="file"
                                           accept=".jpg,.png,.pdf"
                                           class="form-control ps-5 @error('calificaciones') is-invalid @enderror"
                                           id="calificaciones"
                                           name="calificaciones"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <p class="text-muted small mt-1" style="font-size: 0.75rem;">JPG, PNG o PDF (máx. 5 MB)</p>
                                    @error('calificaciones')
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
                            <i class="fas fa-save me-1"></i>Actualizar Documentos
                        </button>
                        <a href="{{ route('documentos.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
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
                    <span class="text-muted"> Los cambios se aplicarán inmediatamente.</span>
=======
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Estudiante</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Foto</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Acta de Nacimiento</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Calificaciones</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold text-end" style="font-size: 0.75rem; color: #003b73;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($documentos as $doc)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                {{-- ESTUDIANTE --}}
                                <td class="px-3">
                                    <div class="fw-bold" style="color: #003b73;">{{ $doc->estudiante->nombre ?? 'N/A' }}</div>
                                    <small class="text-muted">ID: {{ $doc->estudiante_id }}</small>
                                </td>

                                {{-- FOTO --}}
                                <td class="px-3">
                                    @if($doc->foto)
                                        <a href="{{ asset('storage/' . $doc->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doc->foto) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #4ec7d2;">
                                        </a>
                                    @else
                                        <i class="fas fa-user-circle text-muted fa-2x"></i>
                                    @endif
                                </td>

                                {{-- ACTA --}}
                                <td class="px-3">
                                    <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank" class="btn btn-sm" style="border: 1px solid #00508f; color: #00508f; border-radius: 6px;">
                                        <i class="fas fa-file-pdf me-1"></i> Ver Acta
                                    </a>
                                </td>

                                {{-- CALIFICACIONES --}}
                                <td class="px-3">
                                    <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank" class="btn btn-sm" style="border: 1px solid #4ec7d2; color: #4ec7d2; border-radius: 6px;">
                                        <i class="fas fa-file-alt me-1"></i> Ver Notas
                                    </a>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('documentos.edit', $doc->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este expediente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-50 mb-3">
                                    <h6 class="text-muted">No se encontraron expedientes digitales.</h6>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
>>>>>>> josue_matriculag5
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    @push('styles')
        <style>
            .form-control, .form-select {
                border-radius: 6px;
                border: 1.5px solid #e2e8f0;
                padding: 0.5rem 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.875rem;
            }

            .form-control:focus, .form-select:focus {
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
                color: #6b7280 !important;
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

            .ps-5 {
                padding-left: 2.5rem !important;
            }
        </style>
    @endpush
<<<<<<< HEAD
=======
>>>>>>> josue_matriculag5
@endsection
