@extends('layouts.app')

@section('title', 'Detalles del Estudiante')
@section('page-title', 'Información del Estudiante')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --cyan-light: #e8f8f9;
    --cyan-border:#b2e8ed;
    --surface:    #f8fafc;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --muted:      #64748b;
    --subtle:     #94a3b8;
    --success:    #10b981;
    --danger:     #ef4444;
}

* { box-sizing: border-box; }

body { font-family: 'Inter', sans-serif; }

.hijo-wrap {
    width: 100%;
    margin: 0;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ── Profile header ── */
.profile-header {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex-wrap: wrap;
    box-shadow: 0 4px 20px rgba(0,59,115,.2);
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    flex-shrink: 0;
    object-fit: cover;
    border: 3px solid var(--cyan);
    box-shadow: 0 4px 12px rgba(0,0,0,.2);
}

.profile-avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    flex-shrink: 0;
    background: rgba(255,255,255,.15);
    border: 3px solid var(--cyan);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
}

.profile-info {
    flex: 1;
    min-width: 250px;
}

.profile-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 .25rem;
}

.profile-meta {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    font-size: .875rem;
    color: rgba(255,255,255,.8);
}

.profile-meta-item {
    display: flex;
    align-items: center;
    gap: .35rem;
}

.profile-meta-item i {
    color: var(--cyan);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .4rem .9rem;
    border-radius: 999px;
    background: #fff;
    color: var(--blue-mid);
    font-size: .78rem;
    font-weight: 700;
}

.status-badge i {
    font-size: .4rem;
    color: var(--success);
}

/* ── Tabs Navigation ── */
.tabs-nav {
    display: flex;
    gap: .5rem;
    border-bottom: 2px solid var(--border);
    flex-wrap: wrap;
    background: #fff;
    padding: 0;
    border-radius: 12px 12px 0 0;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}

.tab-button {
    padding: 1rem 1.25rem;
    border: none;
    background: transparent;
    color: var(--muted);
    font-size: .875rem;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all .2s;
    white-space: nowrap;
}

.tab-button:hover {
    color: var(--blue-mid);
    background: var(--cyan-light);
}

.tab-button.active {
    color: var(--blue-dark);
    border-bottom-color: var(--cyan);
}

.tab-button i {
    margin-right: .4rem;
}

/* ── Tab Content ── */
.tabs-content {
    background: #fff;
    border-radius: 0 12px 12px 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}

.tab-pane {
    display: none;
    animation: fadeIn .3s ease-in;
}

.tab-pane.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* ── Card Styles ── */
.section-header {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    padding: 1rem 1.35rem;
    color: #fff;
    display: flex;
    align-items: center;
    gap: .6rem;
    font-weight: 700;
}

.section-header i {
    color: var(--cyan);
    font-size: 1.1rem;
}

.section-body {
    padding: 1.35rem;
}

/* ── Fields Grid ── */
.fields-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .75rem;
}

@media(max-width: 1200px) { .fields-grid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width: 900px) { .fields-grid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width: 600px) { .fields-grid { grid-template-columns: 1fr; } }

.field-box {
    background: var(--surface);
    border-radius: 8px;
    border-left: 3px solid var(--cyan);
    padding: .65rem .85rem;
}

.field-label {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--subtle);
    margin-bottom: .25rem;
}

.field-value {
    font-size: .875rem;
    font-weight: 600;
    color: var(--text);
}

.field-value.mono {
    font-family: monospace;
    color: var(--blue-mid);
}

.field-value.empty {
    color: var(--subtle);
    font-weight: 400;
    font-style: italic;
}

/* ── Calificaciones Table ── */
.calificaciones-container {
    overflow-x: auto;
}

.calificaciones-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
}

.calificaciones-table th {
    background: var(--surface);
    color: var(--blue-dark);
    padding: .8rem;
    text-align: left;
    font-weight: 700;
    border-bottom: 2px solid var(--cyan);
}

.calificaciones-table td {
    padding: .8rem;
    border-bottom: 1px solid var(--border);
}

.calificaciones-table tbody tr:hover {
    background: var(--cyan-light);
}

.nota-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    font-weight: 700;
    color: #fff;
}

.nota-badge.aprobado {
    background: linear-gradient(135deg, var(--success), #059669);
}

.nota-badge.reprobado {
    background: linear-gradient(135deg, var(--danger), #dc2626);
}

.nota-badge.sin-calificar {
    background: var(--subtle);
}

.promedio-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.promedio-card {
    background: var(--surface);
    border-radius: 10px;
    padding: 1rem;
    border: 1.5px solid var(--cyan-border);
    text-align: center;
}

.promedio-label {
    font-size: .75rem;
    font-weight: 700;
    color: var(--subtle);
    text-transform: uppercase;
    margin-bottom: .5rem;
}

.promedio-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--blue-dark);
}

