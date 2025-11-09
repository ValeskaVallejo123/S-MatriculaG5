@extends('layouts.app')

@section('title', 'Perfil Super Admin')

@section('page-title', 'Perfil del Super Administrador')

@section('content')
<div class="container" style="max-width: 1000px;">
    
    <!-- Tarjeta de Bienvenida -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 4px solid #4ec7d2; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                        <i class="fas fa-user-shield" style="font-size: 2rem; color: white;"></i>
                    </div>
                </div>
                <div class="col">
                    <h2 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.5rem;">
                        Bienvenido, {{ auth()->user()->name }}
                    </h2>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-envelope me-1"></i>{{ auth()->user()->email }}
                        </span>
                        <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.5rem 1rem; font-weight: 600; border: 2px solid #4ec7d2; font-size: 0.85rem;">
                            <i class="fas fa-crown me-1"></i>Super Administrador
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h5 class="mb-4 fw-bold" style="color: #003b73;">
                <i class="fas fa-rocket me-2" style="color: #4ec7d2;"></i>
                Accesos Rápidos
            </h5>

            <div class="row g-3">
                <!-- Gestión de Administradores -->
                <div class="col-md-4">
                    <a href="{{ route('superadmin.administradores.index') }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 10px; transition: all 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-users-cog" style="font-size: 2.5rem; color: white; margin-bottom: 1rem;"></i>
                                <h6 class="text-white fw-bold mb-1">Administradores</h6>
                                <p class="text-white small mb-0" style="opacity: 0.9;">Gestionar usuarios admin</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Estudiantes -->
                <div class="col-md-4">
                    <a href="{{ route('estudiantes.index') }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; transition: all 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-user-graduate" style="font-size: 2.5rem; color: white; margin-bottom: 1rem;"></i>
                                <h6 class="text-white fw-bold mb-1">Estudiantes</h6>
                                <p class="text-white small mb-0" style="opacity: 0.9;">Ver matriculados</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Profesores -->
                <div class="col-md-4">
                    <a href="{{ route('profesores.index') }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); border-radius: 10px; transition: all 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-chalkboard-teacher" style="font-size: 2.5rem; color: white; margin-bottom: 1rem;"></i>
                                <h6 class="text-white fw-bold mb-1">Profesores</h6>
                                <p class="text-white small mb-0" style="opacity: 0.9;">Gestionar docentes</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush