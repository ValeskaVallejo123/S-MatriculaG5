@extends('layouts.app')

@section('title', 'Asignar Grado a Profesor')
@section('page-title', 'Asignar Grado')

@section('topbar-actions')
    <a href="{{ route('profesor_grado.index') }}"
       style="background:white; color:#00508f; padding:.6rem .75rem; border-radius:9px;
              text-decoration:none; font-weight:600; display:inline-flex; align-items:center;
              gap:0.4rem; transition:all 0.2s ease; border:1.5px solid #00508f; font-size:.83rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
.form-control, .form-select {
    border: 2px solid #bfd9ea !important;
    border-radius: 10px;
    padding: 0.68rem 1rem 0.68rem 2.8rem !important;
    font-size: .88rem !important;
    transition: all 0.3s ease;
    height: auto !important;
}
.form-control:focus, .form-select:focus {
    border-color: #4ec7d2 !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
    outline: none;
}
.form-label {
    color: #003b73 !important;
    font-size: .63rem !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .22rem;
}
.invalid-feedback { font-size: .7rem; display: block; margin-top: 0.35rem; }
.btn-primary-custom {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; border-radius: 9px;
    padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
    box-shadow: 0 2px 10px rgba(78,199,210,.3); transition: all .2s;
}
.btn-primary-custom:hover { color:white; transform:translateY(-2px); }
.badge-asig {
    background: rgba(0,80,143,0.08); color: #003b73;
    border: 1px solid #bfd9ea; padding: 0.3rem 0.65rem;
    font-size: 0.75rem; border-radius: 7px;
    display: inline-flex; align-items: center; gap: 6px;
}
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- Alertas --}}
    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1); border-left:3px solid #22c55e;
                    border-radius:8px; padding:0.5rem 1rem; margin-bottom:1rem;
                    display:flex; align-items:center; gap:0.5rem; font-size:0.875rem;">
            <i class="fas fa-check-circle" style="color:#16a34a;"></i>
            <span style="color:#15803d;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- HEADER --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:1.6rem 2rem; position:relative; overflow:hidden;">
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.2rem;flex-wrap:wrap;">
            <div style="width:70px; height:70px; border-radius:16px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex; align-items:center; justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-chalkboard-teacher" style="color:white; font-size:1.8rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.3rem; font-weight:800; color:white; margin:0 0 .35rem;">
                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                </h2>
                <div style="display:flex; gap:0.5rem; flex-wrap:wrap; align-items:center;">
                    @if($profesor->especialidad ?? ($profesor->materia->nombre ?? null))
                        <span style="display:inline-flex; align-items:center; gap:.3rem;
                                     padding:.2rem .65rem; border-radius:999px;
                                     background:rgba(255,255,255,.14); color:rgba(255,255,255,.92);
                                     font-size:.72rem; font-weight:600; border:1px solid rgba(255,255,255,.18);">
                            <i class="fas fa-book"></i>
                            {{ $profesor->especialidad ?? $profesor->materia->nombre }}
                        </span>
                    @endif
                    <span style="display:inline-flex; align-items:center; gap:.3rem;
                                 padding:.2rem .65rem; border-radius:999px;
                                 background:rgba(78,199,210,.25); color:white;
                                 font-size:.72rem; font-weight:600; border:1px solid rgba(78,199,210,.4);">
                        <i class="fas fa-layer-group"></i>
                        {{ $profesor->gradosAsignados->count() }} grado(s) asignado(s)
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div style="background:white; border:1px solid #e8edf4; border-top:none;
                border-radius:0 0 14px 14px; box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Sección: nueva asignación --}}
        <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

            <div style="display:flex; align-items:center; gap:.5rem;
                        font-size:.75rem; font-weight:700; color:#00508f;
                        text-transform:uppercase; letter-spacing:.08em;
                        margin-bottom:.95rem; padding-bottom:.55rem;
                        border-bottom:2px solid rgba(78,199,210,.1);">
                <i class="fas fa-plus-circle" style="color:#4ec7d2; font-size:.9rem;"></i>
                Agregar nueva asignación
            </div>

            <form action="{{ route('profesor_grado.store', $profesor->id) }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- Grado --}}
                    <div class="col-md-6">
                        <label for="grado_id" class="form-label">
                            Grado <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-layer-group position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem; z-index:10;"></i>
                            <select class="form-select @error('grado_id') is-invalid @enderror"
                                    id="grado_id" name="grado_id" required>
                                <option value="">Seleccione un grado...</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado->id }}"
                                        {{ old('grado_id') == $grado->id ? 'selected' : '' }}>
                                        {{ $grado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grado_id')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Sección --}}
                    <div class="col-md-4">
                        <label for="seccion" class="form-label">
                            Sección <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-tag position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem; z-index:10;"></i>
                            <select class="form-select @error('seccion') is-invalid @enderror"
                                    id="seccion" name="seccion" required>
                                <option value="">Sección...</option>
                                @foreach($secciones as $sec)
                                    <option value="{{ $sec }}"
                                        {{ old('seccion') == $sec ? 'selected' : '' }}>
                                        Sección {{ $sec }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seccion')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Botón --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-plus me-1"></i> Asignar
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- Sección: asignaciones actuales --}}
        <div style="padding:1.4rem 1.7rem;">

            <div style="display:flex; align-items:center; gap:.5rem;
                        font-size:.75rem; font-weight:700; color:#00508f;
                        text-transform:uppercase; letter-spacing:.08em;
                        margin-bottom:.95rem; padding-bottom:.55rem;
                        border-bottom:2px solid rgba(78,199,210,.1);">
                <i class="fas fa-list-ul" style="color:#4ec7d2; font-size:.9rem;"></i>
                Grados y secciones asignados actualmente
            </div>

            @if($profesor->gradosAsignados->isNotEmpty())
                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($profesor->gradosAsignados as $asig)
                        <div style="display:flex; align-items:center; justify-content:space-between;
                                    padding:0.75rem 1rem; background:#f8fafc;
                                    border:1px solid #e8edf4; border-radius:10px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:34px; height:34px;
                                            background:linear-gradient(135deg,#4ec7d2,#00508f);
                                            border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-layer-group" style="color:white; font-size:0.8rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:600; color:#003b73; font-size:0.88rem;">
                                        {{ $asig->grado->nombre ?? '—' }}
                                    </div>
                                    <div style="font-size:0.73rem; color:#64748b;">
                                        Sección {{ $asig->seccion }}
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('profesor_grado.destroy', $asig->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar esta asignación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="border:1.5px solid #ef4444; color:#ef4444; background:white;
                                               border-radius:7px; padding:0.28rem 0.65rem; font-size:0.8rem;
                                               cursor:pointer; transition:all 0.2s;"
                                        onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                        onmouseout="this.style.background='white'; this.style.color='#ef4444';"
                                        title="Eliminar asignación">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding:2rem; color:#94a3b8;">
                    <i class="fas fa-inbox fa-2x d-block mb-2" style="opacity:0.5;"></i>
                    <p style="font-size:0.875rem; margin:0;">
                        Este profesor aún no tiene grados asignados. Usa el formulario de arriba para agregar uno.
                    </p>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div style="display:flex; padding:1.1rem 1.7rem;
                    background:#f5f8fc; border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;">
            <a href="{{ route('profesor_grado.index') }}"
               style="border:1.5px solid #00508f; color:#00508f; background:white;
                      border-radius:9px; padding:.6rem 1.4rem; font-size:.83rem; font-weight:600;
                      text-decoration:none; transition:all .2s;"
               onmouseover="this.style.background='#eff6ff';"
               onmouseout="this.style.background='white';">
                <i class="fas fa-arrow-left me-1"></i> Volver al listado
            </a>
        </div>

    </div>
</div>
@endsection