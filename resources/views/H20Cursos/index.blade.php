@extends('layouts.app')

@section('title', 'Cursos Secundaria')
@section('page-title', 'Cursos Secundaria')

@push('styles')
<style>
.grado-badge {
    display:inline-flex;align-items:center;gap:.35rem;
    padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
    background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);
}
.sm-sec-title {
    display:flex;align-items:center;gap:.5rem;
    font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
    color:#00508f;margin-bottom:.95rem;padding-bottom:.55rem;
    border-bottom:2px solid rgba(78,199,210,.12);
}
.sm-sec-title i { color:#4ec7d2; }

.curso-card {
    border-radius:12px;border:1px solid #e8edf4;background:white;
    box-shadow:0 2px 8px rgba(0,59,115,.07);
    transition:all .2s;overflow:hidden;
}
.curso-card:hover {
    transform:translateY(-3px);
    box-shadow:0 8px 24px rgba(0,59,115,.13);
    border-color:#4ec7d2;
}
.curso-header {
    background:linear-gradient(135deg,#002d5a,#00508f);
    padding:1.2rem 1.3rem;position:relative;overflow:hidden;
}
.curso-header::after {
    content:'';position:absolute;right:-20px;top:-20px;
    width:90px;height:90px;border-radius:50%;
    background:rgba(78,199,210,.15);pointer-events:none;
}
.curso-body { padding:1.1rem 1.3rem; }
.stat-row {
    display:flex;align-items:center;gap:.5rem;
    font-size:.8rem;color:#6b7a90;padding:.35rem 0;
    border-bottom:1px solid #f1f5f9;
}
.stat-row:last-child { border-bottom:none; }
.stat-row i { color:#4ec7d2;width:14px;text-align:center; }
.stat-val { font-weight:700;color:#003b73;margin-left:auto; }
.btn-accion {
    display:inline-flex;align-items:center;gap:.35rem;
    padding:.38rem .85rem;border-radius:8px;font-size:.78rem;font-weight:600;
    text-decoration:none;transition:all .2s;border:none;cursor:pointer;
}
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem;position:relative;overflow:hidden;">
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:72px;height:72px;border-radius:16px;
                        border:3px solid rgba(78,199,210,.7);background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-graduation-cap" style="color:white;font-size:1.9rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.35rem;font-weight:800;color:white;margin:0 0 .5rem;
                           text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Cursos — Educación Secundaria
                </h2>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <span class="grado-badge">
                        <i class="fas fa-layer-group"></i> Séptimo · Octavo · Noveno Grado
                    </span>
                    <span class="grado-badge">
                        <i class="fas fa-calendar"></i> Año {{ date('Y') }}
                    </span>
                    <span class="grado-badge">
                        <i class="fas fa-chalkboard"></i> {{ $cursos->count() }} sección(es)
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.4rem 1.7rem;">

            @if($cursos->isEmpty())
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-graduation-cap" style="font-size:3rem;display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                    <p style="font-size:.9rem;font-weight:600;margin:0 0 .3rem;color:#64748b;">
                        No hay grados de secundaria registrados
                    </p>
                    <small>Ve a <strong>Grados</strong> para crear los grados de secundaria.</small>
                </div>
            @else
                <div class="sm-sec-title">
                    <i class="fas fa-list"></i> Secciones registradas
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem;">
                    @foreach($cursos as $curso)
                    <div class="curso-card">

                        {{-- Card header --}}
                        <div class="curso-header">
                            <div style="position:relative;z-index:1;">
                                <div style="font-size:1.15rem;font-weight:800;color:white;margin-bottom:.3rem;">
                                    {{ $curso->nombre }}
                                </div>
                                <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                                    <span style="display:inline-flex;align-items:center;gap:.25rem;
                                                 padding:.2rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;
                                                 background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.3);">
                                        <i class="fas fa-door-open"></i> Sección {{ $curso->seccion }}
                                    </span>
                                    <span style="display:inline-flex;align-items:center;gap:.25rem;
                                                 padding:.2rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;
                                                 background:rgba(16,185,129,.25);color:#6ee7b7;border:1px solid rgba(16,185,129,.4);">
                                        <i class="fas fa-circle" style="font-size:.45rem;"></i>
                                        Activo
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Card body --}}
                        <div class="curso-body">
                            <div class="stat-row">
                                <i class="fas fa-users"></i> Estudiantes inscritos
                                <span class="stat-val">{{ $curso->estudiantes_count }}</span>
                            </div>
                            <div class="stat-row">
                                <i class="fas fa-layer-group"></i> Nivel
                                <span class="stat-val">{{ ucfirst($curso->nivel) }}</span>
                            </div>
                            <div class="stat-row">
                                <i class="fas fa-calendar-alt"></i> Año lectivo
                                <span class="stat-val">{{ $curso->anio_lectivo }}</span>
                            </div>

                            {{-- Acciones --}}
                            <div style="display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;">
                                <a href="{{ route('grados.show', $curso->id) }}"
                                   class="btn-accion"
                                   style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;flex:1;justify-content:center;">
                                    <i class="fas fa-users"></i> Estudiantes
                                </a>
                                <a href="{{ route('horarios_grado.show', [$curso->id, 'vespertina']) }}"
                                   class="btn-accion"
                                   style="background:white;color:#00508f;border:1.5px solid #00508f;">
                                    <i class="fas fa-calendar-alt"></i> Horario
                                </a>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            @endif

        </div>

        {{-- Footer --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;
                    padding:.85rem 1.7rem;background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;font-size:.72rem;color:#94a3b8;">
            <span>
                <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                Mostrando grados de secundaria del año lectivo {{ date('Y') }}
            </span>
            <span>
                <i class="fas fa-graduation-cap me-1" style="color:#4ec7d2;"></i>
                III Ciclo — Educación Básica
            </span>
        </div>

    </div>
</div>
@endsection
