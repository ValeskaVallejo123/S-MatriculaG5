@extends('layouts.app')

@section('title', 'Detalle de Grado')
@section('page-title', 'Detalle de Grado')

@section('topbar-actions')
    <a href="{{ route('superadmin.grados.index') }}"
       style="background:white;color:#00508f;padding:.5rem .85rem;border-radius:7px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;border:1.5px solid #00508f;font-size:0.8rem;transition:all .2s;">
        <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Volver
    </a>
@endsection

@section('content')
<div style="max-width:1200px;margin:0 auto;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert"
         style="border-radius:10px;border-left:4px solid #4ec7d2;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- ── Columna principal ── --}}
        <div class="col-lg-8">

            {{-- Info del grado --}}
            <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;overflow:hidden;">
                <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:.85rem 1.25rem;display:flex;align-items:center;gap:.5rem;">
                    <i class="fas fa-graduation-cap" style="color:#4ec7d2;font-size:.95rem;"></i>
                    <span style="color:white;font-weight:700;font-size:.95rem;">Información del Grado</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div style="width:46px;height:46px;border-radius:11px;background:linear-gradient(135deg,#4ec7d2,#00508f);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-school" style="color:white;font-size:1.1rem;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Grado y Sección</small>
                                    <h4 class="mb-0 fw-bold" style="color:#003b73;">
                                        {{ $grado->numero }}° Grado
                                        @if($grado->seccion)
                                            <span style="color:#4ec7d2;">Sección {{ $grado->seccion }}</span>
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3" style="background:rgba(78,199,210,.06);border-radius:8px;border-left:3px solid #4ec7d2;">
                                <small class="text-muted d-block mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Nivel Educativo</small>
                                @if($grado->nivel === 'primaria')
                                    <span style="background:rgba(78,199,210,.15);color:#00508f;border:1px solid #4ec7d2;padding:.3rem .7rem;border-radius:999px;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.3rem;">
                                        <i class="fas fa-child" style="font-size:.7rem;"></i> Primaria (1° - 6°)
                                    </span>
                                @else
                                    <span style="background:rgba(0,80,143,.12);color:#003b73;border:1px solid #00508f;padding:.3rem .7rem;border-radius:999px;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.3rem;">
                                        <i class="fas fa-user-graduate" style="font-size:.7rem;"></i> Secundaria (7° - 9°)
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3" style="background:rgba(0,80,143,.05);border-radius:8px;border-left:3px solid #00508f;">
                                <small class="text-muted d-block mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Año Lectivo</small>
                                <span class="fw-bold" style="color:#003b73;font-size:1rem;">
                                    <i class="fas fa-calendar-alt" style="color:#4ec7d2;margin-right:.3rem;"></i>{{ $grado->anio_lectivo }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3" style="background:rgba(78,199,210,.06);border-radius:8px;border-left:3px solid #4ec7d2;">
                                <small class="text-muted d-block mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Estado</small>
                                @if($grado->activo)
                                    <span style="background:rgba(78,199,210,.15);color:#00508f;border:1px solid #4ec7d2;padding:.3rem .7rem;border-radius:999px;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.3rem;">
                                        <i class="fas fa-check-circle" style="font-size:.7rem;"></i> Activo
                                    </span>
                                @else
                                    <span style="background:#fee2e2;color:#991b1b;border:1px solid #ef4444;padding:.3rem .7rem;border-radius:999px;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.3rem;">
                                        <i class="fas fa-times-circle" style="font-size:.7rem;"></i> Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3" style="background:rgba(0,80,143,.05);border-radius:8px;border-left:3px solid #00508f;">
                                <small class="text-muted d-block mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">Materias Asignadas</small>
                                <span style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;padding:.3rem .7rem;border-radius:999px;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.3rem;">
                                    <i class="fas fa-book" style="font-size:.7rem;"></i> {{ $grado->materias->count() }} Materias
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Materias --}}
            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:.75rem 1.1rem;display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <i class="fas fa-book-open" style="color:#4ec7d2;font-size:.9rem;"></i>
                        <span style="color:white;font-weight:700;font-size:.88rem;">Materias Asignadas ({{ $grado->materias->count() }})</span>
                    </div>
                    <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}"
                       style="background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.3);padding:.28rem .7rem;border-radius:6px;font-size:.75rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;">
                        <i class="fas fa-plus" style="font-size:.65rem;"></i> Gestionar
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($grado->materias->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-2x mb-3 d-block" style="color:#bfd9ea;"></i>
                            <h6 style="color:#003b73;">No hay materias asignadas</h6>
                            <p class="text-muted small mb-3">Asigna materias a este grado para comenzar</p>
                            <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}"
                               style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;padding:.45rem 1rem;border-radius:7px;text-decoration:none;font-size:.82rem;font-weight:600;display:inline-flex;align-items:center;gap:.35rem;">
                                <i class="fas fa-plus" style="font-size:.72rem;"></i> Asignar Materias
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size:.82rem;">
                                <thead style="background:#f8fafc;">
                                    <tr>
                                        <th style="padding:.55rem 1rem;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Materia</th>
                                        <th style="padding:.55rem 1rem;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Código</th>
                                        <th style="padding:.55rem 1rem;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Área</th>
                                        <th style="padding:.55rem 1rem;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Profesor</th>
                                        <th style="padding:.55rem 1rem;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;border-bottom:1.5px solid #e2e8f0;">Hrs/Sem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grado->materias as $materia)
                                    <tr style="border-bottom:1px solid #f1f5f9;">
                                        <td style="padding:.6rem 1rem;">
                                            <span class="fw-semibold" style="color:#003b73;">{{ $materia->nombre }}</span>
                                        </td>
                                        <td style="padding:.6rem 1rem;">
                                            <span style="background:rgba(78,199,210,.12);color:#00508f;border:1px solid #4ec7d2;padding:.18rem .55rem;border-radius:5px;font-family:monospace;font-size:.75rem;font-weight:600;">
                                                {{ $materia->codigo }}
                                            </span>
                                        </td>
                                        <td style="padding:.6rem 1rem;">
                                            <span style="background:rgba(0,80,143,.08);color:#00508f;padding:.18rem .55rem;border-radius:999px;font-size:.72rem;font-weight:600;">
                                                {{ $materia->area }}
                                            </span>
                                        </td>
                                        <td style="padding:.6rem 1rem;">
                                            @if($materia->pivot->profesor_id)
                                                @php $profesor = \App\Models\Profesor::find($materia->pivot->profesor_id); @endphp
                                                <span style="font-size:.8rem;color:#334155;">
                                                    <i class="fas fa-user-tie" style="color:#4ec7d2;margin-right:.25rem;font-size:.72rem;"></i>
                                                    {{ $profesor ? $profesor->nombre . ' ' . $profesor->apellido : 'No encontrado' }}
                                                </span>
                                            @else
                                                <span style="color:#94a3b8;font-size:.78rem;">
                                                    <i class="fas fa-user-times" style="margin-right:.25rem;font-size:.7rem;"></i> Sin asignar
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding:.6rem 1rem;">
                                            <span style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;padding:.2rem .55rem;border-radius:999px;font-size:.72rem;font-weight:600;">
                                                {{ $materia->pivot->horas_semanales }} hrs
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ── Panel lateral ── --}}
        <div class="col-lg-4">

            {{-- Estadísticas --}}
            <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;overflow:hidden;">
                <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:.75rem 1.1rem;display:flex;align-items:center;gap:.5rem;">
                    <i class="fas fa-chart-bar" style="color:#4ec7d2;font-size:.88rem;"></i>
                    <span style="color:white;font-weight:700;font-size:.88rem;">Estadísticas</span>
                </div>
                <div class="card-body p-3">

                    <div class="d-flex justify-content-between align-items-center mb-2 p-2" style="background:rgba(78,199,210,.06);border-radius:8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-book" style="color:#4ec7d2;font-size:.9rem;"></i>
                            <span style="font-size:.8rem;color:#64748b;">Total materias</span>
                        </div>
                        <span style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;padding:.22rem .65rem;border-radius:999px;font-size:.78rem;font-weight:700;">
                            {{ $grado->materias->count() }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 p-2" style="background:rgba(0,80,143,.05);border-radius:8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-clock" style="color:#00508f;font-size:.9rem;"></i>
                            <span style="font-size:.8rem;color:#64748b;">Horas totales/semana</span>
                        </div>
                        <span style="background:rgba(0,80,143,.15);color:#003b73;padding:.22rem .65rem;border-radius:999px;font-size:.78rem;font-weight:700;">
                            {{ $grado->materias->sum('pivot.horas_semanales') }} hrs
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-2" style="background:rgba(16,185,129,.06);border-radius:8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-chalkboard-teacher" style="color:#10b981;font-size:.9rem;"></i>
                            <span style="font-size:.8rem;color:#64748b;">Profesores asignados</span>
                        </div>
                        <span style="background:rgba(16,185,129,.15);color:#059669;padding:.22rem .65rem;border-radius:999px;font-size:.78rem;font-weight:700;">
                            {{ $grado->materias->where('pivot.profesor_id', '!=', null)->count() }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- Acciones rápidas --}}
            <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;overflow:hidden;">
                <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:.75rem 1.1rem;display:flex;align-items:center;gap:.5rem;">
                    <i class="fas fa-bolt" style="color:#4ec7d2;font-size:.88rem;"></i>
                    <span style="color:white;font-weight:700;font-size:.88rem;">Acciones Rápidas</span>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}"
                           style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border-radius:8px;padding:.6rem;font-weight:600;font-size:.83rem;text-decoration:none;text-align:center;display:flex;align-items:center;justify-content:center;gap:.4rem;">
                            <i class="fas fa-tasks" style="font-size:.78rem;"></i> Gestionar Materias
                        </a>
                        <a href="{{ route('superadmin.grados.edit', $grado) }}"
                           style="background:white;color:#00508f;border:1.5px solid #4ec7d2;border-radius:8px;padding:.6rem;font-weight:600;font-size:.83rem;text-decoration:none;text-align:center;display:flex;align-items:center;justify-content:center;gap:.4rem;">
                            <i class="fas fa-edit" style="font-size:.78rem;"></i> Editar Grado
                        </a>
                        <a href="{{ route('superadmin.materias.index') }}"
                           style="background:white;color:#00508f;border:1.5px solid #d0dce8;border-radius:8px;padding:.6rem;font-weight:600;font-size:.83rem;text-decoration:none;text-align:center;display:flex;align-items:center;justify-content:center;gap:.4rem;">
                            <i class="fas fa-book" style="font-size:.78rem;"></i> Ver Materias
                        </a>
                        <form action="{{ route('superadmin.grados.destroy', $grado) }}"
                              method="POST"
                              onsubmit="return confirm('¿Está seguro de eliminar este grado?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="width:100%;background:white;color:#ef4444;border:1.5px solid #fca5a5;border-radius:8px;padding:.6rem;font-weight:600;font-size:.83rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.4rem;">
                                <i class="fas fa-trash" style="font-size:.78rem;"></i> Eliminar Grado
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Info del sistema --}}
            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:.75rem 1.1rem;display:flex;align-items:center;gap:.5rem;">
                    <i class="fas fa-info-circle" style="color:#4ec7d2;font-size:.88rem;"></i>
                    <span style="color:white;font-weight:700;font-size:.88rem;">Información del Sistema</span>
                </div>
                <div class="card-body p-3">
                    <div style="font-size:.8rem;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Creado:</span>
                            <strong style="color:#003b73;">{{ $grado->created_at->format('d/m/Y') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Última actualización:</span>
                            <strong style="color:#003b73;">{{ $grado->updated_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection