@extends('layouts.app')

@section('title', 'Crear Observación')
@section('page-title', 'Nueva Observación')

@push('styles')
<style>
:root {
    --blue-dark: #003b73; --blue-mid: #00508f;
    --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
    --border: #e8edf4; --surface: #f5f8fc;
    --text-main: #0d2137; --text-muted: #6b7a90;
    --radius-lg: 14px; --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
}

.obs-header {
    background: linear-gradient(135deg, var(--blue-mid), var(--blue-dark));
    border-radius: var(--radius-lg); padding: 1.25rem 1.5rem;
    display: flex; align-items: center; gap: 1rem;
    margin-bottom: 1.5rem; box-shadow: 0 4px 14px rgba(0,59,115,.18);
}
.obs-header-icon {
    width:50px; height:50px; background:rgba(78,199,210,.25);
    border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.obs-header h5 { color:#fff; font-weight:700; margin:0 0 .2rem; font-size:1.1rem; }
.obs-header p  { color:rgba(255,255,255,.7); margin:0; font-size:.82rem; }

.obs-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;
}
@media(max-width:900px){ .obs-grid { grid-template-columns: 1fr; } }

.obs-card {
    background: white; border: 1px solid var(--border);
    border-radius: var(--radius-lg); overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.obs-card-head {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    padding: .75rem 1.1rem; display: flex; align-items: center; gap: .5rem;
}
.obs-card-head i    { color: var(--teal); font-size: .9rem; }
.obs-card-head span { color: white; font-weight: 700; font-size: .88rem; }
.obs-card-body { padding: 1.1rem; }

.field-label {
    display: block; font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: var(--blue-dark); margin-bottom: .35rem;
}
.field-input {
    width: 100%; border: 2px solid #bfd9ea; border-radius: 8px;
    padding: .52rem .9rem; font-size: .88rem; color: var(--text-main);
    background: white; outline: none; transition: border .15s; font-family: inherit;
}
.field-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.12); }

/* ── Buscador de estudiante ── */
.est-search-box { position: relative; margin-bottom: .6rem; }
.est-search-box i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--blue-mid); font-size: .85rem; pointer-events: none;
}
.est-search-input {
    width: 100%; border: 2px solid #bfd9ea; border-radius: 8px;
    padding: .52rem 1rem .52rem 2.4rem; font-size: .88rem;
    color: var(--text-main); background: white; outline: none;
    transition: border .15s; font-family: inherit;
}
.est-search-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.12); }

/* ── Lista ── */
.est-list {
    border: 1.5px solid var(--border); border-radius: 9px;
    max-height: 300px; overflow-y: auto; background: white;
}
.est-list::-webkit-scrollbar { width: 4px; }
.est-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

.est-item {
    display: flex; align-items: center; gap: .85rem;
    padding: .65rem .9rem; cursor: pointer;
    border-bottom: 1px solid #f1f5f9; transition: background .12s;
}
.est-item:last-child { border-bottom: none; }
.est-item:hover { background: rgba(78,199,210,.07); }
.est-item.selected {
    background: rgba(78,199,210,.12);
    border-left: 3px solid var(--teal);
    padding-left: calc(.9rem - 3px);
}

.est-av {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 800; font-size: .85rem; overflow: hidden;
}
.est-av img { width: 100%; height: 100%; object-fit: cover; }
.est-item-name { font-weight: 600; color: var(--blue-dark); font-size: .84rem; }
.est-item-sub  { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }
.est-item-badge {
    margin-left: auto; flex-shrink: 0; padding: .18rem .55rem; border-radius: 999px;
    font-size: .67rem; font-weight: 700;
    background: var(--teal-light); color: var(--blue-mid);
    border: 1px solid rgba(78,199,210,.3);
}

/* ── Barra de seleccionado ── */
.est-selected-bar {
    display: none; align-items: center; gap: .75rem;
    background: rgba(78,199,210,.1); border: 1.5px solid var(--teal);
    border-radius: 8px; padding: .65rem .9rem; margin-bottom: .6rem;
}
.est-selected-bar.show { display: flex; }
.est-selected-av {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 800; font-size: .82rem;
}
.est-selected-name { font-weight: 700; color: var(--blue-dark); font-size: .85rem; }
.est-selected-sub  { font-size: .72rem; color: var(--text-muted); }
.est-clear-btn {
    margin-left: auto; width: 26px; height: 26px; border-radius: 6px;
    border: 1.5px solid #ef4444; color: #ef4444; background: white;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .72rem; transition: all .15s; flex-shrink: 0;
}
.est-clear-btn:hover { background: #ef4444; color: white; }

.est-counter { font-size: .72rem; color: var(--text-muted); margin-bottom: .4rem; }

.est-empty-msg {
    text-align: center; padding: 2rem 1rem;
    color: var(--text-muted); font-size: .83rem;
}
.est-empty-msg i { font-size: 1.5rem; color: #cbd5e1; display: block; margin-bottom: .5rem; }

/* ── Tipo radio ── */
.tipo-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: .5rem; }
.tipo-radio { display: none; }
.tipo-label {
    display: flex; flex-direction: column; align-items: center; gap: .35rem;
    padding: .75rem .5rem; border: 2px solid var(--border); border-radius: 9px;
    cursor: pointer; transition: all .15s; background: white; text-align: center;
}
.tipo-label:hover { border-color: var(--teal); background: var(--teal-light); }
.tipo-radio:checked + .tipo-label {
    border-color: var(--teal); background: var(--teal-light);
    box-shadow: 0 0 0 3px rgba(78,199,210,.15);
}
.tipo-label i    { font-size: 1.2rem; }
.tipo-label span { font-size: .73rem; font-weight: 700; color: var(--blue-dark); }

/* ── Textarea ── */
.desc-wrap { position: relative; }
.desc-wrap > i {
    position: absolute; left: 12px; top: 13px;
    color: var(--blue-mid); font-size: .85rem; pointer-events: none;
}
.desc-input {
    width: 100%; border: 2px solid #bfd9ea; border-radius: 8px;
    padding: .65rem 1rem .65rem 2.4rem; font-size: .88rem;
    color: var(--text-main); background: white; outline: none;
    resize: none; min-height: 200px; font-family: inherit; line-height: 1.6;
    transition: border .15s;
}
.desc-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.12); }

