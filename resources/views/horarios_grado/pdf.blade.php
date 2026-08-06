<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Horario {{ $grado->numero }}°{{ $grado->seccion }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        background: white;
        color: #1e293b;
        width: 680px;
        margin: 60px auto;
    }

    /* ══════════════════════════════
       HEADER — solo badges centrados
       ══════════════════════════════ */
    .header {
        background: #00508f;
        border-radius: 12px 12px 0 0;
        padding: 12px 20px;
        text-align: center;
    }

    .badge {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        border: 1px solid rgba(255,255,255,.35);
        background: rgba(255,255,255,.15);
        color: white;
        margin: 0 3px;
    }

    /* ══════════════════════════════
       BODY WRAPPER
       ══════════════════════════════ */
    .body-wrapper {
        background: white;
        border: 1px solid #e8edf4;
        border-top: none;
        border-radius: 0 0 12px 12px;
        padding: 16px 18px 0;
    }

    /* ══════════════════════════════
       TÍTULO PRINCIPAL — centrado
       ══════════════════════════════ */
    .sec-title {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: #00508f;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid rgba(78,199,210,.25);
        text-align: center;
    }

    /* ══════════════════════════════
       TABLA
       ══════════════════════════════ */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #6b7a90;
        background: #f5f8fc;
        padding: 7px 8px;
        border: 1px solid #e8edf4;
        text-align: center;
    }

    thead th.th-hora {
        background: #eaf2f8;
        color: #003b73;
        text-align: center;
        width: 95px;
    }

    tbody td {
        border: 1px solid #e8edf4;
        padding: 6px 8px;
        vertical-align: middle;
        text-align: center;
    }

    .td-hora {
        font-size: 8px;
        font-weight: 700;
        color: #00508f;
        background: #f0f6fb;
        text-align: center;
        white-space: nowrap;
    }

    .td-materia-nombre {
        font-size: 8.5px;
        font-weight: 700;
        color: #003b73;
        display: block;
        margin-bottom: 2px;
    }

    .td-profesor {
        font-size: 7.5px;
        color: #6b7a90;
        display: block;
    }

    .td-salon {
        font-size: 7px;
        color: #94a3b8;
        display: block;
        margin-top: 1px;
    }

    .td-vacia {
        color: #cbd5e1;
        font-size: 9px;
    }

    /* ══════════════════════════════
       EMPTY STATE
       ══════════════════════════════ */
    .empty-state {
        text-align: center;
        padding: 32px 16px;
        color: #94a3b8;
        font-size: 10px;
    }

    /* ══════════════════════════════
       FOOTER
       ══════════════════════════════ */
    .footer {
        display: table;
        width: 100%;
        padding: 8px 18px;
        background: #f5f8fc;
        border-top: 1px solid #e8edf4;
        border-radius: 0 0 12px 12px;
        font-size: 8px;
        color: #94a3b8;
        margin-top: 12px;
    }

    .footer-left  { display: table-cell; text-align: left; }
    .footer-right { display: table-cell; text-align: right; }

    .accent { color: #4ec7d2; }

    tbody tr:nth-child(even) td         { background: #fafcff; }
    tbody tr:nth-child(even) td.td-hora { background: #edf4fb; }
</style>
</head>
<body>

{{-- ── HEADER — solo badges centrados ── --}}
<div class="header">
    <span class="badge">
        @if($jornada === 'matutina') ☀ @else ☾ @endif
        Jornada {{ ucfirst($jornada) }}
    </span>
    <span class="badge">{{ $grado->anio_lectivo }}</span>
</div>

{{-- ── BODY ── --}}
<div class="body-wrapper">

    {{-- Título principal centrado (reemplaza al nombre del grado) --}}
    <div class="sec-title">Distribución de Clases</div>

    @if(!$horarioGrado || empty($horarioGrado->horario))

        <div class="empty-state">
            No hay horario registrado para esta jornada.
        </div>

    @else
        @php
            $estructura = $horarioGrado->horario;
            $dias       = array_keys($estructura);
            $horas      = array_keys(reset($estructura));
        @endphp

        <table>
            <thead>
                <tr>
                    <th class="th-hora">Hora</th>
                    @foreach($dias as $dia)
                        <th>{{ $dia }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($horas as $hora)
                    <tr>
                        <td class="td-hora">{{ $hora }}</td>

                        @foreach($dias as $dia)
                            @php $c = $estructura[$dia][$hora] ?? null; @endphp
                            <td>
                                @if($c && ($c['materia_id'] || $c['profesor_id']))
                                    <span class="td-materia-nombre">
                                        {{ optional($materias->find($c['materia_id']))->nombre ?? '—' }}
                                    </span>
                                    <span class="td-profesor">
                                        {{ optional($profesores->find($c['profesor_id']))->nombre ?? '—' }}
                                    </span>
                                    <span class="td-salon">
                                        Aula: {{ $c['salon'] ?? '—' }}
                                    </span>
                                @else
                                    <span class="td-vacia">—</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</div>{{-- fin body-wrapper --}}

{{-- ── FOOTER ── --}}
<div class="footer">
    <div class="footer-left">
        <span class="accent">&#9432;</span>
        Horario de {{ $grado->numero }}° {{ $grado->seccion }} · Jornada {{ ucfirst($jornada) }}
    </div>
    <div class="footer-right">
        Año lectivo {{ $grado->anio_lectivo }}
    </div>
</div>

</body>
</html>
