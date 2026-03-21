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

        .adm-toolbar {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
            padding: .85rem 1.25rem; margin-bottom: 1.25rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,.05); gap: .75rem; flex-wrap: wrap;
        }
        .adm-search {
            display: flex; align-items: center; gap: .5rem;
            flex: 1; min-width: 180px; max-width: 320px;
        }
        .adm-search input {
            width: 100%; padding: .35rem .75rem .35rem 2rem;
            border: 1.5px solid #e2e8f0; border-radius: 7px;
            font-size: .8rem; color: #0f172a; background: #f8fafc; outline: none;
        }
        .adm-search input:focus { border-color: #4ec7d2; }
        .adm-search-icon { position: absolute; left: .65rem; color: #94a3b8; font-size: .75rem; }
        .adm-search-wrap { position: relative; flex: 1; }

        .adm-filters { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
        .adm-filters select {
            padding: .35rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
            font-size: .8rem; color: #0f172a; background: #f8fafc; outline: none; cursor: pointer;
        }
        .adm-filters select:focus { border-color: #4ec7d2; }

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

        #noResults { display: none; }
        #noResults.visible { display: block; }
    </style>
@endpush

@section('content')
    <div class="adm-wrap">

        {{-- Stats --}}
        <div class="adm-stats">
            <div class="adm-stat">
                <div class="adm-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <div class="adm-stat-lbl">Total Cupos</div>
                    <div class="adm-stat-num">{{ $cursos->count() }}</div>
                </div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon" style="background:linear-gradient(135deg,#fbbf24,#d97706);">
                    <i class="fas fa-sun"></i>
                </div>
                <div>
                    <div class="adm-stat-lbl">Jornada Matutina</div>
                    <div class="adm-stat-num">{{ $cursos->where('jornada','Matutina')->count() }}</div>
                </div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon" style="background:linear-gradient(135deg,#818cf8,#4f46e5);">
                    <i class="fas fa-moon"></i>
                </div>
                <div>
                    <div class="adm-stat-lbl">Jornada Vespertina</div>
                    <div class="adm-stat-num">{{ $cursos->where('jornada','Vespertina')->count() }}</div>
                </div>
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="adm-toolbar">
            <div class="adm-search">
                <div class="adm-search-wrap">
                    <i class="fas fa-search adm-search-icon"></i>
                    <input type="text" id="searchNombre" placeholder="Buscar por curso...">
                </div>
            </div>
            <div class="adm-filters">
                <select id="filterJornada">
                    <option value="">Jornada...</option>
                    <option value="Matutina">Matutina</option>
                    <option value="Vespertina">Vespertina</option>
                </select>
                <select id="filterSeccion">
                    <option value="">Sección...</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="adm-card">
            <div class="adm-card-head">
                <i class="fas fa-users-cog"></i>
                <span>Lista de Cupos Máximos</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="adm-tbl" id="cursosTable">
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
                                <span class="adm-num">{{ $loop->iteration }}</span>
                            </td>
                            <td class="nombre" style="font-weight:600;color:#0f172a;">
                                {{ $curso->nombre }}
                            </td>
                            <td class="tc">
                            <span class="bpill b-blue">
                                <i class="fas fa-users"></i> {{ $curso->cupo_maximo }} alumnos
                            </span>
                            </td>
                            <td class="tc jornada">
                                @if($curso->jornada === 'Matutina')
                                    <span class="bpill b-yellow">
                                    <i class="fas fa-sun"></i> Matutina
                                </span>
                                @elseif($curso->jornada === 'Vespertina')
                                    <span class="bpill b-purple">
                                    <i class="fas fa-moon"></i> Vespertina
                                </span>
                                @else
                                    <span style="color:#cbd5e1;">—</span>
                                @endif
                            </td>
                            <td class="tc seccion">
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
                                            data-route="{{ route('superadmin.cupos_maximos.destroy', $curso->id) }}"
                                            data-message="¿Seguro que deseas eliminar el cupo de {{ addslashes($curso->nombre) }}? Esta acción no se puede deshacer."
                                            data-name="{{ $curso->nombre }}"
                                            onclick="mostrarModalDeleteData(this)"
                                            title="Eliminar">
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

            {{-- Sin resultados por filtro --}}
            <div id="noResults" style="padding:2.5rem 1rem;text-align:center;color:#94a3b8;">
                <i class="fas fa-search-minus" style="font-size:1.75rem;display:block;margin-bottom:.5rem;"></i>
                <p style="margin:0;font-size:.85rem;">No hay coincidencias con los filtros aplicados.</p>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const searchInput   = document.getElementById('searchNombre');
        const filterJornada = document.getElementById('filterJornada');
        const filterSeccion = document.getElementById('filterSeccion');
        const tbody         = document.querySelector('#cursosTable tbody');
        const noResults     = document.getElementById('noResults');

        function filterTable() {
            const s   = searchInput.value.toLowerCase();
            const j   = filterJornada.value;
            const sec = filterSeccion.value;
            let visible = 0;

            Array.from(tbody.rows).forEach(row => {
                if (row.cells.length < 6) return;
                const nombre  = row.querySelector('.nombre')?.textContent.toLowerCase() ?? '';
                const jornada = row.querySelector('.jornada')?.textContent.trim() ?? '';
                const seccion = row.querySelector('.seccion')?.textContent.trim() ?? '';

                const ok = nombre.includes(s)
                    && (j   === '' || jornada.includes(j))
                    && (sec === '' || seccion.includes(sec));

                row.style.display = ok ? '' : 'none';
                if (ok) visible++;
            });

            noResults.style.display = visible === 0 && tbody.rows.length > 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterTable);
        filterJornada.addEventListener('change', filterTable);
        filterSeccion.addEventListener('change', filterTable);
    </script>
@endpush
