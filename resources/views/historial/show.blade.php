@extends('layouts.app')

@section('title', 'Historial Académico - ' . $estudiante->nombre1)

@section('content')
    <div style="width:100%; max-width: 1100px; margin: 0 auto;">

        {{-- BOTÓN VOLVER --}}
        <div class="no-print" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ url()->previous() }}" style="text-decoration: none; color: #00508f; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-chevron-left"></i> VOLVER AL PANEL
            </a>
            <button onclick="window.print();" style="background: #4ec7d2; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.8rem;">
                <i class="fas fa-print me-1"></i> IMPRIMIR REPORTE
            </button>
        </div>

        {{-- TARJETA PRINCIPAL --}}
        <div style="background:white; border-radius:16px; box-shadow:0 10px 25px rgba(0,59,115,0.1); overflow:hidden; border:1px solid #e8edf4;">

            {{-- ENCABEZADO ESTILO DIPLOMA --}}
            <div style="background: linear-gradient(135deg, #002d5a 0%, #00508f 100%); padding: 2.5rem; color: white; position: relative;">
                <div style="position: absolute; right: -20px; top: -20px; opacity: 0.1; font-size: 8rem;">
                    <i class="fas fa-graduation-cap"></i>
                </div>

                <div style="display: flex; align-items: center; gap: 2rem; position: relative; z-index: 1;">
                    {{-- Iniciales dinámicas --}}
                    <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border: 3px solid #4ec7d2; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; text-transform: uppercase;">
                        {{ substr($estudiante->nombre1, 0, 1) }}{{ substr($estudiante->apellido1, 0, 1) }}
                    </div>

                    <div>
                        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;">
                            {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                        </h1>
                        <div style="display: flex; gap: 1.5rem; margin-top: 0.6rem; opacity: 0.9; font-size: 0.9rem;">
                            <span><i class="fas fa-id-card me-1"></i> DNI: <b>{{ $estudiante->dni }}</b></span>
                            <span><i class="fas fa-school me-1"></i> Grado: <b>{{ $estudiante->grado ?? 'N/A' }}</b></span>
                            <span><i class="fas fa-users me-1"></i> Sección: <b>{{ $estudiante->seccion ?? 'N/A' }}</b></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RESUMEN DE RENDIMIENTO --}}
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); background: #f8fafc; border-bottom: 1px solid #e8edf4;">
                <div style="padding: 1.5rem; text-align: center; border-right: 1px solid #e8edf4;">
                    <div style="font-size: 0.65rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Materias Registradas</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #00508f;">{{ $estudiante->calificaciones->count() }}</div>
                </div>
                <div style="padding: 1.5rem; text-align: center; border-right: 1px solid #e8edf4;">
                    <div style="font-size: 0.65rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Promedio General</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #00508f;">{{ number_format($promedio, 2) }}%</div>
                </div>
                <div style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 0.65rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Estado Académico</div>
                    <div>
                        <span style="display: inline-block; margin-top: 0.3rem; padding: 0.2rem 0.8rem; border-radius: 50px; background: {{ $promedio >= 60 ? '#dcfce7' : '#fee2e2' }}; color: {{ $promedio >= 60 ? '#166534' : '#991b1b' }}; font-weight: 800; font-size: 0.75rem;">
                            {{ $promedio >= 60 ? 'SATISFACTORIO' : 'EN RIESGO' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- CUERPO DEL HISTORIAL AGRUPADO POR AÑO --}}
            <div style="padding: 2rem;">
                <h3 style="color: #003b73; font-size: 1.1rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fas fa-list-check" style="color: #4ec7d2;"></i> DETALLE POR CICLO LECTIVO
                </h3>

                @forelse($historialAgrupado as $anio => $notas)
                    <div style="margin-bottom: 2rem; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                        <div style="background: #f1f5f9; padding: 0.8rem 1.2rem; font-weight: 800; color: #334155; font-size: 0.9rem; border-bottom: 1px solid #e2e8f0;">
                            <i class="fas fa-calendar-alt me-2"></i> CICLO: {{ $anio }}
                        </div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr style="text-align: left; background: #ffffff;">
                                <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Materia</th>
                                <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;">Parciales (1-2-3)</th>
                                <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;">Nota Final</th>
                                <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;">Resultado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notas as $nota)
                                <tr style="border-top: 1px solid #f1f5f9;">
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 700; color: #003b73; font-size: 0.85rem;">{{ $nota->materia->nombre }}</div>
                                        <small style="color: #94a3b8;">{{ $nota->periodo->nombre_periodo }}</small>
                                    </td>
                                    <td style="padding: 1rem; text-align: center; color: #64748b; font-size: 0.8rem;">
                                        {{ $nota->primer_parcial ?? '-' }} | {{ $nota->segundo_parcial ?? '-' }} | {{ $nota->tercer_parcial ?? '-' }}
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                            <span style="font-size: 1rem; font-weight: 800; color: {{ $nota->nota_final >= 60 ? '#00508f' : '#ef4444' }};">
                                                {{ number_format($nota->nota_final, 0) }}%
                                            </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        @if($nota->nota_final >= 60)
                                            <span style="color: #22c55e; background: #f0fdf4; padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.65rem; font-weight: 800; border: 1px solid #bcf0da;">
                                                    <i class="fas fa-check me-1"></i> APROBADO
                                                </span>
                                        @else
                                            <span style="color: #ef4444; background: #fef2f2; padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.65rem; font-weight: 800; border: 1px solid #fecaca;">
                                                    <i class="fas fa-times me-1"></i> REPROBADO
                                                </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div style="padding: 4rem; text-align: center;">
                        <i class="fas fa-folder-open" style="font-size: 3rem; color: #e2e8f0; margin-bottom: 1rem;"></i>
                        <p style="color: #94a3b8; font-weight: 600;">No hay historial académico disponible.</p>
                    </div>
                @endforelse
            </div>

            {{-- PIE DE PÁGINA DEL REPORTE --}}
            <div style="margin-top: 1rem; padding: 2rem; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: flex-end;">
                <div style="font-size: 0.7rem; color: #94a3b8; max-width: 300px;">
                    Este documento es un reporte oficial generado por el Sistema de Gestión de la Escuela Gabriela Mistral.
                    <br><br>
                    <b>Generado el:</b> {{ date('d/m/Y h:i A') }}
                </div>
                <div style="text-align: center; min-width: 200px;">
                    <div style="border-top: 1.5px solid #003b73; padding-top: 0.5rem; font-size: 0.75rem; font-weight: 800; color: #003b73; text-transform: uppercase;">
                        Sello Digital Institucional
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOTONES DE ACCIÓN PARA EL ADMINISTRADOR --}}
    @if(auth()->user()->id_rol == 1) {{-- Solo se muestra al Super Administrador --}}
    <div class="no-print" style="margin-top: 2rem; padding: 1.5rem; background: #fff4e5; border: 1px solid #ffe3bc; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h4 style="margin: 0; color: #854d0e; font-size: 0.9rem; font-weight: 800;">
                <i class="fas fa-user-shield me-2"></i> PANEL DE CONTROL ADMINISTRATIVO
            </h4>
            <p style="margin: 0.3rem 0 0 0; color: #a16207; font-size: 0.75rem;">
                Como Super Administrador, puedes modificar los registros de este historial.
            </p>
        </div>

        <div style="display: flex; gap: 1rem;">
            {{-- Botón Volver --}}
            <a href="{{ route('estudiantes.index') }}"
               style="text-decoration: none; background: #64748b; color: white; padding: 0.7rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-arrow-left"></i> VOLVER
            </a>

            {{-- Botón Editar --}}
            <a href="{{ route('superadmin.estudiantes.historial.edit', $estudiante->id) }}"
               style="text-decoration: none; background: #f59e0b; color: white; padding: 0.7rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                <i class="fas fa-edit"></i> EDITAR
            </a>
        </div>
    </div>
    @endif

    <style>
        @media print {
            .no-print, .navbar, .sidebar, .main-footer { display: none !important; }
            body { background: white !important; margin: 0; padding: 0; }
            div[style*="max-width: 1100px"] { max-width: 100% !important; margin: 0 !important; }
            .card { box-shadow: none !important; border: none !important; }
            @page { margin: 1.5cm; }
        }
    </style>
@endsection
