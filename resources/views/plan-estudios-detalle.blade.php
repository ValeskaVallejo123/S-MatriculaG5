<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $grado->numero }}° Grado - Plan de Estudios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background-color: #f4f7f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<div class="container py-4" style="max-width: 1400px;">

    {{-- Encabezado con botón Volver --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #003b73;">Plan de Estudios</h4>
            <small class="text-muted">Detalle del grado y materias asignadas</small>
        </div>
        <a href="{{ route('plan-estudios.index') }}"
           style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
            <i class="fas fa-arrow-left"></i>
            Volver al Plan de Estudios
        </a>
    </div>

    {{-- Stats cards --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-school" style="color: white; font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Grado</p>
                            <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ $grado->numero }}°</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book" style="color: white; font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Materias</p>
                            <h4 class="mb-0 fw-bold" style="color: #28a745;">{{ $grado->materias->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.08) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-layer-group" style="color: white; font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Nivel</p>
                            <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ ucfirst($grado->nivel) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(79, 70, 229, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt" style="color: white; font-size: 1.4rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Año Lectivo</p>
                            <h4 class="mb-0 fw-bold" style="color: #4f46e5;">{{ $grado->anio_lectivo }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Encabezado de sección --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-3">
                {{-- Avatar del grado --}}
                @php
                    $nivelColor = match(strtolower($grado->nivel)) {
                        'primaria'   => 'linear-gradient(135deg, #4ec7d2, #00508f)',
                        'basica'     => 'linear-gradient(135deg, #6366f1, #4f46e5)',
                        'secundaria' => 'linear-gradient(135deg, #00508f, #003b73)',
                        default      => 'linear-gradient(135deg, #64748b, #475569)',
                    };
                @endphp
                <div style="width: 55px; height: 55px; background: {{ $nivelColor }}; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid rgba(255,255,255,0.3);">
                    <span class="text-white fw-bold" style="font-size: 1.1rem; line-height: 1;">{{ $grado->numero }}°</span>
                    @if($grado->seccion)
                    <span class="text-white" style="font-size: 0.65rem; line-height: 1; opacity: 0.9;">{{ $grado->seccion }}</span>
                    @endif
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="color: #003b73;">
                        {{ $grado->numero }}° Grado
                        @if($grado->seccion) · Sección {{ $grado->seccion }} @endif
                    </h5>
                    <div class="d-flex gap-2 mt-1 flex-wrap">
                        <span class="badge" style="background: rgba(78,199,210,0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.7rem; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-layer-group me-1"></i>{{ ucfirst($grado->nivel) }}
                        </span>
                        <span class="badge" style="background: rgba(0,59,115,0.1); color: #003b73; border: 1px solid #00508f; padding: 0.3rem 0.7rem; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-calendar-alt me-1"></i>{{ $grado->anio_lectivo }}
                        </span>
                        @if($grado->activo ?? true)
                        <span class="badge rounded-pill" style="background: rgba(40,167,69,0.15); color: #28a745; border: 1px solid #28a745; padding: 0.3rem 0.8rem; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-check-circle"></i> Activo
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de materias --}}
    @if($grado->materias->isEmpty())
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-book mb-3" style="font-size: 3rem; color: #00508f; opacity: 0.3;"></i>
                <h5 style="color: #003b73;">No hay materias asignadas</h5>
                <p class="text-muted mb-0">Este grado aún no tiene materias registradas en su plan de estudios.</p>
            </div>
        </div>
    @else
        @foreach($grado->materias as $materia)
        <div class="card border-0 shadow-sm mb-2 materia-card" style="border-radius: 10px; transition: all 0.2s ease;">
            <div class="card-body p-2">
                <div class="row align-items-center g-2">

                    {{-- Ícono y nombre de la materia --}}
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #4ec7d2;">
                                <i class="fas fa-book-open text-white" style="font-size: 1rem;"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.95rem;">
                                    {{ $materia->nombre }}
                                </h6>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ $grado->numero }}° Grado · {{ ucfirst($grado->nivel) }}
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Info adicional de la materia --}}
                    <div class="col-lg-4">
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge" style="background: rgba(78,199,210,0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.35rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                                <i class="fas fa-chalkboard me-1"></i>{{ ucfirst($grado->nivel) }}
                            </span>
                            @if(isset($materia->codigo))
                            <span class="badge" style="background: rgba(0,59,115,0.1); color: #003b73; border: 1px solid #00508f; padding: 0.35rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                                <i class="fas fa-barcode me-1"></i>{{ $materia->codigo }}
                            </span>
                            @endif
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                            <i class="fas fa-calendar-alt me-1"></i>{{ $grado->anio_lectivo }}
                        </small>
                    </div>

                    {{-- Badge activo --}}
                    <div class="col-lg-2">
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <span class="badge rounded-pill" style="background: rgba(40,167,69,0.15); color: #28a745; padding: 0.35rem 0.8rem; font-weight: 600; border: 1px solid #28a745; font-size: 0.75rem;">
                                <i class="fas fa-check-circle"></i> Activa
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

        {{-- Contador al pie --}}
        <div class="card border-0 shadow-sm mt-3" style="border-radius: 10px;">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small" style="font-size: 0.85rem;">
                        <i class="fas fa-list-ol me-1"></i>
                        Mostrando {{ $grado->materias->count() }} materia(s) del {{ $grado->numero }}° Grado
                    </div>
                    <div>
                        <span class="badge" style="background: rgba(78,199,210,0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.35rem 0.8rem; font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-book me-1"></i>{{ $grado->materias->count() }} materias en total
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

<style>
    .materia-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 59, 115, 0.15) !important;
    }
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>