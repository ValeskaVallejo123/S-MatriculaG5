@extends('layouts.app')

@section('title', 'Nueva Asignación')
@section('page-title', 'Nueva Asignación Docente')

@section('topbar-actions')
    <a href="{{ route('profesor_materia_grado.index') }}" class="pmg-btn-back">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .pmg-wrap { font-family: 'Inter', sans-serif; }

    .pmg-btn-back {
        background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 0.5rem;
        border: 2px solid #4ec7d2; box-shadow: 0 2px 8px rgba(78,199,210,0.2); transition: all 0.3s;
    }
    .pmg-btn-back:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(78,199,210,0.4); color: #00508f; }

    /* Hero */
    .pmg-hero {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 60%, #003b73 100%);
        border-radius: 14px; padding: 1.5rem 2rem; margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 1.25rem;
        box-shadow: 0 6px 24px rgba(0,59,115,0.18);
    }
    .pmg-hero-icon {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center;
        border: 2px solid rgba(255,255,255,0.35); flex-shrink: 0;
    }
    .pmg-hero-icon i { font-size: 1.5rem; color: white; }
    .pmg-hero-title { font-size: 1.35rem; font-weight: 700; color: white; margin: 0 0 0.2rem; }
    .pmg-hero-sub { color: rgba(255,255,255,0.75); font-size: 0.85rem; margin: 0; }

    /* Card */
    .pmg-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,59,115,0.09); overflow: hidden; }
    .pmg-card-head { background: #003b73; padding: 0.9rem 1.5rem; }
    .pmg-card-head h5 { color: white; font-weight: 700; font-size: 0.95rem; margin: 0; display: flex; align-items: center; gap: 0.6rem; }
    .pmg-card-head h5 i { color: #4ec7d2; }
    .pmg-card-body { background: white; padding: 1.75rem; }

    /* Error alert */
    .pmg-error {
        background: #fef2f2; border: 1px solid #fca5a5; border-radius: 10px;
        color: #991b1b; padding: 1rem 1.25rem; margin-bottom: 1.25rem;
        display: flex; align-items: flex-start; gap: 0.75rem;
    }
    .pmg-error i { font-size: 1.1rem; margin-top: 2px; flex-shrink: 0; }
    .pmg-error ul { margin: 0.4rem 0 0; padding-left: 1.2rem; }

    /* Labels */
    .pmg-label {
        font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; color: #003b73; margin-bottom: 0.4rem; display: block;
    }
    .pmg-label .req { color: #ef4444; margin-left: 2px; }

    /* Selects */
    .pmg-select {
        width: 100%; border: 2px solid #bfd9ea; border-radius: 8px;
        padding: 0.5rem 0.85rem; font-size: 0.92rem; color: #1e293b;
        background: white; transition: border-color 0.2s, box-shadow 0.2s;
        font-family: 'Inter', sans-serif;
    }
    .pmg-select:focus { border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,0.15); outline: none; }
    .pmg-select.is-invalid { border-color: #ef4444; }

    /* Radio secciones */
    .pmg-sec-btn {
        border: 2px solid #00508f; color: #00508f; background: white;
        border-radius: 8px; min-width: 52px; padding: 0.45rem 0.9rem;
        font-weight: 700; font-size: 0.9rem; cursor: pointer;
        transition: all 0.2s; display: inline-block; text-align: center;
    }
    .btn-check:checked + .pmg-sec-btn {
        background: linear-gradient(135deg, #4ec7d2, #00508f);
        color: white; border-color: #00508f;
    }

    /* Footer */
    .pmg-footer {
        display: flex; justify-content: space-between; align-items: center;
        padding-top: 1.25rem; border-top: 1px solid #f1f5f9; margin-top: 0.75rem;
    }
    .pmg-btn-cancel {
        border: 2px solid #ef4444; color: #ef4444; background: white;
        border-radius: 8px; padding: 0.5rem 1.4rem; font-weight: 600; font-size: 0.9rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;
    }
    .pmg-btn-cancel:hover { background: #fef2f2; color: #ef4444; transform: translateY(-1px); }

    .pmg-btn-save {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        color: white; border: none; border-radius: 8px;
        padding: 0.55rem 1.8rem; font-weight: 700; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 0.5rem;
        box-shadow: 0 2px 10px rgba(78,199,210,0.35); cursor: pointer; transition: all 0.2s;
    }
    .pmg-btn-save:hover { transform: translateY(-2px); box-shadow: 0 5px 18px rgba(0,80,143,0.35); }
</style>
@endpush

@section('content')
<div class="pmg-wrap container-fluid px-4">

    {{-- Hero --}}
    <div class="pmg-hero">
        <div class="pmg-hero-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div>
            <h2 class="pmg-hero-title">Nueva Asignación Docente</h2>
            <p class="pmg-hero-sub">Vincula un profesor con una materia y grado específico</p>
        </div>
    </div>

    {{-- Errores --}}
    @if($errors->any())
        <div class="pmg-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" onclick="this.parentElement.remove()"
                    style="margin-left:auto; background:none; border:none; color:#991b1b; font-size:1.2rem; cursor:pointer; flex-shrink:0; line-height:1;">&times;</button>
        </div>
    @endif

    <div class="pmg-card">
        <div class="pmg-card-head">
            <h5><i class="fas fa-link"></i> Datos de la Asignación</h5>
        </div>
        <div class="pmg-card-body">
            <form method="POST" action="{{ route('profesor_materia_grado.store') }}">
                @csrf

                <div class="row g-4">

                    {{-- Profesor --}}
                    <div class="col-md-6">
                        <label class="pmg-label" for="profesor_id">
                            <i class="fas fa-user-tie me-1" style="color:#4ec7d2;"></i>
                            Profesor <span class="req">*</span>
                        </label>
                        <select id="profesor_id" name="profesor_id" required
                                class="pmg-select @error('profesor_id') is-invalid @enderror">
                            <option value="">Seleccione un profesor…</option>
                            @foreach($profesores as $p)
                                <option value="{{ $p->id }}" {{ old('profesor_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nombre_completo ?? $p->nombre . ' ' . $p->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('profesor_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    {{-- Materia --}}
                    <div class="col-md-6">
                        <label class="pmg-label" for="materia_id">
                            <i class="fas fa-book me-1" style="color:#4ec7d2;"></i>
                            Materia <span class="req">*</span>
                        </label>
                        <select id="materia_id" name="materia_id" required
                                class="pmg-select @error('materia_id') is-invalid @enderror">
                            <option value="">Seleccione una materia…</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id }}" {{ old('materia_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('materia_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    {{-- Grado --}}
                    <div class="col-md-8">
                        <label class="pmg-label" for="grado_id">
                            <i class="fas fa-school me-1" style="color:#4ec7d2;"></i>
                            Grado <span class="req">*</span>
                        </label>
                        <select id="grado_id" name="grado_id" required
                                class="pmg-select @error('grado_id') is-invalid @enderror">
                            <option value="">Seleccione un grado…</option>
                            @foreach($grados as $g)
                                <option value="{{ $g->id }}" {{ old('grado_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->numero }}° {{ ucfirst($g->nivel) }} — Sección {{ $g->seccion }} ({{ $g->anio_lectivo }})
                                </option>
                            @endforeach
                        </select>
                        @error('grado_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    {{-- Sección --}}
                    <div class="col-md-4">
                        <label class="pmg-label">
                            <i class="fas fa-door-open me-1" style="color:#4ec7d2;"></i>
                            Sección <span class="req">*</span>
                        </label>
                        <div class="d-flex gap-2 flex-wrap mt-1">
                            @foreach($secciones as $s)
                                <div>
                                    <input type="radio" name="seccion" value="{{ $s }}"
                                           id="sec_{{ $s }}" class="btn-check"
                                           {{ old('seccion') == $s ? 'checked' : '' }}>
                                    <label for="sec_{{ $s }}" class="pmg-sec-btn">{{ $s }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('seccion')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                </div>

                {{-- Botones --}}
                <div class="pmg-footer">
                    <a href="{{ route('profesor_materia_grado.index') }}" class="pmg-btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="pmg-btn-save">
                        <i class="fas fa-save"></i> Guardar Asignación
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
