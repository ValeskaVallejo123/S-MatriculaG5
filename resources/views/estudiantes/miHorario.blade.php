@extends('layouts.app')

@section('title', 'Mi Horario')
@section('page-title', 'Mi Horario de Clases')

@push('styles')
<style>
:root {
    --blue:     #00508f;
    --blue-mid: #003b73;
    --teal:     #4ec7d2;
    --border:   #e8edf4;
    --muted:    #6b7a90;
    --r:        14px;
}

.mh-wrap { width: 100%; box-sizing: border-box; }

.mh-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 1.7rem;
    position: relative; overflow: hidden;
}
.mh-header::before {
    content: ''; position: absolute; right: -50px; top: -50px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.mh-header::after {
    content: ''; position: absolute; right: 100px; bottom: -45px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.mh-header-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap;
}
.mh-avatar {
    width: 80px; height: 80px; border-radius: 18px;
    border: 3px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(0,0,0,.25); flex-shrink: 0;
}
.mh-avatar i { color: white; font-size: 2rem; }
.mh-header h2 {
    font-size: 1.45rem; font-weight: 800; color: white;
    margin: 0 0 .5rem; text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.mh-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
    margin-right: .4rem;
}

.mh-body {
    background: white;
    border: 1px solid var(--border);
    border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: 0 4px 16px rgba(0,59,115,.10);
    padding: 1.4rem 1.7rem;
    margin-bottom: 1.3rem;
}

.mh-sec {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue); margin-bottom: .95rem;
    padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.15);
}
.mh-sec i { color: var(--teal); }

.grado-chip {
    display: inline-flex; align-items: center; gap: .4rem;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; padding: .3rem .85rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700; margin-bottom: 1rem;
}

.mh-table-wrap { overflow-x: auto; margin-bottom: .5rem; }
.mh-table { width: 100%; border-collapse: collapse; }

