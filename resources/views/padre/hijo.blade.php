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
}

.hijo-wrap {
    font-family: 'Inter', sans-serif;
    max-width: 900px;
    margin: 0 auto;
    display: flex; flex-direction: column; gap: 1.25rem;
}

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px;
    font-size: .82rem; font-weight: 600;
    background: #fff; color: var(--blue-mid);
    border: 1.5px solid var(--cyan); text-decoration: none;
    transition: background .15s;
}
.adm-btn-outline:hover { background: var(--cyan-light); color: var(--blue-dark); }

/* ── Profile header ── */
.profile-header {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    border-radius: 12px;
    padding: 1.5rem;
    display: flex; align-items: center; gap: 1.25rem;
    flex-wrap: wrap;
    box-shadow: 0 4px 20px rgba(0,59,115,.2);
}
.profile-avatar {
    width: 72px; height: 72px; border-radius: 12px; flex-shrink: 0;
    object-fit: cover; border: 3px solid var(--cyan);
    box-shadow: 0 4px 12px rgba(0,0,0,.2);
}
.profile-avatar-placeholder {
    width: 72px; height: 72px; border-radius: 12px; flex-shrink: 0;
    background: rgba(255,255,255,.15); border: 3px solid var(--cyan);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem; font-weight: 800; color: #fff;
}
.profile-name { font-size: 1.2rem; font-weight: 700; color: #fff; margin: 0 0 .25rem; }
.profile-sub  { font-size: .82rem; color: rgba(255,255,255,.7); margin: 0; }
.bpill { display: inline-flex; align-items: center; gap: .25rem; padding: .3rem .8rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.b-active { background: #fff; color: var(--blue-mid); border: 2px solid var(--cyan); }

/* ── Cards ── */
.sm-card { background: #fff; border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.05); overflow: hidden; }
.sm-card-header { display: flex; align-items: center; gap: .6rem; padding: .95rem 1.35rem; background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid)); font-size: .82rem; font-weight: 700; color: #fff; }
.sm-card-header i { color: var(--cyan); }
.sm-card-body { padding: 1.35rem; }

/* ── Fields grid ── */
.fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
@media(max-width:600px) { .fields-grid { grid-template-columns: 1fr; } }

.field-box { background: var(--surface); border-radius: 8px; border-left: 3px solid var(--cyan); padding: .65rem .85rem; }
.field-label { font-size: .67rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: var(--subtle); margin-bottom: .2rem; }
.field-value { font-size: .875rem; font-weight: 600; color: var(--text); }
.field-value.mono { font-family: monospace; color: var(--blue-mid); }
.field-value.empty { color: var(--subtle); font-weight: 400; font-style: italic; }

/* ── Documentos ── */
.docs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; }
@media(max-width:600px) { .docs-grid { grid-template-columns: 1fr 1fr; } }

.doc-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: 10px; padding: 1.1rem .75rem; text-align: center; display: flex; flex-direction: column; align-items: center; gap: .55rem; transition: border-color .15s, box-shadow .15s; }
.doc-card:hover { border-color: var(--cyan-border); box-shadow: 0 4px 12px rgba(78,199,210,.15); }
.doc-icon { width: 42px; height: 42px; border-radius: 9px; background: linear-gradient(135deg, var(--cyan), var(--blue-mid)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: .9rem; box-shadow: 0 2px 8px rgba(78,199,210,.3); }
.doc-name { font-size: .72rem; font-weight: 700; color: var(--blue-dark); line-height: 1.3; min-height: 28px; display: flex; align-items: center; justify-content: center; }
.doc-btn { display: inline-flex; align-items: center; gap: .25rem; padding: .28rem .65rem; border-radius: 6px; font-size: .7rem; font-weight: 700; background: linear-gradient(135deg, var(--cyan), var(--blue-mid)); color: #fff; text-decoration: none; transition: opacity .15s; }
.doc-btn:hover { opacity: .85; color: #fff; }
.doc-empty { font-size: .7rem; color: var(--subtle); font-style: italic; }

/* ── Matrícula info ── */
.mat-header { background: var(--cyan-light); border-bottom: 1.5px solid var(--cyan-border); padding: .85rem 1.35rem; display: flex; align-items: center; gap: .5rem; font-size: .82rem; font-weight: 700; color: var(--blue-dark); }
.mat-header i { color: var(--cyan); }

/* ── Datos sistema ── */
.sistema-card { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: .9rem 1.35rem; display: flex; gap: 1.5rem; flex-wrap: wrap; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
.sistema-item { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--muted); }
.sistema-item i { color: var(--cyan); }
.sistema-item strong { color: var(--blue-dark); }
</style>
@endpush

@section('content')
<div class="hijo-wrap">

    {{-- ── Profile header ── --}}
    <div class="profile-header">
        @if($estudiante->foto)
            <img src="{{ asset('storage/' . $estudiante->foto) }}"
                 class="profile-avatar" alt="Foto">
        @else
            <div class="profile-avatar-placeholder">
                {{ strtoupper(substr($estudiante->nombre1, 0, 1) . substr($estudiante->apellido1, 0, 1)) }}
            </div>
        @endif
        <div style="flex:1;">
            <p class="profile-name">{{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}</p>
            <p class="profile-sub">
                <i class="fas fa-graduation-cap" style="margin-right:.3rem;"></i>
                {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
            </p>
        </div>
        <span class="bpill b-active">
            <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
        </span>
    </div>

    {{-- ── Información Personal ── --}}
    <div class="sm-card">
        <div class="sm-card-header">
            <i class="fas fa-user"></i> Información Personal
        </div>
        <div class="sm-card-body">
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
            </div>
        </div>
    </div>

    {{-- ── Información Académica ── --}}
    <div class="sm-card">
        <div class="sm-card-header">
            <i class="fas fa-graduation-cap"></i> Información Académica
        </div>
        <div class="sm-card-body">
            <div class="fields-grid">
                <div class="field-box">
                    <div class="field-label">Grado</div>
                    <div class="field-value">{{ $estudiante->grado }}</div>
                </div>
                <div class="field-box">
                    <div class="field-label">Sección</div>
                    <div class="field-value">{{ $estudiante->seccion }}</div>
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
    </div>

    {{-- ── Datos de la Matrícula ── --}}
    <div class="sm-card">
        <div class="mat-header">
            <i class="fas fa-clipboard-check"></i> Datos de la Matrícula
        </div>
        <div class="sm-card-body">
            <div class="fields-grid">
                <div class="field-box">
                    <div class="field-label">Código</div>
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

    {{-- ── Documentos ── --}}
    <div class="sm-card">
        <div class="sm-card-header">
            <i class="fas fa-paperclip"></i> Documentos Adjuntos
        </div>
        <div class="sm-card-body">
            <div class="docs-grid">
                @php
                    $docs = [
                        ['campo' => 'foto_estudiante',     'icono' => 'fa-camera',    'label' => 'Foto Estudiante',   'accion' => 'Ver'],
                        ['campo' => 'acta_nacimiento',     'icono' => 'fa-file-alt',  'label' => 'Acta Nacimiento',   'accion' => 'Descargar'],
                        ['campo' => 'certificado_estudios','icono' => 'fa-certificate','label' => 'Certificado',      'accion' => 'Descargar'],
                        ['campo' => 'constancia_conducta', 'icono' => 'fa-award',     'label' => 'Constancia',        'accion' => 'Descargar'],
                        ['campo' => 'foto_dni_estudiante', 'icono' => 'fa-id-card',   'label' => 'DNI Estudiante',    'accion' => 'Ver'],
                        ['campo' => 'foto_dni_padre',      'icono' => 'fa-id-card-alt','label' => 'DNI Padre/Tutor',  'accion' => 'Ver'],
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

    {{-- ── Datos del sistema ── --}}
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