@extends('layouts.app')

@section('title', 'Permisos de Padres')
@section('page-title', 'Gestión de Permisos de Padres')

@section('topbar-actions')
    <a href="{{ route('admin.dashboard') }}" class="adm-btn-outline">
        <i class="fas fa-arrow-left"></i> Volver al Dashboard
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.adm-wrap { font-family: 'Inter', sans-serif; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #00508f; border: 1.5px solid #4ec7d2;
    text-decoration: none; transition: background .15s;
}
.adm-btn-outline:hover { background: #e8f8f9; }
.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none; transition: opacity .15s;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* Stats */
.adm-stats {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:768px){ .adm-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .adm-stats { grid-template-columns: 1fr; } }

.adm-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.adm-stat-icon i { font-size: 1.15rem; color: #fff; }
.adm-stat-lbl { font-size: .72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.adm-stat-num { font-size: 1.75rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* Toolbar */
.adm-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .85rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-search-inner { position: relative; flex: 1; max-width: 360px; min-width: 200px; }
.adm-search-inner i {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .78rem; pointer-events: none;
}
.adm-search-inner input {
    width: 100%; padding: .38rem .75rem .38rem 2rem;
    border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .82rem; color: #0f172a; background: #f8fafc; outline: none;
}
.adm-search-inner input:focus { border-color: #4ec7d2; background: #fff; }
.btn-search {
    padding: .38rem .85rem; border-radius: 7px; font-size: .78rem; font-weight: 600;
    border: 1.5px solid #4ec7d2; color: #00508f; background: #fff; cursor: pointer;
    transition: background .15s; display: inline-flex; align-items: center; gap: .3rem;
}
.btn-search:hover { background: #e8f8f9; }
.btn-clear {
    padding: .38rem .75rem; border-radius: 7px; font-size: .78rem;
    border: 1.5px solid #fca5a5; color: #ef4444; background: #fff;
    cursor: pointer; text-decoration: none; transition: background .15s;
    display: inline-flex; align-items: center; gap: .3rem;
}
.btn-clear:hover { background: #fef2f2; }

/* Card / tabla */
.adm-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
}
.adm-card-head-left { display: flex; align-items: center; gap: .6rem; }
.adm-card-head i { color: #4ec7d2; font-size: 1rem; }
.adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.adm-card-head-info { color: rgba(255,255,255,.6); font-size: .78rem; }

.adm-tbl { width: 100%; border-collapse: collapse; }
.adm-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.adm-tbl thead th.tc { text-align: center; }
.adm-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.adm-tbl tbody td.tc { text-align: center; }
.adm-tbl tbody tr:last-child td { border-bottom: none; }
.adm-tbl tbody tr:hover { background: #fafbfc; }

/* Avatar */
.adm-av {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .88rem;
}
.adm-name  { font-weight: 600; color: #0f172a; font-size: .84rem; }
.adm-sub   { font-size: .73rem; color: #64748b; }

/* Badges / pills */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-green  { background: #ecfdf5; color: #059669; }
.b-gray   { background: #f1f5f9; color: #64748b; }
.b-blue   { background: #e8f8f9; color: #00508f; border: 1px solid rgba(78,199,210,.35); }
.b-indigo { background: #eef2ff; color: #4f46e5; }

/* Acción */
.act-btn {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; font-weight: 600;
    text-decoration: none; transition: all .15s;
}
.act-config {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; box-shadow: 0 2px 6px rgba(78,199,210,.3);
}
.act-config:hover { opacity: .88; color: #fff; transform: translateY(-1px); }

/* Empty */
.adm-empty { padding: 3.5rem 1rem; text-align: center; }
.adm-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
.adm-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

/* Footer paginación */
.adm-footer {
    padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa; flex-wrap: wrap; gap: .5rem;
}
.adm-pages { font-size: .78rem; color: #94a3b8; }
.pagination { margin: 0; gap: 3px; display: flex; }
.pagination .page-link {
    border-radius: 7px; padding: .3rem .65rem;
    font-size: .78rem; font-weight: 500;
    border: 1px solid #e2e8f0; color: #00508f; transition: all .15s; line-height: 1.4;
}
.pagination .page-link:hover { background: #e8f8f9; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: #fff;
}
.pagination .page-item.disabled .page-link { opacity: .45; }

/* Info bar */
.adm-info-bar {
    background: rgba(78,199,210,.07); border: 1px solid rgba(78,199,210,.3);
    border-radius: 10px; padding: .65rem 1rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: .5rem;
    font-size: .8rem; color: #00508f;
}
</style>
@endpush

@section('content')
<div class="adm-wrap">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4"
         style="border-radius:10px;border:none;background:#ecfdf5;color:#059669;font-size:.85rem;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4"
         style="border-radius:10px;border-left:4px solid #ef4444;font-size:.85rem;">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="adm-stats">
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Total Padres</div>
                <div class="adm-stat-num">{{ $padres->total() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Activos</div>
                <div class="adm-stat-num">{{ $padres->getCollection()->where('estado','activo')->count() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#818cf8,#4f46e5);">
                <i class="fas fa-child"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Total Hijos</div>
                <div class="adm-stat-num">{{ $padres->getCollection()->sum(fn($p) => $p->estudiantes->count()) }}</div>
            </div>
        </div>
    </div>

    {{-- Info --}}
    <div class="adm-info-bar">
        <i class="fas fa-info-circle"></i>
        <span><strong>Instrucciones:</strong> Selecciona un padre/tutor para configurar los permisos de acceso a la información de sus hijos.</span>
    </div>

    {{-- Toolbar / Buscador --}}
    <form action="{{ route('admins.permisos.index') }}" method="GET">
        <div class="adm-toolbar">
            <div class="adm-search-inner">
                <i class="fas fa-search"></i>
                <input type="text" name="buscar"
                       value="{{ request('buscar') }}"
                       placeholder="Buscar por nombre, DNI o email...">
            </div>
            <button type="submit" class="btn-search">
                <i class="fas fa-search"></i> Buscar
            </button>
            @if(request('buscar'))
                <a href="{{ route('admins.permisos.index') }}" class="btn-clear">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            @endif
        </div>
    </form>

    {{-- Resultado búsqueda --}}
    @if(request('buscar'))
    <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:.5rem 1rem;margin-bottom:1rem;font-size:.8rem;color:#0369a1;display:flex;align-items:center;gap:.5rem;">
        <i class="fas fa-filter"></i>
        @if($padres->total() > 0)
            Mostrando <strong>{{ $padres->total() }}</strong> resultado(s) para:
            <span style="background:rgba(78,199,210,.2);color:#00508f;border:1px solid #4ec7d2;border-radius:999px;padding:.1rem .5rem;font-weight:600;">{{ request('buscar') }}</span>
        @else
            <span style="color:#dc2626;"><i class="fas fa-exclamation-circle me-1"></i>Sin resultados para: <strong>"{{ request('buscar') }}"</strong></span>
        @endif
    </div>
    @endif

    {{-- Tabla --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <div class="adm-card-head-left">
                <i class="fas fa-user-lock"></i>
                <span>Padres / Tutores</span>
            </div>
            <span class="adm-card-head-info">{{ $padres->total() }} registros</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="adm-tbl">
                <thead>
                    <tr>
                        <th class="tc">#</th>
                        <th>Padre / Tutor</th>
                        <th>DNI</th>
                        <th class="tc">Parentesco</th>
                        <th>Contacto</th>
                        <th class="tc">Hijos</th>
                        <th class="tc">Estado</th>
                        <th class="tc">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($padres as $index => $padre)
                    <tr>
                        <td class="tc">
                            <span style="width:26px;height:26px;border-radius:7px;background:#f1f5f9;border:1px solid #e2e8f0;display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;color:#64748b;">
                                {{ $padres->firstItem() + $index }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="adm-av">
                                    {{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($padre->apellido ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="adm-name">{{ $padre->nombre ?? 'N/A' }} {{ $padre->apellido ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($padre->dni)
                                <i class="fas fa-id-card" style="color:#94a3b8;font-size:.7rem;margin-right:.3rem;"></i>
                                {{ $padre->dni }}
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            <span class="bpill b-blue">{{ $padre->parentesco_formateado }}</span>
                        </td>
                        <td>
                            <div class="adm-sub">
                                <i class="fas fa-envelope" style="width:12px;color:#94a3b8;"></i>
                                {{ $padre->correo ?? '—' }}
                            </div>
                            <div class="adm-sub mt-1">
                                <i class="fas fa-phone" style="width:12px;color:#94a3b8;"></i>
                                {{ $padre->telefono ?? '—' }}
                            </div>
                        </td>
                        <td class="tc">
                            <span class="bpill b-indigo">
                                <i class="fas fa-child" style="font-size:.6rem;"></i>
                                {{ $padre->estudiantes->count() }}
                                {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                            </span>
                        </td>
                        <td class="tc">
                            @if(($padre->estado ?? '') === 'activo')
                                <span class="bpill b-green">
                                    <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activo
                                </span>
                            @else
                                <span class="bpill b-gray">
                                    <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="tc">
                            <a href="{{ route('admins.permisos.configurar', $padre->id) }}"
                               class="act-btn act-config" title="Configurar permisos">
                                <i class="fas fa-cog"></i> Configurar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>

                            <div class="adm-empty">
                                <i class="fas fa-user-lock"></i>
                                @if(request('buscar'))
                                    <p>No se encontró ningún padre con "{{ request('buscar') }}"</p>
                                @else
                                    <p>No hay padres registrados en el sistema</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($padres->hasPages())
        <div class="adm-footer">
            <span class="adm-pages">
                Mostrando {{ $padres->firstItem() }}–{{ $padres->lastItem() }}
                de {{ $padres->total() }} registros
            </span>
            {{ $padres->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection