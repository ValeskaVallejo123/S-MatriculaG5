@extends('layouts.app')

@section('title', 'Historial Académico - ' . $estudiante->nombre1)

@push('styles')
    <style>
        /* CORRECCIÓN DE MÁRGENES PARA ESTUDIANTES */
        /* Si no es Admin ni SuperAdmin, quitamos el margen del layout */
        @if(!auth()->user() || !in_array(auth()->user()->id_rol, [1, 2]))
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }
        .content-wrapper {
            padding: 1.5rem !important;
        }
        /* Ocultar sidebar por si acaso el layout intenta renderizarlo vacío */
        .sidebar { display: none !important; }
        @endif

/* Ajustes de impresión */
        @media print {
            .no-print, .navbar, .sidebar, .topbar, .btn-toggle-dark, .btn-logout {
                display: none !important;
            }
            .main-content { margin-left: 0 !important; width: 100% !important; }
            .content-wrapper { padding: 0 !important; }
            body { background: white !important; }
            @page { margin: 1cm; }
        }
    </style>
@endpush

@section('content')
    <div style="width: 100% !important; margin: 0; padding: 10px;">

        {{-- BOTONES DE ACCIÓN --}}
        <div class="no-print" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ auth()->user()->id_rol == 3 ? url('/estudiante/dashboard') : url()->previous() }}" style="text-decoration: none; color: #00508f; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-chevron-left"></i> VOLVER AL PANEL
            </a>
            <button onclick="window.print();" style="background: #4ec7d2; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.85rem; box-shadow: 0 4px 10px rgba(78, 199, 210, 0.2);">
                <i class="fas fa-print me-1"></i> IMPRIMIR REPORTE
            </button>
        </div>

        {{-- BLOQUE DE MENSAJES --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show no-print" role="alert" style="border-radius: 12px; font-weight: 600;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- TARJETA PRINCIPAL DEL HISTORIAL --}}
        <div style="background:white; border-radius:16px; box-shadow:0 10px 25px rgba(0,59,115,0.1); overflow:hidden; border:1px solid #e8edf4; max-width: 1100px; margin: 0 auto;">

            {{-- ENCABEZADO AZUL --}}
            <div style="background: linear-gradient(135deg, #002d5a 0%, #00508f 100%); padding: 2.5rem; color: white; position: relative;">
                <div style="position: absolute; right: 20px; top: 20px; opacity: 0.1; font-size: 6rem;">
                    <i class="fas fa-graduation-cap"></i>
                </div>

                <div style="display: flex; align-items: center; gap: 2rem; position: relative; z-index: 1;">
                    <div style="width: 90px; height: 90px; background: rgba(255,255,255,0.2); border: 3px solid #4ec7d2; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; font-weight: 800; text-transform: uppercase;">
                        {{ substr($estudiante->nombre1, 0, 1) }}{{ substr($estudiante->apellido1, 0, 1) }}
                    </div>

                    <div>
                        <h1 style="margin: 0; font-size: 1.7rem; font-weight: 800; letter-spacing: -0.5px;">
                            {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                        </h1>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-top: 0.6rem; opacity: 0.9; font-size: 0.85rem;">
                            <span><i class="fas fa-id-card me-1"></i> DNI: <b>{{ $estudiante->dni }}</b></span>
                            <span><i class="fas fa-school me-1"></i> Grado: <b>{{ $estudiante->grado ?? 'N/A' }}</b></span>
                            <span><i class="fas fa-users me-1"></i> Sección: <b>{{ $estudiante->seccion ?? 'N/A' }}</b></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RESUMEN DE RENDIMIENTO --}}
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); background: #f8fafc; border-bottom: 1px solid #e8edf4;">
                <div style="padding: 1.2rem; text-align: center; border-right: 1px solid #e8edf4;">
                    <div style="font-size: 0.6rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Materias</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #00508f;">{{ $estudiante->calificaciones->count() }}</div>
                </div>
                <div style="padding: 1.2rem; text-align: center; border-right: 1px solid #e8edf4;">
                    <div style="font-size: 0.6rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Promedio General</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #00508f;">{{ number_format($promedio, 2) }}%</div>
                </div>
                <div style="padding: 1.2rem; text-align: center;">
                    <div style="font-size: 0.6rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Estado</div>
                    <div>
                        <span style="display: inline-block; margin-top: 0.2rem; padding: 0.2rem 0.7rem; border-radius: 50px; background: {{ $promedio >= 60 ? '#dcfce7' : '#fee2e2' }}; color: {{ $promedio >= 60 ? '#166534' : '#991b1b' }}; font-weight: 800; font-size: 0.7rem;">
                            {{ $promedio >= 60 ? 'SATISFACTORIO' : 'EN RIESGO' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- DETALLE ACADÉMICO --}}
            <div style="padding: 2rem;">
                <h3 style="color: #003b73; font-size: 1rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fas fa-list-check" style="color: #4ec7d2;"></i> DETALLE POR CICLO LECTIVO
                </h3>

                @forelse($historialAgrupado as $anio => $notas)
                    <div style="margin-bottom: 1.5rem; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                        <div style="background: #f1f5f9; padding: 0.7rem 1.2rem; font-weight: 800; color: #334155; font-size: 0.85rem; border-bottom: 1px solid #e2e8f0;">
                            <i class="fas fa-calendar-alt me-2"></i> CICLO: {{ $anio }}
                        </div>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                <tr style="text-align: left; background: #ffffff;">
                                    <th style="padding: 0.8rem; color: #64748b; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">Materia</th>
                                    <th style="padding: 0.8rem; color: #64748b; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; text-align: center;">Parciales</th>
                                    <th style="padding: 0.8rem; color: #64748b; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; text-align: center;">Final</th>
                                    <th style="padding: 0.8rem; color: #64748b; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; text-align: center;">Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($notas as $nota)
                                    <tr style="border-top: 1px solid #f1f5f9;">
                                        <td style="padding: 0.8rem;">
                                            <div style="font-weight: 700; color: #003b73; font-size: 0.8rem;">{{ $nota->materia->nombre }}</div>
                                            <small style="color: #94a3b8; font-size: 0.7rem;">{{ $nota->periodo->nombre_periodo }}</small>
                                        </td>
                                        <td style="padding: 0.8rem; text-align: center; color: #64748b; font-size: 0.75rem;">
                                            {{ $nota->primer_parcial ?? '-' }} | {{ $nota->segundo_parcial ?? '-' }} | {{ $nota->tercer_parcial ?? '-' }}
                                        </td>
                                        <td style="padding: 0.8rem; text-align: center;">
                                                <span style="font-weight: 800; color: {{ $nota->nota_final >= 60 ? '#00508f' : '#ef4444' }};">
                                                    {{ number_format($nota->nota_final, 0) }}%
                                                </span>
                                        </td>
                                        <td style="padding: 0.8rem; text-align: center;">
                                                <span style="color: {{ $nota->nota_final >= 60 ? '#22c55e' : '#ef4444' }}; font-weight: 800; font-size: 0.65rem;">
                                                    {{ $nota->nota_final >= 60 ? 'APROBADO' : 'REPROBADO' }}
                                                </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div style="padding: 3rem; text-align: center; color: #94a3b8;">
                        <i class="fas fa-folder-open mb-2" style="font-size: 2rem;"></i>
                        <p>No hay historial académico disponible.</p>
                    </div>
                @endforelse
            </div>

            {{-- PIE DE PÁGINA --}}
            <div style="padding: 1.5rem 2rem; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: center; font-size: 0.7rem; color: #94a3b8;">
                <div>Generado el: {{ date('d/m/Y h:i A') }}</div>
                <div style="text-align: right; font-weight: 700; color: #003b73;">Escuela Gabriela Mistral</div>
            </div>
        </div>

        {{-- PANEL ADMIN --}}
        @if(auth()->user()->id_rol == 1)
            <div class="no-print" style="margin-top: 2rem; padding: 1.2rem; background: #fff4e5; border: 1px solid #ffe3bc; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; max-width: 1100px; margin-left: auto; margin-right: auto;">
                <div>
                    <h4 style="margin: 0; color: #854d0e; font-size: 0.85rem; font-weight: 800;">GESTIÓN ADMINISTRATIVA</h4>
                    <p style="margin: 0; color: #a16207; font-size: 0.75rem;">Puede editar las calificaciones de este estudiante.</p>
                </div>
                <a href="{{ route('superadmin.estudiantes.historial.edit', $estudiante->id) }}" style="text-decoration: none; background: #f59e0b; color: white; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.8rem; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);">
                    <i class="fas fa-edit me-1"></i> EDITAR NOTAS
                </a>
            </div>
        @endif
    </div>
@endsection
