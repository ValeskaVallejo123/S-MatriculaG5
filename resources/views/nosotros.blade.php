@extends('layouts.app')

@section('title', 'Sobre Nosotros')
@section('page-title', 'Sobre Nosotros')

@section('content')

<!-- ======= HERO INSTITUCIONAL (estilo igual al del panel) ======= -->
<div class="card border-0 shadow-sm p-4 mb-4"
     style="background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%);
            border-radius: 20px;">
    <div class="text-center text-white">
        <h2 class="fw-bold mb-3">Centro de Educación Básico Gabriela Mistral</h2>
        <p class="mb-0" style="font-size: 1.1rem;">
            Comprometidos con la formación integral, valores y excelencia académica.
        </p>
    </div>
</div>

<!-- ======= SECCIÓN 1 – QUIÉNES SOMOS ======= -->
<div class="row g-4 mb-4">

    <div class="col-lg-6">
        <div class="card shadow-sm p-4" style="border-radius: 20px;">
            <h4 class="fw-bold text-primary mb-3"><i class="fas fa-school me-2"></i>¿Quiénes Somos?</h4>
            <p class="text-secondary" style="line-height: 1.7;">
                Somos una institución educativa dedicada a brindar una formación de calidad,
                con valores, disciplina y un enfoque integral para el desarrollo humano.
                Nuestra escuela ha formado generaciones con un profundo compromiso académico,
                social y emocional.
            </p>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm p-4" style="border-radius: 20px;">
            <h4 class="fw-bold text-primary mb-3"><i class="fas fa-star me-2"></i>Misión</h4>
            <p class="text-secondary" style="line-height: 1.7;">
                Garantizar una educación inclusiva, participativa y de excelencia, promoviendo
                competencias académicas, científicas, tecnológicas y sociales.
            </p>
        </div>
    </div>

</div>

<!-- ======= SECCIÓN 2 – VISIÓN Y VALORES ======= -->
<div class="row g-4 mb-4">

    <div class="col-lg-6">
        <div class="card shadow-sm p-4" style="border-radius: 20px;">
            <h4 class="fw-bold text-primary mb-3"><i class="fas fa-eye me-2"></i>Visión</h4>
            <p class="text-secondary" style="line-height: 1.7;">
                Ser una institución líder en educación básica, reconocida por su calidad,
                innovación, disciplina y formación de estudiantes preparados para el futuro.
            </p>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm p-4" style="border-radius: 20px;">
            <h4 class="fw-bold text-primary mb-3"><i class="fas fa-heart me-2"></i>Valores</h4>
            <ul class="text-secondary mb-0" style="line-height: 1.8; padding-left: 18px;">
                <li>Respeto</li>
                <li>Responsabilidad</li>
                <li>Honestidad</li>
                <li>Solidaridad</li>
                <li>Disciplina</li>
            </ul>
        </div>
    </div>

</div>

<!-- ======= SECCIÓN 3 – ESTADÍSTICAS ======= -->
<div class="card shadow-sm p-4 mb-4 text-center" style="border-radius: 20px;">
    <h4 class="fw-bold text-primary mb-4"><i class="fas fa-chart-line me-2"></i>Nuestra Comunidad</h4>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="p-3 rounded shadow-sm" style="background: #e7f6fa;">
                <h2 class="fw-bold text-primary">850+</h2>
                <p class="mb-0 text-secondary">Estudiantes Activos</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 rounded shadow-sm" style="background: #e7f6fa;">
                <h2 class="fw-bold text-primary">45</h2>
                <p class="mb-0 text-secondary">Profesores</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 rounded shadow-sm" style="background: #e7f6fa;">
                <h2 class="fw-bold text-primary">12</h2>
                <p class="mb-0 text-secondary">Grados Escolares</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 rounded shadow-sm" style="background: #e7f6fa;">
                <h2 class="fw-bold text-primary">98%</h2>
                <p class="mb-0 text-secondary">Nivel de Satisfacción</p>
            </div>
        </div>

    </div>
</div>

<!-- ======= SECCIÓN 4 – CTA ======= -->
<div class="card shadow-sm p-4 text-center" style="border-radius: 20px;">
    <h4 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>¿Deseas saber más?</h4>
    <p class="text-secondary mb-3">
        Comunícate con nosotros para más información sobre nuestra institución, procesos de matrícula
        o programas educativos.
    </p>

    <a href="{{ route('contacto') }}"
       class="btn px-4 py-2"
       style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
              color: white;
              border-radius: 10px;
              font-weight: 600;">
        <i class="fas fa-phone me-2"></i>Contactar Escuela
    </a>
</div>

@endsection
