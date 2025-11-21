<<<<<<< HEAD
@extends('layouts.app')

@section('title', 'Ver Grado')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalles del Grado</h1>
                <a href="{{ route('grados.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                    Volver
                </a>
            </div>

            <!-- Información General del Grado -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-100">
                    Información General
                </h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">ID</label>
                        <p class="text-lg text-gray-900">{{ $grado->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jornada</label>
                        <span
                            class="px-3 py-1 text-sm rounded-full {{ $grado->jornada == 'Matutina' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $grado->jornada == 'Matutina' ? '☀️ Matutina' : '🌙 Vespertina' }}
                        </span>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                        <p class="text-lg text-gray-900 font-semibold">{{ $grado->nombre }}</p>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Sección</label>
                        <p class="text-lg text-gray-900">{{ $grado->descripcion ?? 'Sin descripción' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Creado</label>
                        <p class="text-sm text-gray-700">
                            {{ $grado->created_at ? $grado->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Actualizado</label>
                        <p class="text-sm text-gray-700">
                            {{ $grado->updated_at ? $grado->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                </div>
            </div>

            <!-- Asignaturas Comunes -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-100">
                    📚 Asignaturas Comunes
                </h2>
                <p class="text-sm text-gray-600 mb-4">Materias que se imparten en este grado:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $asignaturas = [
                            [
                                'nombre' => 'Español',
                                'descripcion' => 'Lectura, escritura y gramática',
                                'icono' => '📖',
                                'color' => 'bg-red-50 border-red-200 text-red-800'
                            ],
                            [
                                'nombre' => 'Matemáticas',
                                'descripcion' => 'Aritmética y conceptos básicos de geometría',
                                'icono' => '🔢',
                                'color' => 'bg-blue-50 border-blue-200 text-blue-800'
                            ],
                            [
                                'nombre' => 'Ciencias',
                                'descripcion' => 'Ciencias Naturales y Ciencias Sociales',
                                'icono' => '🔬',
                                'color' => 'bg-green-50 border-green-200 text-green-800'
                            ],
                            [
                                'nombre' => 'Inglés',
                                'descripcion' => 'Introducción al idioma extranjero',
                                'icono' => '🌎',
                                'color' => 'bg-purple-50 border-purple-200 text-purple-800'
                            ],
                            [
                                'nombre' => 'Educación Física',
                                'descripcion' => 'Actividades deportivas y recreativas',
                                'icono' => '⚽',
                                'color' => 'bg-orange-50 border-orange-200 text-orange-800'
                            ],
                            [
                                'nombre' => 'Formación Ciudadana y Ética',
                                'descripcion' => 'Valores cívicos y formación moral',
                                'icono' => '🏛️',
                                'color' => 'bg-indigo-50 border-indigo-200 text-indigo-800'
                            ],
                            [
                                'nombre' => 'Arte',
                                'descripcion' => 'Expresión artística y creatividad',
                                'icono' => '🎨',
                                'color' => 'bg-pink-50 border-pink-200 text-pink-800'
                            ],
                            [
                                'nombre' => 'Computación',
                                'descripcion' => 'Habilidades tecnológicas básicas',
                                'icono' => '💻',
                                'color' => 'bg-gray-50 border-gray-200 text-gray-800'
                            ]
                        ];
                    @endphp

                    @foreach ($asignaturas as $asignatura)
                        <div class="border-2 rounded-lg p-4 {{ $asignatura['color'] }} hover:shadow-md transition">
                            <div class="flex items-start">
                                <span class="text-3xl mr-3">{{ $asignatura['icono'] }}</span>
                                <div>
                                    <h3 class="font-semibold text-base mb-1">{{ $asignatura['nombre'] }}</h3>
                                    <p class="text-sm opacity-80">{{ $asignatura['descripcion'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>📌 Nota:</strong> Estas son las asignaturas comunes para todos los grados de educación primaria en Honduras.
                    </p>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex gap-4">
                    <a href="{{ route('grados.edit', $grado) }}"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition">
                        ✏️ Editar Grado
                    </a>
                    <form action="{{ route('grados.destroy', $grado) }}" method="POST" class="flex-1"
                        onsubmit="return confirm('¿Está seguro de eliminar este grado?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                            🗑️ Eliminar Grado
                        </button>
                    </form>
=======
@extends('layouts.admin')

@section('title', 'Detalle de Grado')

@section('page-title', 'Detalle de Grado')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('grados.asignar-materias', $grado) }}" class="btn-back" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); font-size: 0.9rem;">
            <i class="fas fa-tasks"></i>
            Gestionar Materias
        </a>
        <a href="{{ route('grados.edit', $grado) }}" class="btn-back" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3); font-size: 0.9rem;">
            <i class="fas fa-edit"></i>
            Editar
        </a>
        <a href="{{ route('grados.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
@endsection

@section('content')
<div class="container" style="max-width: 1200px;">

    <!-- Mensaje de éxito -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-graduation-cap"></i> Información del Grado
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Nombre del Grado -->
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-school me-3" style="color: #4ec7d2; font-size: 1.5rem;"></i>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">GRADO Y SECCIÓN</small>
                                    <h3 class="mb-0 fw-bold" style="color: #003b73;">
                                        {{ $grado->numero }}° Grado 
                                        @if($grado->seccion)
                                            <span style="color: #4ec7d2;">Sección {{ $grado->seccion }}</span>
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Nivel -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(78, 199, 210, 0.05); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">NIVEL EDUCATIVO</small>
                                @if($grado->nivel === 'primaria')
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.9rem;">
                                        <i class="fas fa-child"></i> Primaria (1° - 6°)
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(0, 80, 143, 0.2); color: #003b73; border: 1px solid #00508f; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.9rem;">
                                        <i class="fas fa-user-graduate"></i> Secundaria (7° - 9°)
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Año Lectivo -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(0, 80, 143, 0.05); border-radius: 8px; border-left: 3px solid #00508f;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">AÑO LECTIVO</small>
                                <span class="fw-bold" style="color: #003b73; font-size: 1.1rem;">
                                    <i class="fas fa-calendar-alt" style="color: #4ec7d2;"></i> {{ $grado->anio_lectivo }}
                                </span>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(78, 199, 210, 0.05); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">ESTADO</small>
                                @if($grado->activo)
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.4rem 0.8rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.9rem;">
                                        <i class="fas fa-check-circle"></i> Activo
                                    </span>
                                @else
                                    <span class="badge" style="background: #fee2e2; color: #991b1b; padding: 0.4rem 0.8rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.9rem;">
                                        <i class="fas fa-times-circle"></i> Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Total Materias -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(0, 80, 143, 0.05); border-radius: 8px; border-left: 3px solid #00508f;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">MATERIAS ASIGNADAS</small>
                                <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.9rem;">
                                    <i class="fas fa-book"></i> {{ $grado->materias->count() }} Materias
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materias Asignadas -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-book-open"></i> Materias Asignadas ({{ $grado->materias->count() }})
                        </h6>
                        <a href="{{ route('grados.asignar-materias', $grado) }}" class="btn btn-sm" style="background: white; color: #10b981; border-radius: 6px; padding: 0.3rem 0.8rem; font-weight: 600;">
                            <i class="fas fa-plus"></i> Gestionar
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($grado->materias->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x mb-3" style="color: #00508f; opacity: 0.3;"></i>
                            <h6 style="color: #003b73;">No hay materias asignadas</h6>
                            <p class="text-muted mb-3">Asigna materias a este grado para comenzar</p>
                            <a href="{{ route('grados.asignar-materias', $grado) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                <i class="fas fa-plus"></i> Asignar Materias
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background: rgba(16, 185, 129, 0.1);">
                                    <tr>
                                        <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Materia</th>
                                        <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Código</th>
                                        <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Área</th>
                                        <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Profesor</th>
                                        <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Horas/Semana</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grado->materias as $materia)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="px-3 py-2">
                                            <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $materia->nombre }}</div>
                                        </td>
                                        <td class="px-3 py-2">
                                            <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-family: monospace; font-size: 0.75rem;">
                                                {{ $materia->codigo }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2">
                                            <span class="badge" style="background: rgba(0, 80, 143, 0.1); color: #00508f; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                                {{ $materia->area }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2">
                                            @if($materia->pivot->profesor_id)
                                                <i class="fas fa-user-tie" style="color: #4ec7d2;"></i>
                                                <span class="small">{{ \App\Models\User::find($materia->pivot->profesor_id)->name ?? 'No asignado' }}</span>
                                            @else
                                                <span class="text-muted small">
                                                    <i class="fas fa-user-times"></i> Sin asignar
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2">
                                            <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                                {{ $materia->pivot->horas_semanales }} hrs
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Estadísticas -->
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #bfd9ea; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <h6 class="mb-0 fw-bold" style="color: #003b73;">
                        <i class="fas fa-chart-bar text-primary"></i> Estadísticas
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background: rgba(78, 199, 210, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-book me-2" style="color: #4ec7d2; font-size: 1.2rem;"></i>
                            <span class="small text-muted">Total materias</span>
                        </div>
                        <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.4rem 0.7rem; font-size: 0.9rem;">
                            {{ $grado->materias->count() }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background: rgba(0, 80, 143, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-2" style="color: #00508f; font-size: 1.2rem;"></i>
                            <span class="small text-muted">Horas totales/semana</span>
                        </div>
                        <span class="badge" style="background: rgba(0, 80, 143, 0.2); color: #003b73; padding: 0.4rem 0.7rem; font-size: 0.9rem;">
                            {{ $grado->materias->sum('pivot.horas_semanales') }} hrs
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-2" style="background: rgba(16, 185, 129, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chalkboard-teacher me-2" style="color: #10b981; font-size: 1.2rem;"></i>
                            <span class="small text-muted">Profesores asignados</span>
                        </div>
                        <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #059669; padding: 0.4rem 0.7rem; font-size: 0.9rem;">
                            {{ $grado->materias->where('pivot.profesor_id', '!=', null)->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #bfd9ea; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <h6 class="mb-0 fw-bold" style="color: #003b73;">
                        <i class="fas fa-bolt text-warning"></i> Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('grados.asignar-materias', $grado) }}" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 8px; padding: 0.6rem; font-weight: 600;">
                            <i class="fas fa-tasks"></i> Gestionar Materias
                        </a>
                        <a href="{{ route('grados.edit', $grado) }}" class="btn" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 8px; padding: 0.6rem; font-weight: 600;">
                            <i class="fas fa-edit"></i> Editar Grado
                        </a>
                        <a href="{{ route('materias.index') }}" class="btn" style="background: white; color: #4ec7d2; border: 2px solid #4ec7d2; border-radius: 8px; padding: 0.6rem; font-weight: 600;">
                            <i class="fas fa-book"></i> Ver Materias
                        </a>
                        <form action="{{ route('grados.destroy', $grado) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Está seguro de eliminar este grado?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn w-100" style="background: white; color: #ef4444; border: 2px solid #ef4444; border-radius: 8px; padding: 0.6rem; font-weight: 600;">
                                <i class="fas fa-trash"></i> Eliminar Grado
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #bfd9ea; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <h6 class="mb-0 fw-bold" style="color: #003b73;">
                        <i class="fas fa-info-circle text-info"></i> Información del Sistema
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Creado:</span>
                            <strong style="color: #003b73;">{{ $grado->created_at->format('d/m/Y') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Última actualización:</span>
                            <strong style="color: #003b73;">{{ $grado->updated_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======

</div>

@push('styles')
<style>
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-back:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
@endsection