@extends('layouts.app')

@section('title', 'Gestión de Expedientes')
@section('page-title', 'Expedientes Digitales')

@section('topbar-actions')
    <button type="button" class="btn fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSeleccionarEstudiante"
            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; border: none; padding: 10px 20px;">
        <i class="fas fa-plus me-1"></i> Nuevo Expediente
    </button>
@endsection

@section('content')

    {{-- Notificaciones --}}
    @if(session('success'))
        <div class="alert border-0 mb-3 shadow-sm" style="background: rgba(76, 175, 80, 0.1); border-left: 4px solid #4caf50 !important; color: #2e7d32;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Tabla Principal --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="px-4 py-3 text-muted small fw-bold text-uppercase">Estudiante</th>
                        <th class="px-4 py-3 text-muted small fw-bold text-uppercase text-center">Expediente</th>
                        <th class="px-4 py-3 text-muted small fw-bold text-uppercase">Fecha</th>
                        <th class="px-4 py-3 text-muted small fw-bold text-uppercase text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($documentos as $doc)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($doc->foto)
                                            <img src="/storage/{{ $doc->foto }}?v={{ time() }}"
                                                 class="rounded-circle border shadow-sm"
                                                 style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #4ec7d2 !important;">
                                        @else
                                            <div class="avatar-mini">{{ strtoupper(substr($doc->estudiante->nombre1 ?? 'E', 0, 1)) }}</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark text-capitalize">{{ strtolower($doc->estudiante->nombre1) }} {{ strtolower($doc->estudiante->apellido1) }}</div>
                                        <div class="text-muted small">DNI: {{ $doc->estudiante->dni }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button class="btn btn-sm fw-bold" style="background: #f0f9ff; color: #00508f; border: 1px solid #4ec7d2; border-radius: 7px;"
                                        onclick="verCarpeta('{{ $doc->estudiante->nombre1 }}', '/storage/{{ $doc->foto }}', '/storage/{{ $doc->acta_nacimiento }}', '/storage/{{ $doc->calificaciones }}')">
                                    <i class="fas fa-folder-open me-1"></i> Abrir
                                </button>
                            </td>
                            <td class="px-4 py-3 text-muted small">{{ $doc->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-end">
                                <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" id="delete-form-{{ $doc->id }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-link text-danger p-0" onclick="confirmarEliminar({{ $doc->id }}, '{{ $doc->estudiante->nombre1 }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-5 text-muted">No hay expedientes registrados.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL 1: SELECCIONAR ESTUDIANTE (ANCHO MEJORADO) --}}
    <div class="modal fade" id="modalSeleccionarEstudiante" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 text-white" style="background: #00508f; border-radius: 16px 16px 0 0; padding: 1.2rem 1.5rem;">
                    <h5 class="modal-title fw-bold"><i class="fas fa-user-graduate me-2"></i> Seleccionar Estudiante</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Buscador --}}
                    <div class="input-group mb-4 shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="busquedaEstudiante" class="form-control border-0" placeholder="Buscar por nombre, apellido o DNI..." style="height: 50px;">
                    </div>

                    {{-- Filtros por Grado --}}
                    <div class="d-flex gap-2 mb-4 overflow-auto pb-2" id="contenedorFiltros">
                        <button class="btn btn-sm rounded-pill btn-grado active" data-grado="todos" style="padding: 8px 20px;">Todos</button>
                        @foreach($estudiantes->pluck('grado')->unique()->filter() as $grado)
                            <button class="btn btn-sm rounded-pill btn-grado" data-grado="{{ $grado }}" style="padding: 8px 20px;">{{ $grado }}</button>
                        @endforeach
                    </div>

                    {{-- Lista de Estudiantes --}}
                    <div id="listaEstudiantes" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                        @foreach($estudiantes as $e)
                            <div class="estudiante-item d-flex align-items-center p-3 mb-3 shadow-sm border"
                                 data-grado="{{ $e->grado ?? 'N/A' }}"
                                 onclick="prepararCarga({{ $e->id }}, '{{ $e->nombre1 }} {{ $e->apellido1 }}')"
                                 style="border-radius: 15px; cursor: pointer; transition: 0.3s; background: white;">

                                <div class="avatar-mini me-4" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    {{ strtoupper(substr($e->nombre1, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                        {{ ucwords(strtolower($e->nombre1 . ' ' . $e->apellido1)) }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="far fa-id-card me-1"></i>{{ $e->dni }}
                                        <span class="mx-2">|</span>
                                        <span class="badge rounded-pill bg-light text-dark border fw-normal">{{ $e->grado ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="text-muted ms-3"><i class="fas fa-chevron-right"></i></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-2 px-4 d-flex justify-content-between" style="border-radius: 0 0 16px 16px;">
                    <small class="text-muted">Mostrando <span id="contadorEstudiantes">{{ $estudiantes->count() }}</span> estudiantes</small>
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Haz clic para seleccionar</small>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL 2: CARGA DE ARCHIVOS --}}
    <div class="modal fade" id="modalCarga" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px;">
                <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="estudiante_id" id="estudiante_id_input">
                    <div class="modal-header border-0 bg-light">
                        <h6 class="modal-title fw-bold">Nuevo Expediente: <span id="nombreEstudianteDoc" class="text-primary"></span></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div id="previewFoto" class="mx-auto rounded-circle border mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 110px; height: 110px; background: #f8fafc; border: 2px dashed #4ec7d2 !important; overflow: hidden;">
                            <i class="fas fa-camera fa-2x text-muted"></i>
                        </div>
                        <input type="file" name="foto" id="inputFotoCarga" class="d-none" accept="image/*" required onchange="previewImg(this)">
                        <button type="button" class="btn btn-sm mb-4" style="background: #e0f2fe; color: #00508f; font-weight: 600;" onclick="document.getElementById('inputFotoCarga').click()">Subir Foto de Perfil</button>

                        <div class="text-start">
                            <div class="mb-3">
                                <label class="small fw-bold text-muted text-uppercase">Acta de Nacimiento (PDF/JPG)</label>
                                <input type="file" name="acta_nacimiento" class="form-control" style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold text-muted text-uppercase">Calificaciones (PDF/JPG)</label>
                                <input type="file" name="calificaciones" class="form-control" style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn w-100 fw-bold text-white py-2" style="background: linear-gradient(135deg, #4ec7d2, #00508f); border-radius: 10px; border: none;">Guardar Expediente Completo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL 3: VISOR --}}
    <div class="modal fade" id="modalVisor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; height: 85vh;">
                <div class="modal-header text-white border-0" style="background: #003b73;">
                    <h6 class="modal-title fw-bold" id="visorTitulo"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0 d-flex bg-white">
                    <div class="bg-light border-end d-flex flex-column shadow-sm" style="width: 220px;">
                        <button class="btn btn-light text-start p-3 border-bottom active rounded-0 fw-bold visor-menu-btn" onclick="cambiarArchivo('foto', this)">
                            <i class="fas fa-user-circle me-2"></i>1. Foto Perfil
                        </button>
                        <button class="btn btn-light text-start p-3 border-bottom rounded-0 fw-bold visor-menu-btn" onclick="cambiarArchivo('acta', this)">
                            <i class="fas fa-file-contract me-2"></i>2. Acta Nacimiento
                        </button>
                        <button class="btn btn-light text-start p-3 border-bottom rounded-0 fw-bold visor-menu-btn" onclick="cambiarArchivo('notas', this)">
                            <i class="fas fa-file-invoice me-2"></i>3. Calificaciones
                        </button>
                    </div>
                    <div class="flex-grow-1 d-flex align-items-center justify-content-center p-3 bg-dark" id="visorContent"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .btn-grado { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; margin-right: 5px; white-space: nowrap; font-weight: 500; transition: 0.2s; }
        .btn-grado.active { background: #00508f !important; color: white !important; border-color: #00508f !important; box-shadow: 0 4px 10px rgba(0,80,143,0.2); }
        .avatar-mini { width: 45px; height: 45px; background: linear-gradient(135deg, #4ec7d2, #00508f); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem; flex-shrink: 0; }
        .estudiante-item:hover { border-color: #4ec7d2 !important; background: #f0f9ff !important; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.05) !important; }
        .visor-menu-btn.active { background: #e0f2fe !important; color: #00508f !important; border-left: 4px solid #4ec7d2 !important; }
        #listaEstudiantes::-webkit-scrollbar { width: 6px; }
        #listaEstudiantes::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let docsActuales = {};
        const inputBusqueda = document.getElementById('busquedaEstudiante');
        const botonesGrado = document.querySelectorAll('.btn-grado');
        const items = document.querySelectorAll('.estudiante-item');

        function aplicarFiltros() {
            const busqueda = inputBusqueda.value.toLowerCase();
            const filtroActivo = document.querySelector('.btn-grado.active');
            const gradoActivo = filtroActivo ? filtroActivo.dataset.grado : 'todos';
            let visibleCount = 0;

            items.forEach(item => {
                const textoItem = item.innerText.toLowerCase();
                const gradoItem = item.dataset.grado;
                const coincideBusqueda = textoItem.includes(busqueda);
                const coincideGrado = (gradoActivo === 'todos' || gradoItem === gradoActivo);

                if (coincideBusqueda && coincideGrado) {
                    item.style.setProperty('display', 'flex', 'important');
                    visibleCount++;
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });
            document.getElementById('contadorEstudiantes').innerText = visibleCount;
        }

        inputBusqueda.addEventListener('keyup', aplicarFiltros);
        botonesGrado.forEach(btn => {
            btn.addEventListener('click', function() {
                botonesGrado.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                aplicarFiltros();
            });
        });

        function prepararCarga(id, nombre) {
            bootstrap.Modal.getInstance(document.getElementById('modalSeleccionarEstudiante')).hide();
            document.getElementById('estudiante_id_input').value = id;
            document.getElementById('nombreEstudianteDoc').innerText = nombre;
            new bootstrap.Modal(document.getElementById('modalCarga')).show();
        }

        function previewImg(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('previewFoto').innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover; border-radius:50%">`;
                reader.readAsDataURL(input.files[0]);
            }
        }

        function verCarpeta(nombre, foto, acta, notas) {
            docsActuales = { foto, acta, notas };
            document.getElementById('visorTitulo').innerText = "Expediente Digital: " + nombre;
            cambiarArchivo('foto', document.querySelector('#modalVisor .visor-menu-btn'));
            new bootstrap.Modal(document.getElementById('modalVisor')).show();
        }

        function cambiarArchivo(tipo, btn) {
            document.querySelectorAll('#modalVisor .visor-menu-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const url = docsActuales[tipo];
            const container = document.getElementById('visorContent');

            if (!url || url.split('/').pop() === "" || url.includes('undefined')) {
                container.innerHTML = `<div class="text-white opacity-50 text-center"><i class="fas fa-file-excel fa-4x mb-3"></i><br><h5 class="fw-bold">Archivo no disponible</h5></div>`;
                return;
            }

            if (url.toLowerCase().endsWith('.pdf')) {
                container.innerHTML = `<embed src="${url}" type="application/pdf" width="100%" height="100%">`;
            } else {
                container.innerHTML = `<img src="${url}?v=${new Date().getTime()}" style="max-width:95%; max-height:95%; object-fit:contain;">`;
            }
        }

        function confirmarEliminar(id, nombre) {
            Swal.fire({
                title: '¿Eliminar Expediente?',
                text: "Se borrarán todos los documentos de " + nombre,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00508f',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => { if (result.isConfirmed) document.getElementById('delete-form-' + id).submit(); });
        }
    </script>
@endpush
