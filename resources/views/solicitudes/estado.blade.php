@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#001D39] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-[#49769F] text-center mb-6">Consulta de estado de solicitud de matricula</h2>

            <form method="POST" action="/estado-solicitud" class="space-y-8">
                @csrf
                <label for="dni" class="block text-sm font-semibold text-gray-700">Buscar solicitud por DNI:</label>
                <input type="text" name="dni" id="dni" required
                       pattern="\d{4}-\d{4}-\d{5}"
                       title="Formato: ####-####-#####"
                       placeholder="Ej: 0801-1990-12345"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#4E8EA2] focus:outline-none text-sm shadow-sm text-center"
                >
                <div class="text-center">
                    <button type="submit"
                            class="px-6 py-2 bg-[#4E8EA2] text-white font-semibold rounded-lg shadow-md hover:bg-[#3f7c91] transition transform hover:scale-105">
                        Buscar solicitud de matricula
                    </button>
                </div>
            </form>

            @if(isset($solicitud))
                @if($solicitud)
                    <div class="mt-6 px-4 py-3 rounded-lg font-semibold text-center
                    @if($solicitud->estado === 'aprobada') bg-green-100 text-green-700
                    @elseif($solicitud->estado === 'rechazada') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                        @if($solicitud->estado === 'aprobada')
                            Tu solicitud ha sido aprobada.
                        @elseif($solicitud->estado === 'rechazada')
                            Tu solicitud fue rechazada.
                        @else
                            Tu solicitud está en revisión.
                        @endif
                    </div>

                    <div class="mt-6 bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                        <h4 class="text-[#49769F] font-bold mb-3">📋 Datos del estudiante</h4>
                        <p><strong>Nombre:</strong> {{ $solicitud->nombre }}</p>
                        <p><strong>DNI:</strong> {{ $solicitud->dni }}</p>
                        <p><strong>Correo:</strong> {{ $solicitud->correo }}</p>
                        <p><strong>Teléfono:</strong> {{ $solicitud->telefono }}</p>
                        <p><strong>Fecha de solicitud:</strong> {{ $solicitud->created_at->format('d/m/Y') }}</p>
                    </div>

                    @if($solicitud->notificar)
                        <p class="mt-4 text-sm text-gray-600 text-center">
                            Recibirás notificaciones cuando el estado cambie.
                        </p>
                    @endif
                @else
                    <div class="mt-6 bg-gray-200 text-gray-700 p-4 rounded-lg text-center font-semibold">
                        No se encontró ninguna solicitud con ese DNI. Verifica e intenta nuevamente.
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
