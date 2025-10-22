@extends('layouts.app')

@section('title', 'Listado de Documentos')

@section('content')
    <div class="max-w-6xl mx-auto my-10">

        {{-- Título --}}
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="bi bi-file-earmark-text"></i>Documentos
            </h1>
        </div>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-6 text-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón de subir documentos --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('documentos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 flex items-center gap-2">
                <i class="bi bi-upload"></i> Subir Nuevos Documentos
            </a>
        </div>

        {{-- Tabla refinada --}}
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <table class="min-w-full table-auto">
                <thead class="bg-blue-600 text-white text-center">
                <tr>
                    <th class="px-4 py-2 font-semibold text-sm uppercase">Nombre Estudiante</th>
                    <th class="px-4 py-2 font-semibold text-sm uppercase">Acta de Nacimiento</th>
                    <th class="px-4 py-2 font-semibold text-sm uppercase">Calificaciones</th>
                    <th class="px-4 py-2 font-semibold text-sm uppercase">Acciones</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @forelse ($documentos as $doc)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-4 py-2 font-semibold">{{ $doc->nombre_estudiante }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank"
                               class="bg-blue-100 text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-200 transition">
                                Ver Acta
                            </a>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank"
                               class="bg-teal-100 text-teal-700 px-3 py-1 rounded shadow hover:bg-teal-200 transition">
                                Ver Calificaciones
                            </a>
                        </td>
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

    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        table th, table td {
            font-size: 0.95rem;
        }

        table td a {
            font-size: 0.85rem;
        }

        button, .btn {
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        button:hover, .btn:hover {
            transform: translateY(-1px);
        }

        .bg-blue-50 {
            background-color: #e8f0fe;
        }
    </style>
@endsection


