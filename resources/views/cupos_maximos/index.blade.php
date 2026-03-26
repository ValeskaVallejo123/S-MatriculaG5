@extends('layouts.app')

@section('title', 'Cupos Máximos')
@section('page-title', 'Cupos Máximos')

@section('topbar-actions')
    <a href="{{ route('superadmin.cupos_maximos.create') }}" class="adm-btn-solid">
        <i class="fas fa-plus"></i> Nuevo Cupo
    </a>
@endsection

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        .adm-wrap { font-family: 'Inter', sans-serif; }

        .adm-btn-solid {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            color: #fff; border: none; text-decoration: none; transition: opacity .15s;
        }
        .adm-btn-solid:hover { opacity: .88; color: #fff; }

        /* Stats */
        .adm-stats {
            display: grid; grid-template-columns: repeat(3,1fr);
            gap: 1rem; margin-bottom: 1.5rem;
        }
        @media(max-width:640px){ .adm-stats { grid-template-columns: 1fr; } }

        .adm-stat {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
            padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .adm-stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .adm-stat-icon i { font-size: 1.15rem; color: #fff; }
        .adm-stat-lbl { font-size: .72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
        .adm-stat-num { font-size: 1.75rem; font-weight: 700; color: #0f172a; line-height: 1; }

        /* Toolbar */
        .adm-toolbar {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
            padding: .85rem 1.25rem; margin-bottom: 1.25rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,.05); gap: .75rem; flex-wrap: wrap;
        }
        .adm-search-wrap { position: relative; flex: 1; min-width: 180px; max-width: 320px; }
        .adm-search-icon { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .75rem; pointer-events: none; }
        .adm-search-input {
            width: 100%; padding: .35rem .75rem .35rem 2rem;
            border: 1.5px solid #e2e8f0; border-radius: 7px;
            font-size: .8rem; color: #0f172a; background: #f8fafc; outline: none;
            font-family: 'Inter', sans-serif;
        }
        .adm-search-input:focus { border-color: #4ec7d2; }

        .adm-filters { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
        .adm-filter-sel {
            padding: .35rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
            font-size: .8rem; color: #0f172a; background: #f8fafc; outline: none; cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .adm-filter-sel:focus { border-color: #4ec7d2; }

        .adm-btn-filter {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .35rem .9rem; border-radius: 7px; font-size: .8rem; font-weight: 600;
            background: linear-gradient(135deg, #4ec7d2, #00508f); color: #fff;
            border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: opacity .15s;
        }
        .adm-btn-filter:hover { opacity: .88; }
        .adm-btn-clear {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .35rem .9rem; border-radius: 7px; font-size: .8rem; font-weight: 600;
            background: #fff; color: #64748b; border: 1.5px solid #e2e8f0;
            text-decoration: none; font-family: 'Inter', sans-serif; transition: all .15s;
        }
        .adm-btn-clear:hover { border-color: #94a3b8; color: #334155; background: #f8fafc; }

        /* Card + Table */
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

        .adm-tbl { width: 100%; border-collapse: collapse; }
        .adm-tbl thead th {
            background: #f8fafc; padding: .6rem 1rem;
            font-size: .7rem; font-weight: 700; letter-spacing: .07em;
            text-transform: uppercase; color: #64748b;
            border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
        }
        .adm-tbl thead th.tc { text-align: center; }
        .adm-tbl tbody td {
            padding: .65rem 1rem; border-bottom: 1px solid #f1f5f9;
            font-size: .82rem; color: #334155; vertical-align: middle;
        }
        .adm-tbl tbody td.tc { text-align: center; }
        .adm-tbl tbody tr:last-child td { border-bottom: none; }
        .adm-tbl tbody tr:hover { background: #fafbfc; }

        .adm-num {
            width: 28px; height: 28px; border-radius: 6px;
            background: #f1f5f9; color: #64748b;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700;
        }

        .bpill {
            display: inline-flex; align-items: center; gap: .25rem;
            padding: .22rem .65rem; border-radius: 999px;
            font-size: .7rem; font-weight: 600; white-space: nowrap;
        }
        .b-blue   { background: #e8f8f9; color: #00508f; }
        .b-yellow { background: #fef9c3; color: #854d0e; }
        .b-purple { background: #f3e8ff; color: #6b21a8; }
        .b-green  { background: #dcfce7; color: #166534; }

        .act-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 7px; border: none;
            cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
        }
        .act-btn:hover { transform: translateY(-1px); }
        .act-edit { background: #e8f8f9; color: #00508f; }
        .act-edit:hover { background: #4ec7d2; color: #fff; }
        .act-del  { background: #fef2f2; color: #ef4444; }
        .act-del:hover  { background: #ef4444; color: #fff; }

        .adm-empty { padding: 3.5rem 1rem; text-align: center; }
        .adm-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
        .adm-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

        /* Pagination footer */
        .adm-footer {
            padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
            display: flex; align-items: center; justify-content: space-between;
            background: #fafafa; flex-wrap: wrap; gap: .5rem;
        }
        .adm-footer-info { font-size: .78rem; color: #64748b; }
        .pagination { margin: 0; }
        .pagination .page-item .page-link {
            font-size: .78rem; padding: .3rem .65rem; border-radius: 6px;
            color: #00508f; border-color: #e2e8f0; font-family: 'Inter', sans-serif;
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            border-color: #4ec7d2; color: #fff;
        }
        .pagination .page-item.disabled .page-link { color: #cbd5e1; }
    </style>
@endpush

@section('content')
<div class="adm-wrap container-fluid px-4">

    {{-- Stats --}}
    <div class="adm-stats">
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-users-cog"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Total Cupos</div>
                <div class="adm-stat-num">{{ $totalCupos }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#fbbf24,#d97706);">
                <i class="fas fa-sun"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Jornada Matutina</div>
                <div class="adm-stat-num">{{ $totalMatutina }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#818cf8,#4f46e5);">
                <i class="fas fa-moon"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Jornada Vespertina</div>
                <div class="adm-stat-num">{{ $totalVespertina }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar con filtros server-side --}}
    <form method="GET" action="{{ route('superadmin.cupos_maximos.index') }}" id="frmFiltro">
        <div class="adm-toolbar">
            <div class="adm-search-wrap">
                <i class="fas fa-search adm-search-icon"></i>
                <input type="text" name="buscar" class="adm-search-input"
                       placeholder="Buscar por curso..."
                       value="{{ request('buscar') }}">
            </div>
            <div class="adm-filters">
                <select name="jornada" class="adm-filter-sel" onchange="this.form.submit()">
                    <option value="">Jornada...</option>
                    <option value="Matutina"   {{ request('jornada') === 'Matutina'   ? 'selected' : '' }}>Matutina</option>
                    <option value="Vespertina" {{ request('jornada') === 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                </select>
                <select name="seccion" class="adm-filter-sel" onchange="this.form.submit()">
                    <option value="">Sección...</option>
                    @foreach(['A','B','C','D'] as $s)
                        <option value="{{ $s }}" {{ request('seccion') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <select name="per_page" class="adm-filter-sel" onchange="this.form.submit()">
                    @foreach([10,15,25,50] as $n)
                        <option value="{{ $n }}" {{ request('per_page', 15) == $n ? 'selected' : '' }}>{{ $n }} / pág</option>
                    @endforeach
                </select>
                <button type="submit" class="adm-btn-filter">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if(request()->hasAny(['buscar','jornada','seccion']))
                    <a href="{{ route('superadmin.cupos_maximos.index') }}" class="adm-btn-clear">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Tabla --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-users-cog"></i>
            <span>Lista de Cupos Máximos</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="adm-tbl">
                <thead>
                    <tr>
                        <th class="tc">#</th>
                        <th>Nombre del Curso</th>
                        <th class="tc">Cupo Máximo</th>
                        <th class="tc">Jornada</th>
                        <th class="tc">Sección</th>
                        <th class="tc">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($cursos as $curso)
                    <tr>
                        <td class="tc">
                            <span class="adm-num">{{ $cursos->firstItem() + $loop->index }}</span>
                        </td>
                        <td style="font-weight:600;color:#0f172a;">{{ $curso->nombre }}</td>
                        <td class="tc">
                            <span class="bpill b-blue">
                                <i class="fas fa-users"></i> {{ $curso->cupo_maximo }} alumnos
                            </span>
                        </td>
                        <td class="tc">
                            @if($curso->jornada === 'Matutina')
                                <span class="bpill b-yellow"><i class="fas fa-sun"></i> Matutina</span>
                            @elseif($curso->jornada === 'Vespertina')
                                <span class="bpill b-purple"><i class="fas fa-moon"></i> Vespertina</span>
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            @if($curso->seccion)
                                <span class="bpill b-green">{{ $curso->seccion }}</span>
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            <div style="display:inline-flex;gap:.4rem;align-items:center;">
                                <a href="{{ route('superadmin.cupos_maximos.edit', $curso->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del"
                                        title="Eliminar"
                                        onclick="sysConfirm('¿Eliminar el cupo de {{ addslashes($curso->nombre) }}? Esta acción no se puede deshacer.', () => {
                                            document.getElementById('form-del-idx').action='{{ route('superadmin.cupos_maximos.destroy', $curso->id) }}';
                                            document.getElementById('form-del-idx').submit();
                                        })">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="adm-empty">
                                <i class="fas fa-inbox"></i>
                                <p>No hay cupos registrados</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination footer --}}
        @if($cursos->hasPages())
        <div class="adm-footer">
            <div class="adm-footer-info">
                Mostrando {{ $cursos->firstItem() }}–{{ $cursos->lastItem() }} de {{ $cursos->total() }} cupos
            </div>
            {{ $cursos->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    {{-- Form oculto para eliminar --}}
    <form id="form-del-idx" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

</div>
@endsection
