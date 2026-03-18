@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 text-primary fw-bold">
                            <i class="fas fa-folder-open me-2"></i>Gestión de Expedientes
                        </h5>
                        <a href="{{ route('documentos.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                            <i class="fas fa-plus me-1"></i> Nuevo Expediente
                        </a>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th style="width: 40%">Estudiante</th>
                                    <th class="text-center">Expediente Digital</th>
                                    <th>Fecha Registro</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($documentos as $documento)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- Foto en el círculo --}}
                                                <div class="me-3">
                                                    @if($documento->foto)
                                                        <img src="{{ asset('storage/' . $documento->foto) }}"
                                                             class="rounded-circle border shadow-sm"
                                                             style="width: 48px; height: 48px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border"
                                                             style="width: 48px; height: 48px;">
                                                            <i class="fas fa-user-graduate text-primary"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                {{-- Nombre completo usando el Accessor del Modelo --}}
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark">
                                                        {{ $documento->estudiante->nombre_completo ?? 'Estudiante no encontrado' }}
                                                    </h6>
                                                    <small class="text-muted">DNI: {{ $documento->estudiante->dni ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            {{-- BOTÓN ÚNICO PARA ABRIR LA CARPETA --}}
                                            <button type="button"
                                                    class="btn btn-info btn-sm text-white px-3 shadow-sm"
                                                    onclick="verCarpeta('{{ $documento->estudiante->nombre_completo }}', '{{ asset('storage/'.$documento->foto) }}', '{{ asset('storage/'.$documento->acta_nacimiento) }}', '{{ asset('storage/'.$documento->calificaciones) }}')">
                                                <i class="fas fa-folder-open me-1"></i> Abrir Carpeta
                                            </button>
                                        </td>

                                        <td class="text-muted small">
                                            {{ $documento->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="text-center">
                                            <form action="{{ route('documentos.destroy', $documento->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este expediente?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-5">No hay expedientes registrados.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE CARPETA DIGITAL --}}
    <div class="modal fade" id="modalCarpeta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-folder me-2"></i>Expediente: <span id="nombreTitulo"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="d-flex" style="height: 70vh;">
                        {{-- Mini Menú Lateral --}}
                        <div class="bg-light border-end" style="width: 200px;">
                            <div class="list-group list-group-flush" id="docsMenu">
                                <button class="list-group-item list-group-item-action active" onclick="mostrarArchivo('foto', this)">
                                    <i class="fas fa-camera me-2"></i> Foto Perfil
                                </button>
                                <button class="list-group-item list-group-item-action" onclick="mostrarArchivo('acta', this)">
                                    <i class="fas fa-file-pdf me-2"></i> Acta Nac.
                                </button>
                                <button class="list-group-item list-group-item-action" onclick="mostrarArchivo('notas', this)">
                                    <i class="fas fa-graduation-cap me-2"></i> Calificaciones
                                </button>
                            </div>
                        </div>
                        {{-- Visor Central --}}
                        <div class="flex-grow-1 bg-dark d-flex align-items-center justify-content-center p-2" id="visorContainer">
                            {{-- El contenido se carga por JS --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let archivosActuales = {};

            function verCarpeta(nombre, foto, acta, notas) {
                archivosActuales = { foto, acta, notas };
                document.getElementById('nombreTitulo').innerText = nombre;

                // Resetear al primer archivo
                const botones = document.querySelectorAll('#docsMenu button');
                mostrarArchivo('foto', botones[0]);

                new bootstrap.Modal(document.getElementById('modalCarpeta')).show();
            }

            function mostrarArchivo(tipo, btn) {
                // Estética de botones
                document.querySelectorAll('#docsMenu button').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const visor = document.getElementById('visorContainer');
                const url = archivosActuales[tipo];

                // Validar si el archivo existe
                if (!url || url.includes('storage/')) {
                    // Si el string termina en storage/ sin nada más, asumimos que no hay archivo
                    if(url.split('/').pop() === ""){
                        visor.innerHTML = '<h5 class="text-white opacity-50"><i class="fas fa-eye-slash me-2"></i>Archivo no disponible</h5>';
                        return;
                    }
                }

                // Detectar si es PDF o Imagen
                if (url.toLowerCase().endsWith('.pdf')) {
                    visor.innerHTML = `<embed src="${url}" type="application/pdf" width="100%" height="100%">`;
                } else {
                    visor.innerHTML = `<img src="${url}" style="max-width: 100%; max-height: 100%; object-fit: contain;" class="shadow-lg">`;
                }
            }
        </script>
    @endpush

    <style>
        .avatar-placeholder { background-color: #f0f7ff; }
        .list-group-item.active { background-color: #0d6efd !important; border-color: #0d6efd !important; }
        .table thead th { font-size: 0.8rem; letter-spacing: 0.5px; }
        .modal-content { border-radius: 15px; overflow: hidden; }
    </style>
@endsection
