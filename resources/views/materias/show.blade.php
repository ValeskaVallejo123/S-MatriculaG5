@extends('layouts.app')

@section('title', 'Detalle de Materia')
@section('page-title', 'Detalle de Materia')

@section('topbar-actions')
    <div style="display:flex;gap:.5rem;">
        <a href="{{ route('materias.edit', $materia) }}"
           style="display:inline-flex;align-items:center;gap:.4rem;padding:.42rem 1rem;border-radius:7px;font-size:.82rem;font-weight:600;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;text-decoration:none;transition:opacity .15s;">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('materias.index') }}"
           style="display:inline-flex;align-items:center;gap:.4rem;padding:.42rem 1rem;border-radius:7px;font-size:.82rem;font-weight:600;background:#fff;color:#00508f;text-decoration:none;border:1.5px solid #00508f;transition:opacity .15s;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.show-wrap { font-family: 'Inter', sans-serif; }

/* ── Layout ── */
.show-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 1.25rem;
    align-items: start;
}
@media(max-width:900px){ .show-grid { grid-template-columns: 1fr; } }

/* ── Card base ── */
.s-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    margin-bottom: 1.25rem;
}
.s-card:last-child { margin-bottom: 0; }

.s-card-head {
    padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
    border-bottom: 1px solid #e2e8f0;
}
.s-card-head i   { font-size: 1rem; }
.s-card-head span { font-weight: 700; font-size: .92rem; color: #fff; }
.s-card-head.blue { background: #003b73; }
.s-card-head.blue i { color: #4ec7d2; }
.s-card-head.white { background: #fff; }
.s-card-head.white i { color: #4ec7d2; }
.s-card-head.white span { color: #003b73; }

.s-card-body { padding: 1.25rem; }

/* ── Nombre badge ── */
.mat-hero-name {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, #f8fafc, #edf2f7);
}
.mat-hero-icon {
    width: 52px; height: 52px; border-radius: 12px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
}
.mat-hero-icon i { color: #fff; font-size: 1.3rem; }
.mat-hero-title { font-size: 1.2rem; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; }
.mat-hero-code  { font-size: .78rem; color: #64748b; margin-top: .2rem; }
.mat-hero-code span {
    font-family: 'Courier New', monospace;
    background: rgba(78,199,210,.12); color: #00508f;
    border: 1px solid rgba(78,199,210,.3);
    padding: .1rem .45rem; border-radius: 4px; font-weight: 700;
}

/* ── Info grid ── */
.info-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1rem; padding: 1.25rem;
}
@media(max-width:540px){ .info-grid { grid-template-columns: 1fr; } }

.info-item {
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 10px; padding: .85rem 1rem;
    border-left: 3px solid #4ec7d2;
}
.info-item.alt { border-left-color: #00508f; }
.info-lbl {
    font-size: .68rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #94a3b8; margin-bottom: .4rem;
}
.info-val { font-size: .88rem; font-weight: 600; color: #0f172a; }

/* Desc item full width */
.info-item.full { grid-column: 1 / -1; }

/* ── Badges ── */
.bpill {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .75rem; font-weight: 600;
}
.b-pri  { background: #e0f7fa; color: #006064; }
.b-sec  { background: #e8eaf6; color: #283593; }
.b-on   { background: #ecfdf5; color: #059669; }
.b-off  { background: #fef2f2; color: #dc2626; }

/* ── Tabla grados ── */
.s-tbl { width: 100%; border-collapse: collapse; }
.s-tbl thead th {
    background: #f8fafc; padding: .55rem 1rem;
    font-size: .68rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0;
}
.s-tbl tbody td {
    padding: .65rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.s-tbl tbody tr:last-child td { border-bottom: none; }
.s-tbl tbody tr:hover { background: #fafbfc; }

.grado-badge {
    display: inline-flex; align-items: center;
    background: rgba(78,199,210,.12); color: #00508f;
    border: 1px solid rgba(78,199,210,.3);
    padding: .2rem .6rem; border-radius: 6px;
    font-size: .78rem; font-weight: 700;
}
.hrs-badge {
    display: inline-flex; align-items: center;
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    color: #fff; padding: .2rem .6rem; border-radius: 99px;
    font-size: .72rem; font-weight: 700;
}

/* ── Stat items (sidebar) ── */
.stat-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9;
}
.stat-row:last-child { border-bottom: none; }
.stat-row-left { display: flex; align-items: center; gap: .6rem; font-size: .82rem; color: #334155; }
.stat-row-left i { color: #4ec7d2; font-size: .95rem; width: 18px; text-align: center; }
.stat-num {
    font-size: .82rem; font-weight: 700; color: #fff;
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    padding: .18rem .6rem; border-radius: 99px;
}

/* ── Accion btns ── */
.act-full {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    width: 100%; padding: .55rem; border-radius: 8px;
    font-size: .82rem; font-weight: 600; text-decoration: none;
    border: none; cursor: pointer; transition: opacity .15s; margin-bottom: .5rem;
}
.act-full:last-child { margin-bottom: 0; }
.act-full:hover { opacity: .88; }
.af-edit   { background: linear-gradient(135deg,#f59e0b,#d97706); color: #fff; }
.af-grados { background: #fff; color: #00508f; border: 1.5px solid #00508f; }
.af-del    { background: #fff; color: #ef4444; border: 1.5px solid #ef4444; }

/* ── Info sistema ── */
.sys-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: .55rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .8rem;
}
.sys-row:last-child { border-bottom: none; }
.sys-lbl { color: #94a3b8; }
.sys-val { font-weight: 600; color: #0f172a; }

/* ── Empty state ── */
.s-empty { padding: 2.5rem 1rem; text-align: center; }
.s-empty i { font-size: 1.8rem; color: #cbd5e1; display: block; margin-bottom: .6rem; }
.s-empty p { color: #94a3b8; font-size: .82rem; margin: 0; }
</style>
@endpush

@section('content')
<div class="show-wrap">
<div class="show-grid">

    {{-- ── Columna Principal ── --}}
    <div>

        {{-- Info de la materia --}}
        <div class="s-card">
            <div class="s-card-head blue">
                <i class="fas fa-book"></i>
                <span>Información de la Materia</span>
            </div>

            {{-- Nombre destacado --}}
            <div class="mat-hero-name">
                <div class="mat-hero-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <div class="mat-hero-title">{{ $materia->nombre }}</div>
                    <div class="mat-hero-code">Código: <span>{{ $materia->codigo }}</span></div>
                </div>
            </div>

            {{-- Grid de datos --}}
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-lbl">Área</div>
                    <div class="info-val">{{ $materia->area }}</div>
                </div>
                <div class="info-item alt">
                    <div class="info-lbl">Nivel Educativo</div>
                    <div class="info-val">
                        @if($materia->nivel === 'primaria')
                            <span class="bpill b-pri"><i class="fas fa-child"></i> Primaria (1° - 6°)</span>
                        @else
                            <span class="bpill b-sec"><i class="fas fa-user-graduate"></i> Secundaria (7° - 9°)</span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-lbl">Estado</div>
                    <div class="info-val">
                        @if($materia->activo)
                            <span class="bpill b-on"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activa</span>
                        @else
                            <span class="bpill b-off"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactiva</span>
                        @endif
                    </div>
                </div>
                <div class="info-item alt">
                    <div class="info-lbl">Grados Asignados</div>
                    <div class="info-val">{{ $materia->grados->count() }} grado(s)</div>
                </div>
                @if($materia->descripcion)
                <div class="info-item full">
                    <div class="info-lbl">Descripcion</div>
                    <div class="info-val" style="font-weight:400;color:#334155;line-height:1.5;">{{ $materia->descripcion }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Grados donde se imparte --}}
        <div class="s-card">
            <div class="s-card-head blue">
                <i class="fas fa-school"></i>
                <span>Grados donde se Imparte ({{ $materia->grados->count() }})</span>
            </div>
            @if($materia->grados->count() > 0)
            <div style="overflow-x:auto;">
                <table class="s-tbl">
                    <thead>
                        <tr>
                            <th>Grado</th>
                            <th>Nivel</th>
                            <th>Seccion</th>
                            <th>Año Lectivo</th>
                            <th>Profesor</th>
                            <th>Horas/Sem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materia->grados as $grado)
                        <tr>
                            <td>
                                <span class="grado-badge">{{ $grado->numero }}° Grado</span>
                            </td>
                            <td>
                                @if(strtolower($grado->nivel) === 'primaria')
                                    <span class="bpill b-pri">Primaria</span>
                                @else
                                    <span class="bpill b-sec">Secundaria</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-weight:600;color:#0f172a;">
                                    {{ $grado->seccion ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span style="color:#64748b;">{{ $grado->anio_lectivo }}</span>
                            </td>
                            <td>
                                @if($grado->pivot->profesor_id)
                                    @php $prof = \App\Models\Profesor::find($grado->pivot->profesor_id); @endphp
                                    @if($prof)
                                        <span style="font-weight:600;color:#0f172a;">
                                            {{ $prof->nombre }} {{ $prof->apellido }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;font-size:.78rem;">Sin asignar</span>
                                    @endif
                                @else
                                    <span style="color:#94a3b8;font-size:.78rem;">Sin asignar</span>
                                @endif
                            </td>
                            <td>
                                <span class="hrs-badge">{{ $grado->pivot->horas_semanales }} hrs</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="s-empty">
                <i class="fas fa-school"></i>
                <p>Esta materia aun no esta asignada a ningun grado</p>
            </div>
            @endif
        </div>

    </div>

    {{-- ── Sidebar ── --}}
    <div>

        {{-- Estadisticas --}}
        <div class="s-card">
            <div class="s-card-head white">
                <i class="fas fa-chart-bar"></i>
                <span>Estadisticas</span>
            </div>
            <div class="stat-row">
                <div class="stat-row-left">
                    <i class="fas fa-school"></i>
                    <span>Grados asignados</span>
                </div>
                <span class="stat-num">{{ $materia->grados->count() }}</span>
            </div>
            <div class="stat-row">
                <div class="stat-row-left">
                    <i class="fas fa-clock"></i>
                    <span>Total horas semanales</span>
                </div>
                <span class="stat-num">{{ $materia->grados->sum('pivot.horas_semanales') }} hrs</span>
            </div>
            <div class="stat-row">
                <div class="stat-row-left">
                    <i class="fas fa-layer-group"></i>
                    <span>Nivel</span>
                </div>
                <span style="font-size:.78rem;font-weight:600;color:#003b73;">
                    {{ $materia->nivel === 'primaria' ? 'Primaria' : 'Secundaria' }}
                </span>
            </div>
            <div class="stat-row">
                <div class="stat-row-left">
                    <i class="fas fa-toggle-on"></i>
                    <span>Estado</span>
                </div>
                @if($materia->activo)
                    <span class="bpill b-on" style="font-size:.72rem;">Activa</span>
                @else
                    <span class="bpill b-off" style="font-size:.72rem;">Inactiva</span>
                @endif
            </div>
        </div>

        {{-- Acciones --}}
        <div class="s-card">
            <div class="s-card-head white">
                <i class="fas fa-bolt" style="color:#f59e0b;"></i>
                <span>Acciones Rapidas</span>
            </div>
            <div style="padding:1rem;">
                <a href="{{ route('materias.edit', $materia) }}" class="act-full af-edit">
                    <i class="fas fa-edit"></i> Editar Materia
                </a>
                <a href="{{ route('grados.index') }}" class="act-full af-grados">
                    <i class="fas fa-layer-group"></i> Ver Grados
                </a>
                <button type="button" class="act-full af-del"
                        data-route="{{ route('materias.destroy', $materia) }}"
                        data-name="{{ $materia->nombre }}"
                        data-message="Esta accion eliminara la materia {{ $materia->nombre }} y todas sus asignaciones."
                        onclick="mostrarModalDeleteData(this)">
                    <i class="fas fa-trash"></i> Eliminar Materia
                </button>
            </div>
        </div>

        {{-- Info sistema --}}
        <div class="s-card">
            <div class="s-card-head white">
                <i class="fas fa-info-circle"></i>
                <span>Informacion del Sistema</span>
            </div>
            <div class="sys-row">
                <span class="sys-lbl">ID</span>
                <span class="sys-val">#{{ $materia->id }}</span>
            </div>
            <div class="sys-row">
                <span class="sys-lbl">Creado</span>
                <span class="sys-val">{{ $materia->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="sys-row">
                <span class="sys-lbl">Actualizado</span>
                <span class="sys-val">{{ $materia->updated_at->format('d/m/Y') }}</span>
            </div>
            <div class="sys-row">
                <span class="sys-lbl">Codigo</span>
                <span style="font-family:'Courier New',monospace;font-size:.8rem;font-weight:700;color:#00508f;">{{ $materia->codigo }}</span>
            </div>
        </div>

    </div>

</div>
</div>
@endsection