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
                                    {{ $g->numero }}° {{ ucfirst($g->nivel) }} — Sec. {{ $g->seccion }}
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
                            <th style="min-width:200px;">Estudiante</th>
                            <th style="min-width:180px;">Grado</th>
                            <th style="min-width:150px;">Materia</th>
                            <th style="min-width:170px;">Periodo Académico</th>
                            <th style="min-width:110px;">Nota</th>
                            <th style="min-width:200px;">Observación</th>
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

                                <td>

                                    {{ $calificacion->grado->numero ?? '' }}°
                                    {{ ucfirst($calificacion->grado->nivel ?? '') }}
                                    - Sección {{ $calificacion->grado->seccion ?? '' }}

                                </td>

                                <td>

                                    {{ $calificacion->materia->nombre ?? '' }}

                                </td>

                                <td>

                                    {{ $calificacion->periodoAcademico->nombre_periodo ?? 'No asignado' }}

                                </td>

                                <td>

                                    @php
                                        $nota = $calificacion->nota;
                                    @endphp

                                    @if($nota < 60)

                                        <span class="badge"
                                              style="background:#ffe6e6;color:#7a1a1a;font-size:0.9rem;padding:6px 10px;">

                                        {{ $nota }}

                                    </span>

                                    @elseif($nota < 80)

                                        <span class="badge"
                                              style="background:#fff4cc;color:#6a4a00;font-size:0.9rem;padding:6px 10px;">

                                        {{ $nota }}

                                    </span>

                                    @else

                                        <span class="badge"
                                              style="background:#e6ffef;color:#0f5132;font-size:0.9rem;padding:6px 10px;">

                                        {{ $nota }}

                                    </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $calificacion->observacion ?? '-' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-4 text-muted">

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
