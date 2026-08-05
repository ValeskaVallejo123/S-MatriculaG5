@extends('layouts.app')

@section('title', 'Gestión de Permisos de Padres')
@section('page-title', 'Gestión de Permisos de Padres')


@push('styles')
<style>
    .table > :not(caption) > * > * { padding: 0.6rem 0.75rem; }
    .btn-group .btn:hover { transform: translateY(-1px); z-index: 1; }
    .pagination { margin-bottom: 0; }
    .pagination .page-link {
        border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0;
        color: #00508f; transition: all 0.3s ease; padding: 0.3rem 0.6rem; font-size: 0.85rem;
    }
    .pagination .page-link:hover { background:#bfd9ea; border-color:#4ec7d2; color:#003b73; }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        border-color:#4ec7d2; color:white;
    }
    .table tbody tr:hover { background-color: rgba(191,217,234,0.08); }
    #searchInput:focus {
        border-color:#4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78,199,210,0.15);
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="container" style="max-width: 1400px;">

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Buscador y resumen --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute"
                           style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:0.9rem;"></i>
                        <input type="text" id="searchInput" class="form-control form-control-sm ps-5"
                               placeholder="Buscar por nombre, DNI, correo..."
                               style="border:2px solid #bfd9ea;border-radius:8px;padding:0.5rem 1rem 0.5rem 2.5rem;transition:all 0.3s ease;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <span class="small">
                            <i class="fas fa-users me-1" style="color:#00508f;"></i>
                            <strong style="color:#00508f;">{{ $padres->total() }}</strong>
                            <span class="text-muted">Total padres</span>
                        </span>
                        <span class="small">
                            <i class="fas fa-check-circle me-1" style="color:#4ec7d2;"></i>
                            <strong style="color:#4ec7d2;">{{ $padres->getCollection()->where('estado', 1)->count() }}</strong>
                            <span class="text-muted">Activos</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm" style="border-radius:10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="permisosTable">
                    <thead style="background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Padre / Tutor</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">DNI</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Parentesco</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Contacto</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Hijos</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Estado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size:0.7rem;color:#003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($padres as $padre)
                        <tr style="border-bottom:1px solid #f1f5f9;transition:all 0.2s ease;" class="padre-row">

                            {{-- Nombre --}}
                            <td class="px-3 py-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:35px;height:35px;background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.85rem;flex-shrink:0;">
                                        {{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($padre->apellido ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color:#003b73;font-size:0.9rem;">
                                            {{ $padre->nombre }} {{ $padre->apellido }}
                                        </div>
                                        @if($padre->correo)
                                            <small class="text-muted" style="font-size:0.75rem;">{{ $padre->correo }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- DNI --}}
                            <td class="px-3 py-2">
                                <span class="font-monospace small" style="color:#00508f;font-size:0.85rem;">
                                    {{ $padre->dni ?? 'N/A' }}
                                </span>
                            </td>

                            {{-- Parentesco --}}
                            <td class="px-3 py-2">
                                <span class="badge"
                                      style="background:rgba(78,199,210,0.15);color:#00508f;border:1px solid #4ec7d2;padding:0.3rem 0.6rem;font-size:0.75rem;">
                                    {{ $padre->parentesco_formateado }}
                                </span>
                            </td>

                            {{-- Contacto --}}
                            <td class="px-3 py-2">
                                @if($padre->telefono)
                                    <small class="d-block text-muted" style="font-size:0.78rem;">
                                        <i class="fas fa-phone me-1" style="color:#4ec7d2;"></i>{{ $padre->telefono }}
                                    </small>
                                @endif
                                @if(!$padre->telefono && !$padre->correo)
                                    <small class="text-muted fst-italic">Sin contacto</small>
                                @endif
                            </td>

                            {{-- Hijos --}}
                            <td class="px-3 py-2">
                                <span class="badge"
                                      style="background:rgba(78,199,210,0.15);color:#00508f;border:1px solid #4ec7d2;padding:0.3rem 0.6rem;font-size:0.75rem;">
                                    <i class="fas fa-child me-1"></i>
                                    {{ $padre->estudiantes->count() }}
                                    {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="px-3 py-2">
                                @if($padre->estado)
                                    <span class="badge rounded-pill"
                                          style="background:rgba(78,199,210,0.2);color:#00508f;border:1px solid #4ec7d2;padding:0.3rem 0.7rem;font-size:0.75rem;">
                                        <i class="fas fa-circle me-1" style="font-size:0.4rem;color:#4ec7d2;"></i>Activo
                                    </span>
                                @else
                                    <span class="badge rounded-pill"
                                          style="background:#fee2e2;color:#991b1b;border:1px solid #ef4444;padding:0.3rem 0.7rem;font-size:0.75rem;">
                                        <i class="fas fa-circle me-1" style="font-size:0.4rem;"></i>Inactivo
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-3 py-2 text-end">
                                <a href="{{ route('admin.permisos.configurar', $padre->id) }}"
                                   class="btn btn-sm"
                                   style="border-radius:6px;border:1.5px solid #00508f;color:#00508f;background:white;padding:0.3rem 0.75rem;font-size:0.8rem;"
                                   title="Configurar permisos"
                                   onmouseover="this.style.background='#00508f';this.style.color='white';"
                                   onmouseout="this.style.background='white';this.style.color='#00508f';">
                                    <i class="fas fa-sliders-h me-1"></i>Configurar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users fa-2x mb-2" style="color:#00508f;opacity:0.5;"></i>
                                <h6 style="color:#003b73;">No hay padres registrados</h6>
                                <p class="small mb-0 text-muted">No se encontraron resultados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        @if($padres->hasPages())
        <div class="card-footer bg-white border-0 py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    {{ $padres->firstItem() }} – {{ $padres->lastItem() }} de {{ $padres->total() }}
                </small>
                {{ $padres->links() }}
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tbody = document.querySelector('#permisosTable tbody');
    const rows = tbody.querySelectorAll('.padre-row');

    searchInput.addEventListener('keyup', function () {
        const term = this.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach(function (row) {
            const match = row.textContent.toLowerCase().includes(term);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        let noRow = tbody.querySelector('.no-results-row');
        if (visible === 0 && term !== '') {
            if (!noRow) {
                noRow = document.createElement('tr');
                noRow.className = 'no-results-row';
                noRow.innerHTML = `<td colspan="7" class="text-center py-4">
                    <i class="fas fa-search" style="color:#00508f;opacity:0.5;font-size:1.5rem;"></i>
                    <p class="text-muted mt-2 mb-0">Sin resultados para "<strong>${term}</strong>"</p>
                </td>`;
                tbody.appendChild(noRow);
            }
        } else if (noRow) {
            noRow.remove();
        }
    });
});
</script>
@endpush
