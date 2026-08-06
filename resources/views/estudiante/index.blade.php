@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        <a href="{{ url()->previous() }}"
           style="background:white;color:#00508f;padding:.6rem .75rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.5rem;border:1.5px solid #00508f;font-size:0.83rem;transition:all .2s;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <a href="{{ route('estudiantes.create') }}"
           style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);color:white;padding:.6rem .75rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.5rem;border:none;box-shadow:0 2px 8px rgba(78,199,210,0.3);font-size:0.83rem;">
            <i class="fas fa-plus"></i> Agregar Nuevo Estudiante
        </a>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --blue-dark:   #003b73;
            --blue-mid:    #00508f;
            --teal:        #4ec7d2;
            --border:      #e8edf4;
            --text-muted:  #64748b;
            --radius-lg:   16px;
        }

        .est-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        @media(max-width:900px){ .est-stats { grid-template-columns: repeat(2,1fr); } }

        .est-stat {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            padding: 1.1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .est-stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: #f1f5f9; color: var(--blue-mid);
        }
        .est-stat-num { font-size: 1.5rem; font-weight: 800; color: var(--blue-dark); line-height: 1; }
        .est-stat-lbl { font-size: .65rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); }

        .est-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }

        .est-card-head {
            background: var(--blue-dark);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .est-card-head i { color: var(--teal); font-size: 1.1rem; }
        .est-card-head span { color: white; font-weight: 700; font-size: 1rem; }

        .est-tbl { width: 100%; border-collapse: collapse; }
        .est-tbl thead th {
            background: #f8fafc;
            padding: .75rem 1rem;
            font-size: .7rem; font-weight: 700;
            text-transform: uppercase; color: var(--text-muted);
            border-bottom: 1.5px solid var(--border);
            text-align: left;
        }

        .row-num {
            width: 34px; height: 30px; border-radius: 8px;
            background: #f1f5f9; border: 1px solid #e2e8f0;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700; color: #64748b;
        }

        .est-av {
            width: 46px; height: 46px; border-radius: 12px;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            display: inline-flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 1rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .est-av img { width: 100%; height: 100%; object-fit: cover; }

        .est-name { font-weight: 700; color: var(--blue-dark); font-size: .95rem; }
        .est-email { font-size: .78rem; color: var(--text-muted); }

        .badge-activo { background: #d1fae5; color: #065f46; padding: .25rem .75rem; border-radius: 999px; font-size: .7rem; font-weight: 700; }
        .badge-inactivo { background: #fee2e2; color: #991b1b; padding: .25rem .75rem; border-radius: 999px; font-size: .7rem; font-weight: 700; }

        .act-btn {
            width: 32px; height: 32px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            border: 1.5px solid; transition: 0.2s;
        }
        .act-view { border-color: var(--blue-mid); color: var(--blue-mid); }
        .act-view:hover { background: var(--blue-mid); color: white; }
    </style>
@endpush

@section('content')
    <div>
        {{-- STATS --}}
        <div class="est-stats">
            <div class="est-stat">
                <div class="est-stat-icon"><i class="fas fa-users"></i></div>
                <div>
                    <div class="est-stat-num">{{ $estudiantes->total() }}</div>
                    <div class="est-stat-lbl">Total Alumnos</div>
                </div>
            </div>
            <div class="est-stat">
                <div class="est-stat-icon" style="color:#10b981;"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="est-stat-num">{{ $estudiantes->where('estado','activo')->count() }}</div>
                    <div class="est-stat-lbl">Activos</div>
                </div>
            </div>
        </div>

        {{-- TABLA --}}
        <div class="est-card">
            <div class="est-card-head">
                <i class="fas fa-list-ul"></i>
                <span>Lista de Estudiantes</span>
            </div>

            <div style="overflow-x:auto;">
                <table class="est-tbl">
                    <thead>
                    <tr>
                        <th style="text-align:center; width:60px;">#</th>
                        <th style="width:80px;">Foto</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Grado / Sección</th>
                        <th>Estado</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($estudiantes as $i => $estudiante)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="text-align:center;">
                                <span class="row-num">{{ $estudiantes->firstItem() + $i }}</span>
                            </td>

                            <td>
                                <div class="est-av">
                                    @php
                                        $nombreFoto = $estudiante->foto;
                                        $rutaFinal = '';
                                        $existe = false;

                                        if ($nombreFoto) {
                                            // Limpiamos el nombre por si el controlador guardó la carpeta 'estudiantes/'
                                            $soloNombre = basename($nombreFoto);

                                            // Ruta según tu estructura de carpetas (public/storage/expedientes/fotos)
                                            $pathFisico = 'storage/expedientes/fotos/' . $soloNombre;

                                            if (file_exists(public_path($pathFisico))) {
                                                $rutaFinal = asset($pathFisico);
                                                $existe = true;
                                            }
                                        }
                                    @endphp

                                    @if($existe)
                                        <img src="{{ $rutaFinal }}" alt="Foto">
                                    @else
                                        {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="est-name">{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}</div>
                                <div class="est-email">{{ $estudiante->email }}</div>
                            </td>

                            <td>
                                <span style="font-family:monospace; font-weight:600; color:#475569;">{{ $estudiante->dni }}</span>
                            </td>

                            <td>
                                <span style="background:#e0f2f1; color:#00796b; padding:.2rem .5rem; border-radius:6px; font-size:.75rem; font-weight:700;">{{ $estudiante->grado }}</span>
                                <span style="background:#e1effe; color:#1e429f; padding:.2rem .5rem; border-radius:6px; font-size:.75rem; font-weight:700;">{{ $estudiante->seccion }}</span>
                            </td>

                            <td>
                            <span class="{{ $estudiante->estado === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                {{ ucfirst($estudiante->estado) }}
                            </span>
                            </td>

                            <td style="text-align:center;">
                                <div style="display:flex; gap:.4rem; justify-content:center;">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="act-btn act-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="act-btn" style="border-color:#4ec7d2; color:#4ec7d2;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:3rem; color:#94a3b8;">No hay estudiantes registrados.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($estudiantes->hasPages())
                <div style="padding:1rem; border-top:1px solid #e8edf4; background:#f8fafc; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:.8rem; color:#64748b;">Mostrando {{ $estudiantes->count() }} de {{ $estudiantes->total() }}</span>
                    {{ $estudiantes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
