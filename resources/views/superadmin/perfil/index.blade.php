@extends('layouts.app')

@section('title', 'Perfil Super Admin')
@section('page-title', 'Perfil del Super Administrador')

@push('styles')
<style>
.info-row {
    display:flex;align-items:center;gap:.6rem;
    padding:.65rem 0;border-bottom:1px solid #f1f5f9;
    font-size:.83rem;color:#4b5563;
}
.info-row:last-child { border-bottom:none; }
.info-row i { color:#4ec7d2;width:16px;text-align:center;flex-shrink:0; }
.info-row .lbl { color:#7a8fa8;min-width:120px; }
.info-row .val { font-weight:700;color:#003b73; }

.sec-title {
    display:flex;align-items:center;gap:.5rem;
    font-size:.74rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
    color:#00508f;margin-bottom:.95rem;padding-bottom:.5rem;
    border-bottom:2px solid rgba(78,199,210,.15);
}
.sec-title i { color:#4ec7d2; }

.field-label {
    font-size:.75rem;font-weight:700;color:#00508f;
    display:block;margin-bottom:.3rem;
}
.field-input {
    width:100%;padding:.5rem .8rem;border-radius:8px;font-size:.83rem;
    border:1.5px solid #d1d9e6;outline:none;transition:border .2s;
}
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem;position:relative;overflow:hidden;">
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:72px;height:72px;border-radius:16px;
                        border:3px solid rgba(78,199,210,.7);background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-user-shield" style="color:white;font-size:1.9rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.35rem;font-weight:800;color:white;margin:0 0 .5rem;
                           text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    {{ $user->name }}
                </h2>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                                 padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
                                 background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);">
                        <i class="fas fa-crown"></i> Super Administrador
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                                 padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
                                 background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);">
                        <i class="fas fa-calendar"></i> Miembro desde {{ $user->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.5rem 1.7rem;display:grid;grid-template-columns:1fr 1fr;gap:2rem;">

            {{-- COLUMNA IZQUIERDA: info + editar --}}
            <div>
                <div class="sec-title">
                    <i class="fas fa-id-card"></i> Datos de la cuenta
                </div>

                <div style="background:#f8fafc;border-radius:10px;padding:.8rem 1.1rem;
                            border:1px solid #e8edf4;margin-bottom:1.3rem;">
                    <div class="info-row">
                        <i class="fas fa-user"></i>
                        <span class="lbl">Nombre</span>
                        <span class="val">{{ $user->name }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-envelope"></i>
                        <span class="lbl">Correo</span>
                        <span class="val">{{ $user->email }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-shield-alt"></i>
                        <span class="lbl">Rol</span>
                        <span class="val">Super Administrador</span>
                    </div>
                </div>

                @if(session('success'))
                    <div style="padding:.6rem 1rem;border-radius:8px;font-size:.8rem;font-weight:600;
                                background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;margin-bottom:.9rem;">
                        <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                    </div>
                @endif

                <div class="sec-title">
                    <i class="fas fa-pen"></i> Editar información
                </div>

                <form action="{{ route('superadmin.perfil.actualizar') }}" method="POST">
                    @csrf @method('PUT')
                    <div style="margin-bottom:.7rem;">
                        <label class="field-label">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="field-input"
                               onfocus="this.style.borderColor='#4ec7d2'" onblur="this.style.borderColor='#d1d9e6'">
                        @error('name')<div style="font-size:.72rem;color:#dc2626;margin-top:.2rem;">{{ $message }}</div>@enderror
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label class="field-label">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="field-input"
                               onfocus="this.style.borderColor='#4ec7d2'" onblur="this.style.borderColor='#d1d9e6'">
                        @error('email')<div style="font-size:.72rem;color:#dc2626;margin-top:.2rem;">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:.4rem;
                                   padding:.45rem 1.1rem;border-radius:8px;font-size:.8rem;font-weight:700;
                                   background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
                                   border:none;cursor:pointer;">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                </form>
            </div>

            {{-- COLUMNA DERECHA: cambiar contraseña --}}
            <div>
                <div class="sec-title">
                    <i class="fas fa-lock"></i> Cambiar contraseña
                </div>

                <form action="{{ route('superadmin.perfil.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div style="margin-bottom:.7rem;">
                        <label class="field-label">Contraseña actual</label>
                        <input type="password" name="current_password"
                               class="field-input"
                               onfocus="this.style.borderColor='#4ec7d2'" onblur="this.style.borderColor='#d1d9e6'">
                        @error('current_password')<div style="font-size:.72rem;color:#dc2626;margin-top:.2rem;">{{ $message }}</div>@enderror
                    </div>
                    <div style="margin-bottom:.7rem;">
                        <label class="field-label">Nueva contraseña</label>
                        <input type="password" name="password"
                               class="field-input"
                               onfocus="this.style.borderColor='#4ec7d2'" onblur="this.style.borderColor='#d1d9e6'">
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label class="field-label">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="field-input"
                               onfocus="this.style.borderColor='#4ec7d2'" onblur="this.style.borderColor='#d1d9e6'">
                        @error('password')<div style="font-size:.72rem;color:#dc2626;margin-top:.2rem;">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:.4rem;
                                   padding:.45rem 1.1rem;border-radius:8px;font-size:.8rem;font-weight:700;
                                   background:white;color:#00508f;
                                   border:1.5px solid #00508f;cursor:pointer;">
                        <i class="fas fa-key"></i> Cambiar contraseña
                    </button>
                </form>
            </div>

        </div>

        {{-- Footer --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;
                    padding:.85rem 1.7rem;background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;font-size:.72rem;color:#94a3b8;">
            <span>
                <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                Sistema de Gestión Académica — Año {{ date('Y') }}
            </span>
            <span>
                <i class="fas fa-user-shield me-1" style="color:#4ec7d2;"></i>
                Super Administrador
            </span>
        </div>

    </div>
</div>
@endsection
