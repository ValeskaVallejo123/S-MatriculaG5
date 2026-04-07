@extends('layouts.app')

@section('title', 'Dashboard Padre')
@section('page-title', 'Portal de Padres')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.pad-wrap { font-family: 'Inter', sans-serif; }

/* ── Banner de bienvenida ── */
.pad-banner {
    background: linear-gradient(135deg, #003b73, #00508f 60%, #4ec7d2);
    border-radius: 12px; padding: 1.4rem 1.75rem;
    display: flex; align-items: center; gap: 1.25rem;
    box-shadow: 0 4px 18px rgba(0,59,115,.2);
    position: relative; overflow: hidden; margin-bottom: 1.5rem;
}
.pad-banner::before {
    content:''; position:absolute; top:-40%; right:-4%;
    width:200px; height:200px; background:rgba(255,255,255,.07); border-radius:50%;
}
.pad-banner::after {
    content:''; position:absolute; bottom:-50%; right:12%;
    width:130px; height:130px; background:rgba(255,255,255,.05); border-radius:50%;
}
.pad-banner-icon {
    width:58px; height:58px; border-radius:14px;
    background:rgba(255,255,255,.18); border:2px solid rgba(255,255,255,.3);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:1.5rem; flex-shrink:0; position:relative; z-index:1;
}
.pad-banner-info { position:relative; z-index:1; }
.pad-banner-info h4 { color:#fff; font-weight:700; margin:0 0 .25rem; font-size:1.15rem; }
.pad-banner-info p  { color:rgba(255,255,255,.75); font-size:.82rem; margin:0; }

/* ── Stat cards ── */
.stat-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:768px){ .stat-grid { grid-template-columns: 1fr; } }

.stat-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); position: relative; overflow: hidden;
    transition: box-shadow .15s;
}
.stat-card:hover { box-shadow: 0 4px 14px rgba(0,80,143,.1); }
.stat-card-stripe {
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 4px; border-radius: 12px 0 0 12px;
}
.stat-icon {
    width: 46px; height: 46px; border-radius: 11px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.15rem;
}
.stat-label { font-size: .75rem; font-weight: 600; color: #64748b; margin-bottom: .2rem; text-transform: uppercase; letter-spacing: .04em; }
.stat-value { font-size: 1.55rem; font-weight: 700; color: #003b73; line-height: 1; }

/* ── Section card ── */
.pad-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1.25rem;
}
.pad-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.pad-card-head i    { color: #4ec7d2; font-size: 1rem; }
.pad-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

/* ── Estado en construcción ── */
.under-construction {
    padding: 3.5rem 1.5rem; text-align: center;
}
.uc-icon {
    width: 80px; height: 80px; border-radius: 20px;
    background: linear-gradient(135deg, rgba(0,80,143,.08), rgba(78,199,210,.12));
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem; font-size: 2rem; color: #00508f;
}
.under-construction h5 {
    color: #0f172a; font-weight: 700; margin-bottom: .4rem; font-size: 1rem;
}
.under-construction p { color: #94a3b8; font-size: .83rem; margin: 0 0 1.5rem; }

/* ── Feature pills ── */
.feature-list {
    display: flex; flex-wrap: wrap; justify-content: center; gap: .5rem;
    max-width: 520px; margin: 0 auto;
}
.feature-pill {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .38rem .9rem; border-radius: 999px; font-size: .78rem; font-weight: 600;
    background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b;
}
.feature-pill i { color: #4ec7d2; font-size: .8rem; }

/* ── Info row (próximamente) ── */
.info-row {
    display: grid; grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}
@media(max-width:600px){ .info-row { grid-template-columns: 1fr; } }

.info-item {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1rem; background: #f8fafc; border-radius: 10px;
    border: 1px solid #f1f5f9;
}
.info-item-icon {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: .9rem;
}
.info-item-title { font-size: .83rem; font-weight: 700; color: #0f172a; margin-bottom: .15rem; }
.info-item-desc  { font-size: .76rem; color: #94a3b8; margin: 0; line-height: 1.4; }
</style>
@endpush

@section('content')
<div class="pad-wrap" style="max-width:1100px; margin:0 auto;">

    {{-- ── Banner de bienvenida ── --}}
    <div class="pad-banner">
        <div class="pad-banner-icon">
            <i class="fas fa-user-friends"></i>
        </div>
        <div class="pad-banner-info">
            <h4>Bienvenido, {{ auth()->user()->name }}</h4>
            <p>Portal de seguimiento escolar de sus hijos</p>
        </div>
    </div>

    {{-- ── Stat cards ── --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-card-stripe" style="background:#4ec7d2;"></div>
            <div class="stat-icon" style="background:#e8f8f9;">
                <i class="fas fa-child" style="color:#00508f;"></i>
            </div>
            <div>
                <div class="stat-label">Hijos vinculados</div>
                <div class="stat-value">—</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-stripe" style="background:#00508f;"></div>
            <div class="stat-icon" style="background:#e8f1f9;">
                <i class="fas fa-file-invoice" style="color:#003b73;"></i>
            </div>
            <div>
                <div class="stat-label">Reportes</div>
                <div class="stat-value">—</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-stripe" style="background:#003b73;"></div>
            <div class="stat-icon" style="background:#eef2ff;">
                <i class="fas fa-bell" style="color:#4f46e5;"></i>
            </div>
            <div>
                <div class="stat-label">Notificaciones</div>
                <div class="stat-value">—</div>
            </div>
        </div>

    {{-- ── Sección próximamente ── --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <i class="fas fa-rocket"></i>
            <span>Funciones Disponibles Próximamente</span>
        </div>
        <div style="padding:1.5rem;">

            <div class="under-construction">
                <div class="uc-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h5>Portal en Construcción</h5>
                <p>Pronto tendrá acceso a toda la información escolar<br>de sus hijos desde este panel.</p>
                <div class="feature-list">
                    <span class="feature-pill"><i class="fas fa-star"></i> Calificaciones</span>
                    <span class="feature-pill"><i class="fas fa-calendar-check"></i> Asistencia</span>
                    <span class="feature-pill"><i class="fas fa-comment-alt"></i> Observaciones</span>
                    <span class="feature-pill"><i class="fas fa-file-alt"></i> Reportes</span>
                    <span class="feature-pill"><i class="fas fa-bell"></i> Notificaciones</span>
                    <span class="feature-pill"><i class="fas fa-book"></i> Materias</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <div class="info-item-icon" style="background:#e8f8f9;">
                        <i class="fas fa-star" style="color:#00508f;"></i>
                    </div>
                    <div>
                        <div class="info-item-title">Calificaciones en tiempo real</div>
                        <p class="info-item-desc">Consulte las notas de cada materia y período directamente desde el portal.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon" style="background:#ecfdf5;">
                        <i class="fas fa-calendar-check" style="color:#059669;"></i>
                    </div>
                    <div>
                        <div class="info-item-title">Control de asistencia</div>
                        <p class="info-item-desc">Vea el registro de asistencias, tardanzas y ausencias de sus hijos.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon" style="background:#fef3c7;">
                        <i class="fas fa-comment-alt" style="color:#d97706;"></i>
                    </div>
                    <div>
                        <div class="info-item-title">Observaciones de profesores</div>
                        <p class="info-item-desc">Reciba notificaciones con las observaciones registradas por los docentes.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon" style="background:#f3e8ff;">
                        <i class="fas fa-file-alt" style="color:#7c3aed;"></i>
                    </div>
                    <div>
                        <div class="info-item-title">Reportes y constancias</div>
                        <p class="info-item-desc">Descargue reportes de rendimiento y constancias de matrícula.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
