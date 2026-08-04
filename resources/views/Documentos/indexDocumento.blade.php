@extends('layouts.app')

@section('title', 'Documentos')
@section('page-title', 'Documentos')

@push('styles')
<style>
:root {
    --cp: #00508f; --cd: #003b73; --cs: #4ec7d2;
    --cb: #e2e8f0; --cf: #f8fafc; --ct: #1e293b; --cm: #64748b;
}

.doc-card {
    background:#fff; border:1px solid var(--cb); border-radius:12px;
    overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.05);
}
.doc-card-head {
    background:var(--cd); padding:.85rem 1.25rem;
    display:flex; align-items:center; gap:.6rem;
}
.doc-card-head i    { color:var(--cs); font-size:1rem; }
.doc-card-head span { color:#fff; font-weight:700; font-size:.95rem; }

.doc-tbl { width:100%; border-collapse:collapse; }
.doc-tbl thead th {
    background:var(--cf); padding:.65rem 1rem;
    font-size:.68rem; font-weight:700; letter-spacing:.07em;
    text-transform:uppercase; color:var(--cm);
    border-bottom:1.5px solid var(--cb); white-space:nowrap;
}
.doc-tbl tbody td {
    padding:.7rem 1rem; border-bottom:1px solid #f1f5f9;
    font-size:.82rem; color:#334155; vertical-align:middle;
}
.doc-tbl tbody tr:last-child td { border-bottom:none; }
.doc-tbl tbody tr:hover td { background:#fafbfc; }
.doc-tbl tbody td:last-child { white-space:nowrap; }

/* ── Botones de acción ── */
.act-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:30px; height:30px; border-radius:7px; border:none;
    cursor:pointer; font-size:.75rem; text-decoration:none; transition:all .15s;
}
.act-edit  { background:#e8f8f9; color:var(--cp); }
.act-edit:hover  { background:var(--cs); color:#fff; }
.act-del   { background:#fef2f2; color:#ef4444; }
.act-del:hover   { background:#ef4444; color:#fff; }

/* ── Botones "Ver" para documentos ── */
.doc-ver-btn {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.22rem .65rem; border-radius:999px;
    font-size:.7rem; font-weight:600; text-decoration:none;
    cursor:pointer; border:none; transition:all .15s;
}
.doc-ver-img { background:#e8f8f9; color:var(--cp); }
.doc-ver-img:hover { background:var(--cp); color:#fff; }
.doc-ver-pdf { background:#dcfce7; color:#166534; }
.doc-ver-pdf:hover { background:#166534; color:#fff; }

/* ── Avatar foto ── */
.doc-foto-thumb {
    width:38px; height:38px; border-radius:50%; object-fit:cover;
    border:2px solid var(--cs); cursor:pointer;
    transition:transform .15s, border-color .15s;
}
.doc-foto-thumb:hover { transform:scale(1.1); border-color:var(--cp); }

/* ── Empty ── */
.doc-empty { padding:3.5rem 1rem; text-align:center; }
.doc-empty i { font-size:2rem; color:#cbd5e1; margin-bottom:.75rem; display:block; }
.doc-empty p { color:#94a3b8; font-size:.85rem; margin:0; }

/* ── Footer ── */
.doc-footer {
    padding:.85rem 1.25rem; border-top:1px solid #f1f5f9;
    display:flex; align-items:center; justify-content:space-between;
    background:#fafafa; flex-wrap:wrap; gap:.5rem;
}
.doc-footer-info { font-size:.78rem; color:var(--cm); }
.pagination { margin:0; }
.pagination .page-item .page-link {
    font-size:.78rem; padding:.3rem .65rem; border-radius:6px;
    color:var(--cp); border-color:var(--cb);
}
.pagination .page-item.active .page-link {
    background:linear-gradient(135deg,var(--cs),var(--cp));
    border-color:var(--cs); color:#fff;
}
.pagination .page-item.disabled .page-link { color:#cbd5e1; }

/* ══════════════════════════════════════
   MODAL VISOR
══════════════════════════════════════ */
#modalVisor .modal-content {
    border-radius:14px; overflow:hidden; border:none;
}
#modalVisor .modal-header {
    background:linear-gradient(135deg, var(--cd), var(--cp));
    color:white; border:none; padding:1rem 1.4rem;
}
#modalVisor .modal-title { font-weight:700; font-size:.95rem; }
#modalVisor .modal-body  { padding:0; background:#0f172a; }

/* Contenedor imagen */
.visor-img-wrap {
    display:flex; align-items:center; justify-content:center;
    min-height:320px; padding:1.25rem; background:#0f172a;
}
.visor-img-wrap img {
    max-width:100%; max-height:70vh;
    border-radius:8px; object-fit:contain;
    box-shadow:0 8px 32px rgba(0,0,0,.5);
}

/* Contenedor PDF */
.visor-pdf-wrap {
    width:100%; height:70vh; background:#1e293b;
}
.visor-pdf-wrap iframe {
    width:100%; height:100%; border:none; display:block;
}

/* Footer del modal */
#modalVisor .modal-footer {
    background:#f8fafc; border-top:1px solid var(--cb);
    padding:.75rem 1.25rem; gap:.5rem;
}
.btn-abrir-ext {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.4rem .9rem; border-radius:8px;
    font-size:.82rem; font-weight:600;
    background:var(--cp); color:white; text-decoration:none;
    border:none; transition:background .15s;
}
.btn-abrir-ext:hover { background:var(--cd); color:white; }

/* Loader mientras carga el PDF */
.visor-loading {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    height:70vh; gap:1rem; color:rgba(255,255,255,.6); font-size:.85rem;
}
.visor-loading .spinner-border { width:2.5rem; height:2.5rem; color:#4ec7d2; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"
             style="border-left:4px solid #ef4444;border-radius:8px;font-size:.82rem;">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="doc-card">
        <div class="doc-card-head">
            <i class="fas fa-folder-open"></i>
            <span>Expedientes Digitales</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="doc-tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th style="text-align:center;">Foto</th>
                        <th style="text-align:center;">Acta Nacimiento</th>
                        <th style="text-align:center;">Calificaciones</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $doc)
                    <tr>
                        <td style="color:var(--cm);font-weight:600;">
                            {{ $documentos->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div style="font-weight:600;color:#0f172a;">
                                {{ $doc->estudiante->nombre1 ?? 'N/A' }}
                                {{ $doc->estudiante->apellido1 ?? '' }}
                            </div>
                            <small style="color:#94a3b8;">ID: {{ $doc->estudiante_id }}</small>
                        </td>

                        {{-- FOTO — abre modal imagen ── --}}
                        <td style="text-align:center;">
                            @if($doc->foto)
                                <img src="{{ asset('storage/' . $doc->foto) }}"
                                     class="doc-foto-thumb"
                                     alt="Foto estudiante"
                                     onclick="abrirVisor('imagen', '{{ asset('storage/' . $doc->foto) }}', 'Foto — {{ $doc->estudiante->nombre1 ?? '' }} {{ $doc->estudiante->apellido1 ?? '' }}')"
                                     title="Clic para ampliar">
                            @else
                                <i class="fas fa-user-circle" style="font-size:1.6rem;color:#cbd5e1;"></i>
                            @endif
                        </td>

                        {{-- ACTA NACIMIENTO — abre modal PDF ── --}}
                        <td style="text-align:center;">
                            @if($doc->acta_nacimiento)
                                <button type="button" class="doc-ver-btn doc-ver-pdf"
                                        onclick="abrirVisor('pdf', '{{ asset('storage/' . $doc->acta_nacimiento) }}', 'Acta de Nacimiento — {{ $doc->estudiante->nombre1 ?? '' }} {{ $doc->estudiante->apellido1 ?? '' }}')">
                                    <i class="fas fa-file-pdf"></i> Ver
                                </button>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>

                        {{-- CALIFICACIONES — abre modal PDF ── --}}
                        <td style="text-align:center;">
                            @if($doc->calificaciones)
                                <button type="button" class="doc-ver-btn doc-ver-img"
                                        onclick="abrirVisor('pdf', '{{ asset('storage/' . $doc->calificaciones) }}', 'Calificaciones — {{ $doc->estudiante->nombre1 ?? '' }} {{ $doc->estudiante->apellido1 ?? '' }}')">
                                    <i class="fas fa-file-alt"></i> Ver
                                </button>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>

                        {{-- ACCIONES ── --}}
                        <td style="text-align:center;">
                            <div style="display:inline-flex;gap:.4rem;align-items:center;">
                                <a href="{{ route('documentos.edit', $doc->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('documentos.destroy', $doc->id) }}"
                                      method="POST" class="d-inline"
                                      data-confirm="¿Eliminar el expediente de {{ $doc->estudiante->nombre1 ?? 'este estudiante' }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn act-del" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="doc-empty">
                                <i class="fas fa-folder-open"></i>
                                <p>No hay expedientes digitales registrados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documentos->hasPages())
        <div class="doc-footer">
            <div class="doc-footer-info">
                Mostrando {{ $documentos->firstItem() }}–{{ $documentos->lastItem() }}
                de {{ $documentos->total() }} expedientes
            </div>
            {{ $documentos->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════
     MODAL VISOR (imagen o PDF)
══════════════════════════════════════ --}}
<div class="modal fade" id="modalVisor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="visorTitulo">
                    <i class="fas fa-file me-2" id="visorIcono"></i>
                    <span id="visorNombre">Documento</span>
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="visorBody">
                {{-- Se rellena por JavaScript --}}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm"
                        data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
                <a id="visorBtnAbrir" href="#" target="_blank"
                   class="btn-abrir-ext">
                    <i class="fas fa-external-link-alt me-1"></i>Abrir en pestaña
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const modalEl  = document.getElementById('modalVisor');
    const body     = document.getElementById('visorBody');
    const titulo   = document.getElementById('visorNombre');
    const icono    = document.getElementById('visorIcono');
    const btnAbrir = document.getElementById('visorBtnAbrir');

    let bsModal = null;

    /* ── Abrir visor ── */
    window.abrirVisor = function (tipo, url, nombre) {
        if (!modalEl) return;

        // Actualizar título e ícono
        titulo.textContent = nombre || 'Documento';
        icono.className    = tipo === 'imagen'
            ? 'fas fa-image me-2'
            : 'fas fa-file-pdf me-2';

        // Botón "Abrir en pestaña"
        btnAbrir.href = url;

        // Contenido según tipo
        if (tipo === 'imagen') {
            body.innerHTML = `
                <div class="visor-img-wrap">
                    <img src="${url}" alt="${nombre}"
                         onerror="this.parentElement.innerHTML='<div class=\\'visor-loading\\'><i class=\\'fas fa-exclamation-triangle\\' style=\\'font-size:2rem;color:#ef4444;\\'></i><span>No se pudo cargar la imagen</span></div>'">
                </div>`;
        } else {
            // PDF — intentamos iframe primero
            body.innerHTML = `
                <div class="visor-loading" id="pdfLoader">
                    <div class="spinner-border" role="status"></div>
                    <span>Cargando documento…</span>
                </div>
                <div class="visor-pdf-wrap" id="pdfWrap" style="display:none;">
                    <iframe src="${url}" id="pdfFrame"
                            onload="document.getElementById('pdfLoader').style.display='none';
                                    document.getElementById('pdfWrap').style.display='block';"
                            onerror="mostrarFallbackPdf('${url}')">
                    </iframe>
                </div>`;

            // Fallback si el iframe no carga (permisos CORS, etc.)
            setTimeout(function () {
                const loader = document.getElementById('pdfLoader');
                const wrap   = document.getElementById('pdfWrap');
                if (loader && loader.style.display !== 'none') {
                    mostrarFallbackPdf(url);
                }
            }, 6000);
        }

        // Mostrar modal
        if (!bsModal) bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    };

    /* ── Fallback PDF: no se pudo incrustar ── */
    window.mostrarFallbackPdf = function (url) {
        if (!body) return;
        body.innerHTML = `
            <div class="visor-loading" style="gap:1.25rem;">
                <i class="fas fa-file-pdf" style="font-size:3rem;color:#4ec7d2;"></i>
                <div style="text-align:center;">
                    <p style="color:rgba(255,255,255,.85);font-weight:600;margin-bottom:.5rem;">
                        No se puede previsualizar este PDF aquí
                    </p>
                    <p style="color:rgba(255,255,255,.5);font-size:.8rem;margin-bottom:1rem;">
                        Usa el botón de abajo para verlo
                    </p>
                    <a href="${url}" target="_blank"
                       style="display:inline-flex;align-items:center;gap:.4rem;
                              padding:.55rem 1.25rem;border-radius:9px;font-size:.85rem;
                              font-weight:700;background:#4ec7d2;color:white;text-decoration:none;">
                        <i class="fas fa-external-link-alt"></i> Abrir PDF
                    </a>
                </div>
            </div>`;
    };

    /* Limpiar contenido al cerrar para liberar memoria */
    modalEl?.addEventListener('hidden.bs.modal', function () {
        body.innerHTML = '';
        btnAbrir.href  = '#';
        titulo.textContent = 'Documento';
    });

})();
</script>
@endpush