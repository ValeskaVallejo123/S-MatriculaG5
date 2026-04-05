@extends('layouts.app')

@section('title', 'Asignación Profesor-Grado')
@section('page-title', 'Asignación de Profesores a Grados')

@section('topbar-actions')
@endsection

@push('styles')
<style>
#searchInput:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
    outline: none;
}
.table tbody tr:hover { background-color: rgba(191,217,234,0.08); }
.badge-grado {
    background: rgba(0,80,143,0.08);
    color: #003b73;
    border: 1px solid #bfd9ea;
    padding: 0.25rem 0.55rem;
    font-size: 0.7rem;
    font-weight: 500;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- Alertas --}}
    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1); border-left:3px solid #22c55e;
                    border-radius:8px; padding:0.5rem 1rem; margin-bottom:1rem;
                    display:flex; align-items:center; gap:0.5rem; font-size:0.875rem;">
            <i class="fas fa-check-circle" style="color:#16a34a;"></i>
            <span style="color:#15803d;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Barra de búsqueda y resumen --}}
    <div style="background:white; border:1px solid #e8edf4; border-radius:10px;
                box-shadow:0 2px 8px rgba(0,59,115,0.06); padding:0.85rem 1.2rem; margin-bottom:1rem;">
        <div class="row align-items-center g-2">
            <div class="col-md-7">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute"
                       style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem;"></i>
                    <input type="text" id="searchInput"
                           style="border:2px solid #bfd9ea; border-radius:8px; padding:0.45rem 1rem 0.45rem 2.4rem;
                                  font-size:0.85rem; width:100%;"
                           placeholder="Buscar por nombre, materia o grado...">
                </div>
            </div>
            <div class="col-md-5 d-flex align-items-center justify-content-md-end gap-3">
                <span style="font-size:0.82rem;">
                    <i class="fas fa-chalkboard-teacher" style="color:#00508f;"></i>
                    <strong style="color:#00508f;">{{ $profesores->total() }}</strong>
                    <span class="text-muted"> profesores</span>
                </span>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div style="background:white; border:1px solid #e8edf4; border-radius:10px;
                box-shadow:0 2px 16px rgba(0,59,115,0.07); overflow:hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="profesoresTable">
                <thead style="background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%);">
                    <tr>
                        <th class="px-3 py-2" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.3px; color:#003b73; font-weight:700;">Profesor</th>
                        <th class="px-3 py-2" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.3px; color:#003b73; font-weight:700;">Especialidad</th>
                        <th class="px-3 py-2" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.3px; color:#003b73; font-weight:700;">Grados Asignados</th>
                        <th class="px-3 py-2 text-center" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.3px; color:#003b73; font-weight:700;">Estado</th>
                        <th class="px-3 py-2 text-end"    style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.3px; color:#003b73; font-weight:700;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($profesores as $profesor)
                    <tr style="border-bottom:1px solid #f1f5f9;" class="profesor-row">

                        {{-- Nombre --}}
                        <td class="px-3 py-2">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; flex-shrink:0;
                                            background:linear-gradient(135deg,#4ec7d2,#00508f);
                                            border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-user-tie" style="color:white; font-size:0.8rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:600; color:#003b73; font-size:0.88rem;">
                                        {{ $profesor->nombre }} {{ $profesor->apellido }}
                                    </div>
                                    @if($profesor->email)
                                        <div style="font-size:0.73rem; color:#64748b;">{{ $profesor->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Especialidad / Materia --}}
                        <td class="px-3 py-2">
                            <span style="font-size:0.82rem; color:#475569;">
                                {{ $profesor->especialidad ?? ($profesor->materia->nombre ?? '—') }}
                            </span>
                        </td>

                        {{-- Grados asignados --}}
                        <td class="px-3 py-2">
                            @if($profesor->gradosAsignados && $profesor->gradosAsignados->isNotEmpty())
                                <div style="display:flex; flex-wrap:wrap; gap:4px;">
                                    @foreach($profesor->gradosAsignados as $asig)
                                        <span class="badge-grado">
                                            <i class="fas fa-layer-group" style="font-size:0.6rem;"></i>
                                            {{ $asig->grado->nombre ?? '—' }} — Sec. {{ $asig->seccion }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span style="font-size:0.8rem; color:#94a3b8;">
                                    <i class="fas fa-info-circle me-1"></i>Sin grados asignados
                                </span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td class="px-3 py-2 text-center">
                            @php
                                $estado = $profesor->estado ?? 'activo';
                                $colors = [
                                    'activo'   => ['bg'=>'rgba(34,197,94,0.12)',  'color'=>'#15803d', 'border'=>'#86efac'],
                                    'inactivo' => ['bg'=>'rgba(239,68,68,0.1)',   'color'=>'#b91c1c', 'border'=>'#fca5a5'],
                                    'licencia' => ['bg'=>'rgba(234,179,8,0.12)',  'color'=>'#92400e', 'border'=>'#fde047'],
                                ];
                                $c = $colors[$estado] ?? $colors['activo'];
                            @endphp
                            <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }};
                                         border:1px solid {{ $c['border'] }};
                                         padding:0.25rem 0.65rem; border-radius:999px;
                                         font-size:0.72rem; font-weight:600;">
                                {{ ucfirst($estado) }}
                            </span>
                        </td>

                        {{-- Acciones --}}
                        <td class="px-3 py-2 text-end">
                            <a href="{{ route('profesor_grado.edit', $profesor->id) }}"
                               style="border:1.5px solid #4ec7d2; color:#4ec7d2; background:white;
                                      border-radius:6px; padding:0.3rem 0.75rem; font-size:0.8rem;
                                      text-decoration:none; display:inline-flex; align-items:center; gap:5px;
                                      transition:all 0.2s;"
                               onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                               onmouseout="this.style.background='white'; this.style.color='#4ec7d2';"
                               title="Asignar / editar grados">
                                <i class="fas fa-chalkboard"></i> Asignar grado
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-inbox fa-2x d-block mb-2" style="color:#00508f; opacity:0.4;"></i>
                            <h6 style="color:#003b73;">No hay profesores registrados</h6>
                            <p class="small text-muted mb-3">Registra un profesor primero para poder asignarle grados</p>
                            <a href="{{ route('profesores.create') }}"
                               style="background:linear-gradient(135deg,#4ec7d2,#00508f); color:white;
                                      border-radius:8px; padding:0.5rem 1.2rem; text-decoration:none;
                                      font-size:0.85rem; font-weight:600;">
                                <i class="fas fa-plus me-1"></i> Registrar Profesor
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($profesores->hasPages())
            <div style="padding:0.75rem 1rem; border-top:1px solid #f1f5f9;">
                {{ $profesores->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchInput');
    const rows  = document.querySelectorAll('#profesoresTable tbody .profesor-row');

    input.addEventListener('keyup', function () {
        const term = this.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach(row => {
            const match = row.textContent.toLowerCase().includes(term);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        const existing = document.querySelector('.no-results-row');
        if (visible === 0 && term !== '') {
            if (!existing) {
                const tr = document.createElement('tr');
                tr.className = 'no-results-row';
                tr.innerHTML = `<td colspan="5" class="text-center py-4">
                    <i class="fas fa-search" style="color:#00508f;opacity:0.5;font-size:1.4rem;"></i>
                    <p class="text-muted mt-2 mb-0">Sin resultados para "<strong>${term}</strong>"</p>
                </td>`;
                document.querySelector('#profesoresTable tbody').appendChild(tr);
            }
        } else if (existing) {
            existing.remove();
        }
    });
});
</script>
@endpush