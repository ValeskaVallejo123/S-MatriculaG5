@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestión de Cursos y Secciones (H20)</h1>

        <div class="mb-3">
            <a href="{{ route('h20cursos.create') }}" class="btn btn-primary">+ Nuevo Curso</a>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Curso</th>
                <th>Sección</th>
                <th>Cupo Máximo</th>
                <th>Nivel</th>
                <th>Año Lectivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cursos as $curso)
                <tr>
                    <td>{{ $curso->nombre }}</td>
                    <td>{{ $curso->seccion }}</td>
                    <td>{{ $curso->cupo_maximo }}</td>
                    <td>{{ $curso->nivel }}</td>
                    <td>{{ $curso->anio_lectivo }}</td>
                    <td>{{ $curso->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('h20cursos.edit', $curso) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('h20cursos.destroy', $curso) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $cursos->links() }}
    </div>
@endsection
