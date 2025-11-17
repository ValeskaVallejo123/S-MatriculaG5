@extends('layouts.app')

@section('title', 'Horarios')

@section('page-title')
    @if(Auth::check() && Auth::user()->user_type === 'profesor')
        Mis Horarios
    @elseif(Auth::check() && Auth::user()->user_type === 'estudiante')
        Mi Horario
    @else
        Gestión de Horarios
    @endif
@endsection

@section('topbar-actions')
    @if(Auth::check() && Auth::user()->user_type !== 'estudiante')
        <a href="{{ route('horarios.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
            <i class="fas fa-plus"></i>
            Nuevo Horario
        </a>
    @endif
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 8px; padding: 12px 15px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 8px; padding: 12px 15px;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabla de horarios -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color: #003b73;">
                    <thead style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.15), rgba(0, 80, 143, 0.1)); border-bottom: 2px solid #4ec7d2;">
                        <tr>
                            <th>Profesor</th>
                            <th>Día</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Grado</th>
                            <th>Sección</th>
                            <th>Aula</th>
                            @if(Auth::check() && Auth::user()->user_type !== 'estudiante')
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($horarios as $horario)
                            @php $estaReciente = $horario->updated_at->diffInHours(now()) < 24; @endphp
                            <tr style="{{ $estaReciente ? 'background-color: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107;' : '' }}">
                                <td>{{ $horario->profesor->nombre ?? 'Sin asignar' }}</td>
                                <td>{{ $horario->dia }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_inicio)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_fin)->format('H:i') }}</td>
                                <td>{{ $horario->grado }}</td>
                                <td>{{ $horario->seccion }}</td>
                                <td>{{ $horario->aula ?? '—' }}</td>
                                @if(Auth::check() && Auth::user()->user_type !== 'estudiante')
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('horarios.show', $horario) }}" class="btn btn-sm btn-outline-primary" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-sm btn-outline-info" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('horarios.destroy', $horario) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar este horario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::check() && Auth::user()->user_type !== 'estudiante' ? 8 : 7 }}" class="text-center">
                                    No hay horarios registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($horarios->hasPages())
        <div class="card border-0 shadow-sm mt-3" style="border-radius: 10px;">
            <div class="card-body py-2 px-3">
                {{ $horarios->links() }}
            </div>
        </div>
    @endif

    <small class="text-muted d-block mt-3">
        Los horarios resaltados en amarillo han sido modificados en las últimas 24 horas.
    </small>
</div>
@endsection
