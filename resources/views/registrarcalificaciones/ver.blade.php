@extends('layouts.app')

@section('title', 'Todas las Calificaciones')
@section('page-title', 'Listado General de Calificaciones')

@section('content')

    <div class="container-fluid px-4 py-3">

        <!-- HEADER -->
        <div class="card border-0 shadow-sm mb-4"
             style="border-radius:12px;background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">

            <div class="card-body p-3">

                <div class="d-flex align-items-center">

                    <div class="me-3"
                         style="width:48px;height:48px;border-radius:10px;
                     background:rgba(255,255,255,0.2);
                     display:flex;align-items:center;justify-content:center;">

                        <i class="fas fa-chart-bar text-white"></i>

                    </div>

                    <div class="text-white">

                        <h5 class="mb-0 fw-bold">
                            Listado General de Calificaciones
                        </h5>

                        <p class="mb-0 opacity-90" style="font-size:0.85rem;">
                            Consulta todas las calificaciones registradas en el sistema
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- CARD PRINCIPAL -->
        <div class="card border-0 shadow-sm" style="border-radius:12px;">

            <div class="card-body">

                <h6 class="fw-bold mb-3" style="color:#003b73;">
                    <i class="fas fa-list me-2"></i>
                    Calificaciones Registradas
                </h6>

                <!-- FILTROS -->
                <form method="GET" action="{{ route('registrarcalificaciones.ver') }}"
                      class="mb-3 d-flex flex-wrap gap-2 align-items-end">
                    <div>
                        <label class="form-label small fw-semibold mb-1" style="color:#003b73;">Grado</label>
                        <select name="grado_id" class="form-select form-select-sm" style="border:2px solid #bfd9ea;border-radius:8px;min-width:170px;">
                            <option value="">Todos los grados</option>
                            @foreach($gradosFiltro as $g)
                                <option value="{{ $g->id }}" {{ request('grado_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label small fw-semibold mb-1" style="color:#003b73;">Materia</label>
                        <select name="materia_id" class="form-select form-select-sm" style="border:2px solid #bfd9ea;border-radius:8px;min-width:160px;">
                            <option value="">Todas las materias</option>
                            @foreach($materiasFiltro as $m)
                                <option value="{{ $m->id }}" {{ request('materia_id') == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label small fw-semibold mb-1" style="color:#003b73;">Período</label>
                        <select name="periodo_id" class="form-select form-select-sm" style="border:2px solid #bfd9ea;border-radius:8px;min-width:150px;">
                            <option value="">Todos los períodos</option>
                            @foreach($periodosFiltro as $per)
                                <option value="{{ $per->id }}" {{ request('periodo_id') == $per->id ? 'selected' : '' }}>{{ $per->nombre_periodo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm"
                                style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:#fff;border:none;border-radius:8px;font-weight:600;padding:6px 14px;">
                            <i class="fas fa-filter me-1"></i> Filtrar
                        </button>
                        @if(request()->hasAny(['grado_id','materia_id','periodo_id']))
                            <a href="{{ route('registrarcalificaciones.ver') }}"
                               class="btn btn-sm ms-1"
                               style="border:2px solid #94a3b8;color:#64748b;border-radius:8px;font-weight:600;">
                                <i class="fas fa-times me-1"></i> Limpiar
                            </a>
                        @endif
                    </div>
                </form>

                <!-- TABLA -->
                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead style="background:#003b73;color:white;">

                        <tr>
                            <th style="min-width:190px;">Estudiante</th>
                            <th style="min-width:170px;">Grado</th>
                            <th style="min-width:140px;">Materia</th>
                            <th style="min-width:150px;">Período</th>
                            <th style="text-align:center;min-width:75px;">P1</th>
                            <th style="text-align:center;min-width:75px;">P2</th>
                            <th style="text-align:center;min-width:75px;">P3</th>
                            <th style="text-align:center;min-width:75px;">Rec.</th>
                            <th style="text-align:center;min-width:90px;">Nota Final</th>
                            <th style="min-width:160px;">Observación</th>
                        </tr>

                        </thead>

                        <tbody>

                        @forelse($calificaciones as $calificacion)

                            <tr>

                                <td>

                                    <strong>
                                        {{ $calificacion->estudiante->apellido1 ?? '' }}
                                        {{ $calificacion->estudiante->nombre1 ?? '' }}
                                    </strong>

                                </td>

                                <td>{{ $calificacion->grado->nombre_completo ?? '—' }}</td>

                                <td>{{ $calificacion->materia->nombre ?? '—' }}</td>

                                <td>{{ $calificacion->periodoAcademico->nombre_periodo ?? 'No asignado' }}</td>

                                @php
                                    $parciales = [
                                        $calificacion->primer_parcial,
                                        $calificacion->segundo_parcial,
                                        $calificacion->tercer_parcial,
                                    ];
                                    $nota = $calificacion->nota;
                                    $colorNota = $nota === null ? '#94a3b8' : ($nota >= 60 ? '#059669' : '#dc2626');
                                    $bgNota    = $nota === null ? '#f1f5f9' : ($nota >= 60 ? '#ecfdf5'  : '#fee2e2');
                                @endphp

                                @foreach($parciales as $p)
                                    <td style="text-align:center;">
                                        @if($p !== null)
                                            <span style="font-weight:700;color:{{ $p >= 60 ? '#059669' : '#dc2626' }};">
                                                {{ number_format($p, 1) }}
                                            </span>
                                        @else
                                            <span style="color:#cbd5e1;">—</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td style="text-align:center;">
                                    @if($calificacion->recuperacion !== null)
                                        <span style="font-weight:700;color:#d97706;">
                                            {{ number_format($calificacion->recuperacion, 1) }}
                                        </span>
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>

                                <td style="text-align:center;">
                                    <span style="display:inline-block;padding:.3rem .7rem;border-radius:999px;
                                                 font-weight:800;font-size:.9rem;
                                                 background:{{ $bgNota }};color:{{ $colorNota }};">
                                        {{ $nota !== null ? number_format($nota, 1) : '—' }}
                                    </span>
                                </td>

                                <td style="color:#64748b;font-size:.83rem;">{{ $calificacion->observacion ?? '—' }}</td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10" class="text-center py-4 text-muted">

                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay calificaciones registradas.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- PAGINACION -->
                <div class="mt-3">

                    {{ $calificaciones->links() }}

                </div>

            </div>

        </div>

    </div>

@endsection
