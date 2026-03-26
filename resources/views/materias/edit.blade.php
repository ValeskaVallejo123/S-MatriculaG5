@extends('layouts.app')

@section('title', 'Editar Materia')
@section('page-title', 'Editar Materia')

@section('topbar-actions')
    <a href="{{ route('materias.index') }}"
       style="display:inline-flex;align-items:center;gap:.4rem;padding:.42rem 1rem;border-radius:7px;font-size:.82rem;font-weight:600;background:#fff;color:#00508f;text-decoration:none;border:1.5px solid #00508f;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.edit-wrap { font-family: 'Inter', sans-serif; max-width: 820px; margin: 0 auto; }

/* ── Card ── */
.e-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1.25rem;
}
.e-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.e-card-head i    { color: #4ec7d2; font-size: 1rem; }
.e-card-head span { color: #fff; font-weight: 700; font-size: .92rem; }
.e-card-body { padding: 1.25rem; }

/* ── Banner materia actual ── */
.e-banner {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, #f8fafc, #edf2f7);
}
.e-banner-icon {
    width: 48px; height: 48px; border-radius: 11px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
}
.e-banner-icon i { color: #fff; font-size: 1.2rem; }
.e-banner-name { font-size: 1.1rem; font-weight: 700; color: #0f172a; }
.e-banner-sub  { font-size: .78rem; color: #64748b; margin-top: .15rem; }
.e-banner-id   {
    margin-left: auto; background: rgba(0,59,115,.08);
    padding: .3rem .75rem; border-radius: 7px;
    font-size: .78rem; font-weight: 700; color: #003b73;
    white-space: nowrap;
}

/* ── Sección ── */
.e-section-title {
    font-size: .72rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: #00508f;
    padding-bottom: .5rem; margin-bottom: 1rem;
    border-bottom: 1.5px solid #e8f4f5;
    display: flex; align-items: center; gap: .4rem;
}
.e-section-title i { color: #4ec7d2; }

/* ── Form fields ── */
.e-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.e-grid.full { grid-template-columns: 1fr; }
@media(max-width:600px){ .e-grid { grid-template-columns: 1fr; } }

.e-field { display: flex; flex-direction: column; gap: .35rem; }
.e-field.span2 { grid-column: 1 / -1; }

.e-label {
    font-size: .78rem; font-weight: 600; color: #334155;
    display: flex; align-items: center; gap: .3rem;
}
.e-label .req { color: #ef4444; }

.e-input, .e-select, .e-textarea {
    padding: .45rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .83rem; color: #0f172a; outline: none;
    font-family: 'Inter', sans-serif; transition: border-color .15s, box-shadow .15s;
    background: #f8fafc;
}
.e-input:focus, .e-select:focus, .e-textarea:focus {
    border-color: #4ec7d2; background: #fff;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
}
.e-input.is-invalid, .e-select.is-invalid, .e-textarea.is-invalid {
    border-color: #ef4444;
}
.e-error { font-size: .73rem; color: #ef4444; margin-top: .15rem; }

.e-textarea { resize: vertical; min-height: 85px; }

/* Código con icono de regenerar */
.e-codigo-wrap { position: relative; }
.e-codigo-wrap .e-input {
    padding-right: 2.5rem;
    font-family: 'Courier New', monospace; font-weight: 700; color: #00508f;
    letter-spacing: .05em;
}
.e-codigo-btn {
    position: absolute; right: .4rem; top: 50%; transform: translateY(-50%);
    background: rgba(78,199,210,.15); border: none; border-radius: 6px;
    padding: .25rem .45rem; cursor: pointer; color: #00508f; font-size: .75rem;
    transition: background .15s;
}
.e-codigo-btn:hover { background: rgba(78,199,210,.3); }

/* Hint bajo el campo */
.e-hint { font-size: .72rem; color: #94a3b8; margin-top: .2rem; }

/* ── Estado toggle ── */
.e-toggle-wrap { display: flex; align-items: center; gap: .75rem; }
.e-toggle {
    width: 42px; height: 22px; border-radius: 99px;
    background: #e2e8f0; position: relative; cursor: pointer;
    border: none; transition: background .2s; flex-shrink: 0;
}
.e-toggle.on { background: linear-gradient(135deg, #4ec7d2, #00508f); }
.e-toggle::after {
    content: ''; position: absolute; top: 2px; left: 2px;
    width: 18px; height: 18px; border-radius: 50%; background: #fff;
    transition: left .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.e-toggle.on::after { left: 22px; }
.e-toggle-lbl { font-size: .82rem; font-weight: 600; color: #334155; }

/* ── Preview áreas ── */
.areas-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: .5rem; margin-top: .5rem;
}
.area-chip {
    display: flex; align-items: center; gap: .4rem;
    padding: .4rem .7rem; border-radius: 8px; cursor: pointer;
    border: 1.5px solid #e2e8f0; background: #f8fafc;
    font-size: .78rem; font-weight: 600; color: #475569;
    transition: all .15s; user-select: none;
}
.area-chip:hover  { border-color: #4ec7d2; background: #e8f8f9; color: #00508f; }
.area-chip.active { border-color: #4ec7d2; background: #e8f8f9; color: #00508f; }
.area-chip i { font-size: .8rem; }

/* ── Botones submit ── */
.e-actions {
    display: flex; gap: .75rem; padding: 1rem 1.25rem;
    border-top: 1px solid #f1f5f9; background: #fafafa;
}
.e-btn-save {
    flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .55rem 1rem; border-radius: 8px; font-size: .83rem; font-weight: 700;
    background: linear-gradient(135deg, #4ec7d2, #00508f); color: #fff;
    border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: opacity .15s;
}
.e-btn-save:hover { opacity: .88; }
.e-btn-cancel {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .55rem 1.25rem; border-radius: 8px; font-size: .83rem; font-weight: 600;
    background: #fff; color: #64748b; border: 1.5px solid #e2e8f0;
    text-decoration: none; font-family: 'Inter', sans-serif; transition: border-color .15s;
}
.e-btn-cancel:hover { border-color: #94a3b8; color: #334155; }
</style>
@endpush

@section('content')
<div class="edit-wrap">

    <form action="{{ route('materias.update', $materia) }}" method="POST" id="formEditar">
        @csrf
        @method('PUT')

        {{-- ── Card principal ── --}}
        <div class="e-card">
            <div class="e-card-head">
                <i class="fas fa-book"></i>
                <span>Editar Materia</span>
            </div>

            {{-- Banner con nombre actual --}}
            <div class="e-banner">
                <div class="e-banner-icon"><i class="fas fa-book-open"></i></div>
                <div>
                    <div class="e-banner-name">{{ $materia->nombre }}</div>
                    <div class="e-banner-sub">Codigo: <strong>{{ $materia->codigo }}</strong> &nbsp;·&nbsp; {{ ucfirst($materia->nivel) }}</div>
                </div>
                <div class="e-banner-id">ID #{{ $materia->id }}</div>
            </div>

            <div class="e-card-body">

                {{-- Seccion 1: Identificacion --}}
                <div class="e-section-title">
                    <i class="fas fa-id-card"></i> Identificacion
                </div>

                <div class="e-grid" style="margin-bottom:1.25rem;">

                    {{-- Nivel --}}
                    <div class="e-field">
                        <label class="e-label">Nivel Educativo <span class="req">*</span></label>
                        <select name="nivel" class="e-select @error('nivel') is-invalid @enderror" id="selNivel" required>
                            <option value="">Seleccione...</option>
                            <option value="primaria"   {{ old('nivel', $materia->nivel) == 'primaria'   ? 'selected' : '' }}>Primaria (1° - 6°)</option>
                            <option value="secundaria" {{ old('nivel', $materia->nivel) == 'secundaria' ? 'selected' : '' }}>Secundaria (7° - 9°)</option>
                        </select>
                        @error('nivel')<div class="e-error">{{ $message }}</div>@enderror
                        <span class="e-hint">El nivel determina las areas disponibles</span>
                    </div>

                    {{-- Nombre --}}
                    <div class="e-field">
                        <label class="e-label">Nombre de la Materia <span class="req">*</span></label>
                        <input type="text" name="nombre" id="inpNombre"
                               value="{{ old('nombre', $materia->nombre) }}"
                               class="e-input @error('nombre') is-invalid @enderror"
                               placeholder="Ej: Matematicas" required>
                        @error('nombre')<div class="e-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Codigo --}}
                    <div class="e-field">
                        <label class="e-label">Codigo <span class="req">*</span></label>
                        <div class="e-codigo-wrap">
                            <input type="text" name="codigo" id="inpCodigo"
                                   value="{{ old('codigo', $materia->codigo) }}"
                                   class="e-input @error('codigo') is-invalid @enderror"
                                   placeholder="Ej: MAT-P1" required>
                            <button type="button" class="e-codigo-btn" onclick="generarCodigo()" title="Regenerar codigo">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        @error('codigo')<div class="e-error">{{ $message }}</div>@enderror
                        <span class="e-hint">Click en <i class="fas fa-sync-alt"></i> para regenerar automaticamente</span>
                    </div>

                    {{-- Estado --}}
                    <div class="e-field">
                        <label class="e-label">Estado</label>
                        <div class="e-toggle-wrap" style="margin-top:.25rem;">
                            <button type="button" class="e-toggle {{ old('activo', $materia->activo) ? 'on' : '' }}"
                                    id="toggleActivo" onclick="toggleEstado()"></button>
                            <span class="e-toggle-lbl" id="toggleLbl">
                                {{ old('activo', $materia->activo) ? 'Activa' : 'Inactiva' }}
                            </span>
                            <input type="hidden" name="activo" id="hidActivo"
                                   value="{{ old('activo', $materia->activo) ? '1' : '0' }}">
                        </div>
                        <span class="e-hint">Las materias inactivas no aparecen en asignaciones</span>
                    </div>

                </div>

                {{-- Seccion 2: Area --}}
                <div class="e-section-title">
                    <i class="fas fa-shapes"></i> Area de Conocimiento <span class="req" style="font-size:.7rem;margin-left:.2rem;">*</span>
                </div>

                <input type="hidden" name="area" id="hidArea" value="{{ old('area', $materia->area) }}">
                @error('area')<div class="e-error" style="margin-bottom:.5rem;">{{ $message }}</div>@enderror

                <div class="areas-grid" id="areasGrid">
                    {{-- Se llena con JS --}}
                </div>

                {{-- Seccion 3: Descripcion --}}
                <div class="e-section-title" style="margin-top:1.25rem;">
                    <i class="fas fa-align-left"></i> Descripcion
                </div>

                <div class="e-field">
                    <textarea name="descripcion" class="e-textarea @error('descripcion') is-invalid @enderror"
                              placeholder="Descripcion breve de los objetivos de la materia...">{{ old('descripcion', $materia->descripcion) }}</textarea>
                    @error('descripcion')<div class="e-error">{{ $message }}</div>@enderror
                </div>

            </div>

            {{-- Botones --}}
            <div class="e-actions">
                <button type="submit" class="e-btn-save">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('materias.index') }}" class="e-btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
const AREAS = {
    primaria: [
        { val: 'Español',              icon: 'fas fa-language',      color: '#fdf4ff', border: '#d8b4fe', text: '#7e22ce' },
        { val: 'Matemáticas',          icon: 'fas fa-calculator',    color: '#fff7ed', border: '#fdba74', text: '#c2410c' },
        { val: 'Ciencias Naturales',   icon: 'fas fa-leaf',          color: '#ecfdf5', border: '#6ee7b7', text: '#065f46' },
        { val: 'Ciencias Sociales',    icon: 'fas fa-globe-americas',color: '#eff6ff', border: '#93c5fd', text: '#1e40af' },
        { val: 'Educación Física',     icon: 'fas fa-running',       color: '#fef9c3', border: '#fde047', text: '#854d0e' },
        { val: 'Educación Artística',  icon: 'fas fa-palette',       color: '#fce7f3', border: '#f9a8d4', text: '#9d174d' },
        { val: 'Inglés',               icon: 'fas fa-comments',      color: '#f0fdfa', border: '#5eead4', text: '#134e4a' },
        { val: 'Informática',          icon: 'fas fa-laptop-code',   color: '#f5f3ff', border: '#c4b5fd', text: '#4c1d95' },
    ],
    secundaria: [
        { val: 'Español',              icon: 'fas fa-language',      color: '#fdf4ff', border: '#d8b4fe', text: '#7e22ce' },
        { val: 'Matemáticas',          icon: 'fas fa-calculator',    color: '#fff7ed', border: '#fdba74', text: '#c2410c' },
        { val: 'Ciencias Naturales',   icon: 'fas fa-leaf',          color: '#ecfdf5', border: '#6ee7b7', text: '#065f46' },
        { val: 'Ciencias Sociales',    icon: 'fas fa-globe-americas',color: '#eff6ff', border: '#93c5fd', text: '#1e40af' },
        { val: 'Educación Física',     icon: 'fas fa-running',       color: '#fef9c3', border: '#fde047', text: '#854d0e' },
        { val: 'Educación Artística',  icon: 'fas fa-palette',       color: '#fce7f3', border: '#f9a8d4', text: '#9d174d' },
        { val: 'Inglés',               icon: 'fas fa-comments',      color: '#f0fdfa', border: '#5eead4', text: '#134e4a' },
        { val: 'Informática',          icon: 'fas fa-laptop-code',   color: '#f5f3ff', border: '#c4b5fd', text: '#4c1d95' },
        { val: 'Química',              icon: 'fas fa-flask',         color: '#fef2f2', border: '#fca5a5', text: '#991b1b' },
        { val: 'Física',               icon: 'fas fa-atom',          color: '#ecfeff', border: '#67e8f9', text: '#164e63' },
        { val: 'Biología',             icon: 'fas fa-dna',           color: '#f0fdf4', border: '#86efac', text: '#14532d' },
        { val: 'Historia',             icon: 'fas fa-landmark',      color: '#fffbeb', border: '#fcd34d', text: '#78350f' },
        { val: 'Geografía',            icon: 'fas fa-map-marked-alt',color: '#f0f9ff', border: '#7dd3fc', text: '#0c4a6e' },
        { val: 'Formación Ciudadana',  icon: 'fas fa-balance-scale', color: '#f8fafc', border: '#94a3b8', text: '#1e293b' },
    ]
};

// Prefijos para generación de código
const PREFIJOS = {
    'Español':             'ESP',
    'Matemáticas':         'MAT',
    'Ciencias Naturales':  'CNT',
    'Ciencias Sociales':   'CSO',
    'Educación Física':    'EFI',
    'Educación Artística': 'EAR',
    'Inglés':              'ING',
    'Informática':         'INF',
    'Química':             'QUI',
    'Física':              'FIS',
    'Biología':            'BIO',
    'Historia':            'HIS',
    'Geografía':           'GEO',
    'Formación Ciudadana': 'FOR',
};

let areaSeleccionada = document.getElementById('hidArea').value;

function renderAreas() {
    const nivel  = document.getElementById('selNivel').value;
    const grid   = document.getElementById('areasGrid');
    const areas  = AREAS[nivel] || [];
    grid.innerHTML = '';

    if (!nivel) {
        grid.innerHTML = '<p style="color:#94a3b8;font-size:.8rem;grid-column:1/-1;">Selecciona un nivel para ver las areas disponibles.</p>';
        return;
    }

    areas.forEach(a => {
        const active = a.val === areaSeleccionada ? 'active' : '';
        const chip = document.createElement('div');
        chip.className = 'area-chip ' + active;
        chip.dataset.val = a.val;
        if (active) {
            chip.style.background    = a.color;
            chip.style.borderColor   = a.border;
            chip.style.color         = a.text;
        }
        chip.innerHTML = `<i class="${a.icon}"></i> ${a.val}`;
        chip.addEventListener('click', () => seleccionarArea(a, chip));
        grid.appendChild(chip);
    });
}

function seleccionarArea(area, chipEl) {
    document.querySelectorAll('.area-chip').forEach(c => {
        c.classList.remove('active');
        c.style.background  = '';
        c.style.borderColor = '';
        c.style.color       = '';
    });
    chipEl.classList.add('active');
    chipEl.style.background  = area.color;
    chipEl.style.borderColor = area.border;
    chipEl.style.color       = area.text;
    areaSeleccionada = area.val;
    document.getElementById('hidArea').value = area.val;
    generarCodigo();
}

function generarCodigo() {
    const nivel  = document.getElementById('selNivel').value;
    const area   = document.getElementById('hidArea').value;
    const sufijo = nivel === 'primaria' ? 'P' : 'S';
    const pref   = PREFIJOS[area] || area.substring(0,3).toUpperCase();
    const num    = Math.floor(Math.random() * 90) + 10;
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

// Init
document.getElementById('selNivel').addEventListener('change', function() {
    areaSeleccionada = '';
    document.getElementById('hidArea').value = '';
    renderAreas();
});

renderAreas();
</script>
@endpush