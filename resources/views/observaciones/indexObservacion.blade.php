@extends('layouts.app')

@section('title', 'Observaciones Conductuales')
@section('page-title', 'Observaciones Conductuales')
@section('content-class', 'p-0')

@push('styles')
<style>
.obs-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.obs-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.obs-hero-left { display: flex; align-items: center; gap: 1rem; }
.obs-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.obs-hero-icon i { font-size: 1.3rem; color: white; }
.obs-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.obs-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.obs-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.obs-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.obs-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }
.obs-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.obs-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar */
.obs-toolbar {
    background: white; border-bottom: 1px solid #e2e8f0;
    padding: .75rem 1.5rem; flex-shrink: 0;
}
.obs-filter-row {
    display: flex; align-items: flex-end; gap: .6rem; flex-wrap: wrap;
}
.obs-field { display: flex; flex-direction: column; gap: .25rem; }
.obs-label {
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .04em; color: #64748b;
}
.obs-input, .obs-select {
    padding: .4rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #334155; background: white; transition: border-color .2s;
}
.obs-input:focus, .obs-select:focus { outline: none; border-color: #4ec7d2; }
.obs-input { min-width: 180px; }
.obs-btn-filter {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .4rem .9rem; border-radius: 8px;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; font-size: .82rem; font-weight: 600; cursor: pointer;
}
.obs-btn-clear {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .4rem .75rem; border-radius: 8px;
    border: 1.5px solid #e2e8f0; background: white;
    color: #64748b; font-size: .82rem; text-decoration: none;
}
.obs-btn-clear:hover { background: #f8fafc; color: #334155; }

/* Body */
.obs-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Table card */
.obs-table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
}
.obs-tbl thead th {
    background: #003b73; color: white; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem; border: none;
}
.obs-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.obs-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.obs-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .84rem; color: #334155; }
.obs-tbl tbody tr:last-child { border-bottom: none; }

/* Tipo badge */
.tipo-badge {
    display: inline-flex; align-items: center;
    border-radius: 999px; padding: .25rem .65rem;
    font-size: .72rem; font-weight: 700;
}

/* Action btns */
.btn-edit-sm {
    display: inline-flex; align-items: center;
    padding: .28rem .5rem; border-radius: 6px;
    background: rgba(78,199,210,.1); color: #00508f; border: 1px solid #4ec7d2;
    font-size: .75rem; text-decoration: none; transition: background .15s;
}
.btn-edit-sm:hover { background: rgba(78,199,210,.25); color: #00508f; }
.btn-del-sm {
    display: inline-flex; align-items: center;
    padding: .28rem .5rem; border-radius: 6px;
    background: rgba(239,68,68,.08); color: #dc2626; border: 1px solid #fca5a5;
    font-size: .75rem; cursor: pointer; transition: background .15s;
}
.btn-del-sm:hover { background: rgba(239,68,68,.18); }

/* Pagination footer */
.obs-footer {
    padding: .7rem 1rem; display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    border-top: 1px solid #f1f5f9; background: white;
}
.pagination { margin: 0; }
.pagination .page-link { border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0; color: #00508f; font-size: .8rem; padding: .3rem .65rem; transition: all .2s; }
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link { background: linear-gradient(135deg,#4ec7d2,#00508f); border-color: #4ec7d2; color: white; }

/* Dark mode */
body.dark-mode .obs-wrap  { background: #0f172a; }
body.dark-mode .obs-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .obs-input, body.dark-mode .obs-select { background: #0f172a; border-color: #334155; color: #cbd5e1; }
body.dark-mode .obs-table-card { background: #1e293b; }
body.dark-mode .obs-tbl tbody td { color: #cbd5e1; }
body.dark-mode .obs-tbl tbody tr { border-color: #334155; }
body.dark-mode .obs-footer { background: #1e293b; border-color: #334155; }
</style>
@endpush

@section('content')
<div class="obs-wrap">

    {{-- Hero --}}
    <div class="obs-hero">
        <div class="obs-hero-left">
            <div class="obs-hero-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h2 class="obs-hero-title">Observaciones Conductuales</h2>
                <p class="obs-hero-sub">Registro de observaciones académicas, conductuales y de salud</p>
            </div>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <div class="obs-stat">
                <div class="obs-stat-num">{{ $observaciones->total() }}</div>
                <div class="obs-stat-lbl">Total</div>
            </div>
            <a href="{{ route('observaciones.create') }}" class="obs-btn-new">
                <i class="fas fa-plus"></i> Nueva Observación
            </a>
        </div>
    </div>

    {{-- Toolbar / Filtros --}}
    <div class="obs-toolbar">
        <form method="GET" action="{{ route('observaciones.index') }}" class="obs-filter-row">
            <div class="obs-field">
                <label class="obs-label">Estudiante</label>
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute;left:9px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.75rem;"></i>
                    <input type="text" name="nombre" value="{{ $filtros['nombre'] ?? '' }}"
                           class="obs-input" placeholder="Buscar por nombre..."
                           style="padding-left:2rem;">
                </div>
            </div>
            <div class="obs-field">
                <label class="obs-label">Tipo</label>
                <select name="tipo" class="obs-select">
                    <option value="">Todos</option>
                    <option value="academica"  @selected(($filtros['tipo'] ?? '') === 'academica')>Académica</option>
                    <option value="conductual" @selected(($filtros['tipo'] ?? '') === 'conductual')>Conductual</option>
                    <option value="salud"      @selected(($filtros['tipo'] ?? '') === 'salud')>Salud</option>
                    <option value="otro"       @selected(($filtros['tipo'] ?? '') === 'otro')>Otro</option>
                </select>
            </div>
            <div class="obs-field">
                <label class="obs-label">Desde</label>
                <input type="date" name="fecha_desde" value="{{ $filtros['fecha_desde'] ?? '' }}" class="obs-input">
            </div>
            <div class="obs-field">
                <label class="obs-label">Hasta</label>
                <input type="date" name="fecha_hasta" value="{{ $filtros['fecha_hasta'] ?? '' }}" class="obs-input">
            </div>
            <button type="submit" class="obs-btn-filter">
                <i class="fas fa-filter"></i> Filtrar
            </button>
            <a href="{{ route('observaciones.index') }}" class="obs-btn-clear">
                <i class="fas fa-times"></i> Limpiar
            </a>
        </form>
    </div>

    {{-- Body --}}
    <div class="obs-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="obs-table-card">
            @if($observaciones->isEmpty())
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-clipboard fa-2x" style="display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                    <p style="font-size:.9rem;font-weight:600;color:#003b73;margin:0 0 .5rem;">No hay observaciones registradas</p>
                    <small>Comienza registrando la primera observación</small><br>
                    <a href="{{ route('observaciones.create') }}"
                       style="display:inline-flex;align-items:center;gap:.4rem;margin-top:.75rem;
                              background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
                              padding:.5rem 1.25rem;border-radius:8px;font-weight:700;
                              font-size:.85rem;text-decoration:none;">
                        <i class="fas fa-plus"></i> Nueva Observación
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table obs-tbl mb-0">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Profesor</th>
                                <th>Descripción</th>
                                <th style="text-align:center;">Tipo</th>
                                <th>Fecha</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($observaciones as $obs)
                            @php
                                $tipoConfig = match($obs->tipo) {
                                    'academica'  => ['label' => 'Académica',  'bg' => 'rgba(33,150,243,.12)',  'color' => '#0d47a1', 'border' => '#2196f3'],
                                    'conductual' => ['label' => 'Conductual', 'bg' => 'rgba(239,68,68,.12)',   'color' => '#991b1b', 'border' => '#ef4444'],
                                    'salud'      => ['label' => 'Salud',      'bg' => 'rgba(76,175,80,.12)',   'color' => '#2e7d32', 'border' => '#4caf50'],
                                    default      => ['label' => 'Otro',       'bg' => 'rgba(158,158,158,.12)', 'color' => '#424242', 'border' => '#9e9e9e'],
                                };
                            @endphp
                            <tr>
                                <td style="font-weight:700;color:#003b73;">
                                    {{ $obs->estudiante->nombreCompleto ?? '—' }}
                                </td>
                                <td style="color:#00508f;">{{ $obs->profesor->nombreCompleto ?? '—' }}</td>
                                <td style="max-width:260px;">{{ Str::limit($obs->descripcion, 80) }}</td>
                                <td style="text-align:center;">
                                    <span class="tipo-badge"
                                          style="background:{{ $tipoConfig['bg'] }};color:{{ $tipoConfig['color'] }};border:1px solid {{ $tipoConfig['border'] }};">
                                        {{ $tipoConfig['label'] }}
                                    </span>
                                </td>
                                <td style="color:#64748b;font-size:.82rem;">
                                    {{ $obs->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;justify-content:center;gap:.4rem;">
                                        <a href="{{ route('observaciones.edit', $obs) }}" class="btn-edit-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn-del-sm" title="Eliminar"
                                                onclick="mostrarModalDelete(
                                                    '{{ route('observaciones.destroy', $obs) }}',
                                                    '¿Eliminar esta observación? Esta acción no se puede deshacer.',
                                                    '{{ Str::limit($obs->descripcion, 40) }}'
                                                )">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($observaciones->hasPages())
                    <div class="obs-footer">
                        <small style="color:#94a3b8;">
                            Mostrando {{ $observaciones->firstItem() }}–{{ $observaciones->lastItem() }}
                            de {{ $observaciones->total() }} registros
                        </small>
                        {{ $observaciones->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>{{-- /obs-body --}}
</div>
@endsection
