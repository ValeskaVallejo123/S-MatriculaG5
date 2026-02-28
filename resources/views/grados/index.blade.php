@extends('layouts.app')

@section('title', 'Grados')

@section('page-title', 'Gestión de Grados y Secciones')

@section('topbar-actions')
    <a href="{{ route('superadmin.grados.create') }}"
       class="btn-back"
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i> Nuevo Grado
    </a>
@endsection

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border-left: 4px solid #10b981;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filtros --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.938rem;"></i>
                        <input type="text"
                               id="searchInput"
                               class="form-control ps-5"
                               placeholder="Buscar grado..."
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 3rem; transition: all 0.3s ease;">
                    </div>
                </div>

                <div class="col-md-2">
                    <select id="filterNivel" class="form-select" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        <option value="">Todos los niveles</option>
                        <option value="primaria">Primaria</option>
                        <option value="secundaria">Secundaria</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="perPageSelect" class="form-select" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;" onchange="changePerPage(this.value)">
                        <option value="10"  {{ request('per_page') == 10  ? 'selected' : '' }}>10 por página</option>
                        <option value="15"  {{ request('per_page') == 15 || !request('per_page') ? 'selected' : '' }}>15 por página</option>
                        <option value="20"  {{ request('per_page') == 20  ? 'selected' : '' }}>20 por página</option>
                        <option value="30"  {{ request('per_page') == 30  ? 'selected' : '' }}>30 por página</option>
                        <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50 por página</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-school" style="color: #00508f; font-size: 1rem;"></i>
                            <span class="small">
                                <strong style="color: #00508f; font-size: 1rem;">{{ $grados->total() }}</strong>
                                <span class="text-muted">Total</span>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem;"></i>
                            <span class="small">
                                <strong style="color: #10b981; font-size: 1rem;">{{ $grados->where('activo', true)->count() }}</strong>
                                <span class="text-muted">Activos</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4" id="nivelTabs" style="border: none;">
        <li class="nav-item">
            <button class="nav-link active" id="todos-tab" data-nivel="" data-bs-toggle="tab" type="button" style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-th-large me-2"></i>Todos
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="primaria-tab" data-nivel="primaria" data-bs-toggle="tab" type="button" style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-child me-2"></i>Primaria
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="secundaria-tab" data-nivel="secundaria" data-bs-toggle="tab" type="button" style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-user-graduate me-2"></i>Secundaria
            </button>
        </li>
    </ul>

    {{-- Contenido de Tabs --}}
    <div class="tab-content" id="nivelTabsContent">

        {{-- Tab: Todos --}}
        <div class="tab-pane fade show active" id="todos">
            <div class="row g-4" id="gradosContainer">
                @forelse($grados as $grado)
                <div class="col-md-6 col-lg-4 col-xl-3 grado-card"
                     data-nivel="{{ $grado->nivel }}"
                     data-grado="{{ $grado->numero }}"
                     data-seccion="{{ $grado->seccion }}"
                     data-anio="{{ $grado->anio_lectivo }}">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; transition: all 0.3s ease; border-left: 4px solid #4ec7d2;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.125rem;">
                                        <i class="fas fa-graduation-cap me-2" style="color: #4ec7d2;"></i>
                                        {{ $grado->numero }}°
                                        @if($grado->seccion)
                                            <span style="color: #4ec7d2;">{{ $grado->seccion }}</span>
                                        @endif
                                    </h5>
                                    <span class="badge" style="background: linear-gradient(135deg, rgba(78,199,210,0.15) 0%, rgba(0,80,143,0.15) 100%); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.75rem; font-size: 0.75rem; border-radius: 6px;">
                                        <i class="fas fa-layer-group me-1"></i>{{ ucfirst($grado->nivel) }}
                                    </span>
                                </div>
                                @if($grado->activo)
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, rgba(16,185,129,0.15) 0%, rgba(5,150,105,0.15) 100%); color: #059669; padding: 0.4rem 0.875rem; border: 1px solid #10b981; font-size: 0.75rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>Activo
                                    </span>
                                @else
                                    <span class="badge rounded-pill" style="background: rgba(239,68,68,0.1); color: #dc2626; padding: 0.4rem 0.875rem; border: 1px solid #ef4444; font-size: 0.75rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>Inactivo
                                    </span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2" style="border-bottom: 1px solid #e2e8f0;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-calendar-alt" style="color: #4ec7d2; font-size: 0.875rem;"></i>
                                        <span class="text-muted" style="font-size: 0.875rem;">Año Lectivo</span>
                                    </div>
                                    <strong style="color: #003b73; font-size: 0.938rem;">{{ $grado->anio_lectivo }}</strong>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-book" style="color: #4ec7d2; font-size: 0.875rem;"></i>
                                        <span class="text-muted" style="font-size: 0.875rem;">Materias</span>
                                    </div>
                                    <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.4rem 0.75rem; font-size: 0.813rem; border-radius: 6px;">
                                        {{ $grado->materias->count() }}
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('superadmin.grados.show', $grado) }}"
                                   class="btn btn-sm flex-fill btn-grado-view"
                                   style="border: 2px solid #6366f1; color: #6366f1; background: white; border-radius: 8px; font-size: 0.875rem; padding: 0.5rem; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}"
                                   class="btn btn-sm flex-fill btn-grado-materias"
                                   style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 8px; font-size: 0.875rem; padding: 0.5rem; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-tasks"></i>
                                </a>
                                <a href="{{ route('superadmin.grados.edit', $grado) }}"
                                   class="btn btn-sm btn-grado-edit"
                                   style="border: 2px solid #f59e0b; color: #f59e0b; background: white; border-radius: 8px; font-size: 0.875rem; padding: 0.5rem 0.625rem; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body text-center py-5">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(78,199,210,0.1) 0%, rgba(0,80,143,0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                <i class="fas fa-inbox" style="font-size: 2rem; color: #4ec7d2;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: #003b73;">No hay grados registrados</h5>
                            <p class="text-muted mb-4">Comienza agregando el primer grado</p>
                            <a href="{{ route('superadmin.grados.create') }}"
                               style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.6rem 1.5rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-plus"></i>Crear Grado
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($grados->hasPages())
                <div class="pagination-wrapper mt-4">
                    <div class="pagination-info">
                        Mostrando <strong>{{ $grados->firstItem() }}</strong> a <strong>{{ $grados->lastItem() }}</strong> de <strong>{{ $grados->total() }}</strong> resultados
                    </div>
                    <nav aria-label="Navegación de páginas">
                        <ul class="pagination">
                            {{-- Anterior --}}
                            @if ($grados->onFirstPage())
                                <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $grados->appends(['per_page' => request('per_page', 15)])->previousPageUrl() }}" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Primera página --}}
                            @if($grados->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $grados->appends(['per_page' => request('per_page', 15)])->url(1) }}">1</a>
                                </li>
                                @if($grados->currentPage() > 4)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            {{-- Páginas alrededor de la actual --}}
                            @for ($i = max(1, $grados->currentPage() - 2); $i <= min($grados->lastPage(), $grados->currentPage() + 2); $i++)
                                @if ($i == $grados->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $grados->appends(['per_page' => request('per_page', 15)])->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            {{-- Última página --}}
                            @if($grados->currentPage() < $grados->lastPage() - 2)
                                @if($grados->currentPage() < $grados->lastPage() - 3)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $grados->appends(['per_page' => request('per_page', 15)])->url($grados->lastPage()) }}">{{ $grados->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Siguiente --}}
                            @if ($grados->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $grados->appends(['per_page' => request('per_page', 15)])->nextPageUrl() }}" rel="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>

        {{-- Tab: Primaria --}}
        <div class="tab-pane fade" id="primaria">
            <div class="row g-4">
                @forelse($grados->where('nivel', 'primaria') as $grado)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #4ec7d2;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.125rem;">
                                        <i class="fas fa-child me-2" style="color: #4ec7d2;"></i>
                                        {{ $grado->numero }}° {{ $grado->seccion }}
                                    </h5>
                                    <span class="badge" style="background: linear-gradient(135deg, rgba(78,199,210,0.15) 0%, rgba(0,80,143,0.15) 100%); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.75rem; font-size: 0.75rem; border-radius: 6px;">
                                        Primaria
                                    </span>
                                </div>
                                @if($grado->activo)
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, rgba(16,185,129,0.15) 0%, rgba(5,150,105,0.15) 100%); color: #059669; padding: 0.4rem 0.875rem; border: 1px solid #10b981; font-size: 0.75rem;">Activo</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2 pb-2" style="border-bottom: 1px solid #e2e8f0;">
                                    <span class="text-muted" style="font-size: 0.875rem;">Año:</span>
                                    <strong style="color: #003b73;">{{ $grado->anio_lectivo }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted" style="font-size: 0.875rem;">Materias:</span>
                                    <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.4rem 0.75rem;">{{ $grado->materias->count() }}</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('superadmin.grados.show', $grado) }}" class="btn btn-sm flex-fill btn-grado-view" style="border: 2px solid #6366f1; color: #6366f1; background: white; border-radius: 8px; font-size: 0.875rem; font-weight: 600;"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}" class="btn btn-sm flex-fill btn-grado-materias" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 8px; font-size: 0.875rem; font-weight: 600;"><i class="fas fa-tasks"></i></a>
                                <a href="{{ route('superadmin.grados.edit', $grado) }}" class="btn btn-sm btn-grado-edit" style="border: 2px solid #f59e0b; color: #f59e0b; background: white; border-radius: 8px; font-size: 0.875rem; font-weight: 600;"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(78,199,210,0.1) 0%, rgba(0,80,143,0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: #4ec7d2;"></i>
                        </div>
                        <p class="text-muted">No hay grados de primaria registrados</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Tab: Secundaria --}}
        <div class="tab-pane fade" id="secundaria">
            <div class="row g-4">
                @forelse($grados->where('nivel', 'secundaria') as $grado)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #00508f;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.125rem;">
                                        <i class="fas fa-user-graduate me-2" style="color: #00508f;"></i>
                                        {{ $grado->numero }}° {{ $grado->seccion }}
                                    </h5>
                                    <span class="badge" style="background: rgba(0,80,143,0.15); color: #003b73; border: 1px solid #00508f; padding: 0.4rem 0.75rem; font-size: 0.75rem; border-radius: 6px;">
                                        Secundaria
                                    </span>
                                </div>
                                @if($grado->activo)
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, rgba(16,185,129,0.15) 0%, rgba(5,150,105,0.15) 100%); color: #059669; padding: 0.4rem 0.875rem; border: 1px solid #10b981; font-size: 0.75rem;">Activo</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2 pb-2" style="border-bottom: 1px solid #e2e8f0;">
                                    <span class="text-muted" style="font-size: 0.875rem;">Año:</span>
                                    <strong style="color: #003b73;">{{ $grado->anio_lectivo }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted" style="font-size: 0.875rem;">Materias:</span>
                                    <span class="badge" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); color: white; padding: 0.4rem 0.75rem;">{{ $grado->materias->count() }}</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('superadmin.grados.show', $grado) }}" class="btn btn-sm flex-fill btn-grado-view" style="border: 2px solid #6366f1; color: #6366f1; background: white; border-radius: 8px; font-size: 0.875rem; font-weight: 600;"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}" class="btn btn-sm flex-fill btn-grado-materias" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 8px; font-size: 0.875rem; font-weight: 600;"><i class="fas fa-tasks"></i></a>
                                <a href="{{ route('superadmin.grados.edit', $grado) }}" class="btn btn-sm btn-grado-edit" style="border: 2px solid #f59e0b; color: #f59e0b; background: white; border-radius: 8px; font-size: 0.875rem; font-weight: 600;"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(0,80,143,0.1) 0%, rgba(0,59,115,0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: #00508f;"></i>
                        </div>
                        <p class="text-muted">No hay grados de secundaria registrados</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
.card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important; }
.btn-grado-view:hover    { background: #6366f1 !important; color: white !important; transform: translateY(-2px); }
.btn-grado-materias:hover{ background: #4ec7d2 !important; color: white !important; transform: translateY(-2px); }
.btn-grado-edit:hover    { background: #f59e0b !important; color: white !important; transform: translateY(-2px); }
.btn-back:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(78,199,210,0.4) !important; }

#searchInput:focus, .form-select:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 0.2rem rgba(78,199,210,0.15);
    outline: none;
}

.nav-tabs { border-bottom: 2px solid #e2e8f0; }
.nav-tabs .nav-link { border: none; background: transparent; margin-right: 0.5rem; }
.nav-tabs .nav-link.active { background: white; border: 2px solid #4ec7d2 !important; border-bottom: 2px solid white !important; margin-bottom: -2px; color: #00508f !important; }
.nav-tabs .nav-link:hover:not(.active) { background: linear-gradient(135deg, rgba(78,199,210,0.1) 0%, rgba(0,80,143,0.1) 100%); }

.pagination-wrapper { display: flex; flex-direction: column; align-items: center; gap: 1rem; margin-top: 2rem; }
.pagination-info { text-align: center; color: #64748b; font-size: 0.875rem; padding: 0.75rem 1.5rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; }
.pagination-info strong { color: #00508f; font-weight: 600; }

.pagination { display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin: 0; padding: 0; list-style: none; flex-wrap: wrap; }
.page-item { list-style: none; }
.page-link { display: flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0.5rem 0.75rem; background: white; border: 2px solid #e2e8f0; border-radius: 8px; color: #64748b; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: all 0.2s ease; }
.page-link:hover { background: linear-gradient(135deg, rgba(78,199,210,0.1) 0%, rgba(0,80,143,0.1) 100%); border-color: #4ec7d2; color: #00508f; transform: translateY(-2px); }
.page-item.active .page-link { background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-color: #4ec7d2; color: white; box-shadow: 0 4px 12px rgba(78,199,210,0.3); }
.page-item.disabled .page-link { background: #f8fafc; border-color: #e2e8f0; color: #cbd5e1; cursor: not-allowed; opacity: 0.6; }
.page-item.disabled .page-link:hover { transform: none; }

@media (max-width: 768px) {
    .pagination { gap: 0.25rem; }
    .page-link { min-width: 36px; height: 36px; padding: 0.4rem 0.6rem; font-size: 0.813rem; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const filterNivel = document.getElementById('filterNivel');
    const cards = document.querySelectorAll('.grado-card');

    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const nivelFilter = filterNivel.value;

        cards.forEach(function (card) {
            const text  = card.textContent.toLowerCase();
            const nivel = card.dataset.nivel;

            const matchesSearch = text.includes(searchTerm);
            const matchesNivel  = !nivelFilter || nivel === nivelFilter;

            card.style.display = (matchesSearch && matchesNivel) ? '' : 'none';
        });
    }

    // Sincronizar Select → Tabs
    filterNivel.addEventListener('change', function () {
        const val = this.value;
        const targetTab = document.querySelector(`#nivelTabs button[data-nivel="${val}"]`);
        if (targetTab) {
            new bootstrap.Tab(targetTab).show();
        }
        filterCards();
    });

    // Sincronizar Tabs → Select
    tabButtons.forEach(function (button) {
        button.addEventListener('shown.bs.tab', function (event) {
            filterNivel.value = event.target.getAttribute('data-nivel');
            filterCards();
        });
    });

    // Buscador
    searchInput.addEventListener('keyup', filterCards);
});

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush
@endsection
