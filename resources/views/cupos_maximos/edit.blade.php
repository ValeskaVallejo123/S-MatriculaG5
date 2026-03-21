@extends('layouts.app')

@section('title', 'Actualizar Cupo')
@section('page-title', 'Cupos Máximos')

@section('topbar-actions')
    <a href="{{ route('superadmin.cupos_maximos.index') }}" class="adm-btn-outline">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
@endsection

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        .adm-wrap { font-family: 'Inter', sans-serif; }

        .adm-btn-outline {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
            background: #fff; color: #00508f; border: 1.5px solid #4ec7d2;
            text-decoration: none; transition: background .15s;
        }
        .adm-btn-outline:hover { background: #e8f8f9; color: #00508f; }

        .adm-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
            overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .adm-card-head {
            background: #003b73; padding: .85rem 1.25rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .adm-card-head i { color: #4ec7d2; font-size: 1rem; }
        .adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
        .adm-card-body { padding: 1.5rem 1.25rem; }

        .frm-label {
            display: block; font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .05em;
            color: #64748b; margin-bottom: .4rem;
        }
        .frm-label i { color: #4ec7d2; margin-right: .3rem; }

        .frm-control {
            width: 100%; padding: .45rem .75rem;
            border: 1.5px solid #e2e8f0; border-radius: 8px;
            font-size: .82rem; color: #0f172a;
            background: #f8fafc; outline: none;
            transition: border-color .15s, box-shadow .15s;
            font-family: 'Inter', sans-serif;
        }
        .frm-control:focus {
            border-color: #4ec7d2;
            box-shadow: 0 0 0 3px rgba(78,199,210,.12);
            background: #fff;
        }
        .frm-hint { font-size: .72rem; color: #94a3b8; margin-top: .3rem; }
        .frm-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.25rem 0; }

        .frm-actions {
            display: flex; align-items: center; justify-content: space-between;
            gap: .75rem; flex-wrap: wrap;
        }

        .btn-cancel {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .45rem 1.1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
            background: #fff; color: #64748b; border: 1.5px solid #e2e8f0;
            text-decoration: none; cursor: pointer; transition: all .15s;
            font-family: 'Inter', sans-serif;
        }
        .btn-cancel:hover { border-color: #94a3b8; color: #334155; background: #f8fafc; }

        .btn-save {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .45rem 1.25rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            color: #fff; border: none; cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,80,143,.25);
            transition: opacity .15s; font-family: 'Inter', sans-serif;
        }
        .btn-save:hover { opacity: .88; }

        .btn-delete {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .45rem 1.1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
            background: #fff; color: #ef4444; border: 1.5px solid #fecaca;
            cursor: pointer; transition: all .15s; font-family: 'Inter', sans-serif;
        }
        .btn-delete:hover { background: #fef2f2; border-color: #ef4444; }

        .frm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media(max-width:540px){ .frm-row { grid-template-columns: 1fr; } }
        .frm-group { display: flex; flex-direction: column; }

        .adm-curso-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            background: #f0f9ff; border: 1px solid #bae6fd;
            color: #0369a1; border-radius: 8px;
            padding: .4rem .85rem; font-size: .8rem; font-weight: 600;
            margin-bottom: 1.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="adm-wrap">

        <div class="adm-card">
            <div class="adm-card-head">
                <i class="fas fa-pen"></i>
                <span>Actualizar Cupo — {{ $curso->nombre }}</span>
            </div>
            <div class="adm-card-body">

                {{-- Badge informativo --}}
                <div class="adm-curso-badge">
                    <i class="fas fa-info-circle"></i>
                    Editando el cupo para <strong>{{ $curso->nombre }}</strong>
                    &nbsp;·&nbsp; Sección <strong>{{ $curso->seccion ?? '—' }}</strong>
                    &nbsp;·&nbsp; Jornada <strong>{{ $curso->jornada ?? '—' }}</strong>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"
                         style="border-left:4px solid #ef4444;border-radius:8px;font-size:.82rem;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach (collect($errors->all())->unique() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form id="cursoForm" method="POST" action="{{ route('superadmin.cupos_maximos.update', $curso->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="frm-group mb-3">
                        <label for="nombre" class="frm-label">
                            <i class="fas fa-book-open"></i> Nombre del curso
                        </label>
                        <select name="nombre" id="nombre" class="frm-control" required>
                            <option value="">Seleccione un curso...</option>
                            @foreach(['1ro Primaria','2do Primaria','3ro Primaria','4to Primaria','5to Primaria','6to Primaria','1ro Secundaria','2do Secundaria','3ro Secundaria'] as $grado)
                                <option value="{{ $grado }}" {{ old('nombre', $curso->nombre) == $grado ? 'selected' : '' }}>
                                    {{ $grado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Cupo --}}
                    <div class="frm-group mb-3">
                        <label for="cupo_maximo" class="frm-label">
                            <i class="fas fa-users"></i> Cupo de estudiantes
                        </label>
                        <input type="number" name="cupo_maximo" id="cupo_maximo" class="frm-control"
                               value="{{ old('cupo_maximo', $curso->cupo_maximo) }}"
                               min="1" max="35" required>
                        <p class="frm-hint">Máximo 35 estudiantes por sección.</p>
                    </div>

                    {{-- Jornada y Sección --}}
                    <div class="frm-row mb-3">
                        <div class="frm-group">
                            <label for="jornada" class="frm-label">
                                <i class="fas fa-clock"></i> Jornada
                            </label>
                            <select name="jornada" id="jornada" class="frm-control" required>
                                <option value="">Seleccione...</option>
                                <option value="Matutina"   {{ old('jornada', $curso->jornada) == 'Matutina'   ? 'selected' : '' }}>Matutina</option>
                                <option value="Vespertina" {{ old('jornada', $curso->jornada) == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                            </select>
                        </div>
                        <div class="frm-group">
                            <label for="seccion" class="frm-label">
                                <i class="fas fa-tag"></i> Sección
                            </label>
                            <select name="seccion" id="seccion" class="frm-control" required>
                                <option value="">Seleccione...</option>
                                @foreach(['A','B','C','D'] as $sec)
                                    <option value="{{ $sec }}" {{ old('seccion', $curso->seccion) == $sec ? 'selected' : '' }}>
                                        {{ $sec }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="frm-divider">

                    {{-- Botones --}}
                    <div class="frm-actions">
                        <a href="{{ route('superadmin.cupos_maximos.index') }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Cancelar
                        </a>

                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Guardar cambios
                        </button>

                        <button type="button" class="btn-delete"
                                data-route="{{ route('superadmin.cupos_maximos.destroy', $curso->id) }}"
                                data-message="¿Seguro que deseas eliminar el cupo de {{ addslashes($curso->nombre) }}? Esta acción no se puede deshacer."
                                data-name="{{ $curso->nombre }}"
                                onclick="mostrarModalDeleteData(this)">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
