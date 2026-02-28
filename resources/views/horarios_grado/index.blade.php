@extends('layouts.app')

@section('title', 'Horarios por Grado')
@section('page-title', 'Horarios por Grado')

@section('content')
<div class="container" style="max-width: 1100px;">

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Seleccionar Grado
            </h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-4">
                @forelse($grados as $g)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border: 1px solid #e2e8f0 !important;">
                            <div class="card-header border-0 py-3 px-3" style="background: linear-gradient(135deg, rgba(0,80,143,0.08) 0%, rgba(78,199,210,0.08) 100%); border-radius: 10px 10px 0 0;">
                                <h6 class="fw-bold mb-0" style="color: #003b73;">
                                    <i class="fas fa-layer-group me-2" style="color: #4ec7d2;"></i>
                                    {{ ucfirst($g->nivel) }} — {{ $g->numero }}° {{ $g->seccion }}
                                </h6>
                                <small class="text-muted">Año lectivo: {{ $g->anio_lectivo }}</small>
                            </div>

                            <div class="card-body p-3">

                                {{-- Ver horarios --}}
                                <p class="text-muted mb-2" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-eye me-1"></i> Ver Horario
                                </p>
                                <div class="d-flex gap-2 mb-3">
                                    <a href="{{ route('horarios_grado.show', [$g->id, 'matutina']) }}"
                                       class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-sun me-1"></i> Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.show', [$g->id, 'vespertina']) }}"
                                       class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-moon me-1"></i> Vespertina
                                    </a>
                                </div>

                                {{-- Editar horarios --}}
                                <p class="text-muted mb-2" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-edit me-1"></i> Editar Horario
                                </p>
                                <div class="d-flex gap-2 mb-3">
                                    <a href="{{ route('horarios_grado.edit', [$g->id, 'matutina']) }}"
                                       class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-sun me-1"></i> Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.edit', [$g->id, 'vespertina']) }}"
                                       class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-moon me-1"></i> Vespertina
                                    </a>
                                </div>

                                {{-- PDF --}}
                                <p class="text-muted mb-2" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('horarios_grado.pdf', [$g->id, 'matutina']) }}"
                                       class="btn btn-danger btn-sm flex-fill">
                                        <i class="fas fa-sun me-1"></i> Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.pdf', [$g->id, 'vespertina']) }}"
                                       class="btn btn-danger btn-sm flex-fill">
                                        <i class="fas fa-moon me-1"></i> Vespertina
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-3" style="color: #cbd5e1;"></i>
                            <p class="mb-0 fw-semibold">No hay grados registrados.</p>
                            <small>Agregue grados para gestionar sus horarios.</small>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

</div>
@endsection
