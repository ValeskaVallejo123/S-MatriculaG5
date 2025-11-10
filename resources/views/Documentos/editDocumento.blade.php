@extends('layouts.app')

@section('title', 'Editar Documentos')

@section('content')
    <main class="main-content">
        <div class="content-wrapper">

            {{-- Encabezado --}}
            <div class="page-header">
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

                        {{-- Información del estudiante --}}
                        <div class="form-grid">

                            <div class="form-group">
                                <label>Foto del Estudiante</label>
                                <div class="mb-2">
                                    @if($documento->foto)
                                        <img src="{{ asset('storage/' . $documento->foto) }}" class="w-32 h-32 object-cover rounded">
                                    @endif
                                </div>
                                <input type="file" name="foto" id="foto" accept=".jpg,.png"
                                       class="form-control @error('foto') border-red-500 @enderror" required>
                                <p class="text-gray-500 text-sm mt-1">JPG o PNG (máx. 5 MB)</p>
                                @error('foto')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Documentos --}}
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Acta de Nacimiento</label>
                                <div class="mb-2">
                                    @if($documento->acta_nacimiento)
                                        <a href="{{ asset('storage/' . $documento->acta_nacimiento) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-eye"></i> Ver actual
                                        </a>
                                    @endif
                                </div>
                                <input type="file" name="acta_nacimiento" id="acta_nacimiento" accept=".jpg,.png,.pdf"
                                       class="form-control @error('acta_nacimiento') border-red-500 @enderror" required>
                                <p class="text-gray-500 text-sm mt-1">JPG, PNG o PDF (máx. 5 MB)</p>
                                @error('acta_nacimiento')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="form-group">
                                <label>Calificaciones</label>
                                <div class="mb-2">
                                    @if($documento->calificaciones)
                                        <a href="{{ asset('storage/' . $documento->calificaciones) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-eye"></i> Ver actual
                                        </a>
                                    @endif
                                </div>
                                <input type="file" name="calificaciones" id="calificaciones" accept=".jpg,.png,.pdf"
                                       class="form-control @error('calificaciones') border-red-500 @enderror" required>
                                <p class="text-gray-500 text-sm mt-1">JPG, PNG o PDF (máx. 5 MB)</p>
                                @error('calificaciones')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="btn-primary flex-1">Actualizar Documentos</button>
                            <a href="{{ route('documentos.index') }}" class="btn-secondary flex-1 text-center leading-[2.5rem]">
                                Cancelar
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

            .main-content {
                margin-left: 0;
                padding: 30px;
                min-height: 100vh;
                display: flex;
                justify-content: center;
            }

            .content-wrapper {
                width: 100%;
                max-width: 700px;
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
                font-size: 0.7rem;
            }

            .form-card-body {
                padding: 20px;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 12px;
            }

            .form-group label {
                font-size: 0.75rem;
                font-weight: 600;
                margin-bottom: 4px;
                display: block;
            }

            .form-control {
                width: 100%;
                padding: 8px;
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

            .btn-primary {
                background: linear-gradient(135deg, #FFB300, #FFA000);
                color: white;
                font-weight: 600;
                border-radius: 6px;
                padding: 8px;
                border: none;
                cursor: pointer;
            }

            .btn-secondary {
                background: #f1f8fb;
                color: #555;
                font-weight: 600;
                border-radius: 6px;
                padding: 8px;
                border: 1px solid #ddd;
                text-decoration: none;
                display: inline-block;
            }

            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const maxSize = 5 * 1024 * 1024; // 5 MB
                const allowedFiles = {
                    foto: ['image/jpeg','image/png'],
                    otros: ['image/jpeg','image/png','application/pdf']
                };

                const foto = document.getElementById('foto').files[0];
                const acta = document.getElementById('acta_nacimiento').files[0];
                const calif = document.getElementById('calificaciones').files[0];

                let errorMessage = '';

                if (!foto) {
                    errorMessage = 'La Foto del Estudiante es obligatoria.';
                } else if (!allowedFiles.foto.includes(foto.type) || foto.size > maxSize) {
                    errorMessage = 'La Foto debe ser JPG o PNG y no superar 5 MB.';
                } else if (!acta) {
                    errorMessage = 'El Acta de Nacimiento es obligatoria.';
                } else if (acta && !allowedFiles.otros.includes(acta.type) || acta.size > maxSize) {
                    errorMessage = 'El Acta de Nacimiento debe ser JPG, PNG o PDF y no superar 5 MB.';
                } else if (!calif) {
                    errorMessage = 'Las Calificaciones son obligatorias.';
                } else if (calif && !allowedFiles.otros.includes(calif.type) || calif.size > maxSize) {
                    errorMessage = 'Las Calificaciones deben ser JPG, PNG o PDF y no superar 5 MB.';
                }

                if (errorMessage) {
                    e.preventDefault();
                    alert(errorMessage);
                }
            });
        });
    </script>
@endsection
