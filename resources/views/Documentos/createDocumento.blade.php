@extends('layouts.app')

@section('title', 'Subir Documentos')

@section('content')
    <div class="container mt-5">
        <h2>Subir Documentos del Estudiante</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nombre_estudiante" class="form-label">Nombre del Estudiante</label>
                <input type="text" name="nombre_estudiante" id="nombre_estudiante" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="acta_nacimiento" class="form-label">Acta de Nacimiento</label>
                <input type="file" name="acta_nacimiento" id="acta_nacimiento" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="calificaciones" class="form-label">Calificaciones</label>
                <input type="file" name="calificaciones" id="calificaciones" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('documentos.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>
@endsection






















