<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Horario {{ $grado->numero }}°{{ $grado->seccion }}</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
    h2 { text-align:center; color:#003b73; margin-bottom:10px; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th, td { border:1px solid #003b73; padding:8px; text-align:center; }
    th { background:#4ec7d2; color:white; }
    .hora { font-weight:bold; text-align:left; }
    .materia { font-weight:700; color:#003b73; }
    .meta { font-size:11px; color:#666; }
</style>
</head>
<body>

<h2>Horario {{ $grado->numero }}°{{ $grado->seccion }} — {{ ucfirst($jornada) }}</h2>

@php
    $estructura = $horarioGrado->horario;
    $dias = array_keys($estructura);
    $horas = array_keys(reset($estructura));
@endphp

<table>
    <thead>
        <tr>
            <th class="hora">Hora</th>
            @foreach($dias as $dia)
                <th>{{ $dia }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($horas as $hora)
            <tr>
                <td class="hora">{{ $hora }}</td>
                @foreach($dias as $dia)
                    @php $c = $estructura[$dia][$hora]; @endphp
                    <td>
                        @if($c)
                            <div class="materia">
                                {{ optional($materias->find($c['materia_id']))->nombre }}
                            </div>
                            <div class="meta">
                                {{ optional($profesores->find($c['profesor_id']))->nombre ?? '—' }}
                                <br>Aula: {{ $c['salon'] ?? '—' }}
                            </div>
                        @else
                            —
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
