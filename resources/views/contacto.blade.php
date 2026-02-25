@extends('layouts.app')

@section('title', 'Contacto')
@section('page-title', 'Contacto')

@section('content')

<!-- ======= ENCABEZADO ======= -->
<div class="card border-0 shadow-sm p-4 mb-4"
     style="background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%);
            border-radius: 20px;">
    <div class="text-center text-white">
        <h2 class="fw-bold mb-3">Contáctanos</h2>
        <p class="mb-0" style="font-size: 1.1rem;">
            Estamos aquí para ayudarte. Escríbenos si tienes dudas sobre matrícula o información general.
        </p>
    </div>
</div>

<!-- ======= CONTENIDO PRINCIPAL ======= -->
<div class="row g-4 mb-4">

    <!-- ===== INFORMACIÓN DE CONTACTO ===== -->
    <div class="col-lg-5">
        <div class="card shadow-sm p-4" style="border-radius: 20px;">
            <h4 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Información de Contacto</h4>

            <div class="d-flex align-items-start mb-3">
                <div class="me-3 fs-4 text-primary">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <p class="text-secondary mb-0">
                    Danlí, El Paraíso, Honduras<br>
                    Barrio o ubicación específica
                </p>
            </div>

            <div class="d-flex align-items-start mb-3">
                <div class="me-3 fs-4 text-primary">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <p class="text-secondary mb-0">
                    +504 2763-4567<br>
                    Lunes a Viernes – 7:00 AM a 3:00 PM
                </p>
            </div>

            <div class="d-flex align-items-start mb-4">
                <div class="me-3 fs-4 text-primary">
                    <i class="fas fa-envelope"></i>
                </div>
                <p class="text-secondary mb-0">
                    info@gabrielamistral.edu.hn<br>
                    Respuesta en menos de 24 horas
                </p>
            </div>

            <h5 class="fw-bold text-primary mb-3 mt-4">Redes Sociales</h5>

            <div class="d-flex gap-3">
                <a href="#" class="fs-4 text-primary">
                    <i class="fab fa-facebook-square"></i>
                </a>
                <a href="#" class="fs-4 text-primary">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="fs-4 text-primary">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== FORMULARIO DE CONTACTO ===== -->
    <div class="col-lg-7">
        <div class="card shadow-sm p-4" style="border-radius: 20px;">
            <h4 class="fw-bold text-primary mb-3">
                <i class="fas fa-paper-plane me-2"></i>Envíanos un Mensaje
            </h4>

            <form action="#" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-primary">Nombre Completo</label>
                    <input type="text" class="form-control p-3"
                           style="border-radius: 12px;"
                           placeholder="Ingrese su nombre completo" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-primary">Correo Electrónico</label>
                    <input type="email" class="form-control p-3"
                           style="border-radius: 12px;"
                           placeholder="ejemplo@correo.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-primary">Mensaje</label>
                    <textarea rows="5" class="form-control p-3"
                              style="border-radius: 12px; resize: none;"
                              placeholder="Escriba su mensaje aquí..." required></textarea>
                </div>

                <button type="submit"
                        class="btn px-4 py-2 mt-2"
                        style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
                               color: white;
                               border-radius: 10px;
                               font-weight: 600;">
                    <i class="fas fa-paper-plane me-2"></i>Enviar Mensaje
                </button>
            </form>
        </div>
    </div>

</div>

<!-- ===== CTA FINAL ===== -->
<div class="card shadow-sm p-4 text-center" style="border-radius: 20px;">
    <h4 class="fw-bold text-primary mb-3">
        <i class="fas fa-handshake me-2"></i>Estamos para ayudarte
    </h4>
    <p class="text-secondary mb-3">
        Si tienes dudas adicionales, puedes visitar nuestras oficinas o comunicarte directamente con administración.
    </p>
</div>

@endsection
