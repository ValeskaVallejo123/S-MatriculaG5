@extends('layouts.app')

@section('title', 'Documentos')

@section('content')
    <div class="container mt-5">
        <div class="card card-upload p-4">
            <h1 class="mb-3 text-center">Documentos</h1>

            {{-- Mensajes de éxito/error --}}
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger text-center error-msg">{{ session('error') }}</div>
            @endif

            {{-- Formulario para subir documentos (siempre visible) --}}
            <form method="POST" action="{{ route('documentos.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- ACTA DE NACIMIENTO --}}
                <h5 class="section-title">Acta de nacimiento</h5>
                <input type="hidden" name="tipo_documento[]" value="acta">
                <div class="mb-3">
                    <input type="file" name="archivo[]" class="form-control" accept=".jpg,.png,.pdf" required onchange="validateFile(event, 'preview_acta')">
                    <img id="preview_acta" class="preview-img d-none" alt="Vista previa acta">
                </div>

                {{-- CALIFICACIONES --}}
                <h5 class="section-title">Calificaciones</h5>
                <input type="hidden" name="tipo_documento[]" value="calificaciones">
                <div class="mb-3">
                    <input type="file" name="archivo[]" class="form-control" accept=".jpg,.png,.pdf" required onchange="validateFile(event, 'preview_calificaciones')">
                    <img id="preview_calificaciones" class="preview-img d-none" alt="Vista previa calificaciones">
                </div>

                {{-- Botón de subir documentos --}}
                <button type="submit" class="btn btn-primary w-100 mt-3">Subir Documentos</button>
            </form>

            {{-- Botón de editar documentos (siempre visible, pero deshabilitado si no hay documentos) --}}
            <div class="mt-3">
                <a href="{{ $ultimoDocumentoActa || $ultimoDocumentoCalificaciones ? route('documentos.edit') : '#' }}"
                   class="btn btn-warning w-100 @if(!$ultimoDocumentoActa && !$ultimoDocumentoCalificaciones) disabled @endif">
                    Editar Documentos
                </a>
            </div>

            {{-- Mostrar documentos subidos --}}
            <div class="mt-4">
                {{-- Acta --}}
                @if($ultimoDocumentoActa)
                    <h6>Acta subida: {{ $ultimoDocumentoActa->nombre }}</h6>
                    @if(in_array(strtolower($ultimoDocumentoActa->tipo), ['jpg','png','jpeg']))
                        <img src="{{ asset('storage/actas/' . $ultimoDocumentoActa->nombre) }}" class="preview-img">
                    @endif
                    <a href="{{ asset('storage/actas/' . $ultimoDocumentoActa->nombre) }}" target="_blank" class="btn btn-sm btn-secondary mt-2">Ver Acta</a>
                @endif

                {{-- Calificaciones --}}
                @if($ultimoDocumentoCalificaciones)
                    <h6 class="mt-3">Calificaciones subidas: {{ $ultimoDocumentoCalificaciones->nombre }}</h6>
                    @if(in_array(strtolower($ultimoDocumentoCalificaciones->tipo), ['jpg','png','jpeg']))
                        <img src="{{ asset('storage/calificaciones/' . $ultimoDocumentoCalificaciones->nombre) }}" class="preview-img">
                    @endif
                    <a href="{{ asset('storage/calificaciones/' . $ultimoDocumentoCalificaciones->nombre) }}" target="_blank" class="btn btn-sm btn-secondary mt-2">Ver Calificaciones</a>
                @endif
            </div>
        </div>
    </div>

    <script>
        function validateFile(event, previewId) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const preview = document.getElementById(previewId);

            if(file) {
                const maxSize = 5 * 1024 * 1024; // 5MB
                if(file.size > maxSize) {
                    alert('El archivo seleccionado pesa más de 5 MB. Por favor selecciona un archivo más liviano.');
                    fileInput.value = "";
                    preview.src = "";
                    preview.classList.add('d-none');
                    return false;
                }

                if(file.type.startsWith('image/')) {
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('d-none');
                } else {
                    preview.src = "";
                    preview.classList.add('d-none');
                }
            }
        }
    </script>
@endsection



