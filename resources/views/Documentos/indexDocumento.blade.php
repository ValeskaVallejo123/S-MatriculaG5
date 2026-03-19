@extends('layouts.app')

@section('title', 'Documentos')
@section('page-title', 'Documentos')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.doc-wrap { font-family: 'Inter', sans-serif; }

.doc-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.doc-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.doc-card-head i { color: #4ec7d2; font-size: 1rem; }
.doc-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

.doc-tbl { width: 100%; border-collapse: collapse; }
.doc-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.doc-tbl tbody td {
    padding: .65rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.doc-tbl tbody tr:last-child td { border-bottom: none; }
.doc-tbl tbody tr:hover { background: #fafbfc; }

.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: #fff; }

.doc-empty { padding: 3.5rem 1rem; text-align: center; }
.doc-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
.doc-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

.doc-footer {
    padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa; flex-wrap: wrap; gap: .5rem;
}
.doc-footer-info { font-size: .78rem; color: #64748b; }
.pagination { margin: 0; }
.pagination .page-item .page-link {
    font-size: .78rem; padding: .3rem .65rem; border-radius: 6px;
    color: #00508f; border-color: #e2e8f0; font-family: 'Inter', sans-serif;
}
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: #fff;
}
.pagination .page-item.disabled .page-link { color: #cbd5e1; }
</style>
@endpush

@section('content')
<div class="doc-wrap container-fluid px-4">

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
                        <td style="color:#64748b;font-weight:600;">
                            {{ $documentos->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <div style="font-weight:600;color:#0f172a;">
                                {{ $doc->estudiante->nombre1 ?? 'N/A' }}
                                {{ $doc->estudiante->apellido1 ?? '' }}
                            </div>
                            <small style="color:#94a3b8;">ID: {{ $doc->estudiante_id }}</small>
                        </td>
                        <td style="text-align:center;">
                            @if($doc->foto)
                                <a href="{{ asset('storage/' . $doc->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $doc->foto) }}"
                                         class="rounded-circle"
                                         style="width:38px;height:38px;object-fit:cover;border:2px solid #4ec7d2;">
                                </a>
                            @else
                                <i class="fas fa-user-circle" style="font-size:1.6rem;color:#cbd5e1;"></i>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($doc->acta_nacimiento)
                                <a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank"
                                   style="display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:999px;background:#e8f8f9;color:#00508f;font-size:.7rem;font-weight:600;text-decoration:none;">
                                    <i class="fas fa-file-pdf"></i> Ver
                                </a>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($doc->calificaciones)
                                <a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank"
                                   style="display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:999px;background:#dcfce7;color:#166534;font-size:.7rem;font-weight:600;text-decoration:none;">
                                    <i class="fas fa-file-alt"></i> Ver
                                </a>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <div style="display:inline-flex;gap:.4rem;align-items:center;">
                                <a href="{{ route('documentos.edit', $doc->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este expediente?')">
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
                Mostrando {{ $documentos->firstItem() }}–{{ $documentos->lastItem() }} de {{ $documentos->total() }} expedientes
            </div>
            {{ $documentos->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
