@extends('layouts.app')

@section('title', 'Mis Notificaciones')
@section('page-title', 'Notificaciones')

@section('content')
<div class="container" style="max-width: 900px;">

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h4 class="fw-bold mb-4" style="color: #003b73;">Mis Notificaciones</h4>

            @if($notificaciones->isEmpty())
                <p class="text-muted">No tienes notificaciones por el momento.</p>
            @else
                <div class="list-group">
                    @foreach($notificaciones as $notificacion)
                        <div class="list-group-item list-group-item-action mb-2 {{ $notificacion->leida ? '' : 'border-start border-4 border-warning' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $notificacion->titulo }}</h6>
                                <small class="text-muted">{{ $notificacion->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-1">{{ $notificacion->descripcion }}</p>
                            @if(!$notificacion->leida)
                                <form action="{{ route('notificaciones.marcarLeida', $notificacion) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Marcar como leída</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
