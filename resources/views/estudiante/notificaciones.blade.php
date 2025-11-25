@extends('layouts.app')

@section('title', 'Notificaciones')
@section('page-title', 'Mis Notificaciones')

@section('content')
<div class="container" style="max-width: 900px; margin-top: 20px;">

    <h2 class="mb-4">Notificaciones</h2>

    @if($notificaciones->isEmpty())
        <div class="alert alert-info">
            No tienes notificaciones por el momento.
        </div>
    @else
        <div class="list-group">
            @foreach($notificaciones as $notificacion)
                <div class="list-group-item {{ $notificacion->leida ? '' : 'bg-light' }}">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $notificacion->titulo }}</strong>
                        <small>{{ $notificacion->created_at->diffForHumans() }}</small>
                    </div>
                    <p>{{ $notificacion->mensaje }}</p>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
