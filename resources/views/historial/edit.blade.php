@extends('layouts.app')

@section('title', 'Editar Historial - ' . $estudiante->nombre1)

@section('content')
    <div style="width:100%; max-width: 1100px; margin: 0 auto;">

        {{-- BOTÓN VOLVER (Único botón de retorno) --}}
        <div class="no-print" style="margin-bottom: 1.5rem;">
            <a href="{{ route('superadmin.estudiantes.historial.show', $estudiante->id) }}" style="text-decoration: none; color: #00508f; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-chevron-left"></i> CANCELAR Y VOLVER AL HISTORIAL
            </a>
        </div>

        <form action="{{ route('superadmin.estudiantes.historial.update', $estudiante->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="background:white; border-radius:16px; box-shadow:0 10px 25px rgba(0,59,115,0.1); overflow:hidden; border:1px solid #e8edf4;">

                {{-- ENCABEZADO ESTILO DIPLOMA --}}
                <div style="background: linear-gradient(135deg, #854d0e 0%, #b45309 100%); padding: 2rem; color: white; position: relative;">
                    <div style="position: absolute; right: 10px; top: 10px; opacity: 0.2; font-size: 5rem;">
                        <i class="fas fa-user-edit"></i>
                    </div>

                    <div style="display: flex; align-items: center; gap: 2rem; position: relative; z-index: 1;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border: 2px solid #fbbf24; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800;">
                            {{ substr($estudiante->nombre1, 0, 1) }}{{ substr($estudiante->apellido1, 0, 1) }}
                        </div>
                        <div>
                            <h1 style="margin: 0; font-size: 1.5rem; font-weight: 800;">Modo Edición Académica</h1>
                            <p style="margin: 0; opacity: 0.9;">{{ $estudiante->nombre_completo }}</p>
                        </div>
                    </div>
                </div>

                <div style="padding: 2rem;">
                    <h3 style="color: #003b73; font-size: 1.1rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem;">
                        <i class="fas fa-edit" style="color: #f59e0b;"></i> ACTUALIZAR CALIFICACIONES POR PARCIAL
                    </h3>

                    @php
                        $notasAgrupadas = $estudiante->calificaciones->groupBy(fn($n) => $n->periodo->anio_lectivo ?? 'Ciclo Actual');
                    @endphp

                    @forelse($notasAgrupadas as $anio => $notas)
                        {{-- ... (Tu tabla de notas se mantiene igual) ... --}}
                        <div style="margin-bottom: 2rem; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                            <div style="background: #f8fafc; padding: 0.8rem 1.2rem; font-weight: 800; color: #334155; font-size: 0.9rem; border-bottom: 1px solid #e2e8f0;">
                                <i class="fas fa-calendar-check me-2"></i> CICLO LECTIVO: {{ $anio }}
                            </div>

                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                <tr style="text-align: left; background: #ffffff;">
                                    <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Materia</th>
                                    <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;">1er Parcial</th>
                                    <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;">2do Parcial</th>
                                    <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;">3er Parcial</th>
                                    <th style="padding: 1rem; color: #64748b; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;">Nota Final</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($notas as $nota)
                                    <tr style="border-top: 1px solid #f1f5f9;">
                                        <td style="padding: 1rem;">
                                            <div style="font-weight: 700; color: #003b73; font-size: 0.85rem;">{{ $nota->materia->nombre }}</div>
                                            <input type="hidden" name="notas[{{ $nota->id }}][id]" value="{{ $nota->id }}">
                                        </td>
                                        <td style="padding: 0.5rem; text-align: center;">
                                            <input type="number" name="notas[{{ $nota->id }}][p1]" value="{{ $nota->primer_parcial }}" min="0" max="100" class="form-input-nota">
                                        </td>
                                        <td style="padding: 0.5rem; text-align: center;">
                                            <input type="number" name="notas[{{ $nota->id }}][p2]" value="{{ $nota->segundo_parcial }}" min="0" max="100" class="form-input-nota">
                                        </td>
                                        <td style="padding: 0.5rem; text-align: center;">
                                            <input type="number" name="notas[{{ $nota->id }}][p3]" value="{{ $nota->tercer_parcial }}" min="0" max="100" class="form-input-nota">
                                        </td>
                                        <td style="padding: 0.5rem; text-align: center;">
                                            <div style="font-weight: 800; color: {{ $nota->nota_final >= 60 ? '#166534' : '#991b1b' }};">
                                                {{ number_format($nota->nota_final, 0) }}%
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <p>No hay materias para editar.</p>
                    @endforelse
                </div>

                {{-- PIE DE PÁGINA: SOLO BOTÓN DE GUARDAR --}}
                <div style="padding: 2rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
                    <button type="submit" style="background: #00508f; color: white; border: none; padding: 0.8rem 2.5rem; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 0.9rem; box-shadow: 0 4px 15px rgba(0,80,143,0.3); display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-save"></i> GUARDAR CALIFICACIONES
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Mismos estilos --}}
    <style>
        .form-input-nota {
            width: 60px;
            padding: 0.4rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            text-align: center;
            font-weight: 700;
            color: #334155;
        }
        .form-input-nota:focus {
            outline: none;
            border-color: #4ec7d2;
            box-shadow: 0 0 0 3px rgba(78,199,210,0.2);
        }
    </style>
@endsection
