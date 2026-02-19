@extends('layouts.app')

@section('title', 'Listado de Documentos')

@section('page-title', 'Gestión de Documentos')

@section('topbar-actions')
    <a href="{{ route('documentos.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Subir Documentos
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1400px;">

        {{-- Mensajes de Notificación --}}
        @if(session('success'))
            <div class="alert border-0 mb-3" style="background: rgba(76, 175, 80, 0.1); border-left: 3px solid #4caf50 !important; border-radius: 8px;">
                <div class="d-flex align-items-start">
                    <i class="fas fa-check-circle me-2 mt-1" style="font-size: 0.9rem; color: #4caf50;"></i>
                    <strong style="color: #2e7d32;">{{ session('success') }}</strong>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Estudiante</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Foto</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Acta de Nacimiento</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold" style="font-size: 0.75rem; color: #003b73;">Calificaciones</th>
                            <th class="px-3 py-3 text-uppercase fw-semibold text-end" style="font-size: 0.75rem; color: #003b73;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($documentos as $doc)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                {{-- ESTUDIANTE --}}
                                <td class="px-3">
                                    <div class="fw-bold" style="color: #003b73;">{{ $doc->estudiante->nombre ?? 'N/A' }}</div>
                                    <small class="text-muted">ID: {{ $doc->estudiante_id }}</small>
                                </td>

                                {{-- FOTO --}}
                                <td class="px-3">
                                    @if($doc->foto)
                                        <a href="{{ asset('storage/' . $doc->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doc->foto) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #4ec7d2;">
                                        </a>
                                    @else
                                        <i class="fas fa-user-circle text-muted fa-2x"></i>
                                    @endif
                                </td>

                                {{-- ACTA --}}
                                <td class="px-3">
                                    <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank" class="btn btn-sm" style="border: 1px solid #00508f; color: #00508f; border-radius: 6px;">
                                        <i class="fas fa-file-pdf me-1"></i> Ver Acta
                                    </a>
                                </td>

                                {{-- CALIFICACIONES --}}
                                <td class="px-3">
                                    <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank" class="btn btn-sm" style="border: 1px solid #4ec7d2; color: #4ec7d2; border-radius: 6px;">
                                        <i class="fas fa-file-alt me-1"></i> Ver Notas
                                    </a>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('documentos.edit', $doc->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este expediente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-50 mb-3">
                                    <h6 class="text-muted">No se encontraron expedientes digitales.</h6>
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
