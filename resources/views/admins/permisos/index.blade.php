@extends('layouts.app')

@section('title', 'Permisos de Padres')
@section('page-title', 'Gestión de Permisos de Padres')

@section('topbar-actions')
    <a href="{{ route('admin.dashboard') }}"
       style="background:white;color:#00508f;padding:.5rem .85rem;border-radius:7px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;border:1.5px solid #4ec7d2;font-size:0.8rem;transition:background .15s;">
        <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Volver al Dashboard
    </a>
@endsection

@push('styles')
<style>
.adm-btn-solid {
    display:inline-flex;align-items:center;gap:.4rem;
    padding:.42rem 1rem;border-radius:7px;font-size:.82rem;font-weight:600;
    background:linear-gradient(135deg,#4ec7d2,#00508f);
    color:#fff;border:none;text-decoration:none;transition:opacity .15s;
}
.adm-btn-solid:hover { opacity:.88;color:#fff; }

/* Stats */
.adm-stats { display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-bottom:1.1rem; }
@media(max-width:768px){ .adm-stats { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px){ .adm-stats { grid-template-columns:1fr; } }

.adm-stat {
    background:#fff;border:1px solid #e2e8f0;border-radius:12px;
    padding:.85rem 1rem;display:flex;align-items:center;gap:.75rem;
    box-shadow:0 1px 3px rgba(0,0,0,.05);
}
.adm-stat-icon { width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.adm-stat-icon i { font-size:1rem;color:#fff; }
.adm-stat-lbl { font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.1rem; }
.adm-stat-num { font-size:1.55rem;font-weight:800;color:#0f172a;line-height:1; }

/* Toolbar */
.adm-toolbar {
    background:#fff;border:1px solid #e2e8f0;border-radius:12px;
    padding:.7rem 1rem;margin-bottom:1rem;
    display:flex;align-items:center;gap:.65rem;flex-wrap:wrap;
    box-shadow:0 1px 3px rgba(0,0,0,.05);
}
.adm-search-inner { position:relative;flex:1;max-width:360px;min-width:180px; }
.adm-search-inner i {
    position:absolute;left:9px;top:50%;transform:translateY(-50%);
    color:#94a3b8;font-size:.75rem;pointer-events:none;
}
.adm-search-inner input {
    width:100%;padding:.35rem .7rem .35rem 1.9rem;
    border:1.5px solid #e2e8f0;border-radius:7px;
    font-size:.8rem;color:#0f172a;background:#f8fafc;outline:none;
}
.adm-search-inner input:focus { border-color:#4ec7d2;background:#fff; }
.btn-search {
    padding:.35rem .8rem;border-radius:7px;font-size:.76rem;font-weight:600;
    border:1.5px solid #4ec7d2;color:#00508f;background:#fff;cursor:pointer;
    transition:background .15s;display:inline-flex;align-items:center;gap:.3rem;
}
.btn-search:hover { background:#e8f8f9; }
.btn-clear {
    padding:.35rem .7rem;border-radius:7px;font-size:.76rem;
    border:1.5px solid #fca5a5;color:#ef4444;background:#fff;
    cursor:pointer;text-decoration:none;transition:background .15s;
    display:inline-flex;align-items:center;gap:.3rem;
}
.btn-clear:hover { background:#fef2f2; }

/* Per page selector */
.adm-perpage { display:flex;align-items:center;gap:.35rem;font-size:.78rem;color:#64748b;margin-left:auto; }
.adm-perpage select {
    padding:.28rem .5rem;border:1.5px solid #e2e8f0;border-radius:7px;
    font-size:.78rem;color:#0f172a;background:#f8fafc;outline:none;cursor:pointer;
}
.adm-perpage select:focus { border-color:#4ec7d2; }

/* Card */
.adm-card { background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.05); }
.adm-card-head { background:#003b73;padding:.75rem 1.1rem;display:flex;align-items:center;justify-content:space-between; }
.adm-card-head-left { display:flex;align-items:center;gap:.5rem; }
.adm-card-head i { color:#4ec7d2;font-size:.9rem; }
.adm-card-head span { color:#fff;font-weight:700;font-size:.88rem; }
.adm-card-head-info { color:rgba(255,255,255,.55);font-size:.73rem; }

/* Tabla compacta */
.adm-tbl { width:100%;border-collapse:collapse; }
.adm-tbl thead th {
    background:#f8fafc;padding:.5rem .8rem;
    font-size:.63rem;font-weight:700;letter-spacing:.07em;
    text-transform:uppercase;color:#64748b;
    border-bottom:1.5px solid #e2e8f0;white-space:nowrap;
}
.adm-tbl thead th.tc { text-align:center; }
.adm-tbl tbody td {
    padding:.5rem .8rem;border-bottom:1px solid #f1f5f9;
    font-size:.79rem;color:#334155;vertical-align:middle;
}
.adm-tbl tbody td.tc { text-align:center; }
.adm-tbl tbody tr:last-child td { border-bottom:none; }
.adm-tbl tbody tr:hover { background:#fafbfc; }

/* Row num */
.row-num {
    width:22px;height:22px;border-radius:5px;background:#f1f5f9;
    border:1px solid #e2e8f0;display:inline-flex;align-items:center;
    justify-content:center;font-size:.65rem;font-weight:700;color:#64748b;
}

/* Avatar */
.adm-av {
    width:30px;height:30px;border-radius:7px;flex-shrink:0;
    background:linear-gradient(135deg,#4ec7d2,#00508f);
    display:flex;align-items:center;justify-content:center;
    font-weight:700;color:#fff;font-size:.72rem;
}
.adm-name { font-weight:600;color:#0f172a;font-size:.8rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }
.adm-sub  { font-size:.7rem;color:#64748b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }

/* Badges */
.bpill { display:inline-flex;align-items:center;gap:.22rem;padding:.15rem .55rem;border-radius:999px;font-size:.67rem;font-weight:600;white-space:nowrap; }
.b-green  { background:#ecfdf5;color:#059669; }
.b-gray   { background:#f1f5f9;color:#64748b; }
.b-blue   { background:#e8f8f9;color:#00508f;border:1px solid rgba(78,199,210,.35); }
.b-indigo { background:#eef2ff;color:#4f46e5; }

/* Acción */
.act-btn {
    display:inline-flex;align-items:center;justify-content:center;
    width:30px;height:30px;border-radius:7px;border:none;
    cursor:pointer;font-size:.8rem;
    text-decoration:none;transition:all .15s;
}
.act-config { background:linear-gradient(135deg,#4ec7d2,#00508f);color:#fff;box-shadow:0 2px 5px rgba(78,199,210,.25); }
.act-config:hover { opacity:.88;color:#fff;transform:translateY(-1px); }

/* Empty */
.adm-empty { padding:3rem 1rem;text-align:center; }
.adm-empty i { font-size:1.8rem;color:#cbd5e1;margin-bottom:.65rem;display:block; }
.adm-empty p { color:#94a3b8;font-size:.82rem;margin:0; }

/* Footer */
.adm-footer { padding:.65rem 1rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:#fafafa;flex-wrap:wrap;gap:.4rem; }
.adm-pages { font-size:.73rem;color:#94a3b8; }
.pagination { margin:0;gap:2px;display:flex; }
.pagination .page-link { border-radius:6px;padding:.22rem .55rem;font-size:.75rem;font-weight:500;border:1px solid #e2e8f0;color:#00508f;transition:all .15s;line-height:1.4; }
.pagination .page-link:hover { background:#e8f8f9;border-color:#4ec7d2; }
.pagination .page-item.active .page-link { background:linear-gradient(135deg,#4ec7d2,#00508f);border-color:#4ec7d2;color:#fff; }
.pagination .page-item.disabled .page-link { opacity:.4; }

/* Info bar */
.adm-info-bar {
    background:rgba(78,199,210,.07);border:1px solid rgba(78,199,210,.3);
    border-radius:9px;padding:.55rem .9rem;margin-bottom:1rem;
    display:flex;align-items:center;gap:.45rem;font-size:.78rem;color:#00508f;
}
</style>
@endpush

@section('content')
<div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3"
         style="border-radius:10px;border:none;background:#ecfdf5;color:#059669;font-size:.82rem;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3"
         style="border-radius:10px;border-left:4px solid #ef4444;font-size:.82rem;">
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

    {{-- Toolbar --}}
    <form action="{{ route('admins.permisos.index') }}" method="GET" id="searchForm">
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

            {{-- Selector per page --}}
            <div class="adm-perpage">
                <span>Mostrar:</span>
                <select name="per_page" onchange="this.form.submit()">
                    @foreach([10, 25, 50] as $op)
                        <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>
                            {{ $op }} por página
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- Resultado búsqueda --}}
    @if(request('buscar'))
    <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:.45rem .9rem;margin-bottom:.85rem;font-size:.78rem;color:#0369a1;display:flex;align-items:center;gap:.45rem;">
        <i class="fas fa-filter"></i>
        @if($padres->total() > 0)
            Mostrando <strong>{{ $padres->total() }}</strong> resultado(s) para:
            <span style="background:rgba(78,199,210,.2);color:#00508f;border:1px solid #4ec7d2;border-radius:999px;padding:.1rem .45rem;font-weight:600;">{{ request('buscar') }}</span>
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
                        <th class="tc" style="width:38px;">#</th>
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
                            <span class="row-num">{{ $padres->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.55rem;">
                                <div class="adm-av">
                                    {{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($padre->apellido ?? 'A', 0, 1)) }}
                                </div>
                                <div style="min-width:0;">
                                    <div class="adm-name">{{ $padre->nombre ?? 'N/A' }} {{ $padre->apellido ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($padre->dni)
                                <i class="fas fa-id-card" style="color:#94a3b8;font-size:.68rem;margin-right:.25rem;"></i>{{ $padre->dni }}
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            <span class="bpill b-blue">{{ $padre->parentesco_formateado }}</span>
                        </td>
                        <td>
                            <div class="adm-sub">
                                <i class="fas fa-envelope" style="width:11px;color:#94a3b8;"></i> {{ $padre->correo ?? '—' }}
                            </div>
                            <div class="adm-sub" style="margin-top:1px;">
                                <i class="fas fa-phone" style="width:11px;color:#94a3b8;"></i> {{ $padre->telefono ?? '—' }}
                            </div>
                        </td>
                        <td class="tc">
                            <span class="bpill b-indigo">
                                <i class="fas fa-child" style="font-size:.58rem;"></i>
                                {{ $padre->estudiantes->count() }} {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                            </span>
                        </td>
                        <td class="tc">
                            @if(($padre->estado ?? '') === 'activo')
                                <span class="bpill b-green">
                                    <i class="fas fa-circle" style="font-size:.38rem;vertical-align:middle;"></i> Activo
                                </span>
                            @else
                                <span class="bpill b-gray">
                                    <i class="fas fa-circle" style="font-size:.38rem;vertical-align:middle;"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="tc">
                            <a href="{{ route('admins.permisos.configurar', $padre->id) }}"
                               class="act-btn act-config" title="Configurar permisos">
                                <i class="fas fa-cog"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
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