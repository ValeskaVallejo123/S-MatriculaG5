@extends('layouts.app')

@section('title', 'Preferencias de Notificación')

@section('content')
<div class="container" style="max-width: 700px;">
    <h2 class="mb-4">Configuración de Notificaciones</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('notificaciones.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="correo" id="correo" {{ $preferencias->correo ? 'checked' : '' }}>
            <label class="form-check-label" for="correo">Correo electrónico</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="mensaje_interno" id="mensaje_interno" {{ $preferencias->mensaje_interno ? 'checked' : '' }}>
            <label class="form-check-label" for="mensaje_interno">Mensaje interno</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="alerta_visual" id="alerta_visual" {{ $preferencias->alerta_visual ? 'checked' : '' }}>
            <label class="form-check-label" for="alerta_visual">Alerta visual</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="notificacion_academica" id="notificacion_academica" {{ $preferencias->notificacion_academica ? 'checked' : '' }}>
            <label class="form-check-label" for="notificacion_academica">Notificaciones académicas</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="notificacion_administrativa" id="notificacion_administrativa" {{ $preferencias->notificacion_administrativa ? 'checked' : '' }}>
            <label class="form-check-label" for="notificacion_administrativa">Notificaciones administrativas</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="recordatorios" id="recordatorios" {{ $preferencias->recordatorios ? 'checked' : '' }}>
            <label class="form-check-label" for="recordatorios">Recordatorios</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar preferencias</button>
    </form>
</div>
@endsection
