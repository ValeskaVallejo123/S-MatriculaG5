@extends('layouts.app')

@section('title', 'Grados')

@section('page-title', 'Gestión de Grados')

@section('topbar-actions')
    <a href="{{ route('grados.create') }}" class="btn-back" 
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i> Nuevo Grado
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; background-color: #d1f7e0; border-color: #4ec7d2; color: #00508f;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Barra de búsqueda --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text" id="searchInput" class="form-control form-control-sm ps-5" placeholder="Buscar grado, maestro o jornada..." style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-school" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #00508f;">{{ $grados->count() }}</strong> <span class="text-muted">Total de Grados</span></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-sun" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #4ec7d2;">{{ $grados->where('jornada', 'Matutina')->count() }}</strong> <span class="text-muted">Matutinos</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-r
esponsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f0f8ff;">
                        <tr>
                            <th style="color: #00508f; font-weight: 600;">Grado</th>
                            <th style="color: #00508f; font-weight: 600;">Maestro</th>
                            <th style="color: #00508f; font-weight: 600;">Jornada</th>
                            <th style="color: #00508f; font-weight: 600; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="gradosTableBody">
                        @foreach($grados as $grado)
                            <tr>
                                <td>{{ $grado->nombre }}</td>
                                <td>
    {{ optional($grado->maestro)->nombre ?? 'Sin asignar' }}
    {{ optional($grado->maestro)->apellido ?? '' }}
</td>

                                <td>{{ $grado->jornada }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('grados.edit', $grado->id) }}" class="btn btn-sm" 
                                       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 6px; padding: 0.3rem 0.6rem; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    
@endsection