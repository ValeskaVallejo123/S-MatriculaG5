@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Registrar Calificaciones</h2>

        <form action="{{ route('registrarcalificaciones.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="curso_id" class="form-label">Curso</label>
                <select name="curso_id" class="form-control" required>
                    <option value="">Seleccione un curso</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}">
                            {{ $curso->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="materia_id" class="form-label">Materia</label>
                <select name="materia_id" class="form-control" required>
                    <option value="">Seleccione una materia</option>
                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}">
                            {{ $materia->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="parcial" class="form-label">Parcial</label>
                <select name="parcial" class="form-control" required>
                    <option value="">Seleccione parcial</option>
                    <option value="1">Primer Parcial</option>
                    <option value="2">Segundo Parcial</option>
                    <option value="3">Tercer Parcial</option>
                </select>
            </div>

            <hr>

            <h4>Estudiantes</h4>

            @foreach($estudiantes as $estudiante)
                <div class="mb-3">
                    <label class="form-label">
                        {{ $estudiante->apellido1 }}
                        {{ $estudiante->apellido2 }}
                        {{ $estudiante->nombre1 }}
                        {{ $estudiante->nombre2 }}
                    </label>

                    <input type="number"
                           name="notas[{{ $estudiante->id }}]"
                           class="form-control"
                           min="0"
                           max="100"
                           step="0.01"
                           placeholder="Ingrese la nota">
                </div>
            @endforeach

            <button type="submit" class="btn btn-success">
                Guardar Calificaciones
            </button>
        </form>
    </div>
@endsection
