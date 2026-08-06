@extends('layouts.app')

@section('title', 'Detalle de Materia')
@section('page-title', 'Detalle de Materia')

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
.ms-wrap { width: 100%; box-sizing: border-box; }

/* HEADER */
.ms-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 1.7rem; position: relative; overflow: hidden;
}
.ms-header::before {
    content:''; position:absolute; right:-50px; top:-50px;
    width:200px; height:200px; border-radius:50%;
    background:rgba(78,199,210,.13); pointer-events:none;
}
.ms-header::after {
    content:''; position:absolute; right:100px; bottom:-45px;
    width:120px; height:120px; border-radius:50%;
    background:rgba(255,255,255,.05); pointer-events:none;
}
.ms-header-inner {
    position:relative; z-index:1;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:1rem;
}
.ms-header-left { display:flex; align-items:center; gap:1.4rem; flex-wrap:wrap; }
.ms-avatar {
    width:80px; height:80px; border-radius:18px;
    border:3px solid rgba(78,199,210,.7);
    background:rgba(255,255,255,.12);
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 6px 20px rgba(0,0,0,.25); flex-shrink:0;
}
.ms-avatar i { color:white; font-size:2rem; }
.ms-header h2 {
    font-size:1.45rem; font-weight:800; color:white;
    margin:0 0 .5rem; text-shadow:0 1px 4px rgba(0,0,0,.2);
}
.ms-badge {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.22rem .7rem; border-radius:999px; font-size:.72rem; font-weight:700;
    border:1px solid rgba(255,255,255,.35);
    background:rgba(255,255,255,.15); color:white; margin-right:.4rem;
}
.ms-header-actions { display:flex; gap:.5rem; flex-wrap:wrap; }
.ms-btn-hdr {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.45rem 1rem; border-radius:8px;
    font-size:.78rem; font-weight:700; text-decoration:none;
    transition:all .2s; white-space:nowrap; border:none; cursor:pointer;
}
.ms-btn-hdr:hover { opacity:.88; transform:translateY(-1px); color:white; text-decoration:none; }
.ms-btn-yellow { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; }
.ms-btn-white  { background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.35) !important; color:white; }

/* BODY */
.ms-body {
    background:white; border:1px solid var(--border); border-top:none;
    border-radius:0 0 var(--r) var(--r);
    box-shadow:0 4px 16px rgba(0,59,115,.10);
    padding:1.4rem 1.7rem; margin-bottom:1.3rem;
}

/* LAYOUT */
.ms-layout { display:grid; grid-template-columns:1fr 280px; gap:1.2rem; }

/* SEC TITLE */
.ms-sec {
    display:flex; align-items:center; gap:.5rem;
    font-size:.75rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.08em;
    color:var(--blue); margin-bottom:.95rem;
    padding-bottom:.55rem;
    border-bottom:2px solid rgba(78,199,210,.15);
}
.ms-sec i { color:var(--teal); }

/* HERO nombre */
.ms-hero {
    display:flex; align-items:center; gap:1rem;
    background:#f5f8fc; border:1px solid var(--border);
    border-radius:10px; padding:1rem 1.1rem; margin-bottom:1.1rem;
}
.ms-hero-icon {
    width:52px; height:52px; border-radius:12px; flex-shrink:0;
    background:linear-gradient(135deg,var(--teal),var(--blue));
    display:flex; align-items:center; justify-content:center;
}
.ms-hero-icon i { color:white; font-size:1.3rem; }
.ms-hero-title { font-size:1.2rem; font-weight:800; color:var(--blue-mid); margin:0 0 .2rem; }
.ms-hero-code  { font-size:.75rem; color:var(--muted); }
.ms-hero-code span {
    font-family:'Courier New',monospace; font-size:.75rem; font-weight:700;
    background:rgba(78,199,210,.12); color:var(--blue);
    border:1px solid rgba(78,199,210,.3);
    padding:.1rem .4rem; border-radius:4px;
}

/* INFO GRID */
.ms-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; margin-bottom:1.4rem; }
.ms-info-box {
    background:#f5f8fc; border:1px solid var(--border);
    border-left:3px solid var(--teal); border-radius:9px; padding:.8rem 1rem;
}
.ms-info-box.blue { border-left-color:var(--blue); }
.ms-info-box.full { grid-column:1/-1; }
.ms-info-label {
    font-size:.63rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.07em; color:var(--muted); margin-bottom:.35rem;
}
.ms-info-val { font-size:.9rem; font-weight:700; color:var(--blue-mid); }

