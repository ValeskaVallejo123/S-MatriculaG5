@extends('layouts.app')

@section('title', 'Preferencias de Notificación')
@section('page-title', 'Preferencias de Notificación')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="fw-bold mb-4" style="color: #003b73;">Configura tus notificaciones</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('notificaciones.update') }}" method="POST">
                @csrf
                @method('PUT')

                <h5>Canales de notificación</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="correo" id="correo" {{ $preferencias->correo ? 'checked' : '' }}>
                    <label class="form-check-label" for="correo">Correo electrónico</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="mensaje_interno" id="mensaje_interno" {{ $preferencias->mensaje_interno ? 'checked' : '' }}>
                    <label class="form-check-label" for="mensaje_interno">Mensaje interno</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="alerta_visual" id="alerta_visual" {{ $preferencias->alerta_visual ? 'checked' : '' }}>
                    <label class="form-check-label" for="alerta_visual">Alerta visual</label>
                </div>

                <h5>Tipos de notificación</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="notificacion_horario" id="notificacion_horario" {{ $preferencias->notificacion_horario ? 'checked' : '' }}>
                    <label class="form-check-label" for="notificacion_horario">Cambios de horario</label>
                </div>

                @if(auth()->user()->isEstudiante())
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="notificacion_materia" id="notificacion_materia" {{ $preferencias->notificacion_materia ?? true ? 'checked' : '' }}>
                        <label class="form-check-label" for="notificacion_materia">Nueva materia asignada</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="notificacion_calificaciones" id="notificacion_calificaciones" {{ $preferencias->notificacion_calificaciones ?? true ? 'checked' : '' }}>
                        <label class="form-check-label" for="notificacion_calificaciones">Calificaciones publicadas</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="notificacion_observaciones" id="notificacion_observaciones" {{ $preferencias->notificacion_observaciones ?? true ? 'checked' : '' }}>
                        <label class="form-check-label" for="notificacion_observaciones">Observaciones del profesor</label>
                    </div>
                @endif

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="notificacion_administrativa" id="notificacion_administrativa" {{ $preferencias->notificacion_administrativa ? 'checked' : '' }}>
                    <label class="form-check-label" for="notificacion_administrativa">Avisos y recordatorios importantes</label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
@endsection
