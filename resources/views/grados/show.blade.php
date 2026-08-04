@extends('layouts.app')

@section('title', 'Detalle de Grado')
@section('page-title', 'Detalle de Grado')

@push('styles')
<style>
:root {
    --c-primary: #00508f;
    --c-dark:    #003b73;
    --c-teal:    #4ec7d2;
    --c-border:  #e8edf4;
    --c-surface: #f5f8fc;
    --c-muted:   #6b7a90;
    --c-green:   #10b981;
    --c-amber:   #f59e0b;
    --c-red:     #ef4444;
    --r:         12px;
}

/* ── Layout ── */
.gd-wrap   { display: grid; grid-template-columns: 1fr 260px; gap: 1.25rem; }
.gd-main   { display: flex; flex-direction: column; gap: 1.25rem; }
.gd-aside  { display: flex; flex-direction: column; gap: 1rem; }

@media(max-width: 900px) {
    .gd-wrap  { grid-template-columns: 1fr; }
}

/* ── Header ── */
.gd-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, var(--c-primary) 60%, #0077b6 100%);
    padding: 1.75rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1rem;
    position: relative; overflow: hidden;
}
.gd-header::after {
    content: ''; position: absolute; right: -40px; top: -40px;
    width: 160px; height: 160px; border-radius: 50%;
    background: rgba(78,199,210,.12); pointer-events: none;
}
.gd-header-left { display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1; }
.gd-avatar {
    width: 64px; height: 64px; border-radius: 14px; flex-shrink: 0;
    background: rgba(255,255,255,.15); border: 2px solid rgba(78,199,210,.6);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; color: white;
}
.gd-header h2 { font-size: 1.3rem; font-weight: 800; color: white; margin: 0 0 .4rem; }
.gd-chip {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .65rem; border-radius: 999px; font-size: .7rem; font-weight: 700;
    background: rgba(255,255,255,.15); color: white;
    border: 1px solid rgba(255,255,255,.3); margin-right: .3rem;
}
.gd-header-actions { display: flex; gap: .5rem; flex-wrap: wrap; position: relative; z-index: 1; }
.gd-btn {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .42rem .9rem; border-radius: 8px;
    font-size: .78rem; font-weight: 700; text-decoration: none;
    transition: all .2s; white-space: nowrap; border: none; cursor: pointer;
}
.gd-btn:hover { opacity: .88; transform: translateY(-1px); color: white; text-decoration: none; }
.gd-btn-green  { background: linear-gradient(135deg, var(--c-green), #059669); color: white; }
.gd-btn-amber  { background: linear-gradient(135deg, var(--c-amber), #d97706); color: white; }
.gd-btn-ghost  { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.35) !important; color: white; }

/* ── Card genérica ── */
.gd-card {
    background: white; border: 1.5px solid var(--c-border);
    border-radius: var(--r); overflow: hidden;
}
.gd-card-head {
    padding: .8rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--c-border); background: var(--c-surface);
}
.gd-card-title {
    font-size: .78rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--c-primary);
    display: flex; align-items: center; gap: .4rem;
}
.gd-card-title i { color: var(--c-teal); }
.gd-card-body { padding: 1.1rem 1.25rem; }

/* ── Info boxes ── */
.gd-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
.gd-info-box {
    background: var(--c-surface); border: 1px solid var(--c-border);
    border-left: 3px solid var(--c-teal); border-radius: 9px; padding: .75rem 1rem;
}
.gd-info-box.accent { border-left-color: var(--c-primary); }
.gd-info-label { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--c-muted); margin-bottom: .3rem; }
.gd-info-val   { font-size: .9rem; font-weight: 700; color: var(--c-dark); display: flex; align-items: center; gap: .35rem; }
.gd-info-val i { color: var(--c-teal); font-size: .85rem; }

/* ── Tabla ── */
.gd-table { width: 100%; border-collapse: collapse; }
.gd-table thead th {
    font-size: .65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--c-muted); background: var(--c-surface);
    padding: .6rem .9rem; border-bottom: 1.5px solid var(--c-border);
    text-align: left; white-space: nowrap;
}
.gd-table tbody td {
    padding: .6rem .9rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: var(--c-dark); vertical-align: middle;
}
.gd-table tbody tr:last-child td { border-bottom: none; }
.gd-table tbody tr:hover td { background: #f0f7ff; }

.tag-code {
    font-family: 'Courier New', monospace; font-size: .72rem;
    background: rgba(78,199,210,.1); border: 1px solid rgba(78,199,210,.3);
    color: var(--c-primary); border-radius: 5px; padding: .12rem .45rem;
}
.tag-area {
    background: rgba(0,80,143,.08); color: var(--c-primary);
    border: 1px solid rgba(0,80,143,.15); border-radius: 999px;
    padding: .15rem .55rem; font-size: .68rem; font-weight: 600;
}
.tag-status {
    padding: .15rem .5rem; border-radius: 5px; font-size: .72rem; font-weight: 600;
}
.tag-activo   { background: #ecfdf5; color: #059669; }
.tag-inactivo { background: #fee2e2; color: #dc2626; }

/* ── Empty state ── */
.gd-empty { text-align: center; padding: 2.5rem 1rem; color: var(--c-muted); }
.gd-empty i { font-size: 2rem; display: block; margin-bottom: .5rem; color: rgba(78,199,210,.3); }
.gd-empty p { font-size: .83rem; font-weight: 600; margin: 0 0 .75rem; }

/* ── Aside stat rows ── */
.gd-stat {
    display: flex; align-items: center; justify-content: space-between;
    padding: .55rem .75rem; border-radius: 8px; margin-bottom: .45rem;
    background: var(--c-surface); border: 1px solid var(--c-border);
}
.gd-stat:last-child { margin-bottom: 0; }
.gd-stat-label { font-size: .75rem; color: var(--c-muted); display: flex; align-items: center; gap: .4rem; }
.gd-stat-label i { color: var(--c-teal); }
.gd-stat-val {
    font-size: .78rem; font-weight: 800; color: white;
    background: linear-gradient(135deg, var(--c-teal), var(--c-primary));
    padding: .18rem .55rem; border-radius: 999px;
}

/* ── Aside action buttons ── */
.gd-action {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    width: 100%; padding: .52rem; border-radius: 8px; margin-bottom: .45rem;
    font-size: .78rem; font-weight: 700; text-decoration: none;
    transition: all .18s; border: none; cursor: pointer;
}
.gd-action:last-child { margin-bottom: 0; }
.gd-action:hover { opacity: .88; transform: translateY(-1px); text-decoration: none; }
.gd-action-green   { background: linear-gradient(135deg, var(--c-green), #059669); color: white; }
.gd-action-amber   { background: linear-gradient(135deg, var(--c-amber), #d97706); color: white; }
.gd-action-teal    { background: white; color: var(--c-teal);  border: 1.5px solid var(--c-teal) !important; }
.gd-action-red     { background: white; color: var(--c-red);   border: 1.5px solid var(--c-red)  !important; }

/* ── Sys info ── */
.gd-sys-row { display: flex; justify-content: space-between; font-size: .75rem; margin-bottom: .35rem; }
.gd-sys-row span   { color: var(--c-muted); }
.gd-sys-row strong { color: var(--c-dark); }
</style>
@endpush

@section('content')

{{-- ── HEADER ── --}}
<div class="gd-header mb-0" style="margin-bottom:0;">
    <div class="gd-header-left">
        <div class="gd-avatar"><i class="fas fa-graduation-cap"></i></div>
        <div>
            <h2>
                {{ $grado->numero }}° Grado
                @if($grado->seccion) — Sección {{ $grado->seccion }} @endif
            </h2>
            <span class="gd-chip"><i class="fas fa-layer-group"></i> {{ ucfirst($grado->nivel) }}</span>
            <span class="gd-chip"><i class="fas fa-calendar"></i> {{ $grado->anio_lectivo }}</span>
            <span class="gd-chip"><i class="fas fa-book"></i> {{ $grado->materias->count() }} materias</span>
            <span class="gd-chip"><i class="fas fa-users"></i> {{ $estudiantes->count() }} estudiantes</span>
        </div>
    </div>
    <div class="gd-header-actions">
        <a href="{{ route('grados.asignar-materias', $grado) }}" class="gd-btn gd-btn-green">
            <i class="fas fa-tasks"></i> Gestionar Materias
        </a>
        <a href="{{ route('grados.edit', $grado) }}" class="gd-btn gd-btn-amber">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('grados.index') }}" class="gd-btn gd-btn-ghost">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

{{-- ── BODY ── --}}
<div style="background:white;border:1.5px solid var(--c-border);border-top:none;
            border-radius:0 0 12px 12px;padding:1.4rem 1.5rem;
            box-shadow:0 4px 16px rgba(0,59,115,.08);margin-bottom:1.25rem;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4"
             style="border-radius:9px;border-left:4px solid var(--c-green);font-size:.83rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="gd-wrap">

        {{-- ══ COLUMNA PRINCIPAL ══ --}}
        <div class="gd-main">

            {{-- Info del grado --}}
            <div class="gd-card">
                <div class="gd-card-head">
                    <div class="gd-card-title"><i class="fas fa-info-circle"></i> Información del Grado</div>
                </div>
                <div class="gd-card-body">
                    <div class="gd-info-grid">
                        <div class="gd-info-box">
                            <div class="gd-info-label">Nivel Educativo</div>
                            <div class="gd-info-val">
                                <i class="fas fa-{{ $grado->nivel === 'primaria' ? 'child' : 'user-graduate' }}"></i>
                                {{ ucfirst($grado->nivel) }}
                            </div>
                        </div>
                        <div class="gd-info-box accent">
                            <div class="gd-info-label">Año Lectivo</div>
                            <div class="gd-info-val"><i class="fas fa-calendar-alt"></i> {{ $grado->anio_lectivo }}</div>
                        </div>
                        <div class="gd-info-box">
                            <div class="gd-info-label">Sección</div>
                            <div class="gd-info-val"><i class="fas fa-door-open"></i> {{ $grado->seccion ?? '—' }}</div>
                        </div>
                        <div class="gd-info-box accent">
                            <div class="gd-info-label">Estado</div>
                            <div class="gd-info-val">
                                @if($grado->activo)
                                    <i class="fas fa-check-circle" style="color:var(--c-green);"></i>
                                    <span style="color:var(--c-green);">Activo</span>
                                @else
                                    <i class="fas fa-times-circle" style="color:var(--c-red);"></i>
                                    <span style="color:var(--c-red);">Inactivo</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Materias --}}
            <div class="gd-card">
                <div class="gd-card-head">
                    <div class="gd-card-title">
                        <i class="fas fa-book-open"></i>
                        Materias Asignadas
                        <span style="background:rgba(78,199,210,.12);color:var(--c-primary);
                                     padding:.1rem .5rem;border-radius:999px;font-size:.68rem;">
                            {{ $grado->materias->count() }}
                        </span>
                    </div>
                    <a href="{{ route('grados.asignar-materias', $grado) }}"
                       style="display:inline-flex;align-items:center;gap:.3rem;
                              background:linear-gradient(135deg,var(--c-green),#059669);
                              color:white;padding:.28rem .75rem;border-radius:7px;
                              font-size:.72rem;font-weight:700;text-decoration:none;">
                        <i class="fas fa-plus"></i> Gestionar
                    </a>
                </div>
                <div class="gd-card-body" style="padding:0;">
                    @if($grado->materias->isEmpty())
                        <div class="gd-empty">
                            <i class="fas fa-inbox"></i>
                            <p>No hay materias asignadas</p>
                            <a href="{{ route('grados.asignar-materias', $grado) }}"
                               style="display:inline-flex;align-items:center;gap:.3rem;
                                      background:linear-gradient(135deg,var(--c-teal),var(--c-primary));
                                      color:white;padding:.4rem 1rem;border-radius:7px;
                                      text-decoration:none;font-size:.78rem;font-weight:700;">
                                <i class="fas fa-plus"></i> Asignar Materias
                            </a>
                        </div>
                    @else
                        <table class="gd-table">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Código</th>
                                    <th>Área</th>
                                    <th>Profesor</th>
                                    <th>Hrs/sem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grado->materias as $materia)
                                <tr>
                                    <td style="font-weight:600;">{{ $materia->nombre }}</td>
                                    <td><span class="tag-code">{{ $materia->codigo }}</span></td>
                                    <td><span class="tag-area">{{ $materia->area ?? '—' }}</span></td>
                                    <td style="font-size:.78rem;">
                                        @if($materia->pivot->profesor_id)
                                            @php $prof = \App\Models\Profesor::find($materia->pivot->profesor_id); @endphp
                                            <i class="fas fa-user-tie" style="color:var(--c-teal);"></i>
                                            {{ $prof ? $prof->nombre . ' ' . $prof->apellido : '—' }}
                                        @else
                                            <span style="color:#94a3b8;font-size:.75rem;">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;font-weight:600;">
                                        {{ $materia->pivot->horas_semanales ?? '—' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            {{-- Estudiantes --}}
            <div class="gd-card">
                <div class="gd-card-head">
                    <div class="gd-card-title">
                        <i class="fas fa-user-graduate"></i>
                        Estudiantes
                        <span style="background:rgba(78,199,210,.12);color:var(--c-primary);
                                     padding:.1rem .5rem;border-radius:999px;font-size:.68rem;">
                            {{ $estudiantes->count() }}
                        </span>
                    </div>
                </div>
                <div class="gd-card-body" style="padding:0;">
                    @if($estudiantes->isEmpty())
                        <div class="gd-empty">
                            <i class="fas fa-inbox"></i>
                            <p>No hay estudiantes asignados a este grado</p>
                        </div>
                    @else
                        <table class="gd-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>DNI</th>
                                    <th>Sexo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $i => $est)
                                <tr>
                                    <td style="color:var(--c-muted);font-size:.75rem;">{{ $i + 1 }}</td>
                                    <td style="font-weight:600;">
                                        {{ $est->nombre1 }} {{ $est->nombre2 }}
                                        {{ $est->apellido1 }} {{ $est->apellido2 }}
                                    </td>
                                    <td><span class="tag-code">{{ $est->dni }}</span></td>
                                    <td style="font-size:.78rem;">{{ ucfirst($est->sexo ?? '—') }}</td>
                                    <td>
                                        <span class="tag-status {{ $est->estado === 'activo' ? 'tag-activo' : 'tag-inactivo' }}">
                                            {{ ucfirst($est->estado ?? '—') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>{{-- fin gd-main --}}

        {{-- ══ ASIDE ══ --}}
        <div class="gd-aside">

            {{-- Estadísticas --}}
            <div class="gd-card">
                <div class="gd-card-head">
                    <div class="gd-card-title"><i class="fas fa-chart-bar"></i> Estadísticas</div>
                </div>
                <div class="gd-card-body">
                    <div class="gd-stat">
                        <span class="gd-stat-label"><i class="fas fa-user-graduate"></i> Estudiantes</span>
                        <span class="gd-stat-val">{{ $estudiantes->count() }}</span>
                    </div>
                    <div class="gd-stat">
                        <span class="gd-stat-label"><i class="fas fa-book"></i> Materias</span>
                        <span class="gd-stat-val">{{ $grado->materias->count() }}</span>
                    </div>
                    <div class="gd-stat">
                        <span class="gd-stat-label"><i class="fas fa-chalkboard-teacher"></i> Con profesor</span>
                        <span class="gd-stat-val">
                            {{ $grado->materias->filter(fn($m) => $m->pivot->profesor_id)->count() }}
                        </span>
                    </div>
                    <div class="gd-stat">
                        <span class="gd-stat-label"><i class="fas fa-calendar"></i> Año</span>
                        <span class="gd-stat-val">{{ $grado->anio_lectivo }}</span>
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="gd-card">
                <div class="gd-card-head">
                    <div class="gd-card-title"><i class="fas fa-bolt"></i> Acciones Rápidas</div>
                </div>
                <div class="gd-card-body">
                    <a href="{{ route('grados.asignar-materias', $grado) }}" class="gd-action gd-action-green">
                        <i class="fas fa-tasks"></i> Gestionar Materias
                    </a>
                    <a href="{{ route('grados.edit', $grado) }}" class="gd-action gd-action-amber">
                        <i class="fas fa-edit"></i> Editar Grado
                    </a>
                    <a href="{{ route('horarios_grado.show', [$grado->id, 'matutina']) }}" class="gd-action gd-action-teal">
                        <i class="fas fa-calendar-alt"></i> Ver Horario
                    </a>
                    <form action="{{ route('grados.destroy', $grado) }}" method="POST"
                          onsubmit="return confirm('¿Está seguro de eliminar este grado?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="gd-action gd-action-red" style="width:100%;">
                            <i class="fas fa-trash"></i> Eliminar Grado
                        </button>
                    </form>
                </div>
            </div>

            {{-- Info sistema --}}
            <div class="gd-card">
                <div class="gd-card-head">
                    <div class="gd-card-title"><i class="fas fa-info-circle"></i> Sistema</div>
                </div>
                <div class="gd-card-body">
                    <div class="gd-sys-row">
                        <span>Creado</span>
                        <strong>{{ $grado->created_at->format('d/m/Y') }}</strong>
                    </div>
                    <div class="gd-sys-row">
                        <span>Actualizado</span>
                        <strong>{{ $grado->updated_at->format('d/m/Y') }}</strong>
                    </div>
                    <div class="gd-sys-row">
                        <span>ID</span>
                        <strong>#{{ $grado->id }}</strong>
                    </div>
                </div>
            </div>

        </div>{{-- fin gd-aside --}}

    </div>{{-- fin gd-wrap --}}

</div>

@endsection