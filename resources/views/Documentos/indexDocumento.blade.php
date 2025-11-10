@extends('layouts.app')

@section('title', 'Listado de Documentos')

@section('content')
    <main class="main-content">
        <div class="content-wrapper">

            {{-- Encabezado --}}
            <div class="page-header">
                <div class=""><i class="bi bi-file-earmark-text"></i></div>
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
            <div class="flex justify-end mb-4">
                <a href="{{ route('documentos.create') }}" class="btn-primary flex items-center gap-2">
                    <i class="bi bi-upload"></i> Subir Nuevos Documentos
                </a>
            </div>

            {{-- Tabla --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h2>Documentos</h2>
                </div>
                <div class="form-card-body p-0 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-blue-600 text-white text-center">
                        <tr>
                            <th class="px-4 py-2 font-semibold text-sm uppercase">Foto</th>
                            <th class="px-4 py-2 font-semibold text-sm uppercase">Acta de Nacimiento</th>
                            <th class="px-4 py-2 font-semibold text-sm uppercase">Calificaciones</th>
                            <th class="px-4 py-2 font-semibold text-sm uppercase">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @forelse ($documentos as $doc)
                            <tr class="hover:bg-blue-50 transition-colors">

                                {{-- FOTO --}}
                                <td class="px-4 py-2">
                                    @if($doc->foto && file_exists(storage_path('app/public/' . $doc->foto)))
                                        <a href="{{ asset('storage/' . $doc->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doc->foto) }}" class="w-16 h-16 object-cover rounded mx-auto" alt="Foto del estudiante">
                                        </a>
                                    @else
                                        <span class="text-gray-400">No hay foto</span>
                                    @endif
                                </td>

                                {{-- ACTA --}}
                                <td class="px-4 py-2">
                                    @if($doc->acta_nacimiento && file_exists(storage_path('app/public/' . $doc->acta_nacimiento)))
                                        <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank"
                                           class="bg-blue-100 text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-200 transition">
                                            Ver Acta
                                        </a>
                                    @else
                                        <span class="text-gray-400">No hay acta</span>
                                    @endif
                                </td>

                                {{-- CALIFICACIONES --}}
                                <td class="px-4 py-2">
                                    @if($doc->calificaciones && file_exists(storage_path('app/public/' . $doc->calificaciones)))
                                        <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank"
                                           class="bg-teal-100 text-teal-700 px-3 py-1 rounded shadow hover:bg-teal-200 transition">
                                            Ver Calificaciones
                                        </a>
                                    @else
                                        <span class="text-gray-400">No hay calificaciones</span>
                                    @endif
                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-4 py-2 flex justify-center gap-2">
                                    <a href="{{ route('documentos.edit', $doc->id) }}"
                                       class="bg-yellow-400 text-white px-3 py-1 rounded shadow hover:bg-yellow-500 transition flex items-center gap-1">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 transition flex items-center gap-1"
                                                onclick="return confirm('¿Eliminar documentos?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
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

            .main-content {
                margin-left: 0;
                padding: 30px;
                min-height: 100vh;
                display: flex;
                justify-content: center;
            }

            .content-wrapper {
                width: 100%;
                max-width: 900px;
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
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border-bottom: 1px solid #e0f7fa;
            }

            th {
                padding: 12px;
            }

            td {
                padding: 8px;
            }

            a.btn-primary {
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                color: white;
                font-weight: 600;
                border-radius: 6px;
                padding: 8px 12px;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }

            @media (max-width: 768px) {
                .content-wrapper {
                    width: 100%;
                    padding: 0 15px;
                }
            }
        </style>
    @endpush
@endsection
