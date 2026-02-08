@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg rounded-4">
                    <div class="card-body p-4">

                        <!-- ENCABEZADO -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary text-white d-inline-flex
                                    align-items-center justify-content-center mb-3"
                                 style="width:60px; height:60px;">
                                <i class="bi bi-shield-lock fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Cambiar contraseña</h4>
                            <p class="text-muted mb-0">Actualiza tu contraseña de forma segura</p>
                        </div>

                        <!-- MENSAJES -->
                        @if (session('success'))
                            <div class="alert alert-primary">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('cambiarcontrasenia.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- CONTRASEÑA ACTUAL -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Contraseña actual
                                </label>
                                <input type="password"
                                       name="current_password"
                                       class="form-control form-control-lg"
                                       required>
                                @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- NUEVA CONTRASEÑA -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Nueva contraseña
                                </label>
                                <input type="password"
                                       name="new_password"
                                       class="form-control form-control-lg"
                                       required>
                                @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- CONFIRMAR CONTRASEÑA -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Confirmar nueva contraseña
                                </label>
                                <input type="password"
                                       name="new_password_confirmation"
                                       class="form-control form-control-lg"
                                       required>
                            </div>

                            <!-- BOTONES -->
                            <div class="d-flex justify-content-between">

                                <a href="{{ url()->previous() }}"
                                   class="btn btn-danger px-4">
                                    Cancelar
                                </a>

                                <div>
                                    <button type="reset"
                                            class="btn btn-warning text-white px-4 me-2">
                                        Limpiar
                                    </button>

                                    <button type="submit"
                                            class="btn btn-primary px-4">
                                        Guardar cambios
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
