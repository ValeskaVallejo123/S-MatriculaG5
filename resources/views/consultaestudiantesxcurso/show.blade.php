@extends('layouts.app')

@section('title', 'Detalle del Curso')
@section('page-title', 'Estudiantes del Curso')


@section('content')
<div class="container-fluid px-4 py-3">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:12px;background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="me-3"
                     style="width:48px;height:48px;border-radius:10px;
                            background:rgba(255,255,255,0.2);
                            display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-users text-white fa-lg"></i>
                </div>
                <div class="text-white">
                    <h5 class="mb-0 fw-bold">
                        {{ $grado }} — Sección {{ $seccion }}
                    </h5>
                    <p class="mb-0 opacity-90" style="font-size:0.85rem;">
                        {{ $estudiantes->count() }} estudiantes matriculados
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-0">

            @if($estudiantes->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-2x mb-3" style="color:#4ec7d2;opacity:0.5;"></i>
                    <h6 style="color:#003b73;">No hay estudiantes en este curso</h6>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#003b73;color:white;">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Estudiante</th>
                                <th class="px-4 py-3">DNI</th>
                                <th class="px-4 py-3">Fecha Nacimiento</th>
                                <th class="px-4 py-3 text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $i => $estudiante)
                                <tr style="border-bottom:1px solid #f1f5f9;">
                                    <td class="px-4 py-3 text-muted small">
                                        {{ $i + 1 }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:36px;height:36px;border-radius:50%;
                                                        background:linear-gradient(135deg,#4ec7d2,#00508f);
                                                        display:flex;align-items:center;
                                                        justify-content:center;color:white;
                                                        font-weight:700;font-size:0.8rem;flex-shrink:0;">
                                                {{ strtoupper(substr($estudiante->nombre1,0,1)) }}{{ strtoupper(substr($estudiante->apellido1,0,1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="color:#003b73;">
                                                    {{ $estudiante->apellido1 }}
                                                    {{ $estudiante->apellido2 }},
                                                    {{ $estudiante->nombre1 }}
                                                    {{ $estudiante->nombre2 }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-muted">
                                        {{ $estudiante->dni ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-muted">
                                        {{ $estudiante->fecha_nacimiento
                                            ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')
                                            : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge rounded-pill"
                                              style="{{ $estudiante->estado == 'activo'
                                                        ? 'background:rgba(40,167,69,0.1);color:#28a745;border:1px solid #28a745;'
                                                        : 'background:rgba(108,117,125,0.1);color:#6c757d;border:1px solid #6c757d;' }}
                                                     padding:0.35rem 0.8rem;font-size:0.78rem;">
                                            {{ ucfirst($estudiante->estado ?? 'N/A') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