.promedio-value.high {
    color: var(--success);
}

.promedio-value.low {
    color: var(--danger);
}

/* ── Horario Table ── */
.horario-tabla {
    width: 100%;
    border-collapse: collapse;
    font-size: .8rem;
}

.horario-tabla th,
.horario-tabla td {
    border: 1px solid var(--border);
    padding: .6rem;
    text-align: center;
}

.horario-tabla th {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    color: #fff;
    font-weight: 700;
}

.horario-tabla tr:nth-child(even) {
    background: var(--surface);
}

.horario-celda-llena {
    background: linear-gradient(135deg, rgba(78,199,210,.2), rgba(0,80,143,.1));
    font-weight: 600;
    color: var(--blue-dark);
}

.horario-empty {
    color: var(--subtle);
    font-style: italic;
}

/* ── Documentos Grid ── */
.docs-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: .75rem;
}

@media(max-width: 1200px) { .docs-grid { grid-template-columns: repeat(4, 1fr); } }
@media(max-width: 900px) { .docs-grid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width: 600px) { .docs-grid { grid-template-columns: 1fr 1fr; } }

.doc-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 1rem .75rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .55rem;
    transition: all .15s;
}

.doc-card:hover {
    border-color: var(--cyan-border);
    box-shadow: 0 4px 12px rgba(78,199,210,.15);
}

.doc-icon {
    width: 42px;
    height: 42px;
    border-radius: 9px;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: .9rem;
    box-shadow: 0 2px 8px rgba(78,199,210,.3);
}

.doc-name {
    font-size: .72rem;
    font-weight: 700;
    color: var(--blue-dark);
    line-height: 1.3;
    min-height: 28px;
}

.doc-btn {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    padding: .28rem .65rem;
    border-radius: 6px;
    font-size: .7rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: #fff;
    text-decoration: none;
    transition: opacity .15s;
}

.doc-btn:hover {
    opacity: .85;
    color: #fff;
}

.doc-empty {
    font-size: .7rem;
    color: var(--subtle);
    font-style: italic;
}

/* ── Sistema Timestamps ── */
.sistema-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: .9rem 1.35rem;
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}

.sistema-item {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .78rem;
    color: var(--muted);
}

.sistema-item i {
    color: var(--cyan);
}

.sistema-item strong {
    color: var(--blue-dark);
}

/* ── Empty State ── */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--subtle);
}

.empty-state i {
    font-size: 2.5rem;
    color: var(--cyan);
    margin-bottom: 1rem;
    opacity: .5;
}

.empty-state p {
    margin: .5rem 0;
    font-size: .875rem;
}
</style>
@endpush

