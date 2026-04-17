@extends('layouts.app')

@section('title', 'Historial Académico — ' . $estudiante->nombre1)

@push('styles')
<style>
    /* Sin barra lateral para estudiantes */
    @if(!auth()->user() || !in_array(auth()->user()->id_rol, [1, 2]))
    .main-content  { margin-left: 0 !important; width: 100% !important; }
    .content-wrapper { padding: 1rem !important; }
    .sidebar       { display: none !important; }
    @endif

    /* ── Solo visible al imprimir ── */
    .print-only { display: none; }

    /* Impresión */
    @media print {
        @page { margin: 1.2cm 1.5cm; size: A4; }

        /* Ocultar elementos de pantalla */
        .no-print, .sidebar, .topbar, .btn-toggle-dark,
        .btn-logout, .hist-hero, .alert { display: none !important; }

        /* Layout limpio */
        .main-content  { margin-left: 0 !important; width: 100% !important; }
        .content-wrapper { padding: 0 !important; }
        body { background: white !important; font-size: 11pt !important; }

        /* Mostrar encabezado de impresión */
        .print-only { display: block !important; }

        /* Quitar sombras y bordes decorativos */
        .hist-card, .hist-stat, .hist-ciclo {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
        }

        /* Stats en fila horizontal */
        .hist-stats {
            display: flex !important;
            gap: 0 !important;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .hist-stat {
            flex: 1; border: none !important;
            border-right: 1px solid #ccc !important;
            border-radius: 0 !important;
            padding: 0.6rem 1rem !important;
        }
        .hist-stat:last-child { border-right: none !important; }
        .hist-stat-val { font-size: 1.4rem !important; }

        /* Tabla limpia para impresión */
        .hist-card-head {
            background: #003b73 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .hist-ciclo-head {
            background: #f1f5f9 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .hist-table th { font-size: 7.5pt !important; }
        .hist-table td { font-size: 9pt !important; padding: 0.45rem 0.75rem !important; }

        /* Evitar cortes en ciclos */
        .hist-ciclo { page-break-inside: avoid; }

        /* Firma al fondo */
        .print-firma { display: block !important; }
    }

    /* ── Layout general ── */
    .hist-wrap { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ── Encabezado hero ── */
    .hist-hero {
        background: linear-gradient(135deg, #002d5a 0%, #00508f 60%, #0077b6 100%);
        border-radius: 14px;
        padding: 2rem 2.5rem;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(0,59,115,.25);
    }
    .hist-hero::before {
        content: '\f19d'; /* fa-graduation-cap unicode */
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 2rem; top: 50%; transform: translateY(-50%);
        font-size: 7rem; color: rgba(255,255,255,.06); pointer-events: none;
    }
    .hist-hero-avatar {
        width: 80px; height: 80px; border-radius: 16px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 2.5px solid #4ec7d2;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.9rem; font-weight: 800; text-transform: uppercase; color: #fff;
    }
    .hist-hero-info h2 { margin: 0; font-size: 1.55rem; font-weight: 800; letter-spacing: -.3px; }
    .hist-hero-info .hero-meta {
        display: flex; flex-wrap: wrap; gap: 1.2rem;
        margin-top: .5rem; font-size: .82rem; opacity: .88;
    }
    .hist-hero-info .hero-meta span { display: flex; align-items: center; gap: .35rem; }
    .hist-hero-actions { display: flex; gap: .7rem; flex-wrap: wrap; z-index: 1; }
    .hist-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem 1.1rem; border-radius: 9px; font-size: .82rem;
        font-weight: 700; cursor: pointer; border: none; text-decoration: none;
        transition: opacity .15s, transform .1s;
    }
    .hist-btn:hover { opacity: .88; transform: translateY(-1px); }
    .hist-btn-back  { background: rgba(255,255,255,.15); color: #fff; border: 1.5px solid rgba(255,255,255,.3); }
    .hist-btn-print { background: #4ec7d2; color: #003b73; }
    .hist-btn-edit  { background: #f59e0b; color: #fff; }

    /* ── Tarjetas de resumen ── */
    .hist-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    @media(max-width:700px){ .hist-stats { grid-template-columns: 1fr; } }

    .hist-stat {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 1.25rem 1.5rem; text-align: center;
        box-shadow: 0 1px 4px rgba(0,59,115,.06);
    }
    .hist-stat-lbl {
        font-size: .65rem; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: .08em; margin-bottom: .35rem;
    }
    .hist-stat-val {
        font-size: 2rem; font-weight: 800; color: #00508f; line-height: 1;
    }

    /* ── Tabla de detalle ── */
    .hist-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
        overflow: hidden; box-shadow: 0 2px 8px rgba(0,59,115,.07);
    }
    .hist-card-head {
        background: linear-gradient(135deg, #003b73, #00508f);
        padding: 1rem 1.5rem;
        display: flex; align-items: center; gap: .6rem;
    }
    .hist-card-head i   { color: #4ec7d2; }
    .hist-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

    .hist-ciclo {
        border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;
        margin: 1.25rem; margin-bottom: 0;
    }
    .hist-ciclo:last-child { margin-bottom: 1.25rem; }
    .hist-ciclo-head {
        background: #f1f5f9; padding: .65rem 1.2rem;
        font-weight: 800; color: #334155; font-size: .82rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: .5rem;
    }

    .hist-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
    .hist-table thead tr { background: #fff; }
    .hist-table th {
        padding: .7rem 1rem; color: #64748b; font-size: .65rem;
        font-weight: 800; text-transform: uppercase; letter-spacing: .06em;
        border-bottom: 1px solid #f1f5f9;
    }
    .hist-table td { padding: .75rem 1rem; border-top: 1px solid #f8fafc; vertical-align: middle; }
    .hist-table tbody tr:hover { background: #f8fafc; }

    .nota-materia   { font-weight: 700; color: #003b73; font-size: .82rem; }
    .nota-periodo   { color: #94a3b8; font-size: .7rem; }
    .nota-parciales { color: #64748b; font-size: .75rem; text-align: center; }
    .nota-final     { font-weight: 800; font-size: .9rem; text-align: center; }
    .nota-aprobado  { color: #059669; }
    .nota-reprobado { color: #ef4444; }
    .nota-badge {
        display: inline-block; padding: .18rem .65rem; border-radius: 50px;
        font-weight: 800; font-size: .65rem; letter-spacing: .04em;
    }
    .badge-ok  { background: #dcfce7; color: #166534; }
    .badge-nok { background: #fee2e2; color: #991b1b; }

    /* ── Panel admin ── */
    .hist-admin-bar {
        background: #fff4e5; border: 1px solid #ffe3bc; border-radius: 12px;
        padding: 1.1rem 1.5rem;
        display: flex; justify-content: space-between; align-items: center; gap: 1rem;
        flex-wrap: wrap;
    }
    .hist-admin-bar h5 { margin: 0; color: #854d0e; font-size: .85rem; font-weight: 800; }
    .hist-admin-bar p  { margin: 0; color: #a16207; font-size: .75rem; }

    /* ── Pie ── */
    .hist-foot {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem 1.5rem; border-top: 1px dashed #cbd5e1;
        font-size: .7rem; color: #94a3b8;
    }
    .hist-foot strong { color: #003b73; }

    /* ── Vacío ── */
    .hist-empty {
        padding: 3rem; text-align: center; color: #94a3b8;
    }
    .hist-empty i { font-size: 2.5rem; margin-bottom: .75rem; display: block; }
</style>
@endpush

@section('content')
@php
    $isAdmin = auth()->user() && in_array(auth()->user()->id_rol, [1, 2]);
@endphp

<div class="hist-wrap">

    {{-- ══ ENCABEZADO SOLO IMPRESIÓN ══ --}}
    <div class="print-only" style="margin-bottom:1.25rem;">
        {{-- Cabecera institucional --}}
        <div style="display:flex; align-items:center; justify-content:space-between; border-bottom:3px solid #003b73; padding-bottom:0.75rem; margin-bottom:0.75rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:52px;height:52px;background:#003b73;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <span style="color:#4ec7d2;font-size:1.4rem;">🎓</span>
                </div>
                <div>
                    <div style="font-size:14pt;font-weight:800;color:#003b73;line-height:1.1;">Escuela Gabriela Mistral</div>
                    <div style="font-size:8pt;color:#00508f;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;">Historial Académico Oficial</div>
                </div>
            </div>
            <div style="text-align:right;font-size:8pt;color:#64748b;">
                <div>Fecha de emisión: <strong>{{ date('d/m/Y') }}</strong></div>
                <div>Documento de uso institucional</div>
            </div>
        </div>

        {{-- Datos del estudiante --}}
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #4ec7d2;border-radius:8px;padding:0.75rem 1.25rem;display:flex;gap:2.5rem;flex-wrap:wrap;">
            <div>
                <div style="font-size:7.5pt;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;">Estudiante</div>
                <div style="font-size:12pt;font-weight:800;color:#003b73;">{{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}</div>
            </div>
            <div>
                <div style="font-size:7.5pt;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;">DNI</div>
                <div style="font-size:11pt;font-weight:700;color:#003b73;">{{ $estudiante->dni }}</div>
            </div>
            <div>
                <div style="font-size:7.5pt;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;">Grado</div>
                <div style="font-size:11pt;font-weight:700;color:#003b73;">{{ $estudiante->grado ?? 'N/A' }}</div>
            </div>
            <div>
                <div style="font-size:7.5pt;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;">Sección</div>
                <div style="font-size:11pt;font-weight:700;color:#003b73;">{{ $estudiante->seccion ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    {{-- ══ Encabezado hero ══ --}}
    <div class="hist-hero no-print" style="padding-bottom:1.75rem;">
        <div style="display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;">
            <div class="hist-hero-avatar">
                {{ substr($estudiante->nombre1,0,1) }}{{ substr($estudiante->apellido1,0,1) }}
            </div>
            <div class="hist-hero-info">
                <h2>{{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}</h2>
                <div class="hero-meta">
                    <span><i class="fas fa-id-card"></i> DNI: <b>{{ $estudiante->dni }}</b></span>
                    <span><i class="fas fa-school"></i> Grado: <b>{{ $estudiante->grado ?? 'N/A' }}</b></span>
                    <span><i class="fas fa-users"></i> Sección: <b>{{ $estudiante->seccion ?? 'N/A' }}</b></span>
                </div>
            </div>
        </div>
        <div class="hist-hero-actions">
<button onclick="window.print();" class="hist-btn hist-btn-print">
                <i class="fas fa-print"></i> Imprimir
            </button>
            @if(auth()->user()->id_rol == 1)
            <a href="{{ route('superadmin.estudiantes.historial.edit', $estudiante->id) }}" class="hist-btn hist-btn-edit">
                <i class="fas fa-edit"></i> Editar Notas
            </a>
            @endif
        </div>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert" style="border-radius:10px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show no-print" role="alert" style="border-radius:10px;">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ══ Resumen de rendimiento ══ --}}
    <div class="hist-stats">
        <div class="hist-stat">
            <div class="hist-stat-lbl">Total de Registros</div>
            <div class="hist-stat-val">{{ $estudiante->calificaciones->count() }}</div>
        </div>
        <div class="hist-stat">
            <div class="hist-stat-lbl">Promedio General</div>
            <div class="hist-stat-val">{{ number_format($promedio, 1) }}<span style="font-size:1rem;color:#64748b;">%</span></div>
        </div>
        <div class="hist-stat">
            <div class="hist-stat-lbl">Estado Académico</div>
            <div class="hist-stat-val" style="font-size:1.2rem; padding-top:.3rem;">
                <span class="nota-badge {{ $promedio >= 60 ? 'badge-ok' : 'badge-nok' }}" style="font-size:.75rem;padding:.35rem 1rem;">
                    {{ $promedio >= 60 ? '✓ SATISFACTORIO' : '⚠ EN RIESGO' }}
                </span>
            </div>
        </div>
    </div>

    {{-- ══ Detalle por ciclo ══ --}}
    <div class="hist-card">
        <div class="hist-card-head">
            <i class="fas fa-list-check"></i>
            <span>Detalle por Ciclo Lectivo</span>
        </div>

        @forelse($historialAgrupado as $anio => $notas)
            <div class="hist-ciclo">
                <div class="hist-ciclo-head">
                    <i class="fas fa-calendar-alt" style="color:#4ec7d2;"></i>
                    Ciclo Lectivo: {{ $anio }}
                    <span style="margin-left:auto;font-weight:600;color:#64748b;font-size:.75rem;">
                        {{ $notas->count() }} {{ $notas->count() == 1 ? 'materia' : 'materias' }}
                    </span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="hist-table">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th style="text-align:center;">1er Parcial</th>
                                <th style="text-align:center;">2do Parcial</th>
                                <th style="text-align:center;">3er Parcial</th>
                                <th style="text-align:center;">Nota Final</th>
                                <th style="text-align:center;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notas as $nota)
                            <tr>
                                <td>
                                    <div class="nota-materia">{{ $nota->materia->nombre }}</div>
                                    <div class="nota-periodo">{{ $nota->periodo->nombre_periodo }}</div>
                                </td>
                                <td class="nota-parciales">{{ $nota->primer_parcial  ?? '—' }}</td>
                                <td class="nota-parciales">{{ $nota->segundo_parcial ?? '—' }}</td>
                                <td class="nota-parciales">{{ $nota->tercer_parcial  ?? '—' }}</td>
                                <td class="nota-final {{ $nota->nota_final >= 60 ? 'nota-aprobado' : 'nota-reprobado' }}">
                                    {{ number_format($nota->nota_final, 0) }}%
                                </td>
                                <td style="text-align:center;">
                                    <span class="nota-badge {{ $nota->nota_final >= 60 ? 'badge-ok' : 'badge-nok' }}">
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
            <div class="hist-empty">
                <i class="fas fa-folder-open"></i>
                <p>No hay historial académico disponible para este estudiante.</p>
            </div>
        @endforelse

        <div class="hist-foot">
            <span>Generado el: {{ date('d/m/Y h:i A') }}</span>
            <strong>Escuela Gabriela Mistral</strong>
        </div>
    </div>

    {{-- ══ ÁREA DE FIRMAS — solo impresión ══ --}}
    <div class="print-only print-firma" style="margin-top:2.5rem;page-break-inside:avoid;">
        <div style="display:flex;justify-content:space-around;gap:2rem;flex-wrap:wrap;">
            <div style="text-align:center;flex:1;min-width:160px;">
                <div style="border-top:1.5px solid #003b73;padding-top:0.5rem;margin-top:2.5rem;">
                    <div style="font-size:9pt;font-weight:700;color:#003b73;">Director(a)</div>
                    <div style="font-size:7.5pt;color:#64748b;">Escuela Gabriela Mistral</div>
                </div>
            </div>
            <div style="text-align:center;flex:1;min-width:160px;">
                <div style="border-top:1.5px solid #003b73;padding-top:0.5rem;margin-top:2.5rem;">
                    <div style="font-size:9pt;font-weight:700;color:#003b73;">Secretaria Académica</div>
                    <div style="font-size:7.5pt;color:#64748b;">Departamento de Registros</div>
                </div>
            </div>
            <div style="text-align:center;flex:1;min-width:160px;">
                <div style="border-top:1.5px solid #003b73;padding-top:0.5rem;margin-top:2.5rem;">
                    <div style="font-size:9pt;font-weight:700;color:#003b73;">Recibido por</div>
                    <div style="font-size:7.5pt;color:#64748b;">Padre / Tutor / Estudiante</div>
                </div>
            </div>
        </div>
        <div style="text-align:center;margin-top:1.5rem;font-size:7.5pt;color:#94a3b8;border-top:1px dashed #e2e8f0;padding-top:0.75rem;">
            Este documento es válido únicamente con sellos y firmas originales de la institución. — Escuela Gabriela Mistral · {{ date('Y') }}
        </div>
    </div>

</div>
@endsection
