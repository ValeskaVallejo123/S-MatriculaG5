@extends('layouts.app')

@section('title', 'Calificaciones')

@section('page-title', 'Gestión de Calificaciones')

@section('topbar-actions')
    <a href="{{ route('calificaciones.create') }}" class="btn-back" 
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
              color: white; padding: 0.5rem 1.2rem; border-radius: 8px;
              text-decoration: none; font-weight: 600; display: inline-flex;
              align-items: center; gap: 0.5rem; transition: all 0.3s ease;
              border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);
              font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nueva Calificación
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    <!-- Barra de búsqueda y resumen -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <!-- Buscador -->
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" 
                           style="left: 12px; top: 50%; transform: translateY(-50%);
                           color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text" id="searchInput" class="form-control form-control-sm ps-5"
                               placeholder="Buscar por nombre de alumno..." 
                               style="border: 2px solid #bfd9ea; border-radius: 8px;
                               padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                    </div>
                </div>

                <!-- Resumen -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-users" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small">
                                <strong style="color: #00508f;">{{ $calificaciones->count() }}</strong>
                                <span class="text-muted">Total</span>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small">
                                <strong style="color: #4ec7d2;">{{ $calificaciones->where('nota_final', '>=', 60)->count() }}</strong>
                                <span class="text-muted">Aprobados</span>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-times-circle" style="color: #ef4444; font-size: 0.9rem;"></i>
                            <span class="small">
                                <strong style="color: #ef4444;">{{ $calificaciones->where('nota_final', '<', 60)->whereNotNull('nota_final')->count() }}</strong>
                                <span class="text-muted">Reprobados</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de calificaciones -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="gradesTable">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Alumno</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem;">1°</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem;">2°</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem;">3°</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem;">4°</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem;">Recup.</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem;">Nota Final</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem;">Estado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($calificaciones as $calificacion)
                        <tr class="grade-row">
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                    {{ $calificacion->nombre_alumno }}
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;">ID: {{ $calificacion->id }}</small>
                            </td>
                            <td class="text-center small">{{ $calificacion->primer_parcial ?? '-' }}</td>
                            <td class="text-center small">{{ $calificacion->segundo_parcial ?? '-' }}</td>
                            <td class="text-center small">{{ $calificacion->tercer_parcial ?? '-' }}</td>
                            <td class="text-center small">{{ $calificacion->cuarto_parcial ?? '-' }}</td>
                            <td class="text-center small">{{ $calificacion->recuperacion ?? '-' }}</td>
                            <td class="text-center fw-bold" style="color: {{ $calificacion->nota_final >= 60 ? '#059669' : '#dc2626' }};">
                                {{ $calificacion->nota_final ? number_format($calificacion->nota_final, 2) : '-' }}
                            </td>
                            <td class="text-center">
                                @if($calificacion->estado === 'Aprobado')
                                    <span class="badge rounded-pill" 
                                          style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                        <i class="fas fa-check"></i> {{ $calificacion->estado }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill" 
                                          style="background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; font-size: 0.75rem;">
                                        <i class="fas fa-times"></i> {{ $calificacion->estado }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('calificaciones.show', $calificacion->id) }}" 
                                       class="btn btn-sm" 
                                       style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white;"
                                       title="Ver"
                                       onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('calificaciones.edit', $calificacion->id) }}" 
                                       class="btn btn-sm" 
                                       style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white;"
                                       title="Editar"
                                       onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('calificaciones.destroy', $calificacion->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta calificación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm" 
                                                style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white;"
                                                title="Eliminar"
                                                onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                                onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                    <h6 style="color: #003b73;">No hay calificaciones registradas</h6>
                                    <p class="small mb-3">Agrega la primera calificación</p>
                                    <a href="{{ route('calificaciones.create') }}" class="btn btn-sm" 
                                       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                              color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                        <i class="fas fa-plus me-1"></i> Registrar Calificación
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('gradesTable');
    const rows = table.querySelectorAll('tbody .grade-row');

    searchInput.addEventListener('keyup', function() {
        const term = this.value.toLowerCase().trim();
        let count = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(term)) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mensaje de no resultados
        if (count === 0 && term !== '') {
            if (!document.querySelector('.no-results-row')) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = `
                    <td colspan="9" class="text-center py-4">
                        <i class="fas fa-search" style="color: #00508f; opacity: 0.5; font-size: 1.5rem;"></i>
                        <p class="text-muted mt-2 mb-0">No se encontraron resultados para "<strong>${term}</strong>"</p>
                    </td>
                `;
                table.querySelector('tbody').appendChild(noResultsRow);
            }
        } else {
            const noResultsRow = document.querySelector('.no-results-row');
            if (noResultsRow) noResultsRow.remove();
        }
    });
});
</script>
@endpush
@endsection
