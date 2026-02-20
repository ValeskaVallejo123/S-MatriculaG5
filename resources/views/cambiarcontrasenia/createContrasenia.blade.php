@extends('layouts.app')

@section('title', 'Seguridad de la Cuenta')
@section('page-title', 'Configuración de Seguridad')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100">
                        <div class="w-10 h-10 bg-[#227199] rounded-lg flex items-center justify-center text-white shadow-sm">
                            <i class="fas fa-shield-alt text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-[#004a77] m-0">Seguridad de la Cuenta</h2>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-6 rounded-xl">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('cambiarcontrasenia.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- Importante: El archivo de rutas dice que es PUT --}}

                        <div class="mb-4">
                            <label class="form-label font-bold text-[#004a77]">Contraseña Actual <span class="text-danger">*</span></label>
                            <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-[#227199]">
                                <i class="fas fa-key"></i>
                            </span>
                                <input type="password" name="current_password" required
                                       class="form-control border-start-0 @error('current_password') is-invalid @enderror"
                                       placeholder="Ingrese su contraseña actual">
                            </div>
                            @error('current_password')
                            <div class="text-danger mt-1 small font-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 text-slate-100">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-bold text-[#004a77]">Nueva Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-[#227199]">
                                    <i class="fas fa-lock"></i>
                                </span>
                                    <input type="password" name="new_password" required minlength="8"
                                           class="form-control border-start-0 @error('new_password') is-invalid @enderror"
                                           placeholder="Mínimo 8 caracteres">
                                </div>
                                @error('new_password')
                                <div class="text-danger mt-1 small font-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-bold text-[#004a77]">Confirmar Nueva <span class="text-danger">*</span></label>
                                <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-[#227199]">
                                    <i class="fas fa-check-double"></i>
                                </span>
                                    <input type="password" name="new_password_confirmation" required minlength="8"
                                           class="form-control border-start-0"
                                           placeholder="Repita la contraseña">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 pt-6">
                            <button type="submit"
                                    class="btn btn-primary px-5 py-3 rounded-xl font-bold shadow-sm"
                                    style="background-color: #56b3f5; border: none;">
                                <i class="fas fa-sync-alt me-2"></i>Actualizar Contraseña
                            </button>
                            <a href="{{ url()->previous() }}"
                               class="btn btn-light px-5 py-3 rounded-xl font-bold border">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection