@extends('layouts.app')

@section('title', 'Editar Documentos')

@section('content')
    <div class="container mt-5">
        <h2>Editar Documentos del Estudiante</h2>

        <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre del Estudiante</label>
                <input type="text" name="nombre_estudiante" class="form-control" value="{{ $documento->nombre_estudiante }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Acta de Nacimiento</label><br>
                <a href="{{ asset('storage/' . $documento->acta_nacimiento) }}" target="_blank">Ver actual</a>
                <input type="file" name="acta_nacimiento" class="form-control mt-2">
            </div>

            <div class="mb-3">
                <label class="form-label">Calificaciones</label><br>
                <a href="{{ asset('storage/' . $documento->calificaciones) }}" target="_blank">Ver actual</a>
                <input type="file" name="calificaciones" class="form-control mt-2">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('documentos.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>
@endsection
