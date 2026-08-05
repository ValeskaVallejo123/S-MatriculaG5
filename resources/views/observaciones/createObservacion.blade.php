@extends('layouts.app')

@section('title', 'Gestión de Expedientes')
@section('page-title', 'Expedientes Digitales')

@section('topbar-actions')
    <button type="button" class="btn fw-bold shadow-sm"
            style="background: white; color: #00508f; padding: 0.4rem 1rem; border-radius: 8px;
                   text-decoration: none; font-weight: 600; display: inline-flex; align-items: center;
                   gap: 0.5rem; border: 2px solid #00508f; font-size: 0.85rem;">
        <i class="fas fa-plus"></i> Nuevo Expediente
    </button>
@endsection

@push('styles')
    <style>
        :root {
            --blue-dark: #003b73;
            --blue-mid:  #00508f;
            --cyan:      #4ec7d2;
            --border:    #bfd9ea;
            --surface:   #f5f8fc;
        }

        /* ══ AJUSTE DE ZOOM (CONTENEDORES MÁS COMPACTOS) ══ */
        .obs-header {
            background: linear-gradient(135deg, #00508f, #003b73);
            border-radius: 10px; padding: 1rem 1.25rem;
            display: flex; align-items: center; gap: 0.8rem;
            margin-bottom: 1.2rem;
            box-shadow: 0 3px 10px rgba(0,59,115,.12);
        }

        .obs-card {
            background:#fff; border:1px solid #e2e8f0; border-radius:10px;
            padding:1.2rem; box-shadow:0 1px 3px rgba(0,59,115,.05);
        }

        /* Buscador más esbelto */
        .search-input {
            width:100%; border:2px solid var(--border); border-radius:7px;
            padding:.5rem .8rem .5rem 2.4rem; font-size:.82rem; color:#0f172a;
            background:var(--surface); outline:none; transition:all .15s;
        }
        .search-input:focus { border-color:var(--cyan); background:#fff; }

        /* Tabla compacta */
        .table thead th {
            background: var(--surface);
            color: #64748b; font-size: .68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .05em;
            padding: 0.75rem 1rem;
        }

        .table td { padding: 0.6rem 1rem; font-size: 0.85rem; }

        .s-av-table {
            width:38px; height:38px; border-radius:8px;
            background:linear-gradient(135deg,var(--cyan),var(--blue-mid));
            display:flex; align-items:center; justify-content:center;
            font-size:.8rem; font-weight:800; color:#fff; overflow:hidden;
        }
        .s-av-table img { width:100%; height:100%; object-fit:cover; }

        /* ══ VISOR AJUSTADO (MENOS ZOOM) ══ */
        .img-placeholder {
            background: var(--surface);
            border: 2px dashed var(--border);
            border-radius: 10px;
            height: 350px; /* Reducido de 450px para bajar el zoom */
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; padding: 5px;
        }
        .img-placeholder img {
            max-height: 100%; max-width: 100%;
            object-fit: contain;
        }

        .field-label-modal {
            font-size:.7rem; font-weight:700; text-transform:uppercase;
            color:#64748b; margin-bottom:.3rem; display:block;
        }
    </style>
@endpush

@section('content')

    <div class="obs-header">
        <div style="width:42px; height:42px; background:rgba(78,199,210,.25); border-radius:9px; display:flex; align-items:center; justify-content:center;">
            <i class="fas fa-folder-open" style="color:#fff;font-size:1.1rem;"></i>
        </div>
        <div>
            <h6 style="color:#fff; font-weight:700; margin:0;">Expedientes Digitales</h6>
            <p style="color:rgba(255,255,255,.7); margin:0; font-size:.75rem;">Gestión centralizada de documentos</p>
        </div>
    </div>

    {{-- BUSCADOR COMPACTO --}}
    <div class="obs-card mb-3">
        <form action="{{ route('superadmin.documentos.index') }}" method="GET" class="row g-2">
            <div class="col-md-8 position-relative">
                <i class="fas fa-search" style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--blue-mid); font-size: 0.8rem; z-index:1;"></i>
                <input type="text" name="buscar" class="search-input"
                       placeholder="Buscar estudiante..." value="{{ request('buscar') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn w-100 fw-bold text-white btn-sm"
                        style="background: var(--blue-mid); height: 38px; border-radius: 7px; border:none; font-size: 0.8rem;">
                    Filtrar
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('superadmin.documentos.index') }}" class="btn w-100 fw-bold border btn-sm"
                   style="background: #fff; color: var(--blue-mid); border-color: var(--blue-mid); height: 38px; border-radius: 7px; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size: 0.8rem;">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- TABLA COMPACTA --}}
    <div class="obs-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">#</th>
                    <th>Estudiante</th>
                    <th class="text-center">Documentación</th>
                    <th class="text-end px-4">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($documentos as $doc)
                    <tr>
                        <td class="text-center fw-bold text-muted" style="font-size: 0.8rem;">
                            {{ ($documentos->currentPage() - 1) * $documentos->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="s-av-table">
                                    @if($doc->foto)
                                        <img src="{{ asset('storage/' . $doc->foto) }}">
                                    @else
                                        {{ substr($doc->estudiante->nombre1, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight:700; color:var(--blue-dark); font-size:.82rem;">
                                        {{ $doc->estudiante->nombre1 }} {{ $doc->estudiante->apellido1 }}
                                    </div>
                                    <div style="font-size:.7rem; color:#64748b;">DNI: {{ $doc->estudiante->dni }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm fw-bold px-3"
                                    style="background: rgba(78,199,210,.1); color: var(--blue-mid); border: 1px solid var(--cyan); border-radius: 6px; font-size: 0.75rem;"
                                    onclick="abrirVisor('{{ $doc->estudiante->nombre1 }}', '{{ $doc->foto }}', '{{ $doc->acta_nacimiento }}', '{{ $doc->calificaciones }}')">
                                <i class="fas fa-eye me-1"></i> Ver Expediente
                            </button>
                        </td>
                        <td class="text-end px-4">
                            <button class="btn text-danger btn-sm p-0"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted" style="font-size: 0.85rem;">No hay registros.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL VISOR COMPACTO --}}
    <div class="modal fade" id="modalVisor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 90%;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header py-2 px-3" style="background: var(--blue-mid); color: white; border-radius: 12px 12px 0 0;">
                    <h6 class="modal-title fw-bold" id="tituloModal" style="font-size: 0.9rem;">Expediente</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="font-size: 0.7rem;"></button>
                </div>
                <div class="modal-body p-3" style="background: #f8fafc;">
                    <div class="row g-3">
                        <div class="col-lg-4 text-center">
                            <span class="field-label-modal">Foto Perfil</span>
                            <div class="img-placeholder">
                                <img id="visorFoto" src="">
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <span class="field-label-modal">Acta Nacimiento</span>
                            <div class="img-placeholder">
                                <img id="visorActa" src="">
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <span class="field-label-modal">Calificaciones</span>
                            <div class="img-placeholder">
                                <img id="visorNotas" src="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function abrirVisor(nombre, foto, acta, notas) {
                document.getElementById('tituloModal').innerHTML = `<i class="fas fa-user-graduate me-2"></i> ${nombre}`;

                const cargarImg = (id, path) => {
                    const img = document.getElementById(id);
                    if(path && path !== 'null' && path !== '') {
                        img.src = "{{ asset('storage') }}/" + path;
                        img.style.display = "block";
                    } else {
                        img.src = "https://via.placeholder.com/300x400?text=No+Disponible";
                    }
                };

                cargarImg('visorFoto', foto);
                cargarImg('visorActa', acta);
                cargarImg('visorNotas', notas);

                var myModal = new bootstrap.Modal(document.getElementById('modalVisor'));
                myModal.show();
            }
        </script>
    @endpush

@endsection
