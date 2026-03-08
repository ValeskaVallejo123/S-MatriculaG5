@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Listado de Expedientes Digitales</h5>
                <a href="{{ route('documentos.create') }}" class="btn btn-light btn-sm fw-bold">
                    <i class="fas fa-plus"></i> NUEVO EXPEDIENTE
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">ID</th>
                            <th>Estudiante</th>
                            <th class="text-center">Foto</th>
                            <th class="text-center">Acta</th>
                            <th class="text-center">Notas</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($documentos as $doc)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $doc->id }}</td>
                                <td>
                                    <div class="fw-bold text-primary">
                                        {{ $doc->estudiante->nombre1 }} {{ $doc->estudiante->nombre2 }}
                                        {{ $doc->estudiante->apellido1 }} {{ $doc->estudiante->apellido2 }}
                                    </div>
                                    <small class="text-muted">Estudiante ID: {{ $doc->estudiante_id }}</small>
                                </td>
                                <td class="text-center">
                                    @if($doc->foto)
                                        <a href="{{ asset('storage/' . $doc->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doc->foto) }}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover; border: 1px solid #dee2e6;">
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted border">Sin foto</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($doc->acta_nacimiento)
                                        <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-file-pdf"></i> Ver
                                        </a>
                                    @else
                                        <span class="text-muted small">---</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($doc->calificaciones)
                                        <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-file-alt"></i> Ver
                                        </a>
                                    @else
                                        <span class="text-muted small">---</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('documentos.edit', $doc->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este expediente permanentemente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <h5 class="text-muted">No se encontraron expedientes registrados.</h5>
                                    <a href="{{ route('documentos.create') }}" class="btn btn-primary mt-2">Crear el primero</a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
