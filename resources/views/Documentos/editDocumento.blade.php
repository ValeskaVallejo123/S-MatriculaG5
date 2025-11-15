@extends('layouts.app')

@section('title', 'Editar Documentos')

@section('content')
    <main class="main-content">
        <div class="content-wrapper">

            {{-- Encabezado --}}
            <div class="page-header text-center mb-4">
                <div class="page-icon"><i class="bi bi-pencil-square"></i></div>
                <h1>Editar Documentos del Estudiante</h1>
                <div class="header-divider"></div>
            </div>

            {{-- Formulario --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h2>Información y Documentos</h2>
                    <p>Actualice los datos y documentos del estudiante</p>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Foto del estudiante --}}
                        <div class="form-group text-center">
                            <label class="font-semibold">Foto del Estudiante</label>
                            <div class="mb-3">
                                @if($documento->foto && file_exists(storage_path('app/public/' . $documento->foto)))
                                    <img src="{{ asset('storage/' . $documento->foto) }}"
                                         alt="Foto del estudiante"
                                         class="miniatura">
                                @else
                                    <span class="text-gray-400">No hay foto</span>
                                @endif
                            </div>
                            <input type="file" name="foto" id="foto" accept=".jpg,.png"
                                   class="form-control @error('foto') border-red-500 @enderror" required>
                            <p class="text-gray-500 text-sm mt-1">JPG o PNG (máx. 5 MB)</p>
                            @error('foto')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Documentos --}}
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Acta de Nacimiento</label>
                                <input type="file" name="acta_nacimiento" id="acta_nacimiento" accept=".jpg,.png,.pdf"
                                       class="form-control @error('acta_nacimiento') border-red-500 @enderror" required>
                                <p class="text-gray-500 text-sm mt-1">JPG, PNG o PDF (máx. 5 MB)</p>
                                @error('acta_nacimiento')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="form-group">
                                <label>Calificaciones</label>
                                <input type="file" name="calificaciones" id="calificaciones" accept=".jpg,.png,.pdf"
                                       class="form-control @error('calificaciones') border-red-500 @enderror" required>
                                <p class="text-gray-500 text-sm mt-1">JPG, PNG o PDF (máx. 5 MB)</p>
                                @error('calificaciones')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="btn-warning flex-1 text-white">
                                <i class="bi bi-arrow-repeat"></i> Actualizar Documentos
                            </button>
                            <a href="{{ route('documentos.index') }}" class="btn-danger flex-1 text-center text-white leading-[2.5rem]">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
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

            /* Centrado sin panel lateral */
            .main-content {
                margin: 0;
                padding: 30px;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .content-wrapper {
                width: 100%;
                max-width: 700px;
            }

            .page-header {
                text-align: center;
                margin-bottom: 25px;
            }

            .page-icon {
                width: 55px;
                height: 55px;
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.4rem;
                margin-bottom: 10px;
            }

            .header-divider {
                width: 60px;
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
                margin-bottom: 20px;
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
                font-size: 0.8rem;
            }

            .form-card-body {
                padding: 20px;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
                margin-bottom: 12px;
            }

            .form-group label {
                font-size: 0.85rem;
                font-weight: 600;
                margin-bottom: 6px;
                display: block;
            }

            .form-control {
                width: 100%;
                padding: 8px;
                border: 2px solid #e0f7fa;
                border-radius: 6px;
                font-size: 0.85rem;
                background: #f1f8fb;
                transition: all 0.3s;
            }

            .form-control:focus {
                border-color: #00BCD4;
                background: white;
            }

            /* Miniatura */
            .miniatura {
                width: 80px;
                height: 80px;
                border-radius: 10px;
                object-fit: cover;
                border: 2px solid #e0f7fa;
                transition: transform 0.2s ease;
            }

            .miniatura:hover {
                transform: scale(1.1);
            }

            /* Botones */
            .btn-warning {
                background-color: #facc15;
                border: none;
                border-radius: 6px;
                padding: 8px 14px;
                font-weight: 600;
                cursor: pointer;
                transition: 0.3s;
            }

            .btn-warning:hover {
                background-color: #eab308;
            }

            .btn-danger {
                background-color: #ef4444;
                border: none;
                border-radius: 6px;
                padding: 8px 14px;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                transition: 0.3s;
            }

            .btn-danger:hover {
                background-color: #dc2626;
            }

            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush
@endsection
