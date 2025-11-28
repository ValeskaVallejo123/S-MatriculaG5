@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Mis Notificaciones</h1>

    @if($notificaciones->isEmpty())
        <p>No tienes notificaciones por el momento.</p>
    @else
        <ul class="space-y-4">
            @foreach($notificaciones as $notificacion)
                <li class="p-4 border rounded {{ $notificacion->leida ? 'bg-gray-100' : 'bg-white' }}">
                    <div class="flex justify-between">
                        <span>{{ $notificacion->titulo }}</span>
                        <form action="{{ route('notificaciones.marcarLeida', $notificacion->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            @if(!$notificacion->leida)
                                <button type="submit" class="text-blue-600 hover:underline">Marcar como leída</button>
                            @endif
                        </form>
                    </div>
                    <p class="text-sm text-gray-600">{{ $notificacion->mensaje }}</p>
                    <p class="text-xs text-gray-400">{{ $notificacion->created_at->diffForHumans() }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
