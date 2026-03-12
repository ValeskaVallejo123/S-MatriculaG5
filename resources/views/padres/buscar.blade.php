@extends('layouts.app')

@section('title', 'Buscar Padre/Tutor')
@section('page-title', 'Vincular Padre con Estudiante')

@section('topbar-actions')
    <a href="{{ route('padres.create') }}" class="adm-btn-solid" style="text-decoration:none;">
        <i class="fas fa-plus"></i> Nuevo Padre/Tutor
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.adm-wrap { font-family: 'Inter', sans-serif; }

.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none; transition: opacity .15s; cursor: pointer;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #64748b; border: 1.5px solid #e2e8f0;
    text-decoration: none; transition: background .15s; cursor: pointer;
}
.adm-btn-outline:hover { background: #f1f5f9; color: #334155; }

/* ── Banner estudiante ── */
.student-banner {
    background: linear-gradient(135deg, #003b73, #00508f 60%, #4ec7d2);
    border-radius: 12px; padding: 1.1rem 1.5rem;
    display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;
    box-shadow: 0 4px 14px rgba(0,59,115,.18); position: relative; overflow: hidden;
}
.student-banner::before {
    content:''; position: absolute; top: -40%; right: -5%;
    width: 180px; height: 180px; background: rgba(255,255,255,.07); border-radius: 50%;
}
.student-banner-av {
    width: 48px; height: 48px; background: rgba(255,255,255,.18);
    border: 2px solid rgba(255,255,255,.3); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.3rem; flex-shrink: 0; position: relative; z-index: 1;
}
.student-banner-info { position: relative; z-index: 1; }
.student-banner-label { color: rgba(255,255,255,.75); font-size: .72rem; font-weight: 500; margin-bottom: .15rem; }
.student-banner-name  { color: #fff; font-size: 1.05rem; font-weight: 700; margin-bottom: .2rem; }
.student-banner-meta  { display: flex; gap: .65rem; flex-wrap: wrap; }
.student-banner-meta span {
    color: rgba(255,255,255,.9); font-size: .76rem;
    display: inline-flex; align-items: center; gap: .3rem;
}

/* ── Toolbar búsqueda ── */
.adm-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; margin-bottom: 1.25rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-toolbar-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.adm-toolbar-head i { color: #4ec7d2; font-size: 1rem; }
.adm-toolbar-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.adm-toolbar-head small { color: rgba(255,255,255,.6); font-size: .78rem; margin-left: auto; }
.adm-toolbar-body { padding: 1.25rem; }

.form-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1rem; }
@media(max-width:768px){ .form-grid { grid-template-columns: 1fr; } }

.form-group label {
    display: flex; align-items: center; gap: .35rem;
    font-size: .78rem; font-weight: 600; color: #334155; margin-bottom: .4rem;
}
.form-group label i { color: #00508f; }
.form-group input {
    width: 100%; padding: .48rem .85rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #0f172a; background: #f8fafc;
    outline: none; transition: border .15s; font-family: 'Inter', sans-serif;
}
.form-group input:focus {
    border-color: #4ec7d2; background: #fff;
    box-shadow: 0 0 0 3px rgba(78,199,210,.1);
}
.form-group input::placeholder { color: #94a3b8; }
.form-actions { display: flex; gap: .6rem; flex-wrap: wrap; }

/* ── Card resultado ── */
.adm-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between; gap: .6rem;
}
.adm-card-head-left { display: flex; align-items: center; gap: .6rem; }
.adm-card-head i    { color: #4ec7d2; font-size: 1rem; }
.adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

.results-badge {
    background: rgba(255,255,255,.18); color: #fff;
    padding: .22rem .85rem; border-radius: 999px; font-size: .75rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.25);
}

/* ── Tabla ── */
.adm-tbl { width: 100%; border-collapse: collapse; }
.adm-tbl thead th {
    background: #f8fafc; padding: .65rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.adm-tbl thead th.tc { text-align: center; }
.adm-tbl thead th.tr { text-align: right; }
.adm-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.adm-tbl tbody td.tc { text-align: center; }
.adm-tbl tbody td.tr { text-align: right; }
.adm-tbl tbody tr:last-child td { border-bottom: none; }
.adm-tbl tbody tr { transition: background .12s; }
.adm-tbl tbody tr:hover { background: #f8fafc; }

.adm-num {
    width: 28px; height: 28px; border-radius: 6px;
    background: #f1f5f9; color: #64748b;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
}
.adm-av {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .88rem;
    border: 2px solid #4ec7d2;
}
.adm-name  { font-weight: 600; color: #0f172a; font-size: .83rem; }
.adm-sub   { font-size: .73rem; color: #94a3b8; margin-top: .1rem; }
.adm-dni   { font-family: monospace; font-size: .8rem; color: #00508f; }

.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-cyan   { background: #e8f8f9; color: #00508f; border: 1px solid #b2e8ed; }
.b-indigo { background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; }
.b-green  { background: #ecfdf5; color: #059669; border: 1px solid #6ee7b7; }

.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
    padding: 0 .7rem; gap: .3rem; font-weight: 600; white-space: nowrap;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view   { background: #f0f9ff; color: #0369a1; }
.act-view:hover { background: #0369a1; color: #fff; }
.act-link   { background: #ecfdf5; color: #059669; }
.act-link:hover { background: #059669; color: #fff; }

/* Empty / inicial */
.adm-empty { padding: 3.5rem 1rem; text-align: center; }
.adm-empty-icon {
    width: 72px; height: 72px; border-radius: 16px;
    background: #f1f5f9; display: flex; align-items: center; justify-content: center;
    margin: 0 auto .85rem; font-size: 1.75rem; color: #94a3b8;
}
.adm-empty h5 { color: #0f172a; font-weight: 700; margin-bottom: .4rem; font-size: .95rem; }
.adm-empty p  { color: #94a3b8; font-size: .82rem; margin: 0 0 1rem; }

.tips-list { display: flex; flex-direction: column; gap: .5rem; max-width: 360px; margin: 0 auto; }
.tip-item {
    display: flex; align-items: center; gap: .6rem;
    padding: .55rem .9rem; background: #f8fafc; border-radius: 9px;
    color: #64748b; font-size: .8rem;
}
.tip-item i { color: #4ec7d2; }

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
</style>
@endpush

@section('content')
<div class="adm-wrap" style="max-width:1400px; margin:0 auto;">

    {{-- Banner si viene de un estudiante --}}
    @if(isset($estudiante) && $estudiante)
    <div class="student-banner">
        <div class="student-banner-av"><i class="fas fa-user-graduate"></i></div>
        <div class="student-banner-info">
            <div class="student-banner-label">Vincular padre/tutor para:</div>
            <div class="student-banner-name">{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}</div>
            <div class="student-banner-meta">
                <span><i class="fas fa-graduation-cap"></i> Grado: {{ $estudiante->grado ?? '—' }}</span>
                <span><i class="fas fa-id-badge"></i> ID: {{ $estudiante->id }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Formulario de búsqueda ── --}}
    <div class="adm-toolbar">
        <div class="adm-toolbar-head">
            <i class="fas fa-search"></i>
            <span>Buscar Padre/Tutor</span>
            <small>Ingresa al menos un criterio de búsqueda</small>
        </div>
        <div class="adm-toolbar-body">
            <form action="{{ route('padres.buscar') }}" method="GET">
                @if(isset($estudiante) && $estudiante)
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                @endif
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nombre o Apellido</label>
                        <input type="text" name="nombre"
                               placeholder="Ej: Juan Pérez"
                               value="{{ request('nombre') }}">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i> DNI / Identidad</label>
                        <input type="text" name="identidad"
                               placeholder="Ej: 0801-1990-12345"
                               value="{{ request('identidad') }}">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Teléfono</label>
                        <input type="text" name="telefono"
                               placeholder="Ej: 9999-9999"
                               value="{{ request('telefono') }}">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="adm-btn-solid">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('padres.buscar') }}" class="adm-btn-outline">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                    <a href="{{ isset($estudiante) ? route('estudiantes.show', $estudiante->id) : route('padres.index') }}"
                       class="adm-btn-outline">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <a href="{{ route('padres.create') }}" class="adm-btn-outline">
                        <i class="fas fa-plus"></i> Registrar Nuevo
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Resultados ── --}}
    @if(request()->anyFilled(['nombre', 'identidad', 'telefono']))

        <div class="adm-card">
            <div class="adm-card-head">
                <div class="adm-card-head-left">
                    <i class="fas fa-user-friends"></i>
                    <span>Resultados de Búsqueda</span>
                </div>
                <span class="results-badge">
                    {{ $padres->count() }} {{ $padres->count() == 1 ? 'encontrado' : 'encontrados' }}
                </span>
            </div>

            <div style="overflow-x:auto;">
                @if($padres->count() > 0)
                <table class="adm-tbl">
                    <thead>
                        <tr>
                            <th class="tc">#</th>
                            <th>Nombre</th>
                            <th class="tc">DNI</th>
                            <th class="tc">Parentesco</th>
                            <th>Contacto</th>
                            <th class="tr">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($padres as $index => $padre)
                        <tr>
                            <td class="tc">
                                <span class="adm-num">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:.65rem;">
                                    <div class="adm-av">
                                        {{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($padre->apellido ?? 'T', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="adm-name">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                                        @if($padre->correo)
                                            <div class="adm-sub">{{ $padre->correo }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="tc">
                                @if($padre->dni)
                                    <span class="adm-dni">{{ $padre->dni }}</span>
                                @else
                                    <span style="color:#cbd5e1;">—</span>
                                @endif
                            </td>
                            <td class="tc">
                                @if($padre->parentesco)
                                    <span class="bpill b-indigo">
                                        <i class="fas fa-user-tag"></i> {{ ucfirst($padre->parentesco) }}
                                    </span>
                                @else
                                    <span style="color:#cbd5e1;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($padre->telefono)
                                    <div class="adm-sub" style="font-size:.8rem;color:#334155;">
                                        <i class="fas fa-phone" style="width:14px;color:#4ec7d2;"></i>
                                        {{ $padre->telefono }}
                                    </div>
                                @endif
                                @if(!$padre->telefono && !$padre->correo)
                                    <span style="color:#cbd5e1;font-size:.75rem;">Sin contacto</span>
                                @endif
                            </td>
                            <td class="tr">
                                <div style="display:inline-flex;gap:.35rem;align-items:center;">
                                    @if(isset($estudiante) && $estudiante)
                                        <button type="button"
                                                class="act-btn act-link btn-vincular"
                                                data-padre-id="{{ $padre->id }}"
                                                data-padre-nombre="{{ $padre->nombre }} {{ $padre->apellido }}"
                                                data-estudiante-id="{{ $estudiante->id }}"
                                                data-estudiante-nombre="{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}">
                                            <i class="fas fa-link"></i> Vincular
                                        </button>
                                    @endif
                                    <a href="{{ route('padres.show', $padre->id) }}"
                                       class="act-btn act-view" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($padres->hasPages())
                <div class="adm-footer">
                    <span class="adm-pages">
                        Mostrando {{ $padres->firstItem() }}–{{ $padres->lastItem() }}
                        de {{ $padres->total() }} padres/tutores
                    </span>
                    {{ $padres->appends(request()->query())->links() }}
                </div>
                @endif

                @else
                <div class="adm-empty">
                    <div class="adm-empty-icon"><i class="fas fa-search"></i></div>
                    <h5>Sin resultados</h5>
                    <p>No se encontró ningún padre/tutor con los criterios ingresados.<br>Intenta con otros datos.</p>
                    <a href="{{ route('padres.create') }}" class="adm-btn-solid" style="margin:0 auto;">
                        <i class="fas fa-plus"></i> Registrar Nuevo Padre/Tutor
                    </a>
                </div>
                @endif
            </div>
        </div>

    @else
    {{-- Estado inicial --}}
    <div class="adm-card">
        <div class="adm-empty">
            <div class="adm-empty-icon"
                 style="background:linear-gradient(135deg,rgba(0,80,143,.08),rgba(78,199,210,.12));">
                <i class="fas fa-user-friends" style="color:#00508f;"></i>
            </div>
            <h5>Busca un padre o tutor</h5>
            <p>Completa el formulario con al menos un criterio<br>para encontrar padres/tutores registrados.</p>
            <div class="tips-list">
                <div class="tip-item">
                    <i class="fas fa-lightbulb"></i>
                    <span>Puedes buscar por nombre, DNI o teléfono</span>
                </div>
                <div class="tip-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Los resultados se mostrarán debajo del formulario</span>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ── Modal Vinculación ── --}}
<div id="modalVincularOverlay" style="
    position:fixed;top:0;left:0;right:0;bottom:0;
    background:rgba(0,0,0,.55);backdrop-filter:blur(4px);
    display:none;align-items:center;justify-content:center;z-index:10000;">
    <div style="background:#fff;border-radius:14px;max-width:400px;width:90%;overflow:hidden;
                box-shadow:0 12px 40px rgba(0,80,143,.2);animation:scaleUp .25s ease;position:relative;">
        <style>@keyframes scaleUp{from{transform:scale(.94);opacity:0}to{transform:scale(1);opacity:1}}</style>

        <button onclick="cerrarModalVincular()"
                style="position:absolute;top:.75rem;right:.75rem;background:rgba(255,255,255,.2);
                       border:none;border-radius:7px;width:28px;height:28px;color:#fff;
                       cursor:pointer;z-index:10;font-size:.85rem;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-times"></i>
        </button>

        <div style="background:linear-gradient(135deg,#003b73,#4ec7d2);padding:1.4rem;text-align:center;">
            <div style="width:50px;height:50px;background:rgba(255,255,255,.18);
                        border:2px solid rgba(255,255,255,.3); border-radius:50%;
                        display:flex;align-items:center;justify-content:center;
                        margin:0 auto .6rem;color:#fff;font-size:1.25rem;">
                <i class="fas fa-link"></i>
            </div>
            <h6 style="color:#fff;font-weight:700;margin:0;font-size:1rem;">Confirmar Vinculación</h6>
        </div>

        <div style="padding:1.4rem;">
            <div style="background:#f8fafc;border-radius:10px;padding:1rem;margin-bottom:1rem;">
                <div style="background:#fff;border-radius:8px;padding:.6rem .85rem;display:flex;align-items:center;gap:.6rem;margin-bottom:.35rem;font-weight:600;color:#0f172a;font-size:.84rem;">
                    <div style="width:30px;height:30px;background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;flex-shrink:0;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <span id="modalPadreNombre"></span>
                </div>
                <div style="text-align:center;color:#4ec7d2;font-size:.72rem;padding:.1rem 0;">
                    <i class="fas fa-link"></i>
                </div>
                <div style="background:#fff;border-radius:8px;padding:.6rem .85rem;display:flex;align-items:center;gap:.6rem;margin-top:.35rem;font-weight:600;color:#0f172a;font-size:.84rem;">
                    <div style="width:30px;height:30px;background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;flex-shrink:0;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <span id="modalEstudianteNombre"></span>
                </div>
            </div>
            <p style="text-align:center;color:#64748b;font-size:.83rem;margin:0;">
                ¿Deseas vincular este padre/tutor con el estudiante?
            </p>
        </div>

        <form id="formVincular" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="estudiante_id" id="formEstudianteId">
        </form>

        <div style="padding:.75rem 1.25rem 1.25rem;display:flex;gap:.6rem;">
            <button onclick="cerrarModalVincular()"
                    style="flex:1;padding:.5rem;border-radius:8px;border:1.5px solid #e2e8f0;
                           background:#fff;color:#64748b;font-size:.82rem;font-weight:600;cursor:pointer;">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button onclick="confirmarVinculacion()"
                    style="flex:1;padding:.5rem;border-radius:8px;border:none;
                           background:linear-gradient(135deg,#4ec7d2,#00508f);color:#fff;
                           font-size:.82rem;font-weight:600;cursor:pointer;
                           box-shadow:0 3px 10px rgba(0,80,143,.25);">
                <i class="fas fa-check"></i> Confirmar
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Delegación de eventos para botones vincular
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-vincular');
    if (!btn) return;
    const padreId          = btn.dataset.padreId;
    const padreNombre      = btn.dataset.padreNombre;
    const estudianteId     = btn.dataset.estudianteId;
    const estudianteNombre = btn.dataset.estudianteNombre;
    document.getElementById('modalPadreNombre').textContent      = padreNombre;
    document.getElementById('modalEstudianteNombre').textContent = estudianteNombre;
    document.getElementById('formEstudianteId').value            = estudianteId;
    document.getElementById('formVincular').action               = `/padres/${padreId}/vincular`;
    document.getElementById('modalVincularOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
});
function cerrarModalVincular() {
    document.getElementById('modalVincularOverlay').style.display = 'none';
    document.body.style.overflow = '';
}
function confirmarVinculacion() {
    document.getElementById('formVincular').submit();
}
document.getElementById('modalVincularOverlay').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalVincular();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModalVincular();
});
</script>
@endpush