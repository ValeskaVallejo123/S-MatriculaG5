@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        <a href="{{ route('estudiantes.create') }}"
           style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);color:white;
              padding:.6rem .75rem;border-radius:8px;text-decoration:none;font-weight:600;
              display:inline-flex;align-items:center;gap:.5rem;border:none;
              box-shadow:0 2px 8px rgba(78,199,210,0.3);font-size:0.83rem;">
            <i class="fas fa-plus"></i> Nuevo Estudiante
        </a>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --blue-dark:  #003b73;
            --blue-mid:   #00508f;
            --teal:       #4ec7d2;
            --teal-light: rgba(78,199,210,0.12);
            --border:     #e8edf4;
            --surface:    #f5f8fc;
            --text-main:  #0d2137;
            --text-muted: #6b7a90;
            --green:      #10b981;
            --amber:      #f59e0b;
            --red:        #ef4444;
            --purple:     #8b5cf6;
            --radius-lg:  14px;
            --radius-sm:  7px;
            --shadow-sm:  0 1px 4px rgba(0,59,115,0.07);
            --shadow-md:  0 4px 16px rgba(0,59,115,0.10);
        }

        /* ── Stats ── */
        .est-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
        @media(max-width:900px){ .est-stats { grid-template-columns: repeat(2,1fr); } }
        @media(max-width:480px){ .est-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

        .est-stat {
            background: white; border-radius: var(--radius-lg); border: 1px solid var(--border);
            padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
            box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        }
        .est-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        .est-stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 1.3rem;
        }
        .est-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
        .est-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; }

        /* ── Toolbar ── */
        .est-toolbar {
            background: white; border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: .9rem 1.25rem; margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; box-shadow: var(--shadow-sm);
        }
        .est-search-wrap { position: relative; flex: 1; min-width: 220px; }
        .est-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
        .est-search {
            width: 100%; padding: .5rem 1rem .5rem 2.4rem;
            border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            font-size: .85rem; background: var(--surface); outline: none;
            transition: border-color .2s, box-shadow .2s; font-family: inherit; color: var(--text-main);
        }
        .est-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

        .est-search-btn {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .5rem 1rem; border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--teal), var(--blue-mid));
            color: white; border: none; font-size: .83rem; font-weight: 600;
            cursor: pointer; white-space: nowrap; box-shadow: 0 2px 8px rgba(78,199,210,.3);
        }

        .est-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; margin-left: auto; }
        .est-perpage select { padding: .3rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 7px; background: #f8fafc; outline: none; }

        /* ── Tabla card ── */
        .est-card { background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm); }
        .est-card-head { background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%); padding: .9rem 1.4rem; display: flex; align-items: center; justify-content: space-between; }
        .est-card-head span { color: white; font-weight: 700; font-size: .95rem; }
        .est-card-count { color: white; font-size: .82rem; font-weight: 600; background: rgba(255,255,255,.15); padding: .25rem .75rem; border-radius: 999px; border: 1px solid rgba(255,255,255,.25); }

        .est-tbl { width: 100%; border-collapse: collapse; }
        .est-tbl thead th { background: var(--surface); padding: .65rem 1rem; font-size: .68rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border-bottom: 1.5px solid var(--border); }
        .est-tbl tbody td { padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .84rem; vertical-align: middle; }

        /* ── AVATAR / FOTO ── */
        .est-av {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, var(--teal), var(--blue-mid));
            display: inline-flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: .9rem; flex-shrink: 0;
            border: 2px solid rgba(78,199,210,.3); overflow: hidden;
        }
        .est-av img { width: 100%; height: 100%; object-fit: cover; }

        .est-name { font-weight: 600; color: var(--blue-dark); font-size: .88rem; }
        .est-dni { font-family: 'Courier New', monospace; font-size: .82rem; color: var(--blue-mid); font-weight: 600; background: rgba(0,80,143,.06); padding: .2rem .5rem; border-radius: 5px; }

        .chip { display: inline-flex; align-items: center; padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 600; }
        .chip-teal { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
        .chip-blue { background: rgba(0,80,143,.08); color: var(--blue-dark); border: 1px solid rgba(0,80,143,.2); }

        .act-btn { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: 1.5px solid; transition: all .15s; text-decoration: none; background: white; }
        .act-view { border-color: var(--blue-mid); color: var(--blue-mid); }
        .act-edit { border-color: var(--teal); color: var(--teal); }
        .act-del  { border-color: var(--red); color: var(--red); }
        .act-view:hover { background: var(--blue-mid); color: white; }
        .act-edit:hover { background: var(--teal); color: white; }
        .act-del:hover  { background: var(--red); color: white; }
    </style>
@endpush

@section('content')
    @php
        $totalEstudiantes = \App\Models\Estudiante::count();
        $totalActivos     = \App\Models\Estudiante::where('estado','activo')->count();
        $totalInactivos   = \App\Models\Estudiante::where('estado','inactivo')->count();
        $totalHoy         = \App\Models\Estudiante::whereDate('created_at', today())->count();
    @endphp

    <div>
        {{-- STATS --}}
        <div class="est-stats">
            <div class="est-stat">
                <div class="est-stat-icon" style="background:rgba(0,80,143,.1);"><i class="fas fa-users" style="color:var(--blue-mid);"></i></div>
                <div><div class="est-stat-lbl">Total</div><div class="est-stat-num">{{ $totalEstudiantes }}</div></div>
            </div>
            <div class="est-stat">
                <div class="est-stat-icon" style="background:rgba(16,185,129,.12);"><i class="fas fa-check-circle" style="color:var(--green);"></i></div>
                <div><div class="est-stat-lbl">Activos</div><div class="est-stat-num">{{ $totalActivos }}</div></div>
            </div>
            <div class="est-stat">
                <div class="est-stat-icon" style="background:rgba(245,158,11,.12);"><i class="fas fa-user-slash" style="color:var(--amber);"></i></div>
                <div><div class="est-stat-lbl">Inactivos</div><div class="est-stat-num">{{ $totalInactivos }}</div></div>
            </div>
            <div class="est-stat">
                <div class="est-stat-icon" style="background:rgba(139,92,246,.12);"><i class="fas fa-user-plus" style="color:var(--purple);"></i></div>
                <div><div class="est-stat-lbl">Nuevos Hoy</div><div class="est-stat-num">{{ $totalHoy }}</div></div>
            </div>
        </div>

        {{-- TOOLBAR --}}
        <form method="GET" action="{{ route('estudiantes.index') }}" id="searchForm">
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            <div class="est-toolbar">
                <div class="est-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="buscar" id="searchInput" class="est-search" placeholder="Buscar por nombre, DNI, grado..." value="{{ request('buscar') }}">
                </div>
                <button type="submit" class="est-search-btn"><i class="fas fa-search"></i> Buscar</button>
                <div class="est-perpage">
                    Mostrar:
                    <select onchange="cambiarPerPage(this.value)">
                        @foreach([10, 25, 50] as $op)
                            <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>{{ $op }} por página</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        {{-- TABLA --}}
        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-head-left">
                    <i class="fas fa-user-graduate" style="color:var(--teal);"></i>
                    <span style="margin-left:8px;">Lista de Estudiantes</span>
                </div>
                <span class="est-card-count">{{ $estudiantes->total() }} registros</span>
            </div>

            <div style="overflow-x:auto;">
                <table class="est-tbl">
                    <thead>
                    <tr>
                        <th style="text-align:center; width:50px;">#</th>
                        <th style="width:70px; text-align:center;">Foto</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th style="text-align:center;">Grado</th>
                        <th style="text-align:center;">Estado</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($estudiantes as $i => $estudiante)
                        <tr>
                            <td style="text-align:center;"><span class="row-num">{{ $estudiantes->firstItem() + $i }}</span></td>
                            <td style="text-align:center;">
                                <div class="est-av">
                                    @if($estudiante->foto)
                                        {{-- SINCRONIZACIÓN CON CARPETA DE EXPEDIENTES --}}
                                        <img src="{{ asset('storage/expedientes/fotos/' . basename($estudiante->foto)) }}" alt="Foto">
                                    @else
                                        {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="est-name">{{ $estudiante->nombre_completo }}</div>
                                <div style="font-size: .7rem; color: var(--text-muted);">{{ $estudiante->email }}</div>
                            </td>
                            <td><span class="est-dni">{{ $estudiante->dni }}</span></td>
                            <td style="text-align:center;"><span class="chip chip-teal">{{ $estudiante->grado }} - {{ $estudiante->seccion }}</span></td>
                            <td style="text-align:center;">
                            <span class="{{ $estudiante->estado === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                {{ ucfirst($estudiante->estado) }}
                            </span>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:inline-flex; gap:.4rem;">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="act-btn act-view"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="act-btn act-edit"><i class="fas fa-pen"></i></a>
                                    <button type="button" class="act-btn act-del" onclick="mostrarModalDelete('{{ route('estudiantes.destroy', $estudiante->id) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center; padding:3rem;">No se encontraron estudiantes.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($estudiantes->hasPages())
                <div style="padding: 1rem; border-top: 1px solid var(--border); display:flex; justify-content: space-between; align-items:center; background: var(--surface);">
                    <span style="font-size:.8rem; color:var(--text-muted);">Mostrando {{ $estudiantes->firstItem() }} al {{ $estudiantes->lastItem() }}</span>
                    {{ $estudiantes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function cambiarPerPage(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }
    </script>
@endpush