.mh-table thead th {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--muted); background: #f5f8fc;
    padding: .75rem .85rem;
    border: 1px solid var(--border);
    text-align: center; white-space: nowrap;
}
.mh-table thead th.th-hora {
    background: linear-gradient(135deg, rgba(0,80,143,.08), rgba(78,199,210,.08));
    color: var(--blue-mid); width: 120px;
}
.mh-table tbody td {
    border: 1px solid var(--border);
    padding: .65rem .75rem;
    vertical-align: middle;
    text-align: center;
    min-width: 140px;
}
.td-hora {
    font-size: .72rem; font-weight: 700; color: var(--blue);
    background: linear-gradient(135deg, rgba(0,80,143,.04), rgba(78,199,210,.04));
    text-align: left !important; white-space: nowrap;
}
.celda-asignada {
    background: linear-gradient(135deg, rgba(78,199,210,.12), rgba(0,80,143,.06));
    border-color: rgba(78,199,210,.4) !important;
}
.celda-materia {
    font-size: .8rem; font-weight: 700; color: var(--blue-mid);
    display: block; margin-bottom: .18rem;
}
.celda-profesor {
    font-size: .68rem; color: var(--muted);
    display: inline-flex; align-items: center; gap: .2rem;
}
.celda-salon {
    font-size: .65rem; color: #94a3b8;
    display: block; margin-top: .15rem;
}
.celda-vacia { font-size: .7rem; color: #c8d8e8; font-style: italic; }

.mh-empty {
    text-align: center; padding: 3.5rem 1rem; color: var(--muted);
}
.mh-empty i { font-size: 2.8rem; display: block; margin-bottom: .75rem; color: rgba(78,199,210,.35); }
.mh-empty p { font-size: .9rem; font-weight: 600; margin: 0 0 .25rem; }
.mh-empty small { font-size: .78rem; }

@media(max-width: 768px) {
    .mh-header { padding: 1.4rem 1.1rem; }
    .mh-body   { padding: 1rem 1.1rem; }
    .mh-avatar { width: 60px; height: 60px; }
    .mh-avatar i { font-size: 1.5rem; }
    .mh-header h2 { font-size: 1.1rem; }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="mh-wrap">

    {{-- ── HEADER ── --}}
    <div class="mh-header">
        <div class="mh-header-inner">
            <div class="mh-avatar">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
                <h2>Mi Horario de Clases</h2>
                @if($estudiante)
                    <span class="mh-badge">
                        <i class="fas fa-user-graduate"></i>
                        {{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}
                    </span>
                    @if($estudiante->grado)
                        <span class="mh-badge">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $estudiante->grado }}
                            @if($estudiante->seccion) — Sección {{ $estudiante->seccion }} @endif
                        </span>
                    @endif
                @endif
                <span class="mh-badge">
                    <i class="fas fa-calendar"></i> {{ now()->format('Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="mh-body">

        @if(!$estudiante)

            <div class="alert alert-warning" style="border-left:4px solid #f59e0b;border-radius:10px;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Atención:</strong> No se encontró un perfil de estudiante vinculado a tu cuenta.
                Contacta al administrador del sistema.
            </div>

        @elseif(!$horarioGrado)

            <div class="mh-empty">
                <i class="fas fa-calendar-times"></i>
                <p>No tienes un horario asignado aún</p>
                <small>Cuando el administrador configure el horario de tu grado, aparecerá aquí.</small>
            </div>

        @else

            @php
                $materias  = \App\Models\Materia::all()->keyBy('id');
                $profesores = \App\Models\Profesor::all()->keyBy('id');
                $estructura = $horarioGrado->horario ?? [];
                $dias       = array_keys($estructura);
                $horas      = !empty($estructura) ? array_keys(reset($estructura)) : [];
            @endphp

            <div class="mh-sec">
                <i class="fas fa-table"></i> Distribución de Clases
            </div>

            <div class="grado-chip">
                <i class="fas fa-graduation-cap"></i>
                {{ $horarioGrado->grado->nombre_completo ?? '' }}
                &nbsp;·&nbsp;
                Jornada {{ ucfirst($horarioGrado->jornada ?? '') }}
            </div>

            <div class="mh-table-wrap">
                <table class="mh-table">
                    <thead>
                        <tr>
                            <th class="th-hora">
                                <i class="fas fa-clock" style="color:#4ec7d2;margin-right:.3rem;"></i>Hora
                            </th>
                            @foreach($dias as $dia)
                                <th>{{ $dia }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horas as $hora)
                            <tr>
                                <td class="td-hora">
                                    <i class="fas fa-circle"
                                       style="font-size:.4rem;color:#4ec7d2;vertical-align:middle;margin-right:.3rem;"></i>
                                    {{ $hora }}
                                </td>
                                @foreach($dias as $dia)
                                    @php
                                        $celda = $estructura[$dia][$hora] ?? null;
                                        $tieneClase = !empty($celda) && !empty($celda['materia_id']);
                                    @endphp
                                    <td class="{{ $tieneClase ? 'celda-asignada' : '' }}">
                                        @if($tieneClase)
                                            <span class="celda-materia">
                                                <i class="fas fa-book-open"
                                                   style="color:#4ec7d2;font-size:.65rem;margin-right:.2rem;"></i>
                                                {{ $materias[$celda['materia_id']]->nombre ?? '—' }}
                                            </span>
                                            @if(!empty($celda['profesor_id']))
                                                <span class="celda-profesor">
                                                    <i class="fas fa-user-tie"
                                                       style="color:#94a3b8;font-size:.6rem;"></i>
                                                    {{ optional($profesores[$celda['profesor_id']] ?? null)->nombre }}
                                                    {{ optional($profesores[$celda['profesor_id']] ?? null)->apellido }}
                                                </span>
                                            @endif
                                            @if(!empty($celda['salon']))
                                                <span class="celda-salon">
                                                    <i class="fas fa-door-open"
                                                       style="color:#94a3b8;font-size:.6rem;"></i>
                                                    Aula: {{ $celda['salon'] }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="celda-vacia">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>

</div>
</div>
@endsection
