@extends('layouts.app')

@section('title', 'Buscar Padre/Tutor')
@section('page-title', 'Vincular Padre con Estudiante')

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
    color: #fff; border: none; text-decoration: none; transition: opacity .15s; cursor: pointer;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* Estudiante banner */
.student-banner {
    background: linear-gradient(135deg, #003b73, #00508f 60%, #4ec7d2);
    border-radius: 12px; padding: 1.25rem 1.5rem;
    display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;
    box-shadow: 0 4px 14px rgba(0,59,115,.18); position: relative; overflow: hidden;
}
.student-banner::before {
    content:''; position: absolute; top: -40%; right: -5%;
    width: 200px; height: 200px; background: rgba(255,255,255,.07); border-radius: 50%;
}
.student-banner-av {
    width: 52px; height: 52px; background: rgba(255,255,255,.18);
    border: 2.5px solid rgba(255,255,255,.3); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.4rem; flex-shrink: 0; position: relative; z-index: 1;
}
.student-banner-info { position: relative; z-index: 1; }
.student-banner-label { color: rgba(255,255,255,.75); font-size: .73rem; font-weight: 500; margin-bottom: .2rem; }
.student-banner-name  { color: #fff; font-size: 1.2rem; font-weight: 700; margin-bottom: .25rem; }
.student-banner-meta  { display: flex; gap: .75rem; flex-wrap: wrap; }
.student-banner-meta span {
    color: rgba(255,255,255,.9); font-size: .78rem;
    display: inline-flex; align-items: center; gap: .35rem;
}

/* Search card */
.adm-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1.25rem;
}
.adm-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.adm-card-head i { color: #4ec7d2; font-size: 1rem; }
.adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.adm-card-subhead { color: rgba(255,255,255,.6); font-size: .78rem; }

.adm-card-body { padding: 1.5rem; }

/* Form */
.form-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1.25rem; }
@media(max-width:768px){ .form-grid { grid-template-columns: 1fr; } }
@media(max-width:992px) and (min-width:769px){ .form-grid { grid-template-columns: repeat(2,1fr); } }

.form-group label {
    display: flex; align-items: center; gap: .35rem;
    font-size: .78rem; font-weight: 600; color: #334155; margin-bottom: .4rem;
}
.form-group label i { color: #00508f; }
.form-group input {
    width: 100%; padding: .5rem .85rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .85rem; color: #0f172a; background: #f8fafc; outline: none; transition: border .15s;
}
.form-group input:focus { border-color: #4ec7d2; background: #fff; box-shadow: 0 0 0 3px rgba(78,199,210,.1); }
.form-group input::placeholder { color: #94a3b8; }

.form-actions { display: flex; gap: .65rem; flex-wrap: wrap; }

/* Results */
.results-badge {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; padding: .25rem .85rem; border-radius: 999px; font-size: .75rem; font-weight: 600;
}

.adm-tbl { width: 100%; border-collapse: collapse; }
.adm-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.adm-tbl thead th.tc { text-align: center; }
.adm-tbl tbody td {
    padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.adm-tbl tbody td.tc { text-align: center; }
.adm-tbl tbody tr:last-child td { border-bottom: none; }
.adm-tbl tbody tr:hover { background: #fafbfc; }

.adm-av {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}
.adm-name  { font-weight: 600; color: #0f172a; font-size: .82rem; }
.adm-email { font-size: .75rem; color: #64748b; }

.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-blue   { background: #e8f8f9; color: #00508f; }
.b-indigo { background: #eef2ff; color: #4f46e5; }
.b-green  { background: #ecfdf5; color: #059669; }

.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    padding: .38rem .85rem; border-radius: 7px; border: none;
    cursor: pointer; font-size: .78rem; font-weight: 600; text-decoration: none;
    gap: .35rem; transition: all .15s; white-space: nowrap;
}
.act-btn:hover { transform: translateY(-1px); }
.act-link   { background: #ecfdf5; color: #059669; }
.act-link:hover   { background: #059669; color: #fff; }
.act-view   { background: #e8f8f9; color: #00508f; }
.act-view:hover   { background: #00508f; color: #fff; }

/* Empty/initial */
.adm-empty { padding: 3.5rem 1rem; text-align: center; }
.adm-empty .empty-ico {
    width: 72px; height: 72px; border-radius: 50%; margin: 0 auto .85rem;
    display: flex; align-items: center; justify-content: center; font-size: 1.6rem;
}
.adm-empty h5 { color: #0f172a; font-weight: 700; margin-bottom: .4rem; font-size: 1rem; }
.adm-empty p { color: #94a3b8; font-size: .85rem; margin: 0 0 1rem; }

.tips-list { display: flex; flex-direction: column; gap: .6rem; max-width: 360px; margin: 0 auto; }
.tip-item {
    display: flex; align-items: center; gap: .65rem;
    padding: .6rem .9rem; background: #f8fafc; border-radius: 9px;
    color: #64748b; font-size: .8rem;
}
.tip-item i { color: #4ec7d2; font-size: 1rem; }
</style>
@endpush

@section('content')
<div class="adm-wrap">

    {{-- Estudiante Banner --}}
    @if(isset($estudiante) && $estudiante)
    <div class="student-banner">
        <div class="student-banner-av"><i class="fas fa-user-graduate"></i></div>
        <div class="student-banner-info">
            <div class="student-banner-label">Vincular padre/tutor para:</div>
            <div class="student-banner-name">{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}</div>
            <div class="student-banner-meta">
                <span><i class="fas fa-graduation-cap"></i>Grado: {{ $estudiante->grado }}</span>
                <span><i class="fas fa-id-badge"></i>ID: {{ $estudiante->id }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Formulario de búsqueda --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-search"></i>
            <span>Buscar Padre/Tutor</span>
            <span class="adm-card-subhead ms-auto">Ingresa al menos un criterio</span>
        </div>
        <div class="adm-card-body">
            <form action="{{ route('padres.buscar') }}" method="GET">
                @if(isset($estudiante) && $estudiante)
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                @endif
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nombre o Apellido</label>
                        <input type="text" name="nombre" value="{{ request('nombre') }}"
                               placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i> DNI / Identidad</label>
                        <input type="text" name="identidad" value="{{ request('identidad') }}"
                               placeholder="Ej: 0801-1990-12345">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Teléfono</label>
                        <input type="text" name="telefono" value="{{ request('telefono') }}"
                               placeholder="Ej: 9999-9999">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="adm-btn-solid">
                        <i class="fas fa-search"></i> Buscar Padres
                    </button>
                    <a href="{{ isset($estudiante) ? route('estudiantes.show', $estudiante->id) : route('padres.index') }}"
                       class="adm-btn-outline">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <a href="{{ route('padres.create') }}" class="adm-btn-outline">
                        <i class="fas fa-plus"></i> Registrar Nuevo
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Resultados --}}
    @if(request()->anyFilled(['nombre', 'identidad', 'telefono']))
    <div class="adm-card">
        <div class="adm-card-head" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:.6rem;">
                <i class="fas fa-list"></i>
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
                        <th>Padre / Tutor</th>
                        <th class="tc">DNI</th>
                        <th class="tc">Parentesco</th>
                        <th>Contacto</th>
                        <th class="tc">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($padres as $padre)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="adm-av">
                                    {{ strtoupper(substr($padre->nombre,0,1).substr($padre->apellido,0,1)) }}
                                </div>
                                <div>
                                    <div class="adm-name">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="tc">
                            @if($padre->dni)
                                <span class="bpill b-blue">
                                    <i class="fas fa-id-card"></i> {{ $padre->dni }}
                                </span>
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            <span class="bpill b-indigo">
                                <i class="fas fa-user-tag"></i> {{ ucfirst($padre->parentesco) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;flex-direction:column;gap:.2rem;">
                                @if($padre->telefono)
                                <div class="adm-email"><i class="fas fa-phone" style="width:14px;color:#94a3b8;"></i> {{ $padre->telefono }}</div>
                                @endif
                                @if($padre->correo)
                                <div class="adm-email"><i class="fas fa-envelope" style="width:14px;color:#94a3b8;"></i> {{ $padre->correo }}</div>
                                @endif
                                @if(!$padre->telefono && !$padre->correo)
                                <span style="color:#cbd5e1;font-size:.75rem;">Sin contacto</span>
                                @endif
                            </div>
                        </td>
                        <td class="tc">
                            @if(isset($estudiante) && $estudiante)
                                <button type="button"
                                        class="act-btn act-link"
                                        onclick="mostrarModalVincular({{ $padre->id }}, '{{ addslashes($padre->nombre . ' ' . $padre->apellido) }}', {{ $estudiante->id }}, '{{ addslashes($estudiante->nombre1 . ' ' . $estudiante->apellido1) }}')">
                                    <i class="fas fa-link"></i> Vincular
                                </button>
                            @else
                                <a href="{{ route('padres.show', $padre->id) }}" class="act-btn act-view">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="adm-empty">
                <div class="empty-ico" style="background:#fef2f2;">
                    <i class="fas fa-search" style="color:#ef4444;"></i>
                </div>
                <h5>No se encontraron resultados</h5>
                <p>Intenta con otros criterios de búsqueda.</p>
                <a href="{{ route('padres.create') }}" class="adm-btn-solid">
                    <i class="fas fa-plus-circle"></i> Registrar Nuevo Padre/Tutor
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Estado inicial --}}
    @else
    <div class="adm-card">
        <div class="adm-card-body">
            <div class="adm-empty">
                <div class="empty-ico" style="background:linear-gradient(135deg,rgba(0,80,143,.1),rgba(78,199,210,.1));">
                    <i class="fas fa-search" style="color:#00508f;"></i>
                </div>
                <h5>Busca un padre o tutor</h5>
                <p>Completa el formulario con al menos un criterio para encontrar padres/tutores registrados.</p>
                <div class="tips-list">
                    <div class="tip-item">
                        <i class="fas fa-lightbulb"></i>
                        <span>Puedes buscar por nombre, DNI o teléfono</span>
                    </div>
                    <div class="tip-item">
                        <i class="fas fa-info-circle"></i>
                        <span>Los resultados se mostrarán automáticamente</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- Modal Vinculación --}}
<div id="modalVincularOverlay" style="
    position:fixed;top:0;left:0;right:0;bottom:0;
    background:rgba(0,0,0,.55);backdrop-filter:blur(4px);
    display:none;align-items:center;justify-content:center;z-index:10000;">
    <div style="background:#fff;border-radius:14px;max-width:400px;width:90%;overflow:hidden;box-shadow:0 12px 40px rgba(0,80,143,.2);animation:scaleUp .25s ease;">
        <style>@keyframes scaleUp{from{transform:scale(.94);opacity:0}to{transform:scale(1);opacity:1}}</style>
        <button onclick="cerrarModalVincular()" style="position:absolute;top:.85rem;right:.85rem;background:rgba(255,255,255,.18);border:none;border-radius:7px;width:28px;height:28px;color:#fff;cursor:pointer;z-index:1;font-size:.8rem;">✕</button>

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#003b73,#4ec7d2);padding:1.4rem;text-align:center;position:relative;">
            <div style="width:52px;height:52px;background:rgba(255,255,255,.18);border:2px solid rgba(255,255,255,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .65rem;color:#fff;font-size:1.3rem;">
                <i class="fas fa-link"></i>
            </div>
            <h6 style="color:#fff;font-weight:700;margin:0;font-size:1rem;">Confirmar Vinculación</h6>
        </div>

        {{-- Body --}}
        <div style="padding:1.5rem;">
            <div style="background:#f8fafc;border-radius:10px;padding:1rem;margin-bottom:1rem;">
                <div style="background:#fff;border-radius:8px;padding:.65rem .85rem;display:flex;align-items:center;gap:.65rem;margin-bottom:.4rem;font-weight:600;color:#0f172a;font-size:.85rem;">
                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.75rem;flex-shrink:0;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <span id="modalPadreNombre"></span>
                </div>
                <div style="text-align:center;color:#4ec7d2;font-size:.75rem;padding:.1rem 0;"><i class="fas fa-link"></i></div>
                <div style="background:#fff;border-radius:8px;padding:.65rem .85rem;display:flex;align-items:center;gap:.65rem;margin-top:.4rem;font-weight:600;color:#0f172a;font-size:.85rem;">
                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.75rem;flex-shrink:0;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <span id="modalEstudianteNombre"></span>
                </div>
            </div>
            <p style="text-align:center;color:#64748b;font-size:.85rem;margin:0;">
                ¿Deseas vincular este padre/tutor con el estudiante?
            </p>
        </div>

        <form id="formVincular" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="estudiante_id" id="formEstudianteId">
        </form>

        {{-- Footer --}}
        <div style="padding:.85rem 1.5rem 1.25rem;display:flex;gap:.6rem;">
            <button onclick="cerrarModalVincular()"
                    style="flex:1;padding:.55rem;border-radius:8px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:.82rem;font-weight:600;cursor:pointer;">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button onclick="confirmarVinculacion()"
                    style="flex:1;padding:.55rem;border-radius:8px;border:none;background:linear-gradient(135deg,#4ec7d2,#00508f);color:#fff;font-size:.82rem;font-weight:600;cursor:pointer;box-shadow:0 3px 10px rgba(0,80,143,.25);">
                <i class="fas fa-check"></i> Confirmar
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function mostrarModalVincular(padreId, padreNombre, estudianteId, estudianteNombre) {
    document.getElementById('modalPadreNombre').textContent = padreNombre;
    document.getElementById('modalEstudianteNombre').textContent = estudianteNombre;
    document.getElementById('formEstudianteId').value = estudianteId;
    document.getElementById('formVincular').action = `/padres/${padreId}/vincular`;
    const overlay = document.getElementById('modalVincularOverlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function cerrarModalVincular() {
    document.getElementById('modalVincularOverlay').style.display = 'none';
    document.body.style.overflow = '';
}
function confirmarVinculacion() {
    document.getElementById('formVincular').submit();
}
document.getElementById('modalVincularOverlay').addEventListener('click', function(e) {
    if(e.target === this) cerrarModalVincular();
});
document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') cerrarModalVincular();
});
</script>
@endpush