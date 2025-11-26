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

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="alert border-0 mb-3" style="background: rgba(76, 175, 80, 0.1); border-left: 3px solid #4caf50 !important; border-radius: 8px;">
                <div class="d-flex align-items-start">
                    <i class="fas fa-check-circle me-2 mt-1" style="font-size: 0.9rem; color: #4caf50;"></i>
                    <div>
                        <strong style="color: #2e7d32;">{{ session('success') }}</strong>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabla compacta de Documentos -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Foto</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acta de Nacimiento</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Calificaciones</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($documentos as $doc)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;">
                                {{-- FOTO --}}
                                <td class="px-3 py-2">
                                    @if($doc->foto && file_exists(storage_path('app/public/' . $doc->foto)))
                                        <a href="{{ asset('storage/' . $doc->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doc->foto) }}"
                                                 alt="Foto del estudiante"
                                                 class="rounded-circle object-fit-cover"
                                                 style="width: 35px; height: 35px; border: 2px solid #4ec7d2;">
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size: 0.85rem;">No hay foto</span>
                                    @endif
                                </td>

                                {{-- ACTA --}}
                                <td class="px-3 py-2">
                                    @if($doc->acta_nacimiento && file_exists(storage_path('app/public/' . $doc->acta_nacimiento)))
                                        <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank"
                                           class="btn btn-sm"
                                           style="border: 1.5px solid #00508f; color: #00508f; background: white; border-radius: 6px; padding: 0.3rem 0.6rem; font-size: 0.8rem; text-decoration: none;"
                                           onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                           onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                            Ver Acta
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size: 0.85rem;">No hay acta</span>
                                    @endif
                                </td>

                                {{-- CALIFICACIONES --}}
                                <td class="px-3 py-2">
                                    @if($doc->calificaciones && file_exists(storage_path('app/public/' . $doc->calificaciones)))
                                        <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank"
                                           class="btn btn-sm"
                                           style="border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.6rem; font-size: 0.8rem; text-decoration: none;"
                                           onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                           onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                            Ver Calificaciones
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size: 0.85rem;">No hay calificaciones</span>
                                    @endif
                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-3 py-2 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('documentos.edit', $doc->id) }}"
                                           class="btn btn-sm"
                                           style="border-radius: 6px 0 0 6px; border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                           onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                           onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar documentos?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm"
                                                    style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                    onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                                    onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                        <h6 style="color: #003b73;">No hay documentos registrados</h6>
                                        <p class="small mb-3">Comienza cargando los primeros documentos</p>
                                        <a href="{{ route('documentos.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem; text-decoration: none; display: inline-block;">
                                            <i class="fas fa-plus me-1"></i>Subir Documentos
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .table > :not(caption) > * > * {
                padding: 0.6rem 0.75rem;
            }

            .btn-group .btn:hover {
                transform: translateY(-1px);
                z-index: 1;
            }

            .table tbody tr:hover {
                background-color: rgba(191, 217, 234, 0.08);
            }

            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
            }
        </style>
    @endpush
@endsection