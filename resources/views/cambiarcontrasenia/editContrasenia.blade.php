@extends('layouts.app')

@section('title', 'Cambiar Contraseña')
@section('page-title', 'Seguridad de la Cuenta')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --blue:     #00508f;
    --blue-mid: #003b73;
    --teal:     #4ec7d2;
    --border:   #e8edf4;
    --muted:    #6b7a90;
    --r:        14px;
}

.cc-wrap {
    max-width: 1000px;
    margin: 0 auto;
    font-family: 'Inter', sans-serif;
    padding: 0 1rem;
}

/* ── Header ── */
.cc-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 2.2rem;
    position: relative; overflow: hidden;
}
.cc-header::before {
    content: ''; position: absolute; right: -50px; top: -50px;
    width: 180px; height: 180px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.cc-header::after {
    content: ''; position: absolute; right: 90px; bottom: -40px;
    width: 110px; height: 110px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.cc-header-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.1rem;
}
.cc-icon {
    width: 56px; height: 56px; border-radius: 14px;
    border: 2.5px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.cc-icon i { color: white; font-size: 1.5rem; }
.cc-header h2 {
    font-size: 1.2rem; font-weight: 800; color: white;
    margin: 0 0 .3rem;
}
.cc-header p {
    font-size: .78rem; color: rgba(255,255,255,.7);
    margin: 0;
}

/* ── Body ── */
.cc-body {
    background: white;
    border: 1px solid var(--border);
    border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: 0 4px 20px rgba(0,59,115,.10);
    padding: 2rem;
}

/* ── Section label ── */
.cc-label {
    font-size: .68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--muted); margin-bottom: .45rem;
    display: block;
}

/* ── Input group ── */
.cc-field {
    border: 1.5px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
    display: flex; align-items: center;
}
.cc-field:focus-within {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(78,199,210,.15);
}
.cc-field.is-invalid-field {
    border-color: #dc3545;
}
.cc-field .input-icon {
    padding: 0 .85rem;
    color: var(--teal);
    font-size: .9rem;
    flex-shrink: 0;
}
.cc-field input {
    border: none !important;
    box-shadow: none !important;
    padding: .7rem .75rem .7rem 0;
    font-size: .9rem;
    flex: 1;
    color: #1e293b;
    background: transparent;
}
.cc-field input:focus { outline: none; }

.cc-divider {
    border: none; border-top: 1.5px solid var(--border);
    margin: 1.4rem 0;
}

/* ── Tips card ── */
.cc-tips {
    background: linear-gradient(135deg, rgba(78,199,210,.06), rgba(0,80,143,.04));
    border: 1px solid rgba(78,199,210,.25);
    border-radius: 10px;
    padding: .85rem 1rem;
    margin-top: 1.25rem;
}
.cc-tips-title {
    font-size: .72rem; font-weight: 700;
    color: var(--blue-mid); margin-bottom: .5rem;
    display: flex; align-items: center; gap: .35rem;
}
.cc-tip-item {
    font-size: .75rem; color: var(--muted);
    display: flex; align-items: center; gap: .35rem;
    margin-bottom: .25rem;
}
.cc-tip-item i { color: var(--teal); font-size: .65rem; }

/* ── Buttons ── */
.cc-btn-submit {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border: none; border-radius: 10px;
    color: white; font-weight: 700; font-size: .9rem;
    padding: .75rem 2rem;
    transition: opacity .2s, transform .15s;
    display: inline-flex; align-items: center; gap: .45rem;
}
.cc-btn-submit:hover { opacity: .9; transform: translateY(-1px); color: white; }

.cc-btn-cancel {
    border: 1.5px solid var(--border);
    border-radius: 10px;
    color: var(--muted); font-weight: 600; font-size: .9rem;
    padding: .75rem 1.5rem;
    background: white;
    transition: border-color .2s, color .2s;
    display: inline-flex; align-items: center; gap: .4rem;
}
.cc-btn-cancel:hover { border-color: var(--blue); color: var(--blue); }

.cc-error { font-size: .78rem; color: #dc3545; margin-top: .35rem; font-weight: 500; }

@media(max-width: 576px) {
    .cc-wrap    { padding: 0 .75rem; }
    .cc-header  { padding: 1.3rem 1.1rem; }
    .cc-body    { padding: 1.3rem 1.1rem; }
    .cc-icon    { width: 46px; height: 46px; }
    .cc-icon i  { font-size: 1.2rem; }
    .cc-header h2 { font-size: 1rem; }
}
</style>
@endpush

@section('content')
<div class="cc-wrap">

    {{-- ── Header ── --}}
    <div class="cc-header">
        <div class="cc-header-inner">
            <div class="cc-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <h2>Cambiar Contraseña</h2>
                <p>Actualiza tus credenciales para mantener tu cuenta segura</p>
            </div>
        </div>
    </div>

    {{-- ── Body ── --}}
    <div class="cc-body">

        @if(session('success'))
            <div class="alert mb-4"
                 style="background:linear-gradient(135deg,rgba(78,199,210,.1),rgba(0,80,143,.05));
                        border:1px solid rgba(78,199,210,.35); border-radius:10px; color:#003b73;">
                <i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        @if($errors->has('general'))
            <div class="alert alert-danger mb-4" style="border-radius:10px;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first('general') }}
            </div>
        @endif

        <form action="{{ route('cambiarcontrasenia.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Contraseña actual --}}
            <div class="mb-4">
                <label class="cc-label">Contraseña Actual <span class="text-danger">*</span></label>
                <div class="cc-field {{ $errors->has('current_password') ? 'is-invalid-field' : '' }}">
                    <span class="input-icon"><i class="fas fa-key"></i></span>
                    <input type="password" name="current_password"
                           placeholder="Ingresa tu contraseña actual" required
                           autocomplete="current-password">
                </div>
                @error('current_password')
                    <div class="cc-error"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <hr class="cc-divider">

            {{-- Nueva contraseña + Confirmar (en fila) --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="cc-label">Nueva Contraseña <span class="text-danger">*</span></label>
                    <div class="cc-field {{ $errors->has('new_password') ? 'is-invalid-field' : '' }}">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="new_password"
                               placeholder="Mínimo 8 caracteres" required minlength="8"
                               autocomplete="new-password">
                    </div>
                    @error('new_password')
                        <div class="cc-error"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="cc-label">Confirmar Nueva Contraseña <span class="text-danger">*</span></label>
                    <div class="cc-field">
                        <span class="input-icon"><i class="fas fa-check-double"></i></span>
                        <input type="password" name="new_password_confirmation"
                               placeholder="Repite la nueva contraseña" required minlength="8"
                               autocomplete="new-password">
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="cc-btn-submit">
                    <i class="fas fa-sync-alt"></i> Actualizar Contraseña
                </button>
                <a href="{{ url()->previous() }}" class="cc-btn-cancel">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>

        </form>

        {{-- Tips --}}
        <div class="cc-tips">
            <div class="cc-tips-title">
                <i class="fas fa-info-circle" style="color:var(--teal);"></i>
                Recomendaciones para una contraseña segura
            </div>
            <div class="cc-tip-item"><i class="fas fa-circle"></i> Mínimo 8 caracteres</div>
            <div class="cc-tip-item"><i class="fas fa-circle"></i> Combina mayúsculas y minúsculas</div>
            <div class="cc-tip-item"><i class="fas fa-circle"></i> Incluye números y símbolos (!, @, #...)</div>
            <div class="cc-tip-item"><i class="fas fa-circle"></i> No uses datos personales como tu nombre o fecha de nacimiento</div>
        </div>

    </div>

</div>
@endsection
