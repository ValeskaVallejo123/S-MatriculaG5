@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#001D39] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-[#49769F] text-center mb-6">Períodos académicos registrados</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg text-center font-semibold mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                    <tr class="bg-[#4E8EA2] text-white text-sm uppercase">
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Inicio</th>
                        <th class="px-4 py-3">Fin</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="text-center text-sm text-gray-700">
                    @forelse($periodos as $periodo)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $periodo->nombre_periodo }}</td>
                            <td class="px-4 py-2">{{ ucfirst($periodo->tipo) }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('periodos-academicos.edit', $periodo->id) }}"
                                       class="px-3 py-1 bg-[#4E8EA2] text-white rounded-md hover:bg-[#3f7c91] transition">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('periodos-academicos.destroy', $periodo->id) }}"
                                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar este período académico?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-[#6EA2B3] text-white rounded-md hover:bg-[#5a90a1] transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-gray-500">No hay períodos registrados aún.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('periodos-academicos.create') }}"
                   class="inline-block px-6 py-3 bg-[#001D39] text-white font-semibold rounded-lg hover:bg-[#00152c] transition">
                    Registrar nuevo período
                </a>
            </div>
        </div>
    </div>
@endsection
