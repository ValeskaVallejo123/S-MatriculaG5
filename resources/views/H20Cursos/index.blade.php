@extends('layouts.app')

@section('title', 'Cursos')
@section('page-title', 'Cursos')

@push('styles')
<style>
.grado-badge {
    display:inline-flex;align-items:center;gap:.35rem;
    padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
    background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);
}

/* Tabs */
.nivel-tabs {
    display:flex;gap:0;
    border-bottom:2px solid #e8edf4;
    margin-bottom:1.4rem;
}
.nivel-tab {
    display:inline-flex;align-items:center;gap:.5rem;
    padding:.75rem 1.5rem;font-size:.85rem;font-weight:700;
    cursor:pointer;border:none;background:none;
    color:#94a3b8;border-bottom:3px solid transparent;
    margin-bottom:-2px;transition:all .2s;
}
.nivel-tab:hover { color:#00508f; }
.nivel-tab.active-blue { color:#00508f;border-bottom-color:#00508f; }
.nivel-tab.active-green { color:#10b981;border-bottom-color:#10b981; }
.nivel-tab .tab-count {
    font-size:.68rem;font-weight:700;
    padding:.1rem .45rem;border-radius:999px;
}
.nivel-tab.active-blue .tab-count { background:#e0f2fe;color:#00508f; }
.nivel-tab.active-green .tab-count { background:#d1fae5;color:#065f46; }
.nivel-tab:not(.active-blue):not(.active-green) .tab-count { background:#f1f5f9;color:#94a3b8; }

.nivel-panel { display:none; }
.nivel-panel.active { display:block; }

/* Cards */
.sm-sec-title {
    display:flex;align-items:center;gap:.5rem;
    font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
    color:#00508f;margin-bottom:.95rem;padding-bottom:.55rem;
    border-bottom:2px solid rgba(78,199,210,.12);
}
.sm-sec-title i { color:#4ec7d2; }
.sm-sec-title.green { color:#065f46;border-bottom-color:rgba(16,185,129,.15); }
.sm-sec-title.green i { color:#10b981; }

.curso-card {
    border-radius:12px;border:1px solid #e8edf4;background:white;
    box-shadow:0 2px 8px rgba(0,59,115,.07);
    transition:all .2s;overflow:hidden;
}
.curso-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,59,115,.13); }
.curso-card.blue:hover  { border-color:#4ec7d2; }
.curso-card.green:hover { border-color:#10b981; }

.curso-header-blue  { background:linear-gradient(135deg,#002d5a,#00508f); padding:1.2rem 1.3rem;position:relative;overflow:hidden; }
.curso-header-green { background:linear-gradient(135deg,#065f46,#10b981); padding:1.2rem 1.3rem;position:relative;overflow:hidden; }
.curso-header-blue::after, .curso-header-green::after {
    content:'';position:absolute;right:-20px;top:-20px;
    width:90px;height:90px;border-radius:50%;
    background:rgba(255,255,255,.12);pointer-events:none;
}
.curso-body { padding:1.1rem 1.3rem; }

.stat-row {
    display:flex;align-items:center;gap:.5rem;
    font-size:.8rem;color:#6b7a90;padding:.35rem 0;
    border-bottom:1px solid #f1f5f9;
}
.stat-row:last-child { border-bottom:none; }
.stat-val { font-weight:700;color:#003b73;margin-left:auto; }
.stat-row.blue i  { color:#4ec7d2;width:14px;text-align:center; }
.stat-row.green i { color:#10b981;width:14px;text-align:center; }

.btn-accion {
    display:inline-flex;align-items:center;gap:.35rem;
    padding:.38rem .85rem;border-radius:8px;font-size:.78rem;font-weight:600;
    text-decoration:none;transition:all .2s;border:none;cursor:pointer;
}

.empty-state { text-align:center;padding:3.5rem 1rem;color:#94a3b8; }
.empty-state i { font-size:3rem;display:block;margin-bottom:.75rem; }
.empty-state p { font-size:.9rem;font-weight:600;margin:0 0 .3rem;color:#64748b; }
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
                <i class="fas fa-school" style="color:white;font-size:1.9rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.35rem;font-weight:800;color:white;margin:0 0 .5rem;
                           text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Cursos — Educación Básica
                </h2>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <span class="grado-badge">
                        <i class="fas fa-child"></i> Primaria: {{ $cursosP->count() }} sección(es)
                    </span>
                    <span class="grado-badge">
                        <i class="fas fa-graduation-cap"></i> Secundaria: {{ $cursosS->count() }} sección(es)
                    </span>
                    <span class="grado-badge">
                        <i class="fas fa-calendar"></i> Año {{ date('Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.4rem 1.7rem;">

            {{-- Tabs --}}
            <div class="nivel-tabs">
                <button class="nivel-tab active-blue" onclick="switchTab('primaria', this)">
                    <i class="fas fa-child"></i> Primaria
                    <span class="tab-count">{{ $cursosP->count() }}</span>
                </button>
                <button class="nivel-tab" onclick="switchTab('secundaria', this)">
                    <i class="fas fa-graduation-cap"></i> Secundaria
                    <span class="tab-count">{{ $cursosS->count() }}</span>
                </button>
            </div>

            {{-- ══ PANEL PRIMARIA ══ --}}
            <div id="panel-primaria" class="nivel-panel active">
                @if($cursosP->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-child" style="color:#6ee7b7;"></i>
                        <p>No hay grados de primaria registrados</p>
                        <small>Ve a <strong>Grados</strong> para crearlos.</small>
                    </div>
                @else
                    <div class="sm-sec-title green">
                        <i class="fas fa-list"></i> Secciones de Primaria
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem;">
                        @foreach($cursosP as $curso)
                        <div class="curso-card green">
                            <div class="curso-header-green">
                                <div style="position:relative;z-index:1;">
                                    <div style="font-size:1.1rem;font-weight:800;color:white;margin-bottom:.3rem;">
                                        {{ $curso->numero }}° Grado — Sección {{ $curso->seccion }}
                                    </div>
                                    <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                                        <span style="display:inline-flex;align-items:center;gap:.25rem;
                                                     padding:.2rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;
                                                     background:rgba(255,255,255,.2);color:white;border:1px solid rgba(255,255,255,.3);">
                                            <i class="fas fa-door-open"></i> {{ $curso->seccion }}
                                        </span>
                                        <span style="display:inline-flex;align-items:center;gap:.25rem;
                                                     padding:.2rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;
                                                     background:rgba(255,255,255,.2);color:#d1fae5;border:1px solid rgba(255,255,255,.25);">
                                            <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="curso-body">
                                <div class="stat-row green">
                                    <i class="fas fa-users"></i> Estudiantes inscritos
                                    <span class="stat-val">{{ $curso->estudiantes_count }}</span>
                                </div>
                                <div class="stat-row green">
                                    <i class="fas fa-layer-group"></i> Nivel
                                    <span class="stat-val">{{ ucfirst($curso->nivel) }}</span>
                                </div>
                                <div class="stat-row green">
                                    <i class="fas fa-calendar-alt"></i> Año lectivo
                                    <span class="stat-val">{{ $curso->anio_lectivo }}</span>
                                </div>
                                <div style="display:flex;gap:.5rem;margin-top:1rem;flex-wrap:wrap;">
                                    <a href="{{ route('grados.show', $curso->id) }}"
                                       class="btn-accion"
                                       style="background:linear-gradient(135deg,#10b981,#065f46);color:white;flex:1;justify-content:center;">
                                        <i class="fas fa-users"></i> Estudiantes
                                    </a>
                                    <a href="{{ route('horarios_grado.show', [$curso->id, 'matutina']) }}"
                                       class="btn-accion"
                                       style="background:white;color:#065f46;border:1.5px solid #10b981;">
                                        <i class="fas fa-calendar-alt"></i> Horario
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ══ PANEL SECUNDARIA ══ --}}
            <div id="panel-secundaria" class="nivel-panel">
                @if($cursosS->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-graduation-cap" style="color:#bfd9ea;"></i>
                        <p>No hay grados de secundaria registrados</p>
                        <small>Ve a <strong>Grados</strong> para crearlos.</small>
                    </div>
                @else
                    <div class="sm-sec-title">
                        <i class="fas fa-list"></i> Secciones de Secundaria
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem;">
                        @foreach($cursosS as $curso)
                        <div class="curso-card blue">
                            <div class="curso-header-blue">
                                <div style="position:relative;z-index:1;">
                                    <div style="font-size:1.1rem;font-weight:800;color:white;margin-bottom:.3rem;">
                                        {{ $curso->numero }}° Grado — Sección {{ $curso->seccion }}
                                    </div>
                                    <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                                        <span style="display:inline-flex;align-items:center;gap:.25rem;
                                                     padding:.2rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;
                                                     background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.3);">
                                            <i class="fas fa-door-open"></i> {{ $curso->seccion }}
                                        </span>
                                        <span style="display:inline-flex;align-items:center;gap:.25rem;
                                                     padding:.2rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;
                                                     background:rgba(16,185,129,.25);color:#6ee7b7;border:1px solid rgba(16,185,129,.4);">
                                            <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="curso-body">
                                <div class="stat-row blue">
                                    <i class="fas fa-users"></i> Estudiantes inscritos
                                    <span class="stat-val">{{ $curso->estudiantes_count }}</span>
                                </div>
                                <div class="stat-row blue">
                                    <i class="fas fa-layer-group"></i> Nivel
                                    <span class="stat-val">{{ ucfirst($curso->nivel) }}</span>
                                </div>
                                <div class="stat-row blue">
                                    <i class="fas fa-calendar-alt"></i> Año lectivo
                                    <span class="stat-val">{{ $curso->anio_lectivo }}</span>
                                </div>
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

        </div>

        {{-- Footer --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;
                    padding:.85rem 1.7rem;background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;font-size:.72rem;color:#94a3b8;">
            <span>
                <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                Año lectivo {{ date('Y') }} — I, II y III Ciclo
            </span>
            <span>
                <i class="fas fa-school me-1" style="color:#4ec7d2;"></i>
                Educación Básica Completa
            </span>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(nivel, btn) {
    // Ocultar todos los paneles
    document.querySelectorAll('.nivel-panel').forEach(p => p.classList.remove('active'));
    // Quitar active de todos los tabs
    document.querySelectorAll('.nivel-tab').forEach(t => {
        t.classList.remove('active-blue', 'active-green');
    });

    // Mostrar panel seleccionado
    document.getElementById('panel-' + nivel).classList.add('active');

    // Activar tab con color correcto
    btn.classList.add(nivel === 'primaria' ? 'active-green' : 'active-blue');
}
</script>
@endpush