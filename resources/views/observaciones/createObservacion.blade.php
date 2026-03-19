@extends('layouts.app')

@section('title', 'Crear Observación')
@section('page-title', 'Nueva Observación')

@section('topbar-actions')
    <a href="{{ route('observaciones.index') }}" class="btn-back"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px;
              text-decoration: none; font-weight: 600; display: inline-flex; align-items: center;
              gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
:root {
    --blue-dark: #003b73;
    --blue-mid:  #00508f;
    --cyan:      #4ec7d2;
    --border:    #bfd9ea;
    --surface:   #f5f8fc;
}

/* ══ FORM ══ */
.obs-header {
    background: linear-gradient(135deg, #00508f, #003b73);
    border-radius: 12px; padding: 1.25rem 1.5rem;
    display: flex; align-items: center; gap: 1rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 14px rgba(0,59,115,.18);
}
.obs-header-icon {
    width:50px; height:50px; background:rgba(78,199,210,.25);
    border-radius:11px; display:flex; align-items:center;
    justify-content:center; flex-shrink:0;
}
.obs-header h5 { color:#fff; font-weight:700; margin:0 0 .2rem; font-size:1.1rem; }
.obs-header p  { color:rgba(255,255,255,.7); margin:0; font-size:.82rem; }

.obs-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:12px;
    padding:1.75rem 2rem; box-shadow:0 1px 4px rgba(0,59,115,.07);
}

.sec-icon {
    width:36px; height:36px; background:linear-gradient(135deg,var(--cyan),var(--blue-mid));
    border-radius:9px; display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
}
.sec-icon i { color:#fff; font-size:.85rem; }
.sec-title { color:var(--blue-dark); font-weight:700; font-size:.95rem; margin:0; }

.field-label {
    display:block; font-size:.72rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.06em; color:#64748b; margin-bottom:.4rem;
}

.field-input {
    width:100%; border:2px solid var(--border); border-radius:8px;
    padding:.6rem 1rem; font-size:.88rem; color:#0f172a;
    background:var(--surface); outline:none; transition:border .15s;
    font-family:inherit;
}
.field-input:focus { border-color:var(--cyan); background:#fff; box-shadow:0 0 0 3px rgba(78,199,210,.12); }

/* ══ SELECTOR DE ESTUDIANTE ══ */
.student-selector {
    border:2px dashed var(--border); border-radius:10px;
    padding:1rem 1.25rem; cursor:pointer;
    transition:all .2s; background:var(--surface);
    display:flex; align-items:center; gap:.85rem;
}
.student-selector:hover { border-color:var(--cyan); background:rgba(78,199,210,.05); }
.student-selector.selected {
    border-style:solid; border-color:var(--cyan);
    background:rgba(78,199,210,.08);
}
.student-selector-icon {
    width:42px; height:42px; border-radius:10px; flex-shrink:0;
    background:rgba(0,80,143,.1);
    display:flex; align-items:center; justify-content:center;
    font-size:.95rem; color:var(--blue-mid);
}
.student-selector-icon.active { background:linear-gradient(135deg,var(--cyan),var(--blue-mid)); color:#fff; }
.student-selector-text { flex:1; }
.student-selector-text .hint { font-size:.82rem; color:#94a3b8; font-weight:500; }
.student-selector-text .name { font-size:.92rem; font-weight:700; color:var(--blue-dark); }
.student-selector-text .sub  { font-size:.75rem; color:#64748b; margin-top:.1rem; }

/* ══ TIPO RADIO ══ */
.tipo-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:.6rem; }
.tipo-btn { display:none; }
.tipo-label {
    display:flex; flex-direction:column; align-items:center; gap:.4rem;
    padding:.85rem .5rem; border:2px solid var(--border); border-radius:10px;
    cursor:pointer; transition:all .2s; background:#fff; text-align:center;
}
.tipo-label:hover { border-color:var(--cyan); background:rgba(78,199,210,.05); }
.tipo-btn:checked + .tipo-label {
    border-color:var(--cyan); background:rgba(78,199,210,.1);
    box-shadow:0 0 0 3px rgba(78,199,210,.15);
}
.tipo-label i   { font-size:1.3rem; }
.tipo-label span { font-size:.75rem; font-weight:700; color:var(--blue-dark); }

/* ══ TEXTAREA ══ */
.desc-wrap { position:relative; }
.desc-wrap i { position:absolute; left:12px; top:13px; color:var(--blue-mid); font-size:.85rem; }
.desc-input {
    width:100%; border:2px solid var(--border); border-radius:8px;
    padding:.65rem 1rem .65rem 2.6rem; font-size:.88rem; color:#0f172a;
    background:var(--surface); outline:none; transition:border .15s;
    resize:none; min-height:280px; font-family:inherit; line-height:1.6;
}
.desc-input:focus { border-color:var(--cyan); background:#fff; box-shadow:0 0 0 3px rgba(78,199,210,.12); }

/* ══ MODAL ══ */
.modal-overlay {
    position:fixed; inset:0; background:rgba(0,0,0,.55);
    backdrop-filter:blur(3px); z-index:9999;
    display:none; align-items:center; justify-content:center;
    padding:1rem;
}
.modal-overlay.open { display:flex; animation:fadeIn .2s ease; }
@keyframes fadeIn { from{opacity:0} to{opacity:1} }

.modal-box {
    background:#fff; border-radius:14px; width:100%; max-width:620px;
    max-height:85vh; display:flex; flex-direction:column;
    box-shadow:0 20px 60px rgba(0,59,115,.25);
    animation:slideUp .25s ease;
}
@keyframes slideUp { from{transform:translateY(20px);opacity:0} to{transform:translateY(0);opacity:1} }

.modal-head {
    background:linear-gradient(135deg,var(--blue-dark),var(--blue-mid));
    padding:1rem 1.25rem; border-radius:14px 14px 0 0;
    display:flex; align-items:center; justify-content:space-between;
}
.modal-head h5  { color:#fff; font-weight:700; margin:0; font-size:.95rem; }
.modal-close {
    width:30px; height:30px; border-radius:7px;
    background:rgba(255,255,255,.15); border:none; color:#fff;
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    font-size:.85rem; transition:background .15s;
}
.modal-close:hover { background:rgba(255,255,255,.25); }

.modal-search {
    padding:.85rem 1rem; border-bottom:1px solid #e2e8f0;
    position:relative;
}
.modal-search i {
    position:absolute; left:1.75rem; top:50%; transform:translateY(-50%);
    color:var(--blue-mid); font-size:.85rem;
}
.modal-search input {
    width:100%; border:1.5px solid #e2e8f0; border-radius:8px;
    padding:.55rem 1rem .55rem 2.5rem; font-size:.85rem; outline:none;
    background:#f8fafc; transition:border .15s; font-family:inherit;
}
.modal-search input:focus { border-color:var(--cyan); background:#fff; box-shadow:0 0 0 3px rgba(78,199,210,.1); }

.modal-filters {
    padding:.6rem 1rem; border-bottom:1px solid #e2e8f0;
    display:flex; gap:.5rem; flex-wrap:wrap;
}
.filter-btn {
    padding:.25rem .75rem; border-radius:999px; border:1.5px solid #e2e8f0;
    background:#f8fafc; font-size:.73rem; font-weight:600; color:#64748b;
    cursor:pointer; transition:all .15s;
}
.filter-btn:hover   { border-color:var(--cyan); color:var(--blue-mid); background:rgba(78,199,210,.08); }
.filter-btn.active  { border-color:var(--cyan); color:var(--blue-mid); background:rgba(78,199,210,.12); }

.modal-list { overflow-y:auto; flex:1; padding:.5rem; }

.modal-student-item {
    display:flex; align-items:center; gap:.85rem;
    padding:.75rem .9rem; border-radius:9px; cursor:pointer;
    transition:background .15s; border:1.5px solid transparent;
}
.modal-student-item:hover  { background:rgba(78,199,210,.08); border-color:rgba(78,199,210,.3); }
.modal-student-item.active { background:rgba(78,199,210,.12); border-color:var(--cyan); }

.s-av {
    width:40px; height:40px; border-radius:10px; flex-shrink:0;
    background:linear-gradient(135deg,var(--cyan),var(--blue-mid));
    display:flex; align-items:center; justify-content:center;
    font-size:.88rem; font-weight:800; color:#fff; overflow:hidden;
}
.s-av img { width:100%; height:100%; object-fit:cover; border-radius:8px; }
.s-name  { font-weight:700; color:var(--blue-dark); font-size:.85rem; }
.s-sub   { font-size:.73rem; color:#64748b; margin-top:.1rem; }
.s-badge {
    margin-left:auto; padding:.18rem .6rem; border-radius:999px;
    font-size:.65rem; font-weight:700;
    background:rgba(78,199,210,.12); color:var(--blue-mid);
    border:1px solid rgba(78,199,210,.3); white-space:nowrap;
}

.modal-empty {
    text-align:center; padding:3rem 1rem; color:#94a3b8;
}
.modal-empty i { font-size:2rem; display:block; margin-bottom:.75rem; color:#e2e8f0; }

.modal-foot {
    padding:.85rem 1.25rem; border-top:1px solid #e2e8f0;
    display:flex; align-items:center; justify-content:space-between;
    background:#f8fafc; border-radius:0 0 14px 14px;
    font-size:.78rem; color:#94a3b8;
}
.modal-foot strong { color:var(--blue-dark); }

/* ══ BOTONES FORM ══ */
.btn-submit {
    flex:1; padding:.7rem 1.25rem; border-radius:9px; border:none;
    background:linear-gradient(135deg,var(--cyan),var(--blue-mid));
    color:#fff; font-weight:700; font-size:.88rem; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:.4rem;
    transition:opacity .15s; box-shadow:0 2px 10px rgba(78,199,210,.3);
}
.btn-submit:hover { opacity:.88; }
.btn-cancel-form {
    flex:1; padding:.7rem 1.25rem; border-radius:9px;
    border:2px solid var(--blue-mid); color:var(--blue-mid);
    background:#fff; font-weight:700; font-size:.88rem;
    text-decoration:none; display:flex; align-items:center;
    justify-content:center; gap:.4rem; transition:background .15s;
}
.btn-cancel-form:hover { background:#eff6ff; color:var(--blue-mid); }
</style>
@endpush

@section('content')

{{-- ══ HEADER ══ --}}
<div class="obs-header">
    <div class="obs-header-icon">
        <i class="fas fa-clipboard-list" style="color:#fff;font-size:1.3rem;"></i>
    </div>
    <div>
        <h5>Registro de Observación</h5>
        <p>Complete los campos para registrar una nueva observación</p>
    </div>
</div>

{{-- ══ FORMULARIO ══ --}}
<div class="obs-card">
    <form action="{{ route('observaciones.store') }}" method="POST">
        @csrf

        @if($errors->any())
            <div style="background:rgba(239,68,68,.08);border-left:3px solid #ef4444;
                        border-radius:8px;padding:.85rem 1rem;margin-bottom:1.5rem;">
                <ul style="margin:0;padding-left:1rem;color:#991b1b;font-size:.82rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">

            {{-- ── COLUMNA IZQUIERDA ── --}}
            <div class="col-lg-6">

                {{-- ESTUDIANTE --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="sec-icon"><i class="fas fa-user-graduate"></i></div>
                        <p class="sec-title">Estudiante</p>
                    </div>
                    <label class="field-label">
                        Seleccionar estudiante <span style="color:#ef4444;">*</span>
                    </label>

                    {{-- Botón selector --}}
                    <div class="student-selector {{ old('estudiante_id') ? 'selected' : '' }}"
                         id="studentSelector" onclick="abrirModal()">
                        <div class="student-selector-icon {{ old('estudiante_id') ? 'active' : '' }}" id="selectorIcon">
                            <i class="fas fa-user-graduate" id="selectorIconFA"></i>
                        </div>
                        <div class="student-selector-text">
                            <div id="selectorHint" class="hint"
                                 style="{{ old('estudiante_id') ? 'display:none' : '' }}">
                                <i class="fas fa-mouse-pointer me-1"></i>
                                Haz clic para buscar y seleccionar un estudiante
                            </div>
                            <div id="selectorName" class="name"
                                 style="{{ old('estudiante_id') ? '' : 'display:none' }}">
                                —
                            </div>
                            <div id="selectorSub" class="sub" style="display:none;"></div>
                        </div>
                        <i class="fas fa-chevron-right" style="color:#94a3b8;font-size:.8rem;"></i>
                    </div>

                    <input type="hidden" name="estudiante_id" id="estudianteId"
                           value="{{ old('estudiante_id') }}">

                    @error('estudiante_id')
                        <div style="color:#ef4444;font-size:.72rem;margin-top:.3rem;">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- PROFESOR (solo admin) --}}
                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="sec-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <p class="sec-title">Profesor</p>
                    </div>
                    <label class="field-label">Profesor asignado</label>
                    <div style="position:relative;">
                        <i class="fas fa-chalkboard" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--blue-mid);font-size:.85rem;z-index:1;"></i>
                        <select name="profesor_id" class="field-input" style="padding-left:2.6rem;">
                            <option value="">Sin asignar</option>
                            @foreach($profesores as $prof)
                                <option value="{{ $prof->id }}" {{ old('profesor_id') == $prof->id ? 'selected' : '' }}>
                                    {{ $prof->nombreCompleto }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                {{-- TIPO --}}
                <div class="mb-2">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="sec-icon"><i class="fas fa-tags"></i></div>
                        <p class="sec-title">Tipo de Observación</p>
                    </div>
                    <label class="field-label">Tipo <span style="color:#ef4444;">*</span></label>
                    <div class="tipo-grid">
                        @foreach([
                            ['value'=>'academica',  'label'=>'Académica',  'icon'=>'fa-book',        'color'=>'#2196f3'],
                            ['value'=>'conductual', 'label'=>'Conductual', 'icon'=>'fa-user-shield', 'color'=>'#ef4444'],
                            ['value'=>'salud',      'label'=>'Salud',      'icon'=>'fa-heartbeat',   'color'=>'#4caf50'],
                            ['value'=>'otro',       'label'=>'Otro',       'icon'=>'fa-ellipsis-h',  'color'=>'#9e9e9e'],
                        ] as $t)
                        <div>
                            <input type="radio" class="tipo-btn" name="tipo"
                                   id="tipo_{{ $t['value'] }}" value="{{ $t['value'] }}"
                                   {{ old('tipo') === $t['value'] ? 'checked' : '' }}>
                            <label class="tipo-label" for="tipo_{{ $t['value'] }}">
                                <i class="fas {{ $t['icon'] }}" style="color:{{ $t['color'] }};"></i>
                                <span>{{ $t['label'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('tipo')
                        <div style="color:#ef4444;font-size:.72rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- ── COLUMNA DERECHA — Descripción ── --}}
            <div class="col-lg-6 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="sec-icon"><i class="fas fa-file-alt"></i></div>
                    <p class="sec-title">Descripción</p>
                </div>
                <label class="field-label">
                    Detalle de la observación <span style="color:#ef4444;">*</span>
                </label>
                <div class="desc-wrap flex-fill d-flex flex-column">
                    <i class="fas fa-pen"></i>
                    <textarea name="descripcion" id="descripcion"
                              class="desc-input flex-fill @error('descripcion') is-invalid @enderror"
                              maxlength="1000"
                              placeholder="Describe la observación con detalle...">{{ old('descripcion') }}</textarea>
                </div>
                <div style="text-align:right;margin-top:.3rem;">
                    <span id="charCount" style="font-size:.72rem;color:#94a3b8;">0 / 1000</span>
                </div>
                @error('descripcion')
                    <div style="color:#ef4444;font-size:.72rem;margin-top:.3rem;">{{ $message }}</div>
                @enderror
            </div>

        </div>

        {{-- BOTONES --}}
        <div style="display:flex;gap:.75rem;padding-top:1.25rem;margin-top:.5rem;border-top:1px solid #e2e8f0;">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Registrar Observación
            </button>
            <a href="{{ route('observaciones.index') }}" class="btn-cancel-form">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>

{{-- ══ MODAL SELECCIÓN DE ESTUDIANTE ══ --}}
<div class="modal-overlay" id="modalEstudiante" onclick="cerrarModalClick(event)">
    <div class="modal-box">

        {{-- Head --}}
        <div class="modal-head">
            <h5><i class="fas fa-user-graduate me-2"></i>Seleccionar Estudiante</h5>
            <button class="modal-close" onclick="cerrarModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Búsqueda --}}
        <div class="modal-search">
            <i class="fas fa-search"></i>
            <input type="text" id="modalSearch"
                   placeholder="Buscar por nombre, apellido o DNI..."
                   oninput="filtrarEstudiantes()"
                   autocomplete="off">
        </div>

        {{-- Filtros por grado --}}
        <div class="modal-filters" id="modalFilters">
            <button class="filter-btn active" onclick="filtrarGrado('', this)">Todos</button>
            @php
                $gradosUnicos = $estudiantes->pluck('grado')->unique()->filter()->sort()->values();
            @endphp
            @foreach($gradosUnicos as $g)
                <button class="filter-btn" onclick="filtrarGrado('{{ $g }}', this)">{{ $g }}</button>
            @endforeach
        </div>

        {{-- Lista --}}
        <div class="modal-list" id="modalList">
            {{-- Se rellena con JS --}}
        </div>

        {{-- Footer --}}
        <div class="modal-foot">
            <span>Mostrando <strong id="modalCount">0</strong> estudiantes</span>
            <span><i class="fas fa-info-circle me-1"></i>Haz clic en un estudiante para seleccionarlo</span>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Datos desde Laravel ──
const todosEstudiantes = @json($estudiantesJS);
let filtroGrado   = '';
let estudianteSeleccionado = null;

// ── Inicializar con old() si existe ──
@if(old('estudiante_id'))
    const oldId = {{ old('estudiante_id') }};
    const oldEst = todosEstudiantes.find(e => e.id === oldId);
    if (oldEst) seleccionarEstudiante(oldEst, false);
@endif

// ── Abrir / cerrar modal ──
function abrirModal() {
    document.getElementById('modalEstudiante').classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('modalSearch').focus(), 100);
    renderLista(todosEstudiantes);
}

function cerrarModal() {
    document.getElementById('modalEstudiante').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('modalSearch').value = '';
    filtroGrado = '';
    // Resetear filtros activos
    document.querySelectorAll('.filter-btn').forEach((b,i) => b.classList.toggle('active', i===0));
}

function cerrarModalClick(e) {
    if (e.target === document.getElementById('modalEstudiante')) cerrarModal();
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarModal();
});

// ── Filtrar ──
function filtrarEstudiantes() {
    const q = document.getElementById('modalSearch').value.trim().toLowerCase();
    let lista = todosEstudiantes;
    if (filtroGrado) lista = lista.filter(e => e.grado === filtroGrado);
    if (q.length >= 1) {
        lista = lista.filter(e =>
            e.nombre.toLowerCase().includes(q) ||
            e.dni.toLowerCase().includes(q) ||
            e.grado.toLowerCase().includes(q)
        );
    }
    renderLista(lista);
}

function filtrarGrado(grado, btn) {
    filtroGrado = grado;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filtrarEstudiantes();
}

// ── Render lista ──
function renderLista(lista) {
    const container = document.getElementById('modalList');
    document.getElementById('modalCount').textContent = lista.length;

    if (!lista.length) {
        container.innerHTML = `
            <div class="modal-empty">
                <i class="fas fa-search"></i>
                <p style="margin:0;font-size:.83rem;">Sin resultados para tu búsqueda</p>
            </div>`;
        return;
    }

    container.innerHTML = lista.map(e => {
        const initials = e.nombre.split(' ').slice(0,2).map(n=>n[0]?.toUpperCase()||'').join('');
        const isActive = estudianteSeleccionado?.id === e.id ? 'active' : '';
        const avatar   = e.foto
            ? `<img src="${e.foto}" alt="">`
            : initials;
        return `
        <div class="modal-student-item ${isActive}" onclick="seleccionarEstudiante(${JSON.stringify(e).replace(/"/g,'&quot;')})">
            <div class="s-av">${avatar}</div>
            <div style="flex:1;min-width:0;">
                <div class="s-name">${e.nombre}</div>
                <div class="s-sub">
                    <i class="fas fa-id-card me-1" style="color:#4ec7d2;"></i>${e.dni || '—'}
                </div>
            </div>
            <span class="s-badge">
                ${e.grado} ${e.seccion}
            </span>
        </div>`;
    }).join('');
}

// ── Seleccionar ──
function seleccionarEstudiante(est, cerrar = true) {
    estudianteSeleccionado = est;

    // Actualizar input hidden
    document.getElementById('estudianteId').value = est.id;

    // Actualizar selector visual
    const selector = document.getElementById('studentSelector');
    selector.classList.add('selected');

    const icon = document.getElementById('selectorIcon');
    icon.classList.add('active');

    document.getElementById('selectorHint').style.display = 'none';

    const nameEl = document.getElementById('selectorName');
    nameEl.style.display = 'block';
    nameEl.textContent = est.nombre;

    const subEl = document.getElementById('selectorSub');
    subEl.style.display = 'block';
    subEl.innerHTML = `
        <i class="fas fa-graduation-cap me-1" style="color:#4ec7d2;"></i>${est.grado} — Sección ${est.seccion}
        &nbsp;·&nbsp;
        <i class="fas fa-id-card me-1" style="color:#4ec7d2;"></i>${est.dni || '—'}`;

    if (cerrar) cerrarModal();
}

// ── Contador caracteres ──
const textarea  = document.getElementById('descripcion');
const charCount = document.getElementById('charCount');
function updateCount() {
    const len = textarea.value.length;
    charCount.textContent = `${len} / 1000`;
    charCount.style.color = len > 900 ? '#ef4444' : len > 750 ? '#f59e0b' : '#94a3b8';
}
textarea.addEventListener('input', updateCount);
updateCount();
</script>
@endpush