@extends('layouts.app')

@section('title', 'Preferencias de Notificación')
@section('page-title', 'Preferencias de Notificación')

@section('content')
<div class="container" style="max-width: 800px;">

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-bell me-2"></i>Configura tus notificaciones
            </h5>
        </div>

        <div class="card-body p-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" style="border-left: 4px solid #10b981; border-radius: 8px;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" style="border-left: 4px solid #ef4444; border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('notificaciones.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Canales de notificación --}}
                <div class="card border-0 mb-4" style="background: #f8fafc; border-radius: 10px;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-3" style="color: #003b73;">
                            <i class="fas fa-satellite-dish me-2" style="color: #4ec7d2;"></i>Canales de notificación
                        </h6>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="correo" id="correo"
                                {{ $preferencias->correo ? 'checked' : '' }}>
                            <label class="form-check-label" for="correo">
                                <i class="fas fa-envelope me-1 text-muted"></i> Correo electrónico
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="mensaje_interno" id="mensaje_interno"
                                {{ $preferencias->mensaje_interno ? 'checked' : '' }}>
                            <label class="form-check-label" for="mensaje_interno">
                                <i class="fas fa-inbox me-1 text-muted"></i> Mensaje interno
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="alerta_visual" id="alerta_visual"
                                {{ $preferencias->alerta_visual ? 'checked' : '' }}>
                            <label class="form-check-label" for="alerta_visual">
                                <i class="fas fa-desktop me-1 text-muted"></i> Alerta visual
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Tipos de notificación --}}
                <div class="card border-0 mb-4" style="background: #f8fafc; border-radius: 10px;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-3" style="color: #003b73;">
                            <i class="fas fa-filter me-2" style="color: #4ec7d2;"></i>Tipos de notificación
                        </h6>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="notificacion_horario" id="notificacion_horario"
                                {{ $preferencias->notificacion_horario ? 'checked' : '' }}>
                            <label class="form-check-label" for="notificacion_horario">
                                <i class="fas fa-calendar-alt me-1 text-muted"></i> Cambios de horario
                            </label>
                        </div>

                        @if(auth()->user()->isEstudiante())
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="notificacion_materia" id="notificacion_materia"
                                    {{-- Paréntesis corregidos para evitar error de precedencia --}}
                                    {{ ($preferencias->notificacion_materia ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notificacion_materia">
                                    <i class="fas fa-book me-1 text-muted"></i> Nueva materia asignada
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="notificacion_calificaciones" id="notificacion_calificaciones"
                                    {{ ($preferencias->notificacion_calificaciones ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notificacion_calificaciones">
                                    <i class="fas fa-star me-1 text-muted"></i> Calificaciones publicadas
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="notificacion_observaciones" id="notificacion_observaciones"
                                    {{ ($preferencias->notificacion_observaciones ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notificacion_observaciones">
                                    <i class="fas fa-comment-alt me-1 text-muted"></i> Observaciones del profesor
                                </label>
                            </div>
                        @endif

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="notificacion_administrativa" id="notificacion_administrativa"
                                {{ $preferencias->notificacion_administrativa ? 'checked' : '' }}>
                            <label class="form-check-label" for="notificacion_administrativa">
                                <i class="fas fa-bullhorn me-1 text-muted"></i> Avisos y recordatorios importantes
                            </label>
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Guardar cambios
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
