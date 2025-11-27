@extends('layouts.app')

@section('title', 'Asignar Materias')

@section('page-title', 'Asignar Materias al Grado')

@section('topbar-actions')
    <a href="{{ route('grados.show', $grado) }}" 
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Header con información del grado -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.5rem 1.5rem;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-2 fw-bold">
                        <i class="fas fa-school"></i> {{ $grado->numero }}° Grado 
                        @if($grado->seccion)
                            <span style="opacity: 0.9;">- Sección {{ $grado->seccion }}</span>
                        @endif
                    </h4>
                    <p class="mb-0" style="opacity: 0.9; font-size: 0.938rem;">
                        <i class="fas fa-calendar-alt me-1"></i>Año Lectivo: {{ $grado->anio_lectivo }} 
                        <span class="mx-2">|</span>
                        <i class="fas fa-layer-group me-1"></i>Nivel: {{ ucfirst($grado->nivel) }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="bg-white rounded p-3 d-inline-block" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
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
        <div class="alert alert-dismissible fade show mb-4" role="alert" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 10px; border-left: 4px solid #ef4444;">
            <div class="d-flex align-items-start gap-2">
                <i class="fas fa-exclamation-triangle mt-1" style="color: #ef4444;"></i>
                <div class="flex-grow-1">
                    <strong style="color: #ef4444;">Error:</strong>
                    <span style="color: #64748b;">{{ $errors->first() }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($materias->isEmpty())
            <!-- No hay materias disponibles -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-5">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i class="fas fa-inbox" style="font-size: 2rem; color: #4ec7d2;"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: #003b73;">No hay materias disponibles</h5>
                    <p class="text-muted mb-4">Para el nivel {{ ucfirst($grado->nivel) }}. Por favor, crea materias primero antes de asignarlas a este grado.</p>
                    <a href="{{ route('materias.create') }}" 
                       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-plus"></i>Crear Materia
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
                                <label class="form-check-label fw-semibold" for="selectAll" style="color: #003b73; margin-left: 0.5rem; cursor: pointer;">
                                    <i class="fas fa-check-double" style="color: #4ec7d2;"></i> Seleccionar / Deseleccionar Todas
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="badge" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.15) 100%); color: #00508f; padding: 0.5rem 1rem; font-size: 0.875rem; border-radius: 8px;">
                                <i class="fas fa-book me-1"></i>{{ $materias->count() }} materias disponibles
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
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none; width: 50px;">
                                        <input type="checkbox" id="selectAllHeader" class="form-check-input" style="width: 20px; height: 20px; cursor: pointer;">
                                    </th>
                                    <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                        <i class="fas fa-book-open me-2" style="color: #4ec7d2;"></i>Materia
                                    </th>
                                    <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                        <i class="fas fa-code me-2" style="color: #4ec7d2;"></i>Código
                                    </th>
                                    <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                        <i class="fas fa-layer-group me-2" style="color: #4ec7d2;"></i>Área
                                    </th>
                                    <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                        <i class="fas fa-user-tie me-2" style="color: #4ec7d2;"></i>Profesor
                                    </th>
                                    <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none; width: 130px;">
                                        <i class="fas fa-clock me-2" style="color: #4ec7d2;"></i>Horas/Semana
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materias as $materia)
                                <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.2s ease;" class="materia-row">
                                    <td class="px-4 py-3 text-center">
                                        <input type="checkbox" 
                                               name="materias[]" 
                                               value="{{ $materia->id }}"
                                               class="form-check-input materia-checkbox"
                                               {{ in_array($materia->id, $materiasAsignadas) ? 'checked' : '' }}
                                               style="width: 20px; height: 20px; cursor: pointer;">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="fw-semibold" style="color: #1e293b; font-size: 0.938rem;">
                                            {{ $materia->nombre }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.15) 100%); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.75rem; font-family: 'Courier New', monospace; font-size: 0.813rem; border-radius: 6px;">
                                            {{ $materia->codigo }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge" style="background: linear-gradient(135deg, rgba(0, 80, 143, 0.1) 0%, rgba(78, 199, 210, 0.1) 100%); color: #00508f; padding: 0.4rem 0.75rem; font-size: 0.813rem; border-radius: 6px;">
                                            {{ $materia->area }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <select name="profesores[{{ $materia->id }}]" 
                                                class="form-select form-select-sm"
                                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 0.875rem; font-size: 0.875rem;">
                                            <option value="">Sin asignar</option>
                                            @foreach($profesores as $profesor)
                                                <option value="{{ $profesor->id }}"
                                                    {{ $grado->materias->find($materia->id)?->pivot->profesor_id == $profesor->id ? 'selected' : '' }}>
                                                    {{ $profesor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" 
                                               name="horas[{{ $materia->id }}]" 
                                               class="form-control form-control-sm text-center"
                                               min="1"
                                               max="10"
                                               value="{{ $grado->materias->find($materia->id)?->pivot->horas_semanales ?? 4 }}"
                                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem; font-weight: 600; color: #00508f; font-size: 0.938rem;">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer con resumen -->
                <div class="card-footer bg-white border-0 p-4" style="border-radius: 0 0 12px 12px; border-top: 1px solid #e2e8f0;">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-4">
                                <div class="d-flex align-items-center">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                                    </div>
                                    <div>
                                        <span class="small text-muted d-block" style="font-size: 0.75rem;">Seleccionadas</span>
                                        <strong style="color: #003b73; font-size: 1.125rem;" id="countSelected">{{ count($materiasAsignadas) }}</strong>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                                        <i class="fas fa-clock" style="color: #4ec7d2;"></i>
                                    </div>
                                    <div>
                                        <span class="small text-muted d-block" style="font-size: 0.75rem;">Total horas</span>
                                        <strong style="color: #003b73; font-size: 1.125rem;" id="totalHours">0</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <button type="submit" 
                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); transition: all 0.3s ease;">
                                <i class="fas fa-save me-1"></i>Guardar Asignación
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="alert mt-4 mb-0" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border: 1px solid rgba(78, 199, 210, 0.2); border-radius: 10px; border-left: 4px solid #4ec7d2;">
                <div class="d-flex align-items-start gap-3">
                    <i class="fas fa-info-circle mt-1" style="color: #4ec7d2; font-size: 1.25rem;"></i>
                    <div>
                        <strong class="d-block mb-2" style="color: #003b73; font-size: 0.938rem;">Instrucciones:</strong>
                        <ul class="mb-0" style="color: #64748b; font-size: 0.875rem;">
                            <li class="mb-1">Selecciona las materias que deseas asignar a este grado marcando las casillas</li>
                            <li class="mb-1">Opcionalmente, asigna un profesor responsable para cada materia</li>
                            <li class="mb-1">Define las horas semanales de cada materia (valor predeterminado: 4 horas)</li>
                            <li>Las materias no seleccionadas serán removidas de la asignación del grado</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </form>

</div>

@push('styles')
<style>
    .materia-row:hover {
        background-color: #f8fafc;
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

    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
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
    const form = document.getElementById('formAsignarMaterias');
    if (form) {
        form.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.materia-checkbox:checked');
            
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Por favor, selecciona al menos una materia para asignar al grado.');
                return false;
            }
        });
    }
});
</script>
@endpush

@endsection