/* PILLS */
.ms-pill {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.2rem .65rem; border-radius:999px;
    font-size:.72rem; font-weight:700;
}
.p-pri { background:#e0f7fa; color:#006064; }
.p-sec { background:#e8eaf6; color:#283593; }
.p-on  { background:#ecfdf5; color:#059669; }
.p-off { background:#fef2f2; color:#dc2626; }

/* TABLE */
.ms-table-wrap { overflow-x:auto; }
.ms-table { width:100%; border-collapse:collapse; }
.ms-table thead th {
    font-size:.63rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.07em; color:var(--muted); background:#f5f8fc;
    padding:.65rem .85rem; border:1px solid var(--border);
    text-align:left; white-space:nowrap;
}
.ms-table tbody tr { transition:background .15s; }
.ms-table tbody tr:hover td { background:#f0f7ff; }
.ms-table tbody td {
    border:1px solid var(--border); padding:.6rem .85rem;
    vertical-align:middle; font-size:.82rem; color:var(--blue-mid);
}
.ms-grado-tag {
    background:rgba(78,199,210,.12); color:var(--blue);
    border:1px solid rgba(78,199,210,.3);
    padding:.18rem .55rem; border-radius:6px;
    font-size:.75rem; font-weight:700; display:inline-block;
}
.ms-empty { text-align:center; padding:2.5rem 1rem; color:var(--muted); }
.ms-empty i { font-size:2rem; display:block; margin-bottom:.5rem; color:rgba(78,199,210,.3); }

/* SIDEBAR */
.ms-sidebar { display:flex; flex-direction:column; gap:1rem; }
.ms-side-card {
    background:white; border:1px solid var(--border); border-radius:12px; overflow:hidden;
}
.ms-side-header {
    padding:.75rem 1rem; font-size:.73rem; font-weight:700;
    color:var(--blue-mid); border-bottom:1px solid var(--border);
    display:flex; align-items:center; gap:.4rem; background:#f9fbfd;
}
.ms-side-header i { color:var(--teal); }
.ms-side-body { padding:.85rem 1rem; }

.ms-stat-row {
    display:flex; align-items:center; justify-content:space-between;
    padding:.55rem .7rem; border-radius:8px; margin-bottom:.5rem;
    background:#f5f8fc; border:1px solid var(--border);
}
.ms-stat-row:last-child { margin-bottom:0; }
.ms-stat-label { font-size:.75rem; color:var(--muted); display:flex; align-items:center; gap:.4rem; }
.ms-stat-label i { color:var(--teal); }
.ms-stat-val {
    font-size:.8rem; font-weight:800; color:white;
    background:linear-gradient(135deg,var(--teal),var(--blue));
    padding:.2rem .6rem; border-radius:999px;
}

.ms-action-btn {
    display:flex; align-items:center; justify-content:center; gap:.4rem;
    width:100%; padding:.55rem; border-radius:8px; margin-bottom:.5rem;
    font-size:.78rem; font-weight:700; text-decoration:none;
    transition:all .18s; border:none; cursor:pointer;
}
.ms-action-btn:last-child { margin-bottom:0; }
.ms-action-btn:hover { opacity:.88; transform:translateY(-1px); text-decoration:none; }
.ms-action-yellow       { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; }
.ms-action-outline-blue { background:white; color:var(--blue); border:2px solid var(--blue) !important; }
.ms-action-outline-red  { background:white; color:#ef4444; border:2px solid #ef4444 !important; }

.ms-sys-row {
    display:flex; justify-content:space-between; align-items:center;
    font-size:.75rem; margin-bottom:.4rem;
}
.ms-sys-row:last-child { margin-bottom:0; }
.ms-sys-row span { color:var(--muted); }
.ms-sys-row strong { color:var(--blue-mid); }

@media(max-width:900px) {
    .ms-layout { grid-template-columns:1fr; }
    .ms-sidebar { flex-direction:row; flex-wrap:wrap; }
    .ms-side-card { flex:1; min-width:240px; }
}
@media(max-width:600px) {
    .ms-info-grid { grid-template-columns:1fr; }
    .ms-header { padding:1.4rem 1.1rem; }
    .ms-body   { padding:1rem 1.1rem; }
    .ms-avatar { width:60px; height:60px; }
    .ms-avatar i { font-size:1.5rem; }
    .ms-header h2 { font-size:1.1rem; }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="ms-wrap">

    {{-- HEADER --}}
    <div class="ms-header">
        <div class="ms-header-inner">
            <div class="ms-header-left">
                <div class="ms-avatar">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <h2>{{ $materia->nombre }}</h2>
                    <span class="ms-badge">
                        <i class="fas fa-tag"></i>
                        <span style="font-family:'Courier New',monospace;">{{ $materia->codigo }}</span>
                    </span>
                    <span class="ms-badge"><i class="fas fa-layer-group"></i> {{ $materia->area }}</span>
                    <span class="ms-badge"><i class="fas fa-school"></i> {{ $materia->grados->count() }} grados</span>
                </div>
            </div>
            <div class="ms-header-actions">
                <a href="{{ route('materias.edit', $materia) }}" class="ms-btn-hdr ms-btn-yellow">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('materias.index') }}" class="ms-btn-hdr ms-btn-white">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div class="ms-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4"
                 style="border-radius:10px; border-left:4px solid #10b981; font-size:.83rem;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="ms-layout">

            {{-- COLUMNA PRINCIPAL --}}
            <div>

                <div class="ms-sec"><i class="fas fa-info-circle"></i> Información de la Materia</div>

                {{-- Hero --}}
                <div class="ms-hero">
                    <div class="ms-hero-icon"><i class="fas fa-book-open"></i></div>
                    <div>
                        <div class="ms-hero-title">{{ $materia->nombre }}</div>
                        <div class="ms-hero-code">Código: <span>{{ $materia->codigo }}</span></div>
                    </div>
                </div>

                {{-- Info grid --}}
                <div class="ms-info-grid">
                    <div class="ms-info-box">
                        <div class="ms-info-label">Área</div>
                        <div class="ms-info-val">{{ $materia->area }}</div>
                    </div>
                    <div class="ms-info-box blue">
                        <div class="ms-info-label">Nivel Educativo</div>
                        <div class="ms-info-val">
                            @if($materia->nivel === 'primaria')
                                <span class="ms-pill p-pri"><i class="fas fa-child"></i> Primaria (1° - 6°)</span>
                            @else
                                <span class="ms-pill p-sec"><i class="fas fa-user-graduate"></i> Secundaria (7° - 9°)</span>
                            @endif
                        </div>
                    </div>
                    <div class="ms-info-box">
                        <div class="ms-info-label">Estado</div>
                        <div class="ms-info-val">
                            @if($materia->activo)
                                <span class="ms-pill p-on"><i class="fas fa-check-circle"></i> Activa</span>
                            @else
                                <span class="ms-pill p-off"><i class="fas fa-times-circle"></i> Inactiva</span>
                            @endif
                        </div>
                    </div>
                    <div class="ms-info-box blue">
                        <div class="ms-info-label">Grados Asignados</div>
                        <div class="ms-info-val">
                            <i class="fas fa-school" style="color:var(--teal);"></i>
                            {{ $materia->grados->count() }} grado(s)
                        </div>
                    </div>
                    @if($materia->descripcion)
                    <div class="ms-info-box full">
                        <div class="ms-info-label">Descripción</div>
                        <div class="ms-info-val" style="font-weight:400;color:#334155;line-height:1.6;">
                            {{ $materia->descripcion }}
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Tabla grados --}}
                <div class="ms-sec">
                    <i class="fas fa-school"></i>
                    Grados donde se Imparte ({{ $materia->grados->count() }})
                </div>

                @if($materia->grados->count() > 0)
                    <div class="ms-table-wrap">
                        <table class="ms-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-layer-group" style="color:var(--teal);margin-right:.3rem;"></i>Grado</th>
                                    <th><i class="fas fa-graduation-cap" style="color:var(--teal);margin-right:.3rem;"></i>Nivel</th>
                                    <th><i class="fas fa-door-open" style="color:var(--teal);margin-right:.3rem;"></i>Sección</th>
                                    <th><i class="fas fa-calendar" style="color:var(--teal);margin-right:.3rem;"></i>Año Lectivo</th>
                                    <th><i class="fas fa-user-tie" style="color:var(--teal);margin-right:.3rem;"></i>Profesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materia->grados as $grado)
                                <tr>
                                    <td><span class="ms-grado-tag">{{ $grado->numero }}° Grado</span></td>
                                    <td>
                                        @if(strtolower($grado->nivel) === 'primaria')
                                            <span class="ms-pill p-pri">Primaria</span>
                                        @elseif(strtolower($grado->nivel) === 'básica' || strtolower($grado->nivel) === 'basica')
                                            <span class="ms-pill p-sec">Básica</span>
                                        @else
                                            <span class="ms-pill p-sec">Secundaria</span>
                                        @endif
                                    </td>
                                    <td style="font-weight:600;">{{ $grado->seccion ?? '—' }}</td>
                                    <td style="color:var(--muted);">{{ $grado->anio_lectivo }}</td>
                                    <td>
                                        @if($grado->pivot->profesor_id)
                                            @php $prof = \App\Models\Profesor::find($grado->pivot->profesor_id); @endphp
                                            @if($prof)
                                                <span style="font-size:.78rem;">
                                                    <i class="fas fa-user-tie" style="color:var(--teal);"></i>
                                                    {{ $prof->nombre }} {{ $prof->apellido }}
                                                </span>
                                            @else
                                                <span style="color:var(--muted);font-size:.75rem;">Sin asignar</span>
                                            @endif
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
                @else
                    <div class="ms-empty">
                        <i class="fas fa-school"></i>
                        <p style="font-weight:600;margin:.25rem 0;">Esta materia aún no está asignada a ningún grado</p>
                    </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="ms-sidebar">

                <div class="ms-side-card">
                    <div class="ms-side-header"><i class="fas fa-chart-bar"></i> Estadísticas</div>
                    <div class="ms-side-body">
                        <div class="ms-stat-row">
                            <span class="ms-stat-label"><i class="fas fa-school"></i> Grados asignados</span>
                            <span class="ms-stat-val">{{ $materia->grados->count() }}</span>
                        </div>
                        <div class="ms-stat-row">
                            <span class="ms-stat-label"><i class="fas fa-layer-group"></i> Nivel</span>
                            <span class="ms-stat-val">
                                {{ $materia->nivel === 'primaria' ? 'Primaria' : 'Secundaria' }}
                            </span>
                        </div>
                        <div class="ms-stat-row">
                            <span class="ms-stat-label"><i class="fas fa-toggle-on"></i> Estado</span>
                            @if($materia->activo)
                                <span class="ms-pill p-on" style="font-size:.7rem;">Activa</span>
                            @else
                                <span class="ms-pill p-off" style="font-size:.7rem;">Inactiva</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="ms-side-card">
                    <div class="ms-side-header"><i class="fas fa-bolt"></i> Acciones Rápidas</div>
                    <div class="ms-side-body">
                        <a href="{{ route('materias.edit', $materia) }}" class="ms-action-btn ms-action-yellow">
                            <i class="fas fa-edit"></i> Editar Materia
                        </a>
                        <a href="{{ route('grados.index') }}" class="ms-action-btn ms-action-outline-blue">
                            <i class="fas fa-layer-group"></i> Ver Grados
                        </a>
                        <button type="button" class="ms-action-btn ms-action-outline-red"
                                data-route="{{ route('materias.destroy', $materia) }}"
                                data-name="{{ $materia->nombre }}"
                                onclick="mostrarModalDeleteData(this)">
                            <i class="fas fa-trash"></i> Eliminar Materia
                        </button>
                    </div>
                </div>

                <div class="ms-side-card">
                    <div class="ms-side-header"><i class="fas fa-info-circle"></i> Información del Sistema</div>
                    <div class="ms-side-body">
                        <div class="ms-sys-row">
                            <span>ID</span>
                            <strong>#{{ $materia->id }}</strong>
                        </div>
                        <div class="ms-sys-row">
                            <span>Código</span>
                            <strong style="font-family:'Courier New',monospace;color:var(--blue);">{{ $materia->codigo }}</strong>
                        </div>
                        <div class="ms-sys-row">
                            <span>Creado</span>
                            <strong>{{ $materia->created_at->format('d/m/Y') }}</strong>
                        </div>
                        <div class="ms-sys-row">
                            <span>Actualizado</span>
                            <strong>{{ $materia->updated_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>

            </div>{{-- fin sidebar --}}

        </div>{{-- fin ms-layout --}}

    </div>{{-- fin ms-body --}}

</div>
</div>
@endsection