@section('content')
<div class="hijo-wrap">

    {{-- ── Profile Header ── --}}
    <div class="profile-header">
        @if($estudiante->foto)
            <img src="{{ asset('storage/' . $estudiante->foto) }}"
                 class="profile-avatar" alt="Foto">
        @else
            <div class="profile-avatar-placeholder">
                {{ strtoupper(substr($estudiante->nombre1, 0, 1) . substr($estudiante->apellido1, 0, 1)) }}
            </div>
        @endif
        <div class="profile-info">
            <p class="profile-name">{{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}</p>
            <div class="profile-meta">
                <div class="profile-meta-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>{{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}</span>
                </div>
                <div class="profile-meta-item">
                    <i class="fas fa-id-card"></i>
                    <span>{{ $estudiante->dni }}</span>
                </div>
            </div>
        </div>
        <span class="status-badge">
            <i class="fas fa-circle"></i> Activo
        </span>
    </div>

    {{-- ── Tabs Navigation ── --}}
    <div class="tabs-nav">
        <button class="tab-button active" data-tab="info">
            <i class="fas fa-user"></i> Información Personal
        </button>
        <button class="tab-button" data-tab="calificaciones">
            <i class="fas fa-star"></i> Calificaciones
        </button>
        <button class="tab-button" data-tab="horario">
            <i class="fas fa-calendar-alt"></i> Horario
        </button>
        <button class="tab-button" data-tab="matricula">
            <i class="fas fa-file-alt"></i> Matrícula y Documentos
        </button>
    </div>

    {{-- ── Tab Content ── --}}
    <div class="tabs-content">

        {{-- TAB: Información Personal --}}
        <div id="info" class="tab-pane active">
            <div class="section-header">
                <i class="fas fa-user"></i> Datos Personales
            </div>
            <div class="section-body">
                <div class="fields-grid">
                    <div class="field-box">
                        <div class="field-label">Primer Nombre</div>
                        <div class="field-value">{{ $estudiante->nombre1 ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Segundo Nombre</div>
                        <div class="field-value {{ !$estudiante->nombre2 ? 'empty' : '' }}">{{ $estudiante->nombre2 ?: 'No registrado' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Primer Apellido</div>
                        <div class="field-value">{{ $estudiante->apellido1 ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Segundo Apellido</div>
                        <div class="field-value {{ !$estudiante->apellido2 ? 'empty' : '' }}">{{ $estudiante->apellido2 ?: 'No registrado' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">DNI</div>
                        <div class="field-value mono">{{ $estudiante->dni ?: '—' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Fecha de Nacimiento</div>
                        <div class="field-value">
                            {{ $estudiante->fecha_nacimiento
                                ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')
                                : 'No registrado' }}
                        </div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Sexo</div>
                        <div class="field-value {{ !$estudiante->sexo ? 'empty' : '' }}">{{ $estudiante->sexo ? ucfirst($estudiante->sexo) : 'No registrado' }}</div>
                    </div>
                    <div class="field-box">
                        <div class="field-label">Estado</div>
                        <div class="field-value">{{ ucfirst($estudiante->estado) }}</div>
                    </div>
                    @if($estudiante->email)
                    <div class="field-box">
                        <div class="field-label">Email</div>
                        <div class="field-value">{{ $estudiante->email }}</div>
                    </div>
                    @endif
                    @if($estudiante->telefono)
                    <div class="field-box">
                        <div class="field-label">Teléfono</div>
                        <div class="field-value">{{ $estudiante->telefono }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Matrícula Info --}}
            <div style="margin-top: 1rem;">
                <div class="section-header" style="background: var(--cyan-light); color: var(--blue-dark); border-bottom: 1.5px solid var(--cyan-border);">
                    <i class="fas fa-clipboard-check" style="color: var(--cyan);"></i> Datos de Matrícula
                </div>
                <div class="section-body">
                    <div class="fields-grid">
                        <div class="field-box">
                            <div class="field-label">Código de Matrícula</div>
                            <div class="field-value mono">{{ $matricula->codigo_matricula }}</div>
                        </div>
                        <div class="field-box">
                            <div class="field-label">Año Lectivo</div>
                            <div class="field-value">{{ $matricula->anio_lectivo }}</div>
                        </div>
                        <div class="field-box">
                            <div class="field-label">Fecha de Matrícula</div>
                            <div class="field-value">
                                {{ $matricula->fecha_matricula
                                    ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y')
                                    : '—' }}
                            </div>
                        </div>
                        <div class="field-box">
                            <div class="field-label">Fecha de Aprobación</div>
                            <div class="field-value">
                                {{ $matricula->fecha_confirmacion
                                    ? \Carbon\Carbon::parse($matricula->fecha_confirmacion)->format('d/m/Y')
                                    : '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: Calificaciones --}}
        <div id="calificaciones" class="tab-pane">
            <div class="section-header">
                <i class="fas fa-star"></i> Resumen de Calificaciones
            </div>
            <div class="section-body">
                @if($resumenMaterias->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <p><strong>Sin calificaciones registradas</strong></p>
                        <p style="font-size: .8rem;">Las calificaciones aparecerán aquí cuando sean registradas.</p>
                    </div>
                @else
                    <div class="calificaciones-container">
                        <table class="calificaciones-table">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th style="text-align: center;">Promedio</th>
                                    <th style="text-align: center;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resumenMaterias as $resumen)
                                <tr>
                                    <td>
                                        <strong>{{ $resumen['materia']->nombre ?? 'Sin nombre' }}</strong>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($resumen['promedio'] !== null)
                                            <span class="nota-badge {{ $resumen['aprobado'] ? 'aprobado' : 'reprobado' }}">
                                                {{ number_format($resumen['promedio'], 2) }}
                                            </span>
                                        @else
                                            <span class="nota-badge sin-calificar">—</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if($resumen['promedio'] === null)
                                            <span style="color: var(--subtle); font-size: .75rem;">Sin calificar</span>
                                        @elseif($resumen['aprobado'])
                                            <span style="color: var(--success); font-weight: 700; font-size: .75rem;">
                                                <i class="fas fa-check-circle"></i> Aprobado
                                            </span>
                                        @else
                                            <span style="color: var(--danger); font-weight: 700; font-size: .75rem;">
                                                <i class="fas fa-times-circle"></i> Reprobado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Promedio General --}}
                    @if($promedioGeneral !== null)
                    <div class="promedio-section">
                        <div class="promedio-card">
                            <div class="promedio-label">Promedio General</div>
                            <div class="promedio-value {{ $promedioGeneral >= 60 ? 'high' : 'low' }}">
                                {{ number_format($promedioGeneral, 2) }}
                            </div>
                            <div style="font-size: .75rem; color: var(--subtle); margin-top: .5rem;">
                                {{ $promedioGeneral >= 60 ? '✓ Desempeño satisfactorio' : '⚠ Necesita mejora' }}
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- TAB: Horario --}}
        <div id="horario" class="tab-pane">
            <div class="section-header">
                <i class="fas fa-calendar-alt"></i> Horario de Clases
            </div>
            <div class="section-body">
                @if(!$horarioGrado || !$horarioGrado->horario)
                    <div class="empty-state">
                        <i class="fas fa-clock"></i>
                        <p><strong>Horario no disponible</strong></p>
                        <p style="font-size: .8rem;">El horario para este grado aún no ha sido configurado.</p>
                    </div>
                @else
                    <div style="overflow-x: auto; margin-top: 1rem;">
                        <table class="horario-tabla">
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miércoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $horario = $horarioGrado->horario ?? [];
                                    // Extraer las horas únicas
                                    $horasSet = collect();
                                    foreach ($horario as $dia => $horas) {
                                        foreach ($horas as $hora => $celda) {
                                            $horasSet->push($hora);
                                        }
                                    }
                                    $horas = $horasSet->unique()->sort()->values();
                                @endphp
                                @foreach($horas as $hora)
                                <tr>
                                    <td style="font-weight: 700;">{{ $hora }}</td>
                                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $dia)
                                    <td>
                                        @if(isset($horario[$dia][$hora]) && !empty($horario[$dia][$hora]))
                                            @php
                                                $celda = $horario[$dia][$hora];
                                                $materia = $celda['materia'] ?? 'N/A';
                                                $profesor = $celda['profesor'] ?? 'N/A';
                                                $salon = $celda['salon'] ?? '';
                                            @endphp
                                            <div class="horario-celda-llena">
                                                <div style="font-size: .75rem; margin-bottom: .25rem;">{{ $materia }}</div>
                                                <div style="font-size: .65rem; color: var(--blue-mid); opacity: .8;">{{ $profesor }}</div>
                                                @if($salon)
                                                <div style="font-size: .65rem; color: var(--subtle);">{{ $salon }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="horario-empty">—</span>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- TAB: Matrícula y Documentos --}}
        <div id="matricula" class="tab-pane">
            <div class="section-header">
                <i class="fas fa-paperclip"></i> Documentos Adjuntos
            </div>
            <div class="section-body">
                <div class="docs-grid">
                    @php
                        $docs = [
                            ['campo' => 'foto_estudiante',      'icono' => 'fa-camera',     'label' => 'Foto Estudiante',   'accion' => 'Ver'],
                            ['campo' => 'acta_nacimiento',      'icono' => 'fa-file-alt',   'label' => 'Acta Nacimiento',   'accion' => 'Descargar'],
                            ['campo' => 'certificado_estudios', 'icono' => 'fa-certificate','label' => 'Certificado',       'accion' => 'Descargar'],
                            ['campo' => 'constancia_conducta',  'icono' => 'fa-award',      'label' => 'Constancia',        'accion' => 'Descargar'],
                            ['campo' => 'foto_dni_estudiante',  'icono' => 'fa-id-card',    'label' => 'DNI Estudiante',    'accion' => 'Ver'],
                            ['campo' => 'foto_dni_padre',       'icono' => 'fa-id-card-alt','label' => 'DNI Padre/Tutor',   'accion' => 'Ver'],
                        ];
                    @endphp
                    @foreach($docs as $doc)
                    <div class="doc-card">
                        <div class="doc-icon"><i class="fas {{ $doc['icono'] }}"></i></div>
                        <div class="doc-name">{{ $doc['label'] }}</div>
                        @if($matricula->{$doc['campo']})
                            <a href="{{ asset('storage/' . $matricula->{$doc['campo']}) }}" target="_blank" class="doc-btn">
                                <i class="fas fa-eye"></i> {{ $doc['accion'] }}
                            </a>
                        @else
                            <span class="doc-empty">No adjuntado</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- ── Sistema Timestamps ── --}}
    <div class="sistema-card">
        <div class="sistema-item">
            <i class="fas fa-calendar-plus"></i>
            <span><strong>Registrado:</strong> {{ $estudiante->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
        </div>
        <div class="sistema-item">
            <i class="fas fa-calendar-check"></i>
            <span><strong>Última actualización:</strong> {{ $estudiante->updated_at?->format('d/m/Y H:i') ?? '—' }}</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', function() {
        const tabName = this.getAttribute('data-tab');

        // Remove active class from all buttons and panes
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

        // Add active class to clicked button and corresponding pane
        this.classList.add('active');
        document.getElementById(tabName).classList.add('active');
    });
});
</script>
@endpush
