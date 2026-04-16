@extends('layouts.app')

@section('title', 'Horarios por Grado')
@section('page-title', 'Horarios por Grado')
@section('content-class', 'p-0')

@push('styles')
<style>
.hor-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.hor-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-shrink: 0;
}
.hor-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.hor-hero-icon i { font-size: 1.3rem; color: white; }
.hor-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.hor-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

/* Scrollable body */
.hor-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Grid de cards */
.grados-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.1rem;
}
@media(max-width: 900px) { .grados-grid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width: 580px) { .grados-grid { grid-template-columns: 1fr; } }

/* Card de grado */
.grado-card {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    background: white;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.grado-card:hover {
    box-shadow: 0 6px 24px rgba(0,59,115,.13);
    transform: translateY(-2px);
}

/* Header de card */
.grado-card-header {
    background: #003b73;
    padding: .85rem 1rem;
}
.grado-card-title {
    font-size: .9rem;
    font-weight: 700;
    color: white;
    margin: 0 0 .15rem;
    display: flex; align-items: center; gap: .4rem;
}
.grado-card-title i { color: #4ec7d2; }
.grado-card-sub {
    font-size: .72rem;
    color: rgba(255,255,255,.65);
    font-weight: 500;
    padding-left: 1.4rem;
}

/* Body de card */
.grado-card-body { padding: 1rem; }

/* Etiqueta grupo de botones */
.btn-group-label {
    font-size: .63rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #94a3b8;
    margin-bottom: .4rem;
    display: flex; align-items: center; gap: .28rem;
}
.btn-group-label i { color: #4ec7d2; font-size: .65rem; }

.btn-group-sep {
    margin-bottom: .75rem;
    padding-bottom: .75rem;
    border-bottom: 1px solid #f0f4f9;
}
.btn-group-sep:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }

/* Botón Ver */
.btn-ver-h {
    flex: 1;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
    padding: .32rem .5rem;
    border-radius: 7px;
    font-size: .72rem; font-weight: 600;
    background: white; color: #00508f;
    border: 1.5px solid #00508f;
    text-decoration: none; transition: all .2s;
}
.btn-ver-h:hover { background: #eff6ff; color: #00508f; }

/* Botón Editar */
.btn-edit-h {
    flex: 1;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
    padding: .32rem .5rem;
    border-radius: 7px;
    font-size: .72rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none;
    text-decoration: none; transition: all .2s;
    box-shadow: 0 1px 4px rgba(78,199,210,.25);
}
.btn-edit-h:hover { color: white; opacity: .9; }

/* Empty state */
.empty-state {
    text-align: center; padding: 3.5rem 1rem;
    color: #94a3b8; grid-column: 1/-1;
}
.empty-state i { font-size: 3rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.empty-state p { font-size: .88rem; font-weight: 600; margin: 0 0 .25rem; }
.empty-state small { font-size: .75rem; }

/* Dark mode */
body.dark-mode .hor-wrap  { background: #0f172a; }
body.dark-mode .grado-card { background: #1e293b; border-color: #334155; }
body.dark-mode .grado-card-body { background: #1e293b; }
body.dark-mode .btn-group-sep { border-color: #334155; }
body.dark-mode .btn-ver-h { background: #0f172a; color: #4ec7d2; border-color: #4ec7d2; }
</style>
@endpush

@section('content')
<div class="hor-wrap">

    {{-- Hero --}}
    <div class="hor-hero">
        <div class="hor-hero-icon"><i class="fas fa-calendar-alt"></i></div>
        <div>
            <h2 class="hor-hero-title">Horarios por Grado</h2>
            <p class="hor-hero-sub">Selecciona un grado para gestionar su horario por jornada</p>
        </div>
    </div>

    {{-- Body --}}
    <div class="hor-body">

        {{-- Grid de cards --}}
        <div class="grados-grid">
            @forelse($grados as $g)

                <div class="grado-card">

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

                    <div class="grado-card-body">

                        <div class="btn-group-sep">
                            <div class="btn-group-label">
                                <i class="fas fa-eye"></i> Ver Horario
                            </div>
                            <div style="display:flex;gap:.5rem;">
                                <a href="{{ route('horarios_grado.show', [$g->id, 'matutina']) }}" class="btn-ver-h">
                                    <i class="fas fa-sun"></i> Matutina
                                </a>
                                <a href="{{ route('horarios_grado.show', [$g->id, 'vespertina']) }}" class="btn-ver-h">
                                    <i class="fas fa-moon"></i> Vespertina
                                </a>
                            </div>
                        </div>

                        <div class="btn-group-sep">
                            <div class="btn-group-label">
                                <i class="fas fa-edit"></i> Editar Horario
                            </div>
                            <div style="display:flex;gap:.5rem;">
                                <a href="{{ route('horarios_grado.edit', [$g->id, 'matutina']) }}" class="btn-edit-h">
                                    <i class="fas fa-sun"></i> Matutina
                                </a>
                                <a href="{{ route('horarios_grado.edit', [$g->id, 'vespertina']) }}" class="btn-edit-h">
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

    </div>{{-- /hor-body --}}
</div>
@endsection
