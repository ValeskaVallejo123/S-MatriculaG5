@extends('layouts.app')

@section('title', 'Gestión de Ciclos')
@section('page-title', 'Ciclos')
@section('content-class', 'p-0')

@push('styles')
<style>
.cic-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.cic-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.cic-hero-left { display: flex; align-items: center; gap: 1rem; }
.cic-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cic-hero-icon i { font-size: 1.3rem; color: white; }
.cic-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.cic-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.cic-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.cic-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Scrollable body */
.cic-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.cic-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.cic-tbl thead th {
    background: #003b73;
    color: white;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .75rem 1rem;
    border: none;
}
.cic-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.cic-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.cic-tbl tbody td { padding: .75rem 1rem; vertical-align: middle; font-size: .85rem; color: #334155; }
.cic-tbl tbody tr:last-child { border-bottom: none; }

/* Jornada badge */
.badge-matutina   { background: rgba(79,70,229,.1); color: #4338ca; border: 1px solid rgba(79,70,229,.3); border-radius: 999px; padding: .22rem .65rem; font-size: .72rem; font-weight: 700; }
.badge-vespertina { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); border-radius: 999px; padding: .22rem .65rem; font-size: .72rem; font-weight: 700; }

/* Action buttons */
.btn-clases-sm {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .6rem; border-radius: 6px;
    background: rgba(0,80,143,.08); color: #00508f;
    border: 1px solid #00508f;
    font-size: .75rem; text-decoration: none; transition: background .15s;
}
.btn-clases-sm:hover { background: rgba(0,80,143,.18); color: #00508f; }
.btn-edit-sm {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .6rem; border-radius: 6px;
    background: rgba(78,199,210,.1); color: #00508f;
    border: 1px solid #4ec7d2;
    font-size: .75rem; text-decoration: none; transition: background .15s;
}
.btn-edit-sm:hover { background: rgba(78,199,210,.25); color: #00508f; }
.btn-del-sm {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .6rem; border-radius: 6px;
    background: rgba(239,68,68,.08); color: #dc2626;
    border: 1px solid #fca5a5;
    font-size: .75rem; cursor: pointer; transition: background .15s;
}
.btn-del-sm:hover { background: rgba(239,68,68,.18); }

/* Empty */
.cic-empty { text-align: center; padding: 3.5rem 1rem; color: #94a3b8; }
.cic-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.cic-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0; }

/* Dark mode */
body.dark-mode .cic-wrap  { background: #0f172a; }
body.dark-mode .cic-table-card { background: #1e293b; }
body.dark-mode .cic-tbl tbody td { color: #cbd5e1; }
body.dark-mode .cic-tbl tbody tr { border-color: #334155; }
body.dark-mode .cic-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
</style>
@endpush

@section('content')
<div class="cic-wrap">

    {{-- Hero --}}
    <div class="cic-hero">
        <div class="cic-hero-left">
            <div class="cic-hero-icon"><i class="fas fa-sync-alt"></i></div>
            <div>
                <h2 class="cic-hero-title">Gestión de Ciclos</h2>
                <p class="cic-hero-sub">Administra los ciclos escolares del sistema</p>
            </div>
        </div>
        <a href="{{ route('ciclos.create') }}" class="cic-btn-new">
            <i class="fas fa-plus"></i> Nuevo Ciclo
        </a>
    </div>

    {{-- Body --}}
    <div class="cic-body">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Table card --}}
        <div class="cic-table-card">
            @if($ciclos->isEmpty())
                <div class="cic-empty">
                    <i class="fas fa-inbox"></i>
                    <p>No hay ciclos registrados</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table cic-tbl mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Sección</th>
                                <th>Maestro</th>
                                <th style="text-align:center;">Jornada</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ciclos as $ciclo)
                                <tr>
                                    <td style="color:#94a3b8;font-size:.8rem;">{{ $ciclo->id }}</td>
                                    <td style="font-weight:700;color:#003b73;">{{ $ciclo->nombre }}</td>
                                    <td>{{ $ciclo->seccion ?? '—' }}</td>
                                    <td>{{ $ciclo->maestro ?? '—' }}</td>
                                    <td style="text-align:center;">
                                        @if($ciclo->jornada === 'Matutina')
                                            <span class="badge-matutina">
                                                <i class="fas fa-sun" style="font-size:.65rem;"></i>
                                                {{ $ciclo->jornada }}
                                            </span>
                                        @elseif($ciclo->jornada)
                                            <span class="badge-vespertina">
                                                <i class="fas fa-moon" style="font-size:.65rem;"></i>
                                                {{ $ciclo->jornada }}
                                            </span>
                                        @else
                                            <span style="color:#94a3b8;font-size:.8rem;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display:flex;align-items:center;justify-content:center;gap:.4rem;">
                                            <a href="{{ route('ciclos.show', $ciclo) }}"
                                               class="btn-clases-sm" title="Ver clases">
                                                <i class="fas fa-list"></i> Clases
                                            </a>
                                            <a href="{{ route('ciclos.edit', $ciclo) }}"
                                               class="btn-edit-sm" title="Editar">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="{{ route('ciclos.destroy', $ciclo) }}"
                                                  method="POST"
                                                  data-confirm="¿Eliminar este ciclo?"
                                                  class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-del-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>{{-- /cic-body --}}
</div>
@endsection
