@extends('layouts.app')

@section('title', 'Listado de Documentos')

@section('content')
    <div class="container mt-5">
        <h2>Listado de Documentos</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('documentos.create') }}" class="btn btn-primary mb-3">Subir Nuevos Documentos</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nombre Estudiante</th>
                <th>Acta de Nacimiento</th>
                <th>Calificaciones</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($documentos as $doc)
                <tr>
                    <td>{{ $doc->nombre_estudiante }}</td>
                    <td><a href="{{ asset('storage/' . $doc->acta_nacimiento) }}" target="_blank">Ver Acta</a></td>
                    <td><a href="{{ asset('storage/' . $doc->calificaciones) }}" target="_blank">Ver Calificaciones</a></td>
                    <td>
                        <a href="{{ route('documentos.edit', $doc->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar documentos?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay documentos subidos.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
