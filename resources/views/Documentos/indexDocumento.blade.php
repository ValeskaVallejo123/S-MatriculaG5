@extends('layouts.app')

@section('title', 'Listado de Documentos')

@section('content')
    <main class="main-content">
        <div class="content-wrapper">

            {{-- Encabezado --}}
            <div class="page-header text-center mb-4">
                <div class="page-icon"><i class="bi bi-file-earmark-text"></i></div>
                <h1>Documentos del Estudiante</h1>
                <div class="header-divider"></div>
            </div>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-6 text-center shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Botón subir documentos --}}
            <div class="text-end mb-4">
                <a href="{{ route('documentos.create') }}" class="btn-primary">
                    <i class="bi bi-upload me-2"></i>Subir Nuevos Documentos
                </a>
            </div>

            {{-- Tabla --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h2>Documentos</h2>
                </div>
                <div class="form-card-body p-0">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="bg-blue-600 text-white">
                        <tr>
                            <th>Foto</th>
                            <th>Acta de Nacimiento</th>
                            <th>Calificaciones</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($documentos as $doc)
                            <tr>
                                {{-- FOTO --}}
                                <td>
                                    @if($doc->foto && file_exists(storage_path('app/public/' . $doc->foto)))
                                        <a href="{{ asset('storage/' . $doc->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doc->foto) }}"
                                                 alt="Foto del estudiante"
                                                 class="miniatura">
                                        </a>
                                    @else
                                        <span class="text-gray-400">No hay foto</span>
                                    @endif
                                </td>

                                {{-- ACTA --}}
                                <td>
                                    @if($doc->acta_nacimiento && file_exists(storage_path('app/public/' . $doc->acta_nacimiento)))
                                        <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank"
                                           class="btn-table bg-blue-100 text-blue-700 hover:bg-blue-200">
                                            Ver Acta
                                        </a>
                                    @else
                                        <span class="text-gray-400">No hay acta</span>
                                    @endif
                                </td>

                                {{-- CALIFICACIONES --}}
                                <td>
                                    @if($doc->calificaciones && file_exists(storage_path('app/public/' . $doc->calificaciones)))
                                        <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank"
                                           class="btn-table bg-teal-100 text-teal-700 hover:bg-teal-200">
                                            Ver Calificaciones
                                        </a>
                                    @else
                                        <span class="text-gray-400">No hay calificaciones</span>
                                    @endif
                                </td>

                                {{-- ACCIONES --}}
                                <td>
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="{{ route('documentos.edit', $doc->id) }}"
                                           class="btn-action btn-warning text-white">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Eliminar documentos?')"
                                                    class="btn-action btn-danger text-white">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-gray-500 text-center">
                                    <i class="bi bi-folder-x fs-2 d-block mb-2"></i>
                                    No hay documentos subidos.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
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

            /* Centrado general */
            .main-content {
                margin-left: 0;
                padding: 30px;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .content-wrapper {
                width: 100%;
                max-width: 950px;
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

            .form-card-body {
                padding: 20px;
                overflow-x: auto;
            }

            /* Miniatura */
            .miniatura {
                width: 60px;
                height: 60px;
                border-radius: 8px;
                object-fit: cover;
                border: 2px solid #e0f7fa;
                transition: transform 0.2s ease;
            }

            .miniatura:hover {
                transform: scale(1.1);
            }

            /* Botones */
            .btn-primary {
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                color: white;
                font-weight: 600;
                border-radius: 6px;
                padding: 8px 14px;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: 0.3s;
            }

            .btn-primary:hover {
                opacity: 0.9;
            }

            .btn-table {
                padding: 5px 10px;
                border-radius: 6px;
                font-size: 0.9rem;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                transition: 0.2s;
            }

            .btn-action {
                border: none;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 0.9rem;
                font-weight: 600;
                cursor: pointer;
                transition: 0.3s;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            /* Amarillo para Editar */
            .btn-warning {
                background-color: #facc15;
            }

            .btn-warning:hover {
                background-color: #eab308;
            }

            /* Rojo para Eliminar */
            .btn-danger {
                background-color: #ef4444;
            }

            .btn-danger:hover {
                background-color: #dc2626;
            }

            .table th, .table td {
                vertical-align: middle;
                padding: 12px;
            }

            @media (max-width: 768px) {
                .content-wrapper {
                    width: 100%;
                    padding: 0 15px;
                }

                .miniatura {
                    width: 50px;
                    height: 50px;
                }
            }
        </style>
    @endpush
@endsection
