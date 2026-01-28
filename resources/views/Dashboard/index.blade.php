@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Panel de Control - Super Administrador')

@section('content')
<div class="dashboard-container">

    {{-- ================== BIENVENIDA ================== --}}
    <section class="welcome-banner">
        <div class="welcome-left">
            <h4>
                <i class="fas fa-crown accent"></i>
                ¡Bienvenido, {{ auth()->user()->name }}!
            </h4>
            <p>
                <i class="far fa-calendar-alt"></i>
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                @if($periodoActual)
                    · <strong>{{ $periodoActual->nombre_periodo }}</strong>
                @endif
            </p>
        </div>

        <span class="role-badge">
            <i class="fas fa-user-shield"></i> Super Administrador
        </span>
    </section>

    {{-- ================== KPIs PRINCIPALES ================== --}}
    <section class="grid-kpis">
        <div class="kpi-card gradient-students">
            <i class="fas fa-user-graduate bg-icon"></i>
            <span>Total Estudiantes</span>
            <h2>{{ $totalEstudiantes }}</h2>
            <small>{{ $estudiantesActivos }} activos</small>
        </div>

        <div class="kpi-card gradient-teachers">
            <i class="fas fa-chalkboard-teacher bg-icon"></i>
            <span>Total Profesores</span>
            <h2>{{ $totalProfesores }}</h2>
            <small>{{ $profesoresActivos }} activos</small>
        </div>

        <div class="kpi-card gradient-matriculas">
            <i class="fas fa-clipboard-list bg-icon"></i>
            <span>Matrículas</span>
            <h2>{{ $totalMatriculas }}</h2>
            <small>{{ $matriculasAprobadas }} aprobadas</small>
        </div>

        <div class="kpi-card gradient-courses">
            <i class="fas fa-book-open bg-icon"></i>
            <span>Cursos</span>
            <h2>{{ $totalCursos }}</h2>
            <small>Activos</small>
        </div>
    </section>

    {{-- ================== ESTUDIANTES POR GRADO ================== --}}
    <section class="grid-sections">
        <div class="card-premium">
            <h6><i class="fas fa-chart-bar accent"></i> Estudiantes por Grado</h6>

            @forelse($estudiantesPorGrado as $item)
                @php
                    $porcentaje = $totalEstudiantes > 0
                        ? round(($item->total / $totalEstudiantes) * 100)
                        : 0;
                @endphp

                <div class="progress-item">
                    <div class="progress-header">
                        <strong>{{ $item->grado }}</strong>
                        <span>{{ $item->total }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $porcentaje }}%"></div>
                    </div>
                </div>
            @empty
                <p class="empty">No hay datos disponibles</p>
            @endforelse
        </div>

        {{-- ================== ESTUDIANTES POR SECCIÓN ================== --}}
        <div class="card-premium">
            <h6><i class="fas fa-chart-pie accent"></i> Estudiantes por Sección</h6>

            <div class="section-grid">
                @forelse($estudiantesPorSeccion as $item)
                    <div class="section-box">
                        <h3>{{ $item->seccion }}</h3>
                        <small>{{ $item->total }} estudiantes</small>
                    </div>
                @empty
                    <p class="empty">No hay datos disponibles</p>
                @endforelse
            </div>
        </div>
    </section>

</div>
@endsection

{{-- ================== ESTILOS PREMIUM ================== --}}
@push('styles')
<style>
/* CONTENEDOR */
.dashboard-container{
    max-width:1400px;
    margin:auto;
    padding:1rem;
}

/* COLORES */
.accent{color:#4ec7d2}

/* BIENVENIDA */
.welcome-banner{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(135deg,#003b73,#00508f);
    padding:1.5rem 2rem;
    border-radius:16px;
    color:white;
    margin-bottom:1.5rem;
}
.welcome-banner h4{font-weight:700;margin-bottom:.3rem}
.role-badge{
    background:rgba(255,255,255,.15);
    padding:.5rem 1.2rem;
    border-radius:30px;
    font-size:.85rem;
}

/* KPIs */
.grid-kpis{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:1rem;
    margin-bottom:1.5rem;
}
.kpi-card{
    position:relative;
    padding:1.5rem;
    border-radius:16px;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    transition:.3s;
    overflow:hidden;
}
.kpi-card:hover{transform:translateY(-6px)}
.kpi-card span{font-size:.8rem;opacity:.9}
.kpi-card h2{font-size:2rem;font-weight:800;margin:.3rem 0}
.bg-icon{
    position:absolute;
    top:-10px;
    right:-10px;
    font-size:6rem;
    opacity:.15;
}

/* GRADIENTES */
.gradient-students{background:linear-gradient(135deg,#4ec7d2,#00508f)}
.gradient-teachers{background:linear-gradient(135deg,#667eea,#764ba2)}
.gradient-matriculas{background:linear-gradient(135deg,#f093fb,#f5576c)}
.gradient-courses{background:linear-gradient(135deg,#fa709a,#fee140)}

/* SECCIONES */
.grid-sections{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:1rem;
}
.card-premium{
    background:white;
    border-radius:14px;
    padding:1.2rem;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
}
.card-premium h6{
    font-weight:700;
    margin-bottom:1rem;
    color:#003b73;
}

/* PROGRESS */
.progress-item{margin-bottom:.8rem}
.progress-header{
    display:flex;
    justify-content:space-between;
    font-size:.85rem;
    margin-bottom:.2rem;
}
.progress{
    height:8px;
    background:rgba(78,199,210,.15);
    border-radius:10px;
}
.progress-bar{
    height:100%;
    background:linear-gradient(135deg,#4ec7d2,#00508f);
    border-radius:10px;
    transition:.5s;
}

/* SECCIONES */
.section-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(100px,1fr));
    gap:.6rem;
}
.section-box{
    background:rgba(78,199,210,.08);
    border:2px solid rgba(78,199,210,.25);
    border-radius:12px;
    padding:.8rem;
    text-align:center;
}
.section-box h3{
    margin:0;
    font-weight:800;
    color:#00508f;
}

/* EMPTY */
.empty{
    text-align:center;
    color:#999;
    font-size:.85rem;
}

/* RESPONSIVE */
@media(max-width:768px){
    .welcome-banner{
        flex-direction:column;
        gap:.8rem;
        text-align:center;
    }
}
</style>
@endpush
