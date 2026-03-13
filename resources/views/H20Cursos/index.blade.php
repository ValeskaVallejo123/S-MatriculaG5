@extends('layouts.app')

@section('title', 'Cursos')
@section('page-title', 'Gestión de Cursos')

@section('content')

    <div class="container-fluid">

        <div class="row g-4" id="cursosContainer">
            @forelse($cursos as $curso)

                <div class="col-md-6 col-lg-4 col-xl-3 curso-card"
                     data-nivel="{{ $curso->nivel }}">

                    <div class="card border-0 shadow-sm h-100 curso-box">

                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-start mb-3">

                                <div>
                                    <h5 class="fw-bold curso-title">
                                        <i class="fas fa-book me-2"></i>
                                        {{ $curso->nombre }}

                                        @if($curso->seccion)
                                            <span class="curso-seccion">{{ $curso->seccion }}</span>
                                        @endif
                                    </h5>

                                    <span class="badge curso-badge">
                        {{ ucfirst($curso->nivel) }}
                    </span>
                                </div>

                                @if($curso->activo)
                                    <span class="badge badge-activo">Activo</span>
                                @else
                                    <span class="badge badge-inactivo">Inactivo</span>
                                @endif

                            </div>

                            <p class="text-muted small mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Año Lectivo: <strong>{{ $curso->anio_lectivo }}</strong>
                            </p>

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('h20cursos.show',$curso->id) }}"
                                   class="btn btn-sm btn-ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('h20cursos.edit',$curso->id) }}"
                                   class="btn btn-sm btn-editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('h20cursos.destroy',$curso->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-eliminar"
                                            onclick="return confirm('¿Eliminar curso?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No hay cursos registrados.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $cursos->links() }}
        </div>

    </div>

@endsection


@push('styles')
    <style>

        .curso-box{
            border-left:4px solid #4ec7d2;
            border-radius:12px;
            transition: all 0.3s ease;
        }

        .curso-box:hover{
            transform: translateY(-6px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }

        .curso-title{
            color:#003b73;
            font-size:1.1rem;
        }

        .curso-seccion{
            color:#4ec7d2;
        }

        .curso-badge{
            background:linear-gradient(135deg,rgba(78,199,210,0.15),rgba(0,80,143,0.15));
            color:#00508f;
            border:1px solid #4ec7d2;
        }

        .badge-activo{
            background:linear-gradient(135deg,#10b981,#059669);
            color:white;
        }

        .badge-inactivo{
            background:linear-gradient(135deg,#ef4444,#dc2626);
            color:white;
        }

        /* BOTONES */

        .btn-ver{
            background:linear-gradient(135deg,#4ec7d2,#00508f);
            color:white;
            border-radius:8px;
        }

        .btn-editar{
            background:#f59e0b;
            color:white;
            border-radius:8px;
        }

        .btn-eliminar{
            background:#ef4444;
            color:white;
            border-radius:8px;
        }

        .btn-ver:hover,
        .btn-editar:hover,
        .btn-eliminar:hover{
            transform: translateY(-2px);
        }

        /* PAGINACION */

        .pagination-wrapper{
            display:flex;
            justify-content:center;
            margin-top:2rem;
        }

        .page-link{
            border-radius:8px;
            border:2px solid #e2e8f0;
            font-weight:600;
        }

        .page-link:hover{
            background:linear-gradient(135deg,rgba(78,199,210,0.1),rgba(0,80,143,0.1));
            border-color:#4ec7d2;
            color:#00508f;
            transform:translateY(-2px);
        }

        .page-item.active .page-link{
            background:linear-gradient(135deg,#4ec7d2,#00508f);
            color:white;
        }

    </style>
@endpush
