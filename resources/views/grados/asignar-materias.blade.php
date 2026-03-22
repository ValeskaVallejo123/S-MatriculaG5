@extends('layouts.app')

@section('title', 'Asignar Materias')
@section('page-title', 'Asignar Materias al Grado')

@section('topbar-actions')
    <a href="{{ route('superadmin.grados.show', $grado) }}"
       style="background:white;color:#00508f;padding:.5rem .85rem;border-radius:7px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;border:1.5px solid #00508f;font-size:0.8rem;transition:all .2s;">
        <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Volver
    </a>
@endsection

@push('styles')
<style>
.form-check-input:checked { background-color:#4ec7d2; border-color:#4ec7d2; }
.form-select:focus, .form-control:focus {
    border-color:#4ec7d2 !important;
    box-shadow:0 0 0 3px rgba(78,199,210,.15) !important;
    outline:none;
}
</style>
@endpush

@section('content')

@php $materiasAsignadasIds = $materiasAsignadas->pluck('id')->toArray(); @endphp

<div style="max-width:1200px;margin:0 auto;">

    {{-- Header del grado --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;overflow:hidden;">
        <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:1rem 1.25rem;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.3rem;">
                        <i class="fas fa-school" style="color:#4ec7d2;font-size:1.1rem;"></i>
                        <h5 class="mb-0 fw-bold text-white">
                            {{ $grado->numero }}° Grado
                            @if($grado->seccion)
                                <span style="opacity:.85;">— Sección {{ $grado->seccion }}</span>
                            @endif
                        </h5>
                    </div>
                    <p class="mb-0" style="opacity:.8;font-size:.82rem;color:white;">
                        <i class="fas fa-calendar-alt me-1"></i>Año Lectivo: {{ $grado->anio_lectivo }}
                        <span class="mx-2">·</span>
                        <i class="fas fa-layer-group me-1"></i>Nivel: {{ ucfirst($grado->nivel) }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                    <div style="background:rgba(255,255,255,.12);border-radius:9px;padding:.6rem 1rem;display:inline-block;text-align:center;">
                        <div style="font-size:.72rem;color:rgba(255,255,255,.7);margin-bottom:.1rem;">Materias asignadas</div>
                        <div style="font-size:1.6rem;font-weight:800;color:white;line-height:1;">{{ count($materiasAsignadasIds) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('superadmin.grados.guardar-materias', $grado) }}" method="POST" id="formAsignarMaterias">
        @csrf

        @if($errors->any())
        <div class="alert alert-dismissible fade show mb-3" role="alert"
             style="border-radius:10px;border-left:4px solid #ef4444;background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);">
            <div class="d-flex align-items-start gap-2">
                <i class="fas fa-exclamation-triangle mt-1" style="color:#ef4444;"></i>
                <div>
                    <strong style="color:#ef4444;">Error:</strong>
                    <span style="color:#64748b;">{{ $errors->first() }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($materias->isEmpty())
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-2x mb-3 d-block" style="color:#bfd9ea;"></i>
                <h6 class="fw-bold mb-2" style="color:#003b73;">No hay materias disponibles</h6>
                <p class="text-muted small mb-3">Para el nivel {{ ucfirst($grado->nivel) }}. Crea materias primero antes de asignarlas.</p>
                <a href="{{ route('materias.create') }}"
                   style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border-radius:7px;padding:.5rem 1.1rem;font-weight:600;text-decoration:none;font-size:.83rem;display:inline-flex;align-items:center;gap:.35rem;">
                    <i class="fas fa-plus" style="font-size:.72rem;"></i> Crear Materia
                </a>
            </div>
        </div>
        @else

        {{-- Barra de control --}}
        <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="form-check form-switch" style="padding-left:3.5rem;">
                            <input class="form-check-input" type="checkbox" id="selectAll"
                                   style="width:3rem;height:1.5rem;cursor:pointer;">
                            <label class="form-check-label fw-semibold" for="selectAll"
                                   style="color:#003b73;margin-left:.5rem;font-size:.83rem;cursor:pointer;">
                                Seleccionar / Deseleccionar Todas
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                        <span style="background:rgba(78,199,210,.12);color:#00508f;border:1px solid rgba(78,199,210,.35);padding:.28rem .75rem;border-radius:999px;font-size:.75rem;font-weight:600;">
                            <i class="fas fa-book me-1"></i>{{ $materias->count() }} materias disponibles
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de materias --}}
        <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">

            <div style="overflow-x:auto;">
                <table class="table table-hover align-middle mb-0" id="tableMaterias" style="font-size:.82rem;">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th style="padding:.55rem 1rem;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1.5px solid #e2e8f0;width:50px;">
                                <input type="checkbox" id="selectAllHeader" class="form-check-input"
                                       style="width:18px;height:18px;cursor:pointer;">
                            </th>
                            <th style="padding:.55rem 1rem;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Materia</th>
                            <th style="padding:.55rem 1rem;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Código</th>
                            <th style="padding:.55rem 1rem;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Área</th>
                            <th style="padding:.55rem 1rem;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Profesor</th>
                            <th style="padding:.55rem 1rem;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1.5px solid #e2e8f0;width:120px;">Hrs/Semana</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materias as $materia)
                        <tr class="materia-row" style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:.55rem 1rem;text-align:center;">
                                <input type="checkbox"
                                       name="materias[]"
                                       value="{{ $materia->id }}"
                                       class="form-check-input materia-checkbox"
                                       {{ in_array($materia->id, $materiasAsignadasIds) ? 'checked' : '' }}
                                       style="width:18px;height:18px;cursor:pointer;">
                            </td>
                            <td style="padding:.55rem 1rem;">
                                <span class="fw-semibold" style="color:#0f172a;">{{ $materia->nombre }}</span>
                            </td>
                            <td style="padding:.55rem 1rem;">
                                <span style="background:rgba(78,199,210,.12);color:#00508f;border:1px solid #4ec7d2;padding:.18rem .55rem;border-radius:5px;font-family:monospace;font-size:.75rem;font-weight:600;">
                                    {{ $materia->codigo }}
                                </span>
                            </td>
                            <td style="padding:.55rem 1rem;">
                                <span style="background:rgba(0,80,143,.08);color:#00508f;padding:.18rem .55rem;border-radius:999px;font-size:.72rem;font-weight:600;">
                                    {{ $materia->area }}
                                </span>
                            </td>
                            <td style="padding:.55rem 1rem;">
                                <select name="profesores[{{ $materia->id }}]"
                                        class="form-select form-select-sm"
                                        style="border:1.5px solid #d0dce8;border-radius:7px;font-size:.8rem;">
                                    <option value="">Sin asignar</option>
                                    @foreach($profesores as $profesor)
                                        <option value="{{ $profesor->id }}"
                                            {{ $grado->materias->find($materia->id)?->pivot->profesor_id == $profesor->id ? 'selected' : '' }}>
                                            {{ $profesor->nombre }} {{ $profesor->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="padding:.55rem 1rem;">
                                <input type="number"
                                       name="horas[{{ $materia->id }}]"
                                       class="form-control form-control-sm text-center"
                                       min="1" max="10"
                                       value="{{ $grado->materias->find($materia->id)?->pivot->horas_semanales ?? 4 }}"
                                       style="border:1.5px solid #d0dce8;border-radius:7px;font-weight:600;color:#00508f;font-size:.82rem;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer resumen + guardar --}}
            <div style="padding:.85rem 1.25rem;border-top:1px solid #e8edf4;background:#f8fafc;border-radius:0 0 12px 12px;">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex gap-4">
                            <div style="display:flex;align-items:center;gap:.6rem;">
                                <div style="width:36px;height:36px;background:rgba(16,185,129,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-check-circle" style="color:#10b981;font-size:.85rem;"></i>
                                </div>
                                <div>
                                    <span style="font-size:.7rem;color:#94a3b8;display:block;">Seleccionadas</span>
                                    <strong style="color:#003b73;font-size:1.05rem;" id="countSelected">{{ count($materiasAsignadasIds) }}</strong>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:.6rem;">
                                <div style="width:36px;height:36px;background:rgba(78,199,210,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-clock" style="color:#4ec7d2;font-size:.85rem;"></i>
                                </div>
                                <div>
                                    <span style="font-size:.7rem;color:#94a3b8;display:block;">Total horas</span>
                                    <strong style="color:#003b73;font-size:1.05rem;" id="totalHours">0</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button type="submit"
                                style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border-radius:8px;padding:.6rem 1.4rem;font-weight:600;border:none;font-size:.88rem;display:inline-flex;align-items:center;gap:.4rem;cursor:pointer;">
                            <i class="fas fa-save" style="font-size:.8rem;"></i> Guardar Asignación
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instrucciones --}}
        <div class="mt-3"
             style="border-radius:9px;border-left:4px solid #4ec7d2;background:rgba(78,199,210,.07);padding:.85rem 1rem;">
            <p class="mb-1" style="font-size:.82rem;color:#003b73;font-weight:600;">Instrucciones:</p>
            <ul class="mb-0" style="color:#64748b;font-size:.8rem;padding-left:1.1rem;">
                <li class="mb-1">Selecciona las materias que deseas asignar marcando las casillas.</li>
                <li class="mb-1">Opcionalmente, asigna un profesor responsable para cada materia.</li>
                <li class="mb-1">Define las horas semanales de cada materia (valor predeterminado: 4 horas).</li>
                <li>Las materias no seleccionadas serán removidas de la asignación del grado.</li>
            </ul>
        </div>

        @endif
    </form>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll        = document.getElementById('selectAll');
    const selectAllHeader  = document.getElementById('selectAllHeader');
    const checkboxes       = document.querySelectorAll('.materia-checkbox');
    const countSelected    = document.getElementById('countSelected');
    const totalHours       = document.getElementById('totalHours');

    function updateCounters() {
        let selected = 0, hours = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                selected++;
                const input = cb.closest('tr').querySelector('input[type="number"]');
                hours += parseInt(input?.value) || 0;
            }
        });
        countSelected.textContent = selected;
        totalHours.textContent    = hours;

        const all  = selected === checkboxes.length;
        const some = selected > 0 && selected < checkboxes.length;
        selectAll.checked        = all;
        selectAllHeader.checked  = all;
        selectAll.indeterminate  = some;
        selectAllHeader.indeterminate = some;
    }

    function toggleAll(checked) {
        checkboxes.forEach(cb => cb.checked = checked);
        updateCounters();
    }

    selectAll.addEventListener('change', function () { toggleAll(this.checked); selectAllHeader.checked = this.checked; });
    selectAllHeader.addEventListener('change', function () { toggleAll(this.checked); selectAll.checked = this.checked; });
    checkboxes.forEach(cb => cb.addEventListener('change', updateCounters));
    document.querySelectorAll('input[type="number"]').forEach(i => i.addEventListener('input', updateCounters));

    updateCounters();

    document.getElementById('formAsignarMaterias')?.addEventListener('submit', function (e) {
        if (!document.querySelectorAll('.materia-checkbox:checked').length) {
            e.preventDefault();
            alert('Por favor, selecciona al menos una materia para asignar al grado.');
        }
    });
});
</script>
@endpush