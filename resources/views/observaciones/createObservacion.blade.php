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

@section('content')
{{-- Sin container — el content-wrapper del layout ya provee el padding lateral --}}

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 52px; height: 52px; background: rgba(78,199,210,0.3); border-radius: 12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-clipboard-list text-white" style="font-size: 1.4rem;"></i>
                </div>
                <div class="text-white">
                    <h5 class="mb-0 fw-bold" style="font-size: 1.2rem;">Registro de Observacion</h5>
                    <p class="mb-0 opacity-75" style="font-size: 0.85rem;">Complete los campos para registrar una nueva observacion</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-5">
            <form action="{{ route('observaciones.store') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert border-0 mb-4" style="background: rgba(239,68,68,0.08); border-left: 3px solid #ef4444 !important; border-radius: 8px;">
                        <ul class="mb-0 small" style="color: #991b1b;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-5">

                    {{-- ── COLUMNA IZQUIERDA ── --}}
                    <div class="col-lg-6">

                        {{-- ESTUDIANTE live search --}}
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #4ec7d2, #00508f); border-radius: 9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-user-graduate" style="color:white; font-size:0.9rem;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color:#003b73; font-size:1rem;">Estudiante</h6>
                            </div>

                            <label class="form-label small fw-semibold" style="color:#003b73;">
                                Buscar estudiante <span class="text-danger">*</span>
                            </label>

                            <div class="position-relative">
                                <i class="fas fa-search position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem; z-index:10;"></i>
                                <input type="text" id="estudiante_search"
                                       placeholder="Escribe el nombre o apellido..."
                                       autocomplete="off"
                                       class="form-control ps-5 @error('estudiante_id') is-invalid @enderror"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.65rem 1rem 0.65rem 2.8rem;">

                                <div id="estudiante_dropdown"
                                     style="display:none; position:absolute; top:100%; left:0; right:0; z-index:999;
                                            background:white; border:2px solid #bfd9ea; border-top:none;
                                            border-radius:0 0 8px 8px; max-height:230px; overflow-y:auto;
                                            box-shadow: 0 6px 16px rgba(0,0,0,0.1);">
                                </div>
                            </div>

                            <input type="hidden" id="estudiante_id" name="estudiante_id" value="{{ old('estudiante_id') }}">

                            <div id="estudiante_selected" class="mt-2" style="display:none;">
                                <span class="badge d-inline-flex align-items-center gap-2 px-3 py-2"
                                      style="background:rgba(78,199,210,0.15); color:#003b73; border:1px solid #4ec7d2; border-radius:20px; font-size:0.85rem; font-weight:500;">
                                    <i class="fas fa-user-check" style="color:#00508f;"></i>
                                    <span id="estudiante_selected_name"></span>
                                    <button type="button" id="estudiante_clear"
                                            style="background:none; border:none; color:#ef4444; cursor:pointer; padding:0; font-size:0.8rem; line-height:1;" title="Quitar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            </div>

                            @error('estudiante_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PROFESOR (solo admin) --}}
                        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #4ec7d2, #00508f); border-radius: 9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-chalkboard-user" style="color:white; font-size:0.9rem;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color:#003b73; font-size:1rem;">Profesor</h6>
                            </div>

                            <label for="profesor_id" class="form-label small fw-semibold" style="color:#003b73;">Profesor asignado</label>
                            <div class="position-relative">
                                <i class="fas fa-chalkboard position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem; z-index:10;"></i>
                                <select class="form-select ps-5" id="profesor_id" name="profesor_id"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.65rem 1rem 0.65rem 2.8rem;">
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
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #4ec7d2, #00508f); border-radius: 9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-tags" style="color:white; font-size:0.9rem;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color:#003b73; font-size:1rem;">Tipo de Observacion</h6>
                            </div>

                            <label class="form-label small fw-semibold" style="color:#003b73;">
                                Tipo <span class="text-danger">*</span>
                            </label>

                            <div class="row g-2">
                                @foreach([
                                    ['value'=>'academica',  'label'=>'Academica',  'icon'=>'fa-book',        'color'=>'#2196f3'],
                                    ['value'=>'conductual', 'label'=>'Conductual', 'icon'=>'fa-user-shield', 'color'=>'#ef4444'],
                                    ['value'=>'salud',      'label'=>'Salud',      'icon'=>'fa-heart-pulse', 'color'=>'#4caf50'],
                                    ['value'=>'otro',       'label'=>'Otro',       'icon'=>'fa-ellipsis',    'color'=>'#9e9e9e'],
                                ] as $t)
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="tipo" id="tipo_{{ $t['value'] }}"
                                           value="{{ $t['value'] }}" {{ old('tipo') === $t['value'] ? 'checked' : '' }}>
                                    <label class="btn w-100 d-flex flex-column align-items-center gap-1 py-3"
                                           for="tipo_{{ $t['value'] }}"
                                           style="border: 2px solid #bfd9ea; border-radius: 10px; background: white; cursor:pointer; transition: all 0.2s;">
                                        <i class="fas {{ $t['icon'] }}" style="font-size:1.4rem; color:{{ $t['color'] }};"></i>
                                        <span class="small fw-semibold" style="color:#003b73;">{{ $t['label'] }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            @error('tipo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- ── COLUMNA DERECHA — Descripcion ── --}}
                    <div class="col-lg-6 d-flex flex-column">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #4ec7d2, #00508f); border-radius: 9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-file-lines" style="color:white; font-size:0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color:#003b73; font-size:1rem;">Descripcion</h6>
                        </div>

                        <label for="descripcion" class="form-label small fw-semibold" style="color:#003b73;">
                            Detalle de la observacion <span class="text-danger">*</span>
                        </label>

                        <div class="position-relative flex-fill d-flex flex-column">
                            <i class="fas fa-pen-to-square position-absolute" style="left:12px; top:14px; color:#00508f; font-size:0.85rem;"></i>
                            <textarea class="form-control ps-5 flex-fill @error('descripcion') is-invalid @enderror"
                                      id="descripcion" name="descripcion"
                                      placeholder="Describe la observacion con detalle..."
                                      style="border: 2px solid #bfd9ea; border-radius: 8px; resize: none; min-height: 300px;">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end mt-1">
                            <span id="char_count" class="small text-muted">0 / 1000</span>
                        </div>

                        @error('descripcion')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="d-flex gap-3 pt-4 mt-2 border-top">
                    <button type="submit" class="btn fw-semibold flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color:white; border:none; padding:0.75rem; border-radius: 9px; font-size: 0.95rem;">
                        <i class="fas fa-save me-2"></i>Registrar Observacion
                    </button>
                    <a href="{{ route('observaciones.index') }}" class="btn fw-semibold flex-fill"
                       style="border: 2px solid #00508f; color:#00508f; background:white; padding:0.75rem; border-radius: 9px; font-size: 0.95rem;">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

@push('styles')
<style>
    .btn-check:checked + label {
        border-color: #4ec7d2 !important;
        background: rgba(78,199,210,0.12) !important;
        box-shadow: 0 0 0 3px rgba(78,199,210,0.2);
    }
    .btn-check + label:hover {
        border-color: #4ec7d2 !important;
        background: rgba(78,199,210,0.06) !important;
    }
    #estudiante_dropdown .dropdown-item-custom {
        padding: 0.65rem 1rem;
        cursor: pointer;
        font-size: 0.88rem;
        color: #003b73;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    #estudiante_dropdown .dropdown-item-custom:hover {
        background: rgba(78,199,210,0.1);
    }
    #estudiante_dropdown .dropdown-item-custom:last-child { border-bottom: none; }
    .form-control:focus, .form-select:focus {
        border-color: #4ec7d2 !important;
        box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.2) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    const estudiantes = @json($estudiantes->map(fn($e) => ['id' => $e->id, 'nombre' => $e->nombreCompleto]));

    const searchInput  = document.getElementById('estudiante_search');
    const hiddenId     = document.getElementById('estudiante_id');
    const dropdown     = document.getElementById('estudiante_dropdown');
    const selectedBox  = document.getElementById('estudiante_selected');
    const selectedName = document.getElementById('estudiante_selected_name');
    const clearBtn     = document.getElementById('estudiante_clear');

    function showDropdown(results) {
        dropdown.innerHTML = '';
        if (!results.length) {
            dropdown.innerHTML = '<div class="dropdown-item-custom text-muted">Sin resultados</div>';
        } else {
            results.forEach(e => {
                const div = document.createElement('div');
                div.className = 'dropdown-item-custom';
                div.textContent = e.nombre;
                div.addEventListener('mousedown', () => selectEstudiante(e));
                dropdown.appendChild(div);
            });
        }
        dropdown.style.display = 'block';
    }

    function selectEstudiante(e) {
        hiddenId.value            = e.id;
        searchInput.value         = '';
        searchInput.style.display = 'none';
        selectedName.textContent  = e.nombre;
        selectedBox.style.display = 'block';
        dropdown.style.display    = 'none';
    }

    function clearEstudiante() {
        hiddenId.value            = '';
        searchInput.value         = '';
        searchInput.style.display = 'block';
        selectedBox.style.display = 'none';
        searchInput.focus();
    }

    searchInput.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        if (q.length < 2) { dropdown.style.display = 'none'; return; }
        const found = estudiantes.filter(e => e.nombre.toLowerCase().includes(q)).slice(0, 8);
        showDropdown(found);
    });

    searchInput.addEventListener('blur', () => {
        setTimeout(() => dropdown.style.display = 'none', 150);
    });

    clearBtn.addEventListener('click', clearEstudiante);

    @if(old('estudiante_id'))
        const oldEst = estudiantes.find(e => e.id === {{ old('estudiante_id') }});
        if (oldEst) selectEstudiante(oldEst);
    @endif

    // Contador caracteres
    const textarea  = document.getElementById('descripcion');
    const charCount = document.getElementById('char_count');

    function updateCount() {
        const len = textarea.value.length;
        charCount.textContent = `${len} / 1000`;
        charCount.style.color = len > 900 ? '#ef4444' : len > 750 ? '#f59e0b' : '#6b7280';
    }
    textarea.addEventListener('input', updateCount);
    updateCount();
</script>
@endpush
@endsection
