@extends('layouts.app')

@section('title', 'Horarios por Grado')
@section('page-title', 'Horarios por Grado')

@section('content')
<div class="container" style="max-width:1100px;">

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4" style="color:#003b73;">Seleccionar Grado</h4>

            <div class="row g-3">
                @foreach($grados as $g)
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0" style="border-radius:10px;">
                            <div class="card-body">
                                <h5 class="fw-bold" style="color:#003b73;">
                                    {{ ucfirst($g->nivel) }} — {{ $g->numero }}° {{ $g->seccion }}
                                </h5>
                                <p class="text-muted small mb-3">Año: {{ $g->anio_lectivo }}</p>

                                <div class="d-grid gap-2">
                                    <a href="{{ route('horarios_grado.show', [$g->id, 'matutina']) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        Ver Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.show', [$g->id, 'vespertina']) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        Ver Vespertina
                                    </a>
                                    <a href="{{ route('horarios_grado.edit', [$g->id, 'matutina']) }}"
                                       class="btn btn-primary btn-sm">
                                        Editar Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.edit', [$g->id, 'vespertina']) }}"
                                       class="btn btn-primary btn-sm">
                                        Editar Vespertina
                                    </a>
                                    <a href="{{ route('horarios_grado.pdf', [$g->id, 'matutina']) }}"
                                       class="btn btn-danger btn-sm">
                                        PDF Matutina
                                    </a>
                                    <a href="{{ route('horarios_grado.pdf', [$g->id, 'vespertina']) }}"
                                       class="btn btn-danger btn-sm">
                                        PDF Vespertina
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

</div>
@endsection
