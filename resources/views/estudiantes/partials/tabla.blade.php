@forelse($estudiantes as $i => $estudiante)
<tr class="student-row">
    <td class="tc">
        <span class="row-num">{{ $estudiantes->firstItem() + $i }}</span>
    </td>
    <td>
        <div class="est-av">
            @if($estudiante->foto)
                <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto">
            @else
                <span class="av-txt">{{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}</span>
            @endif
        </div>
    </td>
    <td>
        <div class="est-name">{{ $estudiante->nombre_completo }}</div>
        @if($estudiante->email)
            <div class="est-email">{{ $estudiante->email }}</div>
        @endif
    </td>
    <td><span class="est-dni">{{ $estudiante->dni }}</span></td>
    <td class="tc"><span class="chip chip-teal">{{ $estudiante->grado }}</span></td>
    <td class="tc"><span class="chip chip-blue">{{ $estudiante->seccion }}</span></td>
    <td class="tc">
        @if($estudiante->estado === 'activo')
            <span class="badge-estado badge-activo"><span class="dot dot-teal"></span> Activo</span>
        @else
            <span class="badge-estado badge-inactivo"><span class="dot dot-red"></span> Inactivo</span>
        @endif
    </td>
    <td class="tc">
        <div class="act-group">
            <a href="{{ route('superadmin.estudiantes.historial.show', $estudiante->id) }}"
               class="act-btn act-historial" title="Historial Académico">
                <i class="fas fa-graduation-cap"></i>
            </a>
            <a href="{{ route('estudiantes.show', $estudiante->id) }}"
               class="act-btn act-view" title="Ver Perfil">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
               class="act-btn act-edit" title="Editar">
                <i class="fas fa-pen"></i>
            </a>
            <button type="button" class="act-btn act-del" title="Eliminar"
                    onclick="mostrarModalDelete(
                        '{{ route('estudiantes.destroy', $estudiante->id) }}',
                        '¿Está seguro de eliminar a este estudiante?',
                        '{{ addslashes($estudiante->nombre_completo) }}'
                    )">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="8">
        <div class="est-empty">
            <i class="fas fa-user-graduate"></i>
            <h6>No se encontraron estudiantes</h6>
            <p>Intenta con otro término de búsqueda</p>
        </div>
    </td>
</tr>
@endforelse