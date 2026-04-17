@extends('layouts.app')

@section('title', 'Detalle de Grado')
@section('page-title', 'Detalle de Grado')

@push('styles')
<style>
:root {
    --blue:     #00508f;
    --blue-mid: #003b73;
    --teal:     #4ec7d2;
    --border:   #e8edf4;
    --muted:    #6b7a90;
    --r:        14px;
}
.gs-wrap { width: 100%; box-sizing: border-box; }

/* HEADER */
.gs-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 1.7rem; position: relative; overflow: hidden;
}
.gs-header::before {
    content:''; position:absolute; right:-50px; top:-50px;
    width:200px; height:200px; border-radius:50%;
    background:rgba(78,199,210,.13); pointer-events:none;
}
.gs-header::after {
    content:''; position:absolute; right:100px; bottom:-45px;
    width:120px; height:120px; border-radius:50%;
    background:rgba(255,255,255,.05); pointer-events:none;
}
.gs-header-inner {
    position:relative; z-index:1;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:1rem;
}
.gs-header-left { display:flex; align-items:center; gap:1.4rem; flex-wrap:wrap; }
.gs-avatar {
    width:80px; height:80px; border-radius:18px;
    border:3px solid rgba(78,199,210,.7);
    background:rgba(255,255,255,.12);
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 6px 20px rgba(0,0,0,.25); flex-shrink:0;
}
.gs-avatar i { color:white; font-size:2rem; }
.gs-header h2 {
    font-size:1.45rem; font-weight:800; color:white;
    margin:0 0 .5rem; text-shadow:0 1px 4px rgba(0,0,0,.2);
}
.gs-badge {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.22rem .7rem; border-radius:999px; font-size:.72rem; font-weight:700;
    border:1px solid rgba(255,255,255,.35);
    background:rgba(255,255,255,.15); color:white; margin-right:.4rem;
}
.gs-header-actions { display:flex; gap:.5rem; flex-wrap:wrap; }
.gs-btn-hdr {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.45rem 1rem; border-radius:8px;
    font-size:.78rem; font-weight:700; text-decoration:none;
    transition:all .2s; white-space:nowrap; border:none; cursor:pointer;
}
.gs-btn-hdr:hover { opacity:.88; transform:translateY(-1px); color:white; text-decoration:none; }
.gs-btn-green  { background:linear-gradient(135deg,#10b981,#059669); color:white; }
.gs-btn-yellow { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; }
.gs-btn-white  { background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.35) !important; color:white; }

/* BODY */
.gs-body {
    background:white; border:1px solid var(--border); border-top:none;
    border-radius:0 0 var(--r) var(--r);
    box-shadow:0 4px 16px rgba(0,59,115,.10);
    padding:1.4rem 1.7rem; margin-bottom:1.3rem;
}

/* LAYOUT */
.gs-layout { display:grid; grid-template-columns:1fr 280px; gap:1.2rem; }

/* SEC TITLE */
.gs-sec {
    display:flex; align-items:center; gap:.5rem;
    font-size:.75rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.08em;
    color:var(--blue); margin-bottom:.95rem;
    padding-bottom:.55rem;
    border-bottom:2px solid rgba(78,199,210,.15);
}
.gs-sec i { color:var(--teal); }

/* INFO GRID */
.gs-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; margin-bottom:1.4rem; }
.gs-info-box {
    background:#f5f8fc; border:1px solid var(--border);
    border-left:3px solid var(--teal); border-radius:9px; padding:.8rem 1rem;
}
.gs-info-box.blue { border-left-color:var(--blue); }
.gs-info-label {
    font-size:.63rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.07em; color:var(--muted); margin-bottom:.35rem;
}
.gs-info-val { font-size:.9rem; font-weight:700; color:var(--blue-mid); }

.gs-grado-titulo {
    font-size:1.6rem; font-weight:800; color:var(--blue-mid);
    margin-bottom:1rem; display:flex; align-items:center; gap:.6rem;
}
.gs-grado-titulo i { color:var(--teal); font-size:1.3rem; }
.gs-grado-titulo span { color:var(--teal); }

