{{--
    Partial reutilizable para mostrar un campo de información.
    Uso: @include('estudiantes._info-item', ['label' => 'DNI', 'value' => $estudiante->dni, 'mono' => true])
    Parámetros:
      - label (string) — Etiqueta del campo
      - value (string) — Valor a mostrar
      - mono  (bool, opcional) — true para fuente monoespaciada
--}}
<div class="info-box">
    <p class="info-label">{{ $label }}</p>
    <p class="info-value {{ ($mono ?? false) ? 'font-monospace' : '' }}">
        {{ $value }}
    </p>
</div>
