@extends('layouts.admin')

@section('title', 'Asignar Materias')

@section('page-title', 'Asignar Materias al Grado')

@section('topbar-actions')
    <a href="{{ route('grados.show', $grado) }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    <!-- Header con información del grado -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="text-white mb-2 fw-bold">
                        <i class="fas fa-school"></i> {{ $grado->numero }}° Grado 
                        @if($grado->seccion)
                            <span style="opacity: 0.9;">Sección {{ $grado->seccion }}</span>
                        @endif
                    </h4>
                    <p class="text-white mb-0 opacity-75">
                        <i class="fas fa-calendar-alt"></i> Año Lectivo: {{ $grado->anio_lectivo }} 
                        <span class="mx-2">|</span>
                        <i class="fas fa-layer-group"></i> Nivel: {{ ucfirst($grado->nivel) }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="bg-white rounded p-3 d-inline-block" style="box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        <div class="text-muted small mb-1">Materias Asignadas</div>
                        <h2 class="mb-0 fw-bold" style="color: #00508f;">{{ count($materiasAsignadas) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('grados.guardar-materias', $grado) }}" method="POST" id="formAsignarMaterias">
        @csrf

        <!-- Mensajes de error -->
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px; border-left: 4px solid #ef4444;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error:</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($materias->isEmpty())
            <!-- No hay materias disponibles -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3" style="color: #00508f; opacity: 0.5;"></i>
                    <h5 style="color: #003b73;">No hay materias disponibles para el nivel {{ $grado->nivel }}</h5>
                    <p class="text-muted mb-3">Por favor, crea materias primero antes de asignarlas a este grado.</p>
                    <a href="{{ route('materias.create') }}" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600;">
                        <i class="fas fa-plus"></i> Crear Materia
                    </a>
                </div>
            </div>
        @else
            <!-- Controles superiores -->
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-check form-switch" style="padding-left: 2.5rem;">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="selectAll"
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label fw-semibold" for="selectAll" style="color: #003b73; margin-left: 0.5rem;">
                                    <i class="fas fa-check-double text-primary"></i> Seleccionar / Deseleccionar Todas
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; padding: 0.5rem 1rem; font-size: 0.9rem;">
                                <i class="fas fa-book"></i> {{ $materias->count() }} materias disponibles
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de materias -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tableMaterias">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <tr>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold" style="font-size: 0.7rem; width: 50px;">
                                        <input type="checkbox" id="selectAllHeader" class="form-check-input" style="width: 20px; height: 20px; cursor: pointer;">
                                    </th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Materia</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Código</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Área</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Profesor</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73; width: 120px;">Horas/Semana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materias as $materia)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" class="materia-row">
                                    <td class="px-3 py-3 text-center">
                                        <input type="checkbox" 
                                               name="materias[]" 
                                               value="{{ $materia->id }}"
                                               class="form-check-input materia-checkbox"
                                               {{ in_array($materia->id, $materiasAsignadas) ? 'checked' : '' }}
                                               style="width: 20px; height: 20px; cursor: pointer;">
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="fw-semibold" style="color: #003b73; font-size: 0.95rem;">
                                            <i class="fas fa-book-open" style="color: #4ec7d2;"></i>
                                            {{ $materia->nombre }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-family: monospace; font-size: 0.75rem;">
                                            {{ $materia->codigo }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge" style="background: rgba(0, 80, 143, 0.1); color: #00508f; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                            {{ $materia->area }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <select name="profesores[{{ $materia->id }}]" 
                                                class="form-select form-select-sm"
                                                style="border: 2px solid #bfd9ea; border-radius: 6px; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                            <option value="">Sin asignar</option>
                                            @foreach($profesores as $profesor)
                                                <option value="{{ $profesor->id }}"
                                                    {{ $grado->materias->find($materia->id)?->pivot->profesor_id == $profesor->id ? 'selected' : '' }}>
                                                    {{ $profesor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-3 py-3">
                                        <input type="number" 
                                               name="horas[{{ $materia->id }}]" 
                                               class="form-control form-control-sm text-center"
                                               min="1"
                                               max="10"
                                               value="{{ $grado->materias->find($materia->id)?->pivot->horas_semanales ?? 4 }}"
                                               style="border: 2px solid #bfd9ea; border-radius: 6px; padding: 0.4rem; font-weight: 600; color: #00508f; font-size: 0.9rem;">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer con resumen -->
                <div class="card-footer bg-light border-0 p-3" style="border-radius: 0 0 12px 12px;">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
                                    <span class="small text-muted">Seleccionadas:</span>
                                    <strong class="ms-1" style="color: #003b73;" id="countSelected">{{ count($materiasAsignadas) }}</strong>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock me-2" style="color: #4ec7d2;"></i>
                                    <span class="small text-muted">Total horas:</span>
                                    <strong class="ms-1" style="color: #003b73;" id="totalHours">0</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600; border: none;">
                                <i class="fas fa-save"></i> Guardar Asignación
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card border-0 shadow-sm mt-3" style="border-radius: 12px; background: rgba(78, 199, 210, 0.05); border-left: 4px solid #4ec7d2;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle me-3 mt-1" style="color: #00508f; font-size: 1.2rem;"></i>
                        <div>
                            <strong style="color: #003b73;">Instrucciones:</strong>
                            <ul class="mb-0 mt-2 small text-muted">
                                <li>Selecciona las materias que deseas asignar a este grado marcando las casillas</li>
                                <li>Opcionalmente, asigna un profesor responsable para cada materia</li>
                                <li>Define las horas semanales de cada materia (valor predeterminado: 4 horas)</li>
                                <li>Las materias no seleccionadas serán removidas de la asignación del grado</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>

</div>

@push('styles')
<style>
    .materia-row:hover {
        background-color: rgba(78, 199, 210, 0.05);
    }

    .form-check-input:checked {
        background-color: #4ec7d2;
        border-color: #4ec7d2;
    }

    .form-select:focus, .form-control:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }

    /* Animación suave para checkboxes */
    .materia-checkbox {
        transition: all 0.2s ease;
    }

    .materia-checkbox:hover {
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const materiaCheckboxes = document.querySelectorAll('.materia-checkbox');
    const countSelected = document.getElementById('countSelected');
    const totalHours = document.getElementById('totalHours');

    // Función para actualizar el contador
    function updateCounters() {
        let selectedCount = 0;
        let totalHoursCount = 0;

        materiaCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCount++;
                const row = checkbox.closest('tr');
                const hoursInput = row.querySelector('input[type="number"]');
                totalHoursCount += parseInt(hoursInput.value) || 0;
            }
        });

        countSelected.textContent = selectedCount;
        totalHours.textContent = totalHoursCount;

        // Actualizar el estado del checkbox "seleccionar todo"
        const allChecked = selectedCount === materiaCheckboxes.length;
        const someChecked = selectedCount > 0 && selectedCount < materiaCheckboxes.length;
        
        selectAllCheckbox.checked = allChecked;
        selectAllHeader.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked;
        selectAllHeader.indeterminate = someChecked;
    }

    // Seleccionar/deseleccionar todas las materias
    function toggleAllCheckboxes(checked) {
        materiaCheckboxes.forEach(checkbox => {
            checkbox.checked = checked;
        });
        updateCounters();
    }

    selectAllCheckbox.addEventListener('change', function() {
        toggleAllCheckboxes(this.checked);
        selectAllHeader.checked = this.checked;
    });

    selectAllHeader.addEventListener('change', function() {
        toggleAllCheckboxes(this.checked);
        selectAllCheckbox.checked = this.checked;
    });

    // Actualizar contadores cuando se marca/desmarca una materia
    materiaCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCounters);
    });

    // Actualizar contador de horas cuando cambia el valor
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', updateCounters);
    });

    // Inicializar contadores
    updateCounters();

    // Validación antes de enviar
    document.getElementById('formAsignarMaterias').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.materia-checkbox:checked');
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Por favor, selecciona al menos una materia para asignar al grado.');
            return false;
        }
    });
});
</script>
@endpush

@endsection