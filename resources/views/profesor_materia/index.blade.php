@extends('layouts.app')

@section('title', 'Gestión Profesor-Materia')

@section('page-title', 'Asignación de Materias')

@section('topbar-actions')
    <a href="{{ route('profesor_materia.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Asignar Materias
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1400px;">

        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="row align-items-center g-2">
                    <div class="col-md-6">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                            <input type="text" id="searchInput" class="form-control form-control-sm ps-5" placeholder="Buscar por nombre de profesor o materia..." style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-md-end gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-chalkboard-teacher" style="color: #00508f; font-size: 0.9rem;"></i>
                                <span class="small"><strong style="color: #00508f;">{{ $asignaciones->total() }}</strong> <span class="text-muted">Profesores</span></span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-book-open" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                                <span class="small"><strong style="color: #4ec7d2;">{{ $asignaciones->getCollection()->sum(fn($p) => $p->materiasGrupos->count()) }}</strong> <span class="text-muted">Asignaciones</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="profesorMateriaTable">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Profesor</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Materias / Grados / Secciones</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Total</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; color: #003b73;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($asignaciones as $profesor)
                            <tr class="profesor-row">
                                <td class="px-3 py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 35px; height: 35px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user-tie" style="color: white; font-size: 0.85rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $profesor->nombre }} {{ $profesor->apellido }}</div>
                                            <small class="text-muted" style="font-size: 0.75rem;">{{ $profesor->email ?? 'Sin correo' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    @if($profesor->materiasGrupos->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($profesor->materiasGrupos as $item)
                                                <span class="badge d-flex align-items-center gap-1" style="background: rgba(78, 199, 210, 0.1); color: #00508f; border: 1px solid #bfd9ea; padding: 0.3rem 0.6rem; font-weight: 500; font-size: 0.7rem;">
                                                    <i class="fas fa-book" style="font-size: 0.6rem;"></i>
                                                    {{ $item->materia->nombre }}
                                                    <span class="badge bg-white text-dark border ms-1" style="font-size: 0.65rem;">
                                                        {{ $item->grado->nombre }} "{{ $item->seccion }}"
                                                    </span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted small"><i class="fas fa-info-circle"></i> Sin materias</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                        {{ $profesor->materiasGrupos->count() }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('profesor_materia.edit', $profesor->id) }}" class="btn btn-sm btn-outline-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('profesor_materia.destroy', $profesor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar todas las asignaciones?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No hay asignaciones.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $asignaciones->links() }}
            </div>
        </div>
    </div>
@endsection
