@extends('layouts.app')

@section('title', 'Asignación Profesor-Materia-Grado')
@section('page-title', 'Carga Docente Completa')

@section('topbar-actions')
    <a href="{{ route('profesor_materia_grado.create') }}"
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i> Nueva Asignación
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3" style="border-radius: 10px; border-left: 4px solid #388e3c !important;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Resumen --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #00508f !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:rgba(0,80,143,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chalkboard-teacher" style="color:#00508f;"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Profesores asignados</div>
                        <div class="fw-bold fs-4" style="color:#00508f;">{{ $totalProfesores }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #4ec7d2 !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:rgba(78,199,210,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-list-alt" style="color:#4ec7d2;"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Total asignaciones</div>
                        <div class="fw-bold fs-4" style="color:#4ec7d2;">{{ $totalAsignaciones }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #003b73 !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:rgba(0,59,115,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-school" style="color:#003b73;"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Grupos cubiertos</div>
                        <div class="fw-bold fs-4" style="color:#003b73;">{{ $asignaciones->sum(fn($g) => $g->count()) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">

            {{-- Buscador --}}
            <div class="p-3 border-bottom">
                <div class="position-relative" style="max-width: 350px;">
                    <i class="fas fa-search position-absolute" style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:0.85rem;"></i>
                    <input type="text" id="searchInput" class="form-control form-control-sm ps-4"
                           placeholder="Buscar profesor, materia o grado..."
                           style="border:1.5px solid #e2e8f0;border-radius:8px;">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="pmgTable">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">#</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Profesor</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Materia</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Grado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size:0.7rem;color:#003b73;">Sección</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size:0.7rem;color:#003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @forelse($asignaciones as $profesorId => $items)
                            @foreach($items as $asignacion)
                            <tr class="pmg-row" style="border-bottom:1px solid #f1f5f9;">
                                <td class="px-3 py-2 text-muted small">{{ $i++ }}</td>
                                <td class="px-3 py-2">
                                    <div class="fw-semibold" style="color:#003b73;font-size:0.9rem;">
                                        {{ $asignacion->profesor->nombre_completo ?? ($asignacion->profesor->nombre . ' ' . $asignacion->profesor->apellido) }}
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge" style="background:rgba(78,199,210,0.1);color:#00508f;border:1px solid #4ec7d2;font-size:0.78rem;font-weight:500;padding:0.3rem 0.6rem;">
                                        <i class="fas fa-book me-1" style="font-size:0.65rem;"></i>
                                        {{ $asignacion->materia->nombre ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 small" style="color:#334155;">
                                    {{ $asignacion->grado->nombre ?? '—' }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="badge rounded-pill fw-bold"
                                          style="background:rgba(0,80,143,0.1);color:#00508f;border:1px solid #00508f;padding:0.3rem 0.7rem;font-size:0.8rem;">
                                        {{ $asignacion->seccion }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('profesor_materia_grado.edit', $asignacion->id) }}"
                                           class="btn btn-sm"
                                           title="Editar"
                                           style="background:rgba(78,199,210,0.1);color:#00508f;border:1px solid #4ec7d2;border-radius:6px;padding:0.25rem 0.5rem;">
                                            <i class="fas fa-edit" style="font-size:0.75rem;"></i>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('profesor_materia_grado.destroy', $asignacion->id) }}"
                                              onsubmit="return confirm('¿Eliminar esta asignación?')"
                                              class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" title="Eliminar"
                                                    style="background:rgba(244,67,54,0.08);color:#d32f2f;border:1px solid #ef9a9a;border-radius:6px;padding:0.25rem 0.5rem;">
                                                <i class="fas fa-trash" style="font-size:0.75rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x mb-3" style="color:#00508f;opacity:0.3;"></i>
                                    <h6 style="color:#003b73;">No hay asignaciones registradas</h6>
                                    <a href="{{ route('profesor_materia_grado.create') }}"
                                       class="btn btn-sm mt-2"
                                       style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border-radius:8px;padding:0.4rem 1rem;">
                                        <i class="fas fa-plus me-1"></i>Crear primera asignación
                                    </a>
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
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.pmg-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush
@endsection
