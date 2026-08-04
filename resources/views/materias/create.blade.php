@extends('layouts.app')

@section('title', 'Nueva Materia')
@section('page-title', 'Nueva Materia')

@push('styles')
<style>
:root {
    --c-primary: #00508f;
    --c-teal:    #4ec7d2;
    --c-border:  #e2e8f0;
    --c-surface: #f8fafc;
    --c-text:    #0f172a;
    --c-muted:   #64748b;
    --c-error:   #ef4444;
}

/* Sin max-width — ocupa todo el contenedor */
.form-wrap { width: 100%; }

.form-card {
    background: white;
    border: 1.5px solid var(--c-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
}

.form-card-head {
    background: linear-gradient(135deg, #003b73 0%, #00508f 100%);
    padding: 1.25rem 1.5rem;
    display: flex; align-items: center; gap: .75rem;
}
.form-card-head i    { color: var(--c-teal); font-size: 1.1rem; }
.form-card-head span { color: white; font-weight: 700; font-size: 1rem; }

.form-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; }

/* Nivel: 2 columnas grandes a ancho completo */
.nivel-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .75rem;
}
.nivel-btn {
    padding: 1rem;
    border: 2px solid var(--c-border);
    border-radius: 12px;
    background: var(--c-surface);
    cursor: pointer;
    text-align: center;
    transition: all .2s;
    display: flex; flex-direction: column; align-items: center; gap: .5rem;
}
.nivel-btn i        { font-size: 1.5rem; color: var(--c-muted); transition: color .2s; }
.nivel-btn span     { font-size: .85rem; font-weight: 700; color: var(--c-muted); transition: color .2s; }
.nivel-btn small    { font-size: .72rem; color: #94a3b8; }
.nivel-btn.active   { border-color: var(--c-teal); background: rgba(78,199,210,.06); }
.nivel-btn.active i    { color: var(--c-primary); }
.nivel-btn.active span { color: var(--c-primary); }
.nivel-btn:hover:not(.active) { border-color: #94a3b8; }

.f-group { display: flex; flex-direction: column; gap: .4rem; }
.f-label {
    font-size: .78rem; font-weight: 700; color: #334155;
    display: flex; align-items: center; gap: .3rem;
}
.f-label .req { color: var(--c-error); }
.f-input, .f-textarea {
    padding: .55rem .85rem;
    border: 1.5px solid var(--c-border);
    border-radius: 9px;
    font-size: .875rem;
    color: var(--c-text);
    background: var(--c-surface);
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    width: 100%;
}
.f-input:focus, .f-textarea:focus {
    border-color: var(--c-teal);
    background: white;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
}
.f-input.is-invalid { border-color: var(--c-error); }
.f-error { font-size: .73rem; color: var(--c-error); }
.f-textarea { resize: vertical; min-height: 80px; }

/* 3 columnas para datos a ancho completo */
.f-grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
@media(max-width:700px) { .f-grid3 { grid-template-columns: 1fr 1fr; } }
@media(max-width:480px) { .f-grid3 { grid-template-columns: 1fr; } }

/* Áreas: más columnas disponibles con ancho completo */
.areas-wrap {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: .5rem;
}
.area-chip {
    padding: .45rem .7rem;
    border: 1.5px solid var(--c-border);
    border-radius: 8px;
    background: var(--c-surface);
    cursor: pointer;
    font-size: .78rem;
    font-weight: 600;
    color: var(--c-muted);
    display: flex; align-items: center; gap: .35rem;
    transition: all .15s;
    user-select: none;
}
.area-chip:hover  { border-color: var(--c-teal); color: var(--c-primary); background: rgba(78,199,210,.05); }
.area-chip.active { border-color: var(--c-teal); color: var(--c-primary); background: rgba(78,199,210,.08); font-weight: 700; }
.area-chip i      { font-size: .78rem; }

.toggle-row { display: flex; align-items: center; gap: .75rem; }
.toggle-switch {
    width: 40px; height: 22px;
    border-radius: 99px;
    background: #e2e8f0;
    border: none;
    position: relative;
    cursor: pointer;
    flex-shrink: 0;
    transition: background .2s;
}
.toggle-switch.on { background: linear-gradient(135deg, var(--c-teal), var(--c-primary)); }
.toggle-switch::after {
    content: '';
    position: absolute;
    top: 2px; left: 2px;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: white;
    transition: left .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch.on::after { left: 20px; }
.toggle-label { font-size: .83rem; font-weight: 600; color: #334155; }

.form-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--c-border);
    background: var(--c-surface);
    display: flex; gap: .75rem; justify-content: space-between;
}
.btn-save {
    flex: 1;
    padding: .6rem 1rem;
    background: linear-gradient(135deg, var(--c-teal), var(--c-primary));
    color: white;
    border: none;
    border-radius: 9px;
    font-size: .875rem;
    font-weight: 700;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    transition: opacity .15s;
}
.btn-save:hover { opacity: .88; }
.btn-cancel {
    padding: .6rem 1.25rem;
    background: white;
    color: var(--c-muted);
    border: 1.5px solid var(--c-border);
    border-radius: 9px;
    font-size: .875rem;
    font-weight: 600;
    text-decoration: none;
    display: flex; align-items: center; gap: .4rem;
    transition: border-color .15s;
}
.btn-cancel:hover { border-color: #94a3b8; color: #334155; }

.f-divider {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--c-teal);
    display: flex; align-items: center; gap: .5rem;
    margin-bottom: .5rem;
}
.f-divider::after {
    content: ''; flex: 1; height: 1px; background: rgba(78,199,210,.2);
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="form-wrap">
<form action="{{ route('materias.store') }}" method="POST">
@csrf

<div class="form-card">
    <div class="form-card-head">
        <i class="fas fa-book-open"></i>
        <span>Nueva Materia</span>
    </div>

    <div class="form-body">

        {{-- PASO 1: Nivel --}}
        <div class="f-group">
            <div class="f-divider"><i class="fas fa-layer-group"></i> Nivel educativo</div>
            <div class="nivel-selector">
                <div class="nivel-btn {{ old('nivel') == 'primaria' ? 'active' : '' }}"
                     onclick="seleccionarNivel('primaria', this)">
                    <i class="fas fa-child"></i>
                    <span>Primaria</span>
                    <small>1° — 6° grado</small>
                </div>
                <div class="nivel-btn {{ old('nivel') == 'secundaria' ? 'active' : '' }}"
                     onclick="seleccionarNivel('secundaria', this)">
                    <i class="fas fa-user-graduate"></i>
                    <span>Secundaria</span>
                    <small>7° — 9° grado</small>
                </div>
            </div>
            <input type="hidden" name="nivel" id="hidNivel" value="{{ old('nivel') }}">
            @error('nivel')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        {{-- PASO 2: Área --}}
        <div class="f-group" id="seccionArea" style="{{ old('nivel') ? '' : 'display:none' }}">
            <div class="f-divider"><i class="fas fa-shapes"></i> Área de conocimiento</div>
            <div class="areas-wrap" id="areasGrid"></div>
            <input type="hidden" name="area" id="hidArea" value="{{ old('area') }}">
            @error('area')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        {{-- PASO 3: Datos — grid de 3 columnas --}}
        <div class="f-group" id="seccionDatos" style="{{ old('nivel') ? '' : 'display:none' }}">
            <div class="f-divider"><i class="fas fa-pen"></i> Datos de la materia</div>

            <div class="f-grid3">
                {{-- Nombre --}}
                <div class="f-group">
                    <label class="f-label">Nombre <span class="req">*</span></label>
                    <input type="text" name="nombre" id="inpNombre"
                           value="{{ old('nombre') }}"
                           class="f-input @error('nombre') is-invalid @enderror"
                           placeholder="Ej: Matemáticas" required>
                    @error('nombre')<div class="f-error">{{ $message }}</div>@enderror
                </div>

                {{-- Código --}}
                <div class="f-group">
                    <label class="f-label">Código <span class="req">*</span></label>
                    <div style="position:relative;">
                        <input type="text" name="codigo" id="inpCodigo"
                               value="{{ old('codigo') }}"
                               class="f-input @error('codigo') is-invalid @enderror"
                               placeholder="Ej: MAT-P01" required
                               style="padding-right:2.5rem;">
                        <button type="button" onclick="generarCodigo()"
                                style="position:absolute;right:.4rem;top:50%;transform:translateY(-50%);
                                       background:rgba(78,199,210,.15);border:none;border-radius:6px;
                                       padding:.25rem .45rem;cursor:pointer;color:var(--c-primary);font-size:.75rem;"
                                title="Generar código automático">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    @error('codigo')<div class="f-error">{{ $message }}</div>@enderror
                </div>

                {{-- Estado --}}
                <div class="f-group">
                    <label class="f-label">Estado</label>
                    <div class="toggle-row" style="height:calc(100% - 1.4rem); align-items:center;">
                        <button type="button" class="toggle-switch on"
                                id="toggleActivo" onclick="toggleEstado()"></button>
                        <span class="toggle-label" id="toggleLbl">Activa</span>
                        <input type="hidden" name="activo" id="hidActivo" value="1">
                    </div>
                </div>
            </div>

            {{-- Descripción ocupa todo el ancho --}}
            <div class="f-group" style="margin-top:.25rem;">
                <label class="f-label">
                    Descripción
                    <span style="font-weight:400;color:#94a3b8;">(opcional)</span>
                </label>
                <textarea name="descripcion"
                          class="f-textarea @error('descripcion') is-invalid @enderror"
                          placeholder="Breve descripción de los objetivos de la materia...">{{ old('descripcion') }}</textarea>
                @error('descripcion')<div class="f-error">{{ $message }}</div>@enderror
            </div>
        </div>

    </div>

    <div class="form-footer">
        <a href="{{ route('materias.index') }}" class="btn-cancel">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" class="btn-save">
            <i class="fas fa-save"></i> Guardar Materia
        </button>
    </div>
</div>

</form>
</div>
</div>
@endsection

@push('scripts')
<script>
const AREAS = {
    primaria: [
        { val: 'Español',             icon: 'fas fa-language' },
        { val: 'Matemáticas',         icon: 'fas fa-calculator' },
        { val: 'Ciencias Naturales',  icon: 'fas fa-leaf' },
        { val: 'Ciencias Sociales',   icon: 'fas fa-globe-americas' },
        { val: 'Educación Física',    icon: 'fas fa-running' },
        { val: 'Educación Artística', icon: 'fas fa-palette' },
        { val: 'Inglés',              icon: 'fas fa-comments' },
        { val: 'Informática',         icon: 'fas fa-laptop-code' },
    ],
    secundaria: [
        { val: 'Español',             icon: 'fas fa-language' },
        { val: 'Matemáticas',         icon: 'fas fa-calculator' },
        { val: 'Ciencias Naturales',  icon: 'fas fa-leaf' },
        { val: 'Ciencias Sociales',   icon: 'fas fa-globe-americas' },
        { val: 'Educación Física',    icon: 'fas fa-running' },
        { val: 'Educación Artística', icon: 'fas fa-palette' },
        { val: 'Inglés',              icon: 'fas fa-comments' },
        { val: 'Informática',         icon: 'fas fa-laptop-code' },
        { val: 'Química',             icon: 'fas fa-flask' },
        { val: 'Física',              icon: 'fas fa-atom' },
        { val: 'Biología',            icon: 'fas fa-dna' },
        { val: 'Historia',            icon: 'fas fa-landmark' },
        { val: 'Geografía',           icon: 'fas fa-map-marked-alt' },
        { val: 'Formación Ciudadana', icon: 'fas fa-balance-scale' },
    ]
};

const PREFIJOS = {
    'Español':'ESP','Matemáticas':'MAT','Ciencias Naturales':'CNT',
    'Ciencias Sociales':'CSO','Educación Física':'EFI','Educación Artística':'EAR',
    'Inglés':'ING','Informática':'INF','Química':'QUI','Física':'FIS',
    'Biología':'BIO','Historia':'HIS','Geografía':'GEO','Formación Ciudadana':'FOR',
};

let nivelActual  = document.getElementById('hidNivel').value;
let areaActual   = document.getElementById('hidArea').value;
let nombreManual = '{{ old("nombre") }}' !== '';

document.getElementById('inpNombre').addEventListener('input', function () {
    nombreManual = this.value.trim() !== '';
});

if (nivelActual) renderAreas();

function seleccionarNivel(nivel, el) {
    document.querySelectorAll('.nivel-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    nivelActual = nivel;
    document.getElementById('hidNivel').value = nivel;

    areaActual   = '';
    nombreManual = false;
    document.getElementById('hidArea').value   = '';
    document.getElementById('inpNombre').value = '';
    document.getElementById('inpCodigo').value = '';

    document.getElementById('seccionArea').style.display  = '';
    document.getElementById('seccionDatos').style.display = '';
    renderAreas();
}

function renderAreas() {
    const grid  = document.getElementById('areasGrid');
    const areas = AREAS[nivelActual] || [];
    grid.innerHTML = '';
    areas.forEach(a => {
        const chip     = document.createElement('div');
        chip.className = 'area-chip' + (a.val === areaActual ? ' active' : '');
        chip.innerHTML = `<i class="${a.icon}"></i> ${a.val}`;
        chip.onclick   = () => seleccionarArea(a.val, chip);
        grid.appendChild(chip);
    });
}

function seleccionarArea(area, el) {
    document.querySelectorAll('.area-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');

    areaActual = area;
    document.getElementById('hidArea').value = area;

    if (!nombreManual) {
        document.getElementById('inpNombre').value = area;
    }

    generarCodigo();
}

function generarCodigo() {
    if (!nivelActual || !areaActual) return;
    const sufijo = nivelActual === 'primaria' ? 'P' : 'S';
    const pref   = PREFIJOS[areaActual] || areaActual.substring(0, 3).toUpperCase();
    const num    = String(Math.floor(Math.random() * 90) + 10);
    document.getElementById('inpCodigo').value = `${pref}-${sufijo}${num}`;
}

function toggleEstado() {
    const btn = document.getElementById('toggleActivo');
    const lbl = document.getElementById('toggleLbl');
    const hid = document.getElementById('hidActivo');
    const on  = btn.classList.toggle('on');
    lbl.textContent = on ? 'Activa' : 'Inactiva';
    hid.value = on ? '1' : '0';
}
</script>
@endpush