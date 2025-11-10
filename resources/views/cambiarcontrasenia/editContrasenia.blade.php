@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
    <main class="main-content">
        <div class="content-wrapper">
            {{-- Encabezado de página --}}
            <div class="page-header">
                <div class="page-icon"><i class="fas fa-key"></i></div>
                <h1>Cambiar Contraseña</h1>
                <p>Complete los campos para actualizar su contraseña</p>
                <div class="header-divider"></div>
            </div>

            {{-- Formulario --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h2>Actualizar Contraseña</h2>
                    <p>Campos obligatorios marcados con *</p>
                </div>
                <div class="form-card-body">
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('cambiarcontrasenia.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="form-section">
                            <h3 class="section-title"><i class="fas fa-lock"></i>Contraseña Actual</h3>
                            <div class="form-group input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="current_password" class="form-control" required>
                                @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="section-title"><i class="fas fa-key"></i>Nueva Contraseña</h3>
                            <div class="form-grid">
                                <div class="form-group input-wrapper">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                                    @error('new_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group input-wrapper">
                                    <i class="fas fa-check-circle input-icon"></i>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Repita contraseña" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-full">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @push('styles')
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
                color: #2c3e50;
            }

            .main-content {
                margin-left: 230px;
                padding: 30px;
                min-height: 100vh;
                display: flex;
                justify-content: center;
            }

            .content-wrapper {
                width: 100%;
                max-width: 550px;
            }

            .page-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .page-icon {
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.3rem;
                margin-bottom: 10px;
            }

            .header-divider {
                width: 50px;
                height: 3px;
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                margin: 10px auto 0;
                border-radius: 2px;
            }

            .form-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.07);
                overflow: hidden;
            }

            .form-card-header {
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                padding: 15px 20px;
                color: white;
            }

            .form-card-header h2 {
                font-size: 1rem;
                font-weight: 700;
            }

            .form-card-header p {
                font-size: 0.7rem;
            }

            .form-card-body {
                padding: 20px;
            }

            .form-section {
                margin-bottom: 18px;
            }

            .section-title {
                font-size: 0.9rem;
                font-weight: 600;
                margin-bottom: 12px;
                color: #2c3e50;
                border-bottom: 2px solid #e0f7fa;
                padding-bottom: 5px;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .section-title i {
                color: #00BCD4;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .form-group label {
                display: none; /* Ya usamos títulos de sección */
            }

            .form-control {
                width: 100%;
                padding: 8px 8px 8px 30px;
                border: 2px solid #e0f7fa;
                border-radius: 6px;
                font-size: 0.8rem;
                background: #f1f8fb;
                transition: all 0.3s;
            }

            .form-control:focus {
                border-color: #00BCD4;
                background: white;
            }

            .input-icon {
                position: absolute;
                left: 8px;
                top: 50%;
                transform: translateY(-50%);
                color: #00BCD4;
                font-size: 0.8rem;
            }

            .alert-success {
                background: rgba(0, 188, 212, 0.08);
                border: 1px solid #80deea;
                border-radius: 8px;
                padding: 10px;
                font-size: 0.75rem;
                margin-bottom: 15px;
            }

            .alert-danger {
                background: rgba(255, 99, 71, 0.08);
                border: 1px solid #ff7f50;
                border-radius: 8px;
                padding: 10px;
                font-size: 0.75rem;
                margin-bottom: 15px;
            }

            .btn-primary {
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                color: white;
                font-weight: 600;
                border-radius: 6px;
                padding: 8px;
                border: none;
                cursor: pointer;
            }

            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }
                .main-content {
                    margin-left: 0;
                    padding: 20px;
                }
            }
        </style>
    @endpush
