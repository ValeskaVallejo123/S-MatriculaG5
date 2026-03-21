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
