@extends('layouts.app')

@section('title', 'Notificaciones')
@section('page-title', 'Mis Notificaciones')

@section('content')
<div class="container" style="max-width: 900px;">

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-white fw-bold mb-0">
                    <i class="fas fa-bell me-2"></i>Mis Notificaciones
                </h5>
                @if($notificaciones->isNotEmpty())
                    <span class="badge bg-white" style="color: #00508f;">
                        {{ $notificaciones->count() }} notificaciones
                    </span>
                @endif
            </div>
        </div>

        <div class="card-body p-4">

            @if($notificaciones->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-bell-slash fa-3x mb-3" style="color: #cbd5e1;"></i>
                    <p class="fw-semibold mb-1">No tienes notificaciones por el momento.</p>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($notificaciones as $notificacion)
                        <div class="card border-0 shadow-sm"
                             style="border-radius: 10px; border-left: 4px solid {{ $notificacion->leida ? '#cbd5e1' : '#4ec7d2' }} !important;
                                    background: {{ $notificacion->leida ? '#f8fafc' : 'white' }};">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            @if(!$notificacion->leida)
                                                <span class="badge" style="background: rgba(78,199,210,0.15); color: #00508f; font-size: 0.7rem;">
                                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Nueva
                                                </span>
                                            @else
                                                <span class="badge bg-secondary" style="font-size: 0.7rem;">Leída</span>
                                            @endif
                                            <span class="fw-bold" style="color: #003b73;">{{ $notificacion->titulo }}</span>
                                        </div>
                                        <p class="text-muted mb-1" style="font-size: 0.9rem;">{{ $notificacion->mensaje }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>{{ $notificacion->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    @if(!$notificacion->leida)
                                        <form action="{{ route('notificaciones.marcarLeida', $notificacion->id) }}" method="POST" class="flex-shrink-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-check me-1"></i>Marcar como leída
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