/* TABLE */
.gs-table-wrap { overflow-x:auto; }
.gs-table { width:100%; border-collapse:collapse; }
.gs-table thead th {
    font-size:.63rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.07em; color:var(--muted); background:#f5f8fc;
    padding:.65rem .85rem; border:1px solid var(--border);
    text-align:left; white-space:nowrap;
}
.gs-table tbody tr { transition:background .15s; }
.gs-table tbody tr:hover td { background:#f0f7ff; }
.gs-table tbody td {
    border:1px solid var(--border); padding:.6rem .85rem;
    vertical-align:middle; font-size:.82rem; color:var(--blue-mid);
}
.gs-codigo {
    font-family:'Courier New',monospace; font-size:.72rem;
    background:rgba(78,199,210,.1); border:1px solid rgba(78,199,210,.3);
    color:var(--blue); border-radius:5px; padding:.15rem .45rem; display:inline-block;
}
.gs-area-tag {
    background:rgba(0,80,143,.08); color:var(--blue);
    border:1px solid rgba(0,80,143,.15); border-radius:999px;
    padding:.18rem .6rem; font-size:.68rem; font-weight:600; display:inline-block;
}
.gs-empty-table { text-align:center; padding:2.5rem 1rem; color:var(--muted); }
.gs-empty-table i { font-size:2rem; display:block; margin-bottom:.5rem; color:rgba(78,199,210,.3); }

/* SIDEBAR */
.gs-sidebar { display:flex; flex-direction:column; gap:1rem; }
.gs-side-card {
    background:white; border:1px solid var(--border); border-radius:12px; overflow:hidden;
}
.gs-side-header {
    padding:.75rem 1rem; font-size:.73rem; font-weight:700;
    color:var(--blue-mid); border-bottom:1px solid var(--border);
    display:flex; align-items:center; gap:.4rem; background:#f9fbfd;
}
.gs-side-header i { color:var(--teal); }
.gs-side-body { padding:.85rem 1rem; }

.gs-stat-row {
    display:flex; align-items:center; justify-content:space-between;
    padding:.55rem .7rem; border-radius:8px; margin-bottom:.5rem;
    background:#f5f8fc; border:1px solid var(--border);
}
.gs-stat-row:last-child { margin-bottom:0; }
.gs-stat-label { font-size:.75rem; color:var(--muted); display:flex; align-items:center; gap:.4rem; }
.gs-stat-label i { color:var(--teal); }
.gs-stat-val {
    font-size:.8rem; font-weight:800; color:white;
    background:linear-gradient(135deg,var(--teal),var(--blue));
    padding:.2rem .6rem; border-radius:999px;
}

.gs-action-btn {
    display:flex; align-items:center; justify-content:center; gap:.4rem;
    width:100%; padding:.55rem; border-radius:8px; margin-bottom:.5rem;
    font-size:.78rem; font-weight:700; text-decoration:none;
    transition:all .18s; border:none; cursor:pointer;
}
.gs-action-btn:last-child { margin-bottom:0; }
.gs-action-btn:hover { opacity:.88; transform:translateY(-1px); text-decoration:none; }
.gs-action-green        { background:linear-gradient(135deg,#10b981,#059669); color:white; }
.gs-action-yellow       { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; }
.gs-action-outline-teal { background:white; color:var(--teal); border:2px solid var(--teal) !important; }
.gs-action-outline-red  { background:white; color:#ef4444; border:2px solid #ef4444 !important; }

.gs-sys-row {
    display:flex; justify-content:space-between; align-items:center;
    font-size:.75rem; margin-bottom:.4rem;
}
.gs-sys-row:last-child { margin-bottom:0; }
.gs-sys-row span { color:var(--muted); }
.gs-sys-row strong { color:var(--blue-mid); }

@media(max-width:900px) {
    .gs-layout { grid-template-columns:1fr; }
    .gs-sidebar { flex-direction:row; flex-wrap:wrap; }
    .gs-side-card { flex:1; min-width:240px; }
}
@media(max-width:600px) {
    .gs-info-grid { grid-template-columns:1fr; }
    .gs-header { padding:1.4rem 1.1rem; }
    .gs-body   { padding:1rem 1.1rem; }
    .gs-avatar { width:60px; height:60px; }
    .gs-avatar i { font-size:1.5rem; }
    .gs-header h2 { font-size:1.1rem; }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="gs-wrap">

    {{-- HEADER --}}
    <div class="gs-header">
        <div class="gs-header-inner">
            <div class="gs-header-left">
                <div class="gs-avatar">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h2>{{ $grado->nombre_completo }}</h2>
                    <span class="gs-badge"><i class="fas fa-layer-group"></i> {{ $grado->nivel }}</span>
                    <span class="gs-badge"><i class="fas fa-calendar"></i> {{ $grado->anio_lectivo }}</span>
                    <span class="gs-badge"><i class="fas fa-book"></i> {{ $grado->materias->count() }} materias</span>
                </div>
            </div>
            <div class="gs-header-actions">
                <a href="{{ route('grados.asignar-materias', $grado) }}" class="gs-btn-hdr gs-btn-green">
                    <i class="fas fa-tasks"></i> Gestionar Materias
                </a>
                <a href="{{ route('grados.edit', $grado) }}" class="gs-btn-hdr gs-btn-yellow">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('grados.index') }}" class="gs-btn-hdr gs-btn-white">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div class="gs-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4"
                 style="border-radius:10px; border-left:4px solid #10b981; font-size:.83rem;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="gs-layout">

            {{-- COLUMNA PRINCIPAL --}}
            <div>

                <div class="gs-sec"><i class="fas fa-info-circle"></i> Información del Grado</div>

                <div class="gs-grado-titulo">
                    <i class="fas fa-school"></i>
                    {{ $grado->nombre }}
                    @if($grado->seccion)<span>— Sección {{ $grado->seccion }}</span>@endif
                </div>

                <div class="gs-info-grid">
                    <div class="gs-info-box">
                        <div class="gs-info-label">Nivel Educativo</div>
                        <div class="gs-info-val">
                            @php $n = strtolower($grado->nivel); @endphp
                            @if($n === 'primaria')
                                <i class="fas fa-child" style="color:var(--teal);"></i> Primaria (1° - 6°)
                            @elseif($n === 'básica' || $n === 'basica')
                                <i class="fas fa-book" style="color:var(--teal);"></i> Básica (7° - 9°)
                            @else
                                <i class="fas fa-user-graduate" style="color:var(--teal);"></i> Secundaria
                            @endif
                        </div>
                    </div>
                    <div class="gs-info-box blue">
                        <div class="gs-info-label">Año Lectivo</div>
                        <div class="gs-info-val">
                            <i class="fas fa-calendar-alt" style="color:var(--teal);"></i> {{ $grado->anio_lectivo }}
                        </div>
                    </div>
                    <div class="gs-info-box">
                        <div class="gs-info-label">Estado</div>
                        <div class="gs-info-val">
                            @if($grado->activo)
                                <span style="color:#059669;"><i class="fas fa-check-circle"></i> Activo</span>
                            @else
                                <span style="color:#ef4444;"><i class="fas fa-times-circle"></i> Inactivo</span>
                            @endif
                        </div>
                    </div>
                    <div class="gs-info-box blue">
                        <div class="gs-info-label">Materias Asignadas</div>
                        <div class="gs-info-val">
                            <i class="fas fa-book-open" style="color:var(--teal);"></i>
                            {{ $grado->materias->count() }} materias
                        </div>
                    </div>
                </div>

                {{-- Tabla de materias --}}
                <div class="gs-sec">
                    <i class="fas fa-book-open"></i>
                    Materias Asignadas ({{ $grado->materias->count() }})
                    <a href="{{ route('grados.asignar-materias', $grado) }}"
                       style="margin-left:auto;display:inline-flex;align-items:center;gap:.3rem;
                              background:linear-gradient(135deg,#10b981,#059669);color:white;
                              padding:.25rem .7rem;border-radius:6px;font-size:.68rem;
                              font-weight:700;text-decoration:none;">
                        <i class="fas fa-plus"></i> Gestionar
                    </a>
                </div>

                @if($grado->materias->isEmpty())
                    <div class="gs-empty-table">
                        <i class="fas fa-inbox"></i>
                        <p style="font-weight:600;margin:.25rem 0;">No hay materias asignadas</p>
                        <a href="{{ route('grados.asignar-materias', $grado) }}"
                           style="display:inline-flex;align-items:center;gap:.3rem;margin-top:.5rem;
                                  background:linear-gradient(135deg,var(--teal),var(--blue));color:white;
                                  padding:.4rem 1rem;border-radius:7px;text-decoration:none;
                                  font-size:.78rem;font-weight:700;">
                            <i class="fas fa-plus"></i> Asignar Materias
                        </a>
                    </div>
                @else
                    <div class="gs-table-wrap">
                        <table class="gs-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-book" style="color:var(--teal);margin-right:.3rem;"></i>Materia</th>
                                    <th><i class="fas fa-tag" style="color:var(--teal);margin-right:.3rem;"></i>Código</th>
                                    <th><i class="fas fa-layer-group" style="color:var(--teal);margin-right:.3rem;"></i>Área</th>
                                    <th><i class="fas fa-user-tie" style="color:var(--teal);margin-right:.3rem;"></i>Profesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grado->materias as $materia)
                                <tr>
                                    <td style="font-weight:700;">{{ $materia->nombre }}</td>
                                    <td><span class="gs-codigo">{{ $materia->codigo }}</span></td>
                                    <td><span class="gs-area-tag">{{ $materia->area }}</span></td>
                                    <td>
                                        @if($materia->pivot->profesor_id)
                                            @php
                                                $prof = \App\Models\Profesor::find($materia->pivot->profesor_id);
                                            @endphp
                                            <span style="font-size:.78rem;">
                                                <i class="fas fa-user-tie" style="color:var(--teal);"></i>
                                                {{ $prof ? $prof->nombre . ' ' . $prof->apellido : 'No encontrado' }}
                                            </span>
                                        @else
                                            <span style="color:var(--muted);font-size:.75rem;">
                                                <i class="fas fa-user-times"></i> Sin asignar
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            {{-- Tabla de estudiantes --}}
            <div class="gs-sec" style="margin-top:1.5rem;">
                <i class="fas fa-user-graduate"></i>
                Estudiantes ({{ $estudiantes->count() }})
            </div>

            @if($estudiantes->isEmpty())
                <div class="gs-empty-table">
                    <i class="fas fa-inbox"></i>
                    <p style="font-weight:600;margin:.25rem 0;">No hay estudiantes asignados a este grado</p>
                </div>
            @else
                <div class="gs-table-wrap">
                    <table class="gs-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><i class="fas fa-user" style="color:var(--teal);margin-right:.3rem;"></i>Nombre</th>
                                <th><i class="fas fa-id-card" style="color:var(--teal);margin-right:.3rem;"></i>DNI</th>
                                <th><i class="fas fa-venus-mars" style="color:var(--teal);margin-right:.3rem;"></i>Sexo</th>
                                <th><i class="fas fa-circle" style="color:var(--teal);margin-right:.3rem;font-size:.6rem;"></i>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $i => $est)
                            <tr>
                                <td class="text-muted" style="font-size:.75rem;">{{ $i + 1 }}</td>
                                <td style="font-weight:600;">{{ $est->nombre_completo }}</td>
                                <td><span class="gs-codigo">{{ $est->dni }}</span></td>
                                <td style="font-size:.78rem;">{{ ucfirst($est->sexo ?? '—') }}</td>
                                <td>
                                    @if($est->estado === 'activo')
                                        <span style="background:#ecfdf5;color:#059669;padding:.15rem .5rem;border-radius:5px;font-size:.72rem;font-weight:600;">Activo</span>
                                    @else
                                        <span style="background:#fee2e2;color:#dc2626;padding:.15rem .5rem;border-radius:5px;font-size:.72rem;font-weight:600;">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="gs-sidebar">

                <div class="gs-side-card">
                    <div class="gs-side-header"><i class="fas fa-chart-bar"></i> Estadísticas</div>
                    <div class="gs-side-body">
                        <div class="gs-stat-row">
                            <span class="gs-stat-label"><i class="fas fa-user-graduate"></i> Estudiantes</span>
                            <span class="gs-stat-val">{{ $estudiantes->count() }}</span>
                        </div>
                        <div class="gs-stat-row">
                            <span class="gs-stat-label"><i class="fas fa-book"></i> Total materias</span>
                            <span class="gs-stat-val">{{ $grado->materias->count() }}</span>
                        </div>
                        <div class="gs-stat-row">
                            <span class="gs-stat-label"><i class="fas fa-chalkboard-teacher"></i> Con profesor</span>
                            <span class="gs-stat-val">
                                {{ $grado->materias->filter(fn($m) => $m->pivot->profesor_id)->count() }}
                            </span>
                        </div>
                        <div class="gs-stat-row">
                            <span class="gs-stat-label"><i class="fas fa-calendar"></i> Año lectivo</span>
                            <span class="gs-stat-val">{{ $grado->anio_lectivo }}</span>
                        </div>
                    </div>
                </div>

                <div class="gs-side-card">
                    <div class="gs-side-header"><i class="fas fa-bolt"></i> Acciones Rápidas</div>
                    <div class="gs-side-body">
                        <a href="{{ route('grados.asignar-materias', $grado) }}" class="gs-action-btn gs-action-green">
                            <i class="fas fa-tasks"></i> Gestionar Materias
                        </a>
                        <a href="{{ route('grados.edit', $grado) }}" class="gs-action-btn gs-action-yellow">
                            <i class="fas fa-edit"></i> Editar Grado
                        </a>
                        <a href="{{ route('materias.index') }}" class="gs-action-btn gs-action-outline-teal">
                            <i class="fas fa-book"></i> Ver Materias
                        </a>
                        <form action="{{ route('grados.destroy', $grado) }}" method="POST"
                              data-confirm="¿Está seguro de eliminar este grado?">
                            @csrf @method('DELETE')
                            <button type="submit" class="gs-action-btn gs-action-outline-red">
                                <i class="fas fa-trash"></i> Eliminar Grado
                            </button>
                        </form>
                    </div>
                </div>

                <div class="gs-side-card">
                    <div class="gs-side-header"><i class="fas fa-info-circle"></i> Información del Sistema</div>
                    <div class="gs-side-body">
                        <div class="gs-sys-row">
                            <span>Creado:</span>
                            <strong>{{ $grado->created_at->format('d/m/Y') }}</strong>
                        </div>
                        <div class="gs-sys-row">
                            <span>Actualizado:</span>
                            <strong>{{ $grado->updated_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>

            </div>{{-- fin sidebar --}}

        </div>{{-- fin gs-layout --}}

    </div>{{-- fin gs-body --}}

</div>
</div>
@endsection
