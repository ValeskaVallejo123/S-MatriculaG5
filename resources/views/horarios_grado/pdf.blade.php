<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Horario {{ $grado->nombre_completo }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        background: white;
        color: #1e293b;
        width: 700px;
        margin: 40px auto;
    }

    /* ══════════════════════════════
       BANNER INSTITUCIONAL
       ══════════════════════════════ */
    .inst-banner {
        background: #003b73;
        border-radius: 10px 10px 0 0;
        padding: 18px 24px 14px;
        display: table;
        width: 100%;
    }

    .inst-banner-left {
        display: table-cell;
        vertical-align: middle;
    }

    .inst-banner-name {
        font-size: 17px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: .01em;
    }

    .inst-banner-sub {
        font-size: 9px;
        color: #4ec7d2;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        margin-top: 4px;
    }

    .inst-banner-right {
        display: table-cell;
        vertical-align: middle;
        text-align: right;
        font-size: 8px;
        color: rgba(255,255,255,.7);
        white-space: nowrap;
    }

    .inst-banner-right strong {
        color: #ffffff;
        font-size: 9px;
    }

    /* ══════════════════════════════
       CARD DE DATOS DEL GRADO
       ══════════════════════════════ */
    .grado-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-top: none;
        border-bottom: 3px solid #4ec7d2;
        padding: 12px 24px;
        margin-bottom: 18px;
        display: table;
        width: 100%;
    }

    .grado-card-inner {
        display: table-row;
    }

    .grado-cell {
        display: table-cell;
        vertical-align: middle;
        padding-right: 32px;
    }

    .grado-label {
        font-size: 7px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #94a3b8;
        display: block;
        margin-bottom: 3px;
    }

    .grado-value {
        font-size: 12px;
        font-weight: 800;
        color: #003b73;
    }

    /* ══════════════════════════════
       TÍTULO DE SECCIÓN
       ══════════════════════════════ */
    .sec-title {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: #00508f;
        margin-bottom: 10px;
        padding-bottom: 6px;
        border-bottom: 2px solid rgba(78,199,210,.30);
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
        padding: 8px 6px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    thead th.th-hora {
        background: #eaf2f8;
        color: #003b73;
        width: 90px;
    }

    tbody td {
        border: 1px solid #e2e8f0;
        padding: 6px 7px;
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

    /* ── Fila de RECREO ── */
    .tr-recreo td {
        background: #e8f4fb;
        border: 1px solid #b8d9ee;
    }

    .td-recreo-label {
        font-size: 9px;
        font-weight: 700;
        color: #00508f;
        text-transform: uppercase;
        letter-spacing: .35em;
        text-align: center;
    }

    .td-recreo-hora {
        font-size: 8px;
        font-weight: 700;
        color: #00508f;
        background: #d0e9f7;
        text-align: center;
        white-space: nowrap;
        border: 1px solid #b8d9ee;
    }

    tbody tr:nth-child(even) td:not(.td-recreo-label):not(.td-recreo-hora)         { background: #fafcff; }
    tbody tr:nth-child(even) td.td-hora { background: #edf4fb; }

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
       FIRMAS
       ══════════════════════════════ */
    .firmas {
        display: table;
        width: 100%;
        margin-top: 36px;
        border-top: 1px solid #e2e8f0;
        padding-top: 16px;
    }

    .firma-cell {
        display: table-cell;
        text-align: center;
        width: 33.33%;
        padding: 0 12px;
    }

    .firma-linea {
        border-top: 1px solid #003b73;
        margin-bottom: 5px;
        margin-top: 28px;
    }

    .firma-cargo {
        font-size: 8px;
        font-weight: 700;
        color: #003b73;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .firma-sub {
        font-size: 7px;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* ══════════════════════════════
       FOOTER
       ══════════════════════════════ */
    .footer {
        display: table;
        width: 100%;
        padding: 8px 0;
        border-top: 1px solid #e2e8f0;
        margin-top: 20px;
        font-size: 7.5px;
        color: #94a3b8;
    }

    .footer-left  { display: table-cell; text-align: left; }
    .footer-right { display: table-cell; text-align: right; }

    .accent { color: #4ec7d2; }
</style>
</head>
<body>

{{-- ══ BANNER INSTITUCIONAL ══ --}}
<div class="inst-banner">
    <div class="inst-banner-left">
        <div class="inst-banner-name">Escuela Gabriela Mistral</div>
        <div class="inst-banner-sub">Horario de Clases &mdash; Documento Oficial</div>
    </div>
    <div class="inst-banner-right">
        <div>Fecha de emisión: <strong>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong></div>
        <div style="margin-top:3px;">Documento de uso institucional</div>
    </div>
</div>

{{-- ══ DATOS DEL GRADO ══ --}}
<div class="grado-card">
    <div class="grado-card-inner">
        <div class="grado-cell">
            <span class="grado-label">Grado</span>
            <span class="grado-value">{{ $grado->nombre_completo }}</span>
        </div>
        <div class="grado-cell">
            <span class="grado-label">Nivel</span>
            <span class="grado-value">{{ ucfirst($grado->nivel) }}</span>
        </div>
        <div class="grado-cell">
            <span class="grado-label">Jornada</span>
            <span class="grado-value">{{ ucfirst($jornada) }}</span>
        </div>
        <div class="grado-cell">
            <span class="grado-label">Año Lectivo</span>
            <span class="grado-value">{{ $grado->anio_lectivo }}</span>
        </div>
    </div>
</div>

{{-- ══ TABLA DE HORARIO ══ --}}
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
        $totalCols  = count($dias) + 1; // +1 por columna Hora
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
                @if(str_contains($hora, 'RECREO'))
                    {{-- Fila especial de recreo --}}
                    <tr class="tr-recreo">
                        <td class="td-recreo-hora">{{ $hora }}</td>
                        <td class="td-recreo-label" colspan="{{ count($dias) }}">
                            R E C R E O
                        </td>
                    </tr>
                @else
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
                @endif
            @endforeach
        </tbody>
    </table>

@endif

{{-- ══ ÁREA DE FIRMAS ══ --}}
<div class="firmas">
    <div class="firma-cell">
        <div class="firma-linea"></div>
        <div class="firma-cargo">Director(a)</div>
        <div class="firma-sub">Firma y sello</div>
    </div>
    <div class="firma-cell">
        <div class="firma-linea"></div>
        <div class="firma-cargo">Secretaria</div>
        <div class="firma-sub">Firma y sello</div>
    </div>
    <div class="firma-cell">
        <div class="firma-linea"></div>
        <div class="firma-cargo">Docente responsable</div>
        <div class="firma-sub">Firma</div>
    </div>
</div>

{{-- ══ FOOTER ══ --}}
<div class="footer">
    <div class="footer-left">
        <span class="accent">&#9432;</span>
        Horario oficial &mdash; {{ $grado->nombre_completo }} &middot; Jornada {{ ucfirst($jornada) }}
    </div>
    <div class="footer-right">
        Escuela Gabriela Mistral &middot; {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>
</div>

</body>
</html>
