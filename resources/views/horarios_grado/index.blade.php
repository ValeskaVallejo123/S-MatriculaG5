@extends('layouts.app')

@section('title', 'Horarios por Grado')
@section('page-title', 'Horarios por Grado')

@section('topbar-actions')
    <a href="{{ url()->previous() }}"
       style="background:white; color:#00508f;
              padding:.6rem .75rem; border-radius:9px; font-size:.83rem; font-weight:600;
              display:inline-flex; align-items:center; gap:.4rem;
              text-decoration:none; border:1.5px solid #00508f; transition:all .2s;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Card de grado ── */
.grado-card {
    border-radius: 12px;
    border: 2px solid #e8edf4;
    background: white;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
    height: 100%;
}
.grado-card:hover {
    box-shadow: 0 6px 24px rgba(0,59,115,.13);
    transform: translateY(-2px);
}

/* ── Header de card ── */
.grado-card-header {
    background: linear-gradient(135deg, rgba(0,80,143,.07), rgba(78,199,210,.07));
    border-bottom: 2px solid #e8edf4;
    padding: .85rem 1rem;
}
.grado-card-title {
    font-size: .88rem;                            /* ← TAMAÑO título grado */
    font-weight: 700;
    color: #003b73;
    margin: 0 0 .15rem;
    display: flex; align-items: center; gap: .4rem;
}
.grado-card-title i { color: #4ec7d2; }
.grado-card-sub {
    font-size: .68rem;                            /* ← TAMAÑO subtítulo año lectivo */
    color: #94a3b8;
    font-weight: 500;
    padding-left: 1.4rem;
}

/* ── Body de card ── */
.grado-card-body { padding: .95rem 1rem; }

/* ── Etiqueta grupo de botones ── */
.btn-group-label {
    font-size: .63rem;                            /* ← TAMAÑO etiqueta grupos */
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #94a3b8;
    margin-bottom: .4rem;
    display: flex; align-items: center; gap: .28rem;
}
.btn-group-label i { color: #4ec7d2; font-size: .65rem; }

/* ── Separador entre grupos ── */
.btn-group-sep {
    margin-bottom: .75rem;
    padding-bottom: .75rem;
    border-bottom: 1px solid #f0f4f9;
}

/* ── Botón Ver (outline) ── */
.btn-ver-h {
    flex: 1;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
    padding: .32rem .5rem;                       /* ← TAMAÑO botones ver */
    border-radius: 7px;
    font-size: .72rem; font-weight: 600;          /* ← TEXTO botones ver */
    background: white; color: #00508f;
    border: 1.5px solid #00508f;
    text-decoration: none; transition: all .2s;
}
.btn-ver-h:hover { background: #eff6ff; color: #00508f; }

/* ── Botón Editar (gradient) ── */
.btn-edit-h {
    flex: 1;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
    padding: .32rem .5rem;                       /* ← TAMAÑO botones editar */
    border-radius: 7px;
    font-size: .72rem; font-weight: 600;          /* ← TEXTO botones editar */
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none;
    text-decoration: none; transition: all .2s;
    box-shadow: 0 1px 4px rgba(78,199,210,.25);
}
.btn-edit-h:hover { color: white; opacity: .9; }

/* ── Botón PDF (rojo outline) ── */
.btn-pdf-h {
    flex: 1;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
    padding: .32rem .5rem;                       /* ← TAMAÑO botones PDF */
    border-radius: 7px;
    font-size: .72rem; font-weight: 600;          /* ← TEXTO botones PDF */
    background: white; color: #ef4444;
    border: 1.5px solid #ef4444;
    text-decoration: none; transition: all .2s;
}
.btn-pdf-h:hover { background: #fef2f2; color: #ef4444; }

/* ── Grid de cards ── */
.grados-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);        /* ← COLUMNAS escritorio */
    gap: 1.1rem;
}
@media(max-width: 900px) {
    .grados-grid { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width: 580px) {
    .grados-grid { grid-template-columns: 1fr; }
}

/* ── Empty state ── */
.empty-state {
    text-align: center; padding: 3.5rem 1rem;
    color: #94a3b8; grid-column: 1/-1;
}
.empty-state i {
    font-size: 3rem; display: block;
    margin-bottom: .75rem; color: #bfd9ea;
}
.empty-state p     { font-size: .88rem; font-weight: 600; margin: 0 0 .25rem; }
.empty-state small { font-size: .75rem; }
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem; position:relative; overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;
                        border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-calendar-alt" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;
                           margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Horarios por Grado
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600;
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-layer-group"></i> Selecciona un grado para gestionar su horario
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.4rem 1.7rem;">

            {{-- Título de sección --}}
            <div style="display:flex;align-items:center;gap:.5rem;
                        font-size:.75rem;font-weight:700;color:#00508f;
                        text-transform:uppercase;letter-spacing:.08em;
                        margin-bottom:1.1rem;padding-bottom:.55rem;
                        border-bottom:2px solid rgba(78,199,210,.1);">
                <i class="fas fa-th-large" style="color:#4ec7d2;font-size:.88rem;"></i>
                Grados Registrados
            </div>

            {{-- Grid de cards --}}
            <div class="grados-grid">
                @forelse($grados as $g)

                    <div class="grado-card">

                        {{-- Header --}}
                        <div class="grado-card-header">
                            <div class="grado-card-title">
                                <i class="fas fa-layer-group"></i>
                                {{ ucfirst($g->nivel) }} — {{ $g->numero }}° {{ $g->seccion }}
                            </div>
                            <div class="grado-card-sub">
                                <i class="fas fa-calendar-alt" style="margin-right:.25rem;"></i>
                                Año lectivo: {{ $g->anio_lectivo }}
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="grado-card-body">

                            {{-- Ver horario --}}
                            <div class="btn-group-sep">
                                <div class="btn-group-label">
                                    <i class="fas fa-eye"></i> Ver Horario
                                </div>
                                <div style="display:flex;gap:.5rem;">
                                    <a href="{{ route('horarios_grado.show', [$g->id, 'matutina']) }}"
                                       class="btn-ver-h">
                                        <i class="fas fa-sun"></i> Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.show', [$g->id, 'vespertina']) }}"
                                       class="btn-ver-h">
                                        <i class="fas fa-moon"></i> Vespertina
                                    </a>
                                </div>
                            </div>

                            {{-- Editar horario --}}
                            <div class="btn-group-sep">
                                <div class="btn-group-label">
                                    <i class="fas fa-edit"></i> Editar Horario
                                </div>
                                <div style="display:flex;gap:.5rem;">
                                    <a href="{{ route('horarios_grado.edit', [$g->id, 'matutina']) }}"
                                       class="btn-edit-h">
                                        <i class="fas fa-sun"></i> Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.edit', [$g->id, 'vespertina']) }}"
                                       class="btn-edit-h">
                                        <i class="fas fa-moon"></i> Vespertina
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>No hay grados registrados.</p>
                        <small>Agregue grados para gestionar sus horarios.</small>
                    </div>
                @endforelse
            </div>

        </div>
    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}
@endsection