/* ── Botones ── */
.btn-submit {
    flex: 1; padding: .7rem 1.25rem; border-radius: 9px; border: none;
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    color: white; font-weight: 700; font-size: .88rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    transition: opacity .15s; box-shadow: 0 2px 10px rgba(78,199,210,.3);
    font-family: inherit;
}
.btn-submit:hover { opacity: .88; }
.btn-cancel {
    flex: 1; padding: .7rem 1.25rem; border-radius: 9px;
    border: 2px solid var(--blue-mid); color: var(--blue-mid);
    background: white; font-weight: 700; font-size: .88rem;
    text-decoration: none; display: flex; align-items: center;
    justify-content: center; gap: .4rem; transition: background .15s;
}
.btn-cancel:hover { background: #eff6ff; color: var(--blue-mid); }
</style>
@endpush

@section('content')

<div class="obs-header">
    <div class="obs-header-icon">
        <i class="fas fa-clipboard-list" style="color:#fff;font-size:1.3rem;"></i>
    </div>
    <div>
        <h5>Registro de Observación</h5>
        <p>Complete los campos para registrar una nueva observación</p>
    </div>
</div>

<form action="{{ route('observaciones.store') }}" method="POST">
    @csrf

    @if($errors->any())
        <div style="background:rgba(239,68,68,.08);border-left:3px solid #ef4444;border-radius:8px;padding:.85rem 1rem;margin-bottom:1.25rem;">
            <ul style="margin:0;padding-left:1rem;color:#991b1b;font-size:.82rem;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="obs-grid">

        {{-- ── COLUMNA IZQUIERDA ── --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Buscar estudiante --}}
            <div class="obs-card">
                <div class="obs-card-head">
                    <i class="fas fa-user-graduate"></i>
                    <span>Seleccionar Estudiante <span style="color:#fca5a5;">*</span></span>
                </div>
                <div class="obs-card-body">

                    {{-- Barra de seleccionado --}}
                    <div class="est-selected-bar" id="selectedBar">
                        <div class="est-selected-av" id="selectedAv">—</div>
                        <div>
                            <div class="est-selected-name" id="selectedName">—</div>
                            <div class="est-selected-sub" id="selectedSub"></div>
                        </div>
                        <button type="button" class="est-clear-btn" onclick="limpiarSeleccion()" title="Quitar selección">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <input type="hidden" name="estudiante_id" id="estudianteId" value="{{ old('estudiante_id') }}">

                    {{-- Buscador ── --}}
                    <div class="est-search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="estSearch" class="est-search-input"
                               placeholder="Escribí nombre, apellido o DNI..."
                               autocomplete="off">
                    </div>

                    <div class="est-counter">
                        Mostrando <strong id="estCount">{{ $estudiantes->count() }}</strong>
                        de {{ $estudiantes->count() }} estudiantes
                    </div>

                    {{-- Lista --}}
                    <div class="est-list" id="estList">
                        @forelse($estudiantes as $est)
                        @php
                            $nombreCompleto = trim(($est->nombre1 ?? '') . ' ' . ($est->nombre2 ?? '') . ' ' . ($est->apellido1 ?? '') . ' ' . ($est->apellido2 ?? ''));
                            $inicial = strtoupper(substr($est->nombre1 ?? 'E', 0, 1));
                        @endphp
                        <div class="est-item {{ old('estudiante_id') == $est->id ? 'selected' : '' }}"
                             data-id="{{ $est->id }}"
                             data-buscar="{{ strtolower($nombreCompleto . ' ' . ($est->dni ?? '') . ' ' . ($est->grado ?? '')) }}"
                             data-display="{{ $nombreCompleto }}"
                             data-inicial="{{ $inicial }}"
                             data-grado="{{ $est->grado ?? '' }}"
                             data-seccion="{{ $est->seccion ?? '' }}"
                             data-dni="{{ $est->dni ?? '' }}"
                             onclick="seleccionarEst(this)">
                            <div class="est-av">
                                @if($est->foto)
                                    <img src="{{ asset('storage/' . $est->foto) }}" alt="">
                                @else
                                    {{ $inicial }}
                                @endif
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div class="est-item-name">{{ $nombreCompleto }}</div>
                                <div class="est-item-sub">
                                    <i class="fas fa-id-card" style="color:var(--teal);font-size:.6rem;"></i>
                                    {{ $est->dni ?? '—' }}
                                </div>
                            </div>
                            <span class="est-item-badge">
                                {{ $est->grado ?? '—' }}{{ $est->seccion ? ' ' . $est->seccion : '' }}
                            </span>
                        </div>
                        @empty
                        <div class="est-empty-msg">
                            <i class="fas fa-users"></i>
                            No hay estudiantes registrados
                        </div>
                        @endforelse
                    </div>

                    @error('estudiante_id')
                        <div style="color:#ef4444;font-size:.72rem;margin-top:.4rem;">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Tipo --}}
            <div class="obs-card">
                <div class="obs-card-head">
                    <i class="fas fa-tags"></i>
                    <span>Tipo de Observación <span style="color:#fca5a5;">*</span></span>
                </div>
                <div class="obs-card-body">
                    <div class="tipo-grid">
                        @foreach([
                            ['value'=>'academica',  'label'=>'Académica',  'icon'=>'fa-book',        'color'=>'#2196f3'],
                            ['value'=>'conductual', 'label'=>'Conductual', 'icon'=>'fa-user-shield', 'color'=>'#ef4444'],
                            ['value'=>'salud',      'label'=>'Salud',      'icon'=>'fa-heartbeat',   'color'=>'#4caf50'],
                            ['value'=>'otro',       'label'=>'Otro',       'icon'=>'fa-ellipsis-h',  'color'=>'#9e9e9e'],
                        ] as $t)
                        <div>
                            <input type="radio" class="tipo-radio" name="tipo"
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
                        <div style="color:#ef4444;font-size:.72rem;margin-top:.4rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Profesor (solo admin) --}}
            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
            <div class="obs-card">
                <div class="obs-card-head">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Profesor (opcional)</span>
                </div>
                <div class="obs-card-body">
                    <div style="position:relative;">
                        <i class="fas fa-chalkboard" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--blue-mid);font-size:.85rem;pointer-events:none;"></i>
                        <select name="profesor_id" class="field-input" style="padding-left:2.4rem;">
                            <option value="">Sin asignar</option>
                            @foreach($profesores as $prof)
                                <option value="{{ $prof->id }}" {{ old('profesor_id') == $prof->id ? 'selected' : '' }}>
                                    {{ $prof->nombreCompleto }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- ── COLUMNA DERECHA — Descripción ── --}}
        <div>
            <div class="obs-card" style="height:100%;">
                <div class="obs-card-head">
                    <i class="fas fa-file-alt"></i>
                    <span>Descripción <span style="color:#fca5a5;">*</span></span>
                </div>
                <div class="obs-card-body" style="display:flex;flex-direction:column;height:calc(100% - 44px);">
                    <div class="desc-wrap" style="flex:1;display:flex;flex-direction:column;">
                        <i class="fas fa-pen"></i>
                        <textarea name="descripcion" id="descripcion"
                                  class="desc-input"
                                  style="flex:1;min-height:420px;"
                                  maxlength="1000"
                                  placeholder="Describe con detalle la observación...">{{ old('descripcion') }}</textarea>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:.4rem;">
                        <span style="font-size:.72rem;color:var(--text-muted);">Máximo 1000 caracteres</span>
                        <span id="charCount" style="font-size:.72rem;color:var(--text-muted);">0 / 1000</span>
                    </div>
                    @error('descripcion')
                        <div style="color:#ef4444;font-size:.72rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    {{-- Botones --}}
    <div style="display:flex;gap:.75rem;padding-top:1.25rem;margin-top:1.25rem;border-top:1px solid var(--border);">
        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Registrar Observación
        </button>
        <a href="{{ route('observaciones.index') }}" class="btn-cancel">
            <i class="fas fa-times"></i> Cancelar
        </a>
    </div>

</form>

@endsection

@push('scripts')
<script>
(function() {
    var estSearch   = document.getElementById('estSearch');
    var estList     = document.getElementById('estList');
    var estCount    = document.getElementById('estCount');
    var estIdInput  = document.getElementById('estudianteId');
    var selectedBar = document.getElementById('selectedBar');

    // ── Búsqueda en tiempo real ──
    estSearch.addEventListener('input', function() {
        var q = this.value.trim().toLowerCase();
        var items = estList.querySelectorAll('.est-item');
        var visible = 0;

        items.forEach(function(item) {
            var match = !q || (item.dataset.buscar || '').includes(q);
            item.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        estCount.textContent = visible;

        // Mensaje sin resultados
        var emptyMsg = estList.querySelector('.est-no-results');
        if (visible === 0 && q) {
            if (!emptyMsg) {
                emptyMsg = document.createElement('div');
                emptyMsg.className = 'est-empty-msg est-no-results';
                emptyMsg.innerHTML = '<i class="fas fa-search"></i>Sin resultados para "' + q + '"';
                estList.appendChild(emptyMsg);
            }
        } else {
            if (emptyMsg) emptyMsg.remove();
        }
    });

    // ── Seleccionar estudiante ──
    window.seleccionarEst = function(el) {
        // Quitar selección anterior
        estList.querySelectorAll('.est-item').forEach(function(i) {
            i.classList.remove('selected');
        });
        el.classList.add('selected');

        // Guardar ID
        estIdInput.value = el.dataset.id;

        // Mostrar barra
        document.getElementById('selectedAv').textContent   = el.dataset.inicial || '?';
        document.getElementById('selectedName').textContent = el.dataset.display  || '—';
        document.getElementById('selectedSub').innerHTML    =
            '<i class="fas fa-graduation-cap" style="color:#4ec7d2;font-size:.65rem;margin-right:.3rem;"></i>' +
            (el.dataset.grado || '—') + ' — Sección ' + (el.dataset.seccion || '—');
        selectedBar.classList.add('show');
    };

    // ── Limpiar selección ──
    window.limpiarSeleccion = function() {
        estIdInput.value = '';
        selectedBar.classList.remove('show');
        estList.querySelectorAll('.est-item').forEach(function(i) {
            i.classList.remove('selected');
        });
        estSearch.value = '';
        estSearch.dispatchEvent(new Event('input'));
        estSearch.focus();
    };

    // ── Restaurar selección si hay old() ──
    var oldId = '{{ old('estudiante_id') }}';
    if (oldId) {
        var oldItem = estList.querySelector('[data-id="' + oldId + '"]');
        if (oldItem) seleccionarEst(oldItem);
    }

    // ── Contador de caracteres ──
    var textarea  = document.getElementById('descripcion');
    var charCount = document.getElementById('charCount');
    textarea.addEventListener('input', function() {
        var len = this.value.length;
        charCount.textContent = len + ' / 1000';
        charCount.style.color = len > 900 ? '#ef4444' : len > 750 ? '#f59e0b' : '#94a3b8';
    });
    // Inicializar contador
    textarea.dispatchEvent(new Event('input'));
})();
</script>
@endpush