<div class="card border-0 shadow-sm h-100" style="border-radius:12px; transition: all 0.3s ease;">

    {{-- Header de la card --}}
    <div class="card-header border-0 p-0" style="border-radius:12px 12px 0 0; overflow:hidden;">
        <div style="background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
                    padding: 1.2rem; position:relative; overflow:hidden;">
            {{-- Decoración --}}
            <div style="position:absolute; right:-20px; top:-20px; width:80px; height:80px;
                        border-radius:50%; background:rgba(78,199,210,.13); pointer-events:none;"></div>

            <div style="position:relative; z-index:1;">
                {{-- Nivel badge --}}
                <span style="font-size:.62rem; font-weight:700; text-transform:uppercase;
                             letter-spacing:.08em; color:rgba(78,199,210,.9);">
                    {{ $grado->nivel }}
                </span>
                {{-- Número y sección --}}
                <h5 class="mb-0 fw-800 text-white" style="font-size:1.15rem; font-weight:800; margin-top:.2rem;">
                    {{ $grado->nombre }}
                </h5>
                <div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
                    @if($grado->seccion)
                        <span style="display:inline-flex; align-items:center; gap:.25rem;
                                     background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25);
                                     border-radius:999px; padding:.18rem .6rem;
                                     font-size:.68rem; font-weight:700; color:white;">
                            <i class="fas fa-layer-group" style="font-size:.55rem;"></i>
                            Sección {{ $grado->seccion }}
                        </span>
                    @endif
                    <span style="display:inline-flex; align-items:center; gap:.25rem;
                                 background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25);
                                 border-radius:999px; padding:.18rem .6rem;
                                 font-size:.68rem; font-weight:700; color:white;">
                        <i class="fas fa-calendar" style="font-size:.55rem;"></i>
                        {{ $grado->anio_lectivo }}
                    </span>
                    @if($grado->activo)
                        <span style="display:inline-flex; align-items:center; gap:.25rem;
                                     background:rgba(16,185,129,.25); border:1px solid rgba(16,185,129,.4);
                                     border-radius:999px; padding:.18rem .6rem;
                                     font-size:.68rem; font-weight:700; color:#6ee7b7;">
                            <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
                        </span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:.25rem;
                                     background:rgba(239,68,68,.2); border:1px solid rgba(239,68,68,.3);
                                     border-radius:999px; padding:.18rem .6rem;
                                     font-size:.68rem; font-weight:700; color:#fca5a5;">
                            <i class="fas fa-circle" style="font-size:.4rem;"></i> Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="card-body p-3">

        {{-- Materias count --}}
        <div style="display:flex; align-items:center; justify-content:space-between;
                    background:#f5f8fc; border:1px solid #e8edf4; border-radius:8px;
                    padding:.6rem .85rem; margin-bottom:.75rem;">
            <span style="font-size:.72rem; font-weight:600; color:#6b7a90; display:flex; align-items:center; gap:.4rem;">
                <i class="fas fa-book-open" style="color:#4ec7d2;"></i> Materias asignadas
            </span>
            <span style="font-size:.8rem; font-weight:800; color:#003b73;">
                {{ $grado->materias->count() }}
            </span>
        </div>

        {{-- Materias list (máx 3) --}}
        @if($grado->materias->isNotEmpty())
            <div style="margin-bottom:.75rem;">
                @foreach($grado->materias->take(3) as $materia)
                    <span style="display:inline-flex; align-items:center; gap:.25rem;
                                 background:linear-gradient(135deg,rgba(78,199,210,.12),rgba(0,80,143,.07));
                                 border:1px solid rgba(78,199,210,.3); border-radius:999px;
                                 padding:.2rem .6rem; font-size:.68rem; font-weight:600;
                                 color:#003b73; margin:.1rem .1rem 0 0;">
                        <i class="fas fa-circle" style="font-size:.35rem; color:#4ec7d2;"></i>
                        {{ $materia->nombre }}
                    </span>
                @endforeach
                @if($grado->materias->count() > 3)
                    <span style="font-size:.65rem; color:#6b7a90; margin-left:.25rem;">
                        +{{ $grado->materias->count() - 3 }} más
                    </span>
                @endif
            </div>
        @else
            <p style="font-size:.75rem; color:#94a3b8; font-style:italic; margin-bottom:.75rem;">
                Sin materias asignadas
            </p>
        @endif

    </div>

    {{-- Footer con acciones --}}
    <div class="card-footer border-0 p-3 pt-0" style="background:white; border-radius:0 0 12px 12px;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:.5rem; margin-bottom:.5rem;">
            <a href="{{ route('superadmin.grados.show', $grado) }}"
               style="display:flex; align-items:center; justify-content:center; gap:.3rem;
                      background:#f5f8fc; border:1px solid #e8edf4; border-radius:8px;
                      padding:.45rem; font-size:.72rem; font-weight:700; color:#003b73;
                      text-decoration:none; transition:all .2s;">
                <i class="fas fa-eye" style="color:#4ec7d2;"></i> Ver
            </a>
            <a href="{{ route('superadmin.grados.edit', $grado) }}"
               style="display:flex; align-items:center; justify-content:center; gap:.3rem;
                      background:#fff8eb; border:1px solid #fde68a; border-radius:8px;
                      padding:.45rem; font-size:.72rem; font-weight:700; color:#92400e;
                      text-decoration:none; transition:all .2s;">
                <i class="fas fa-edit" style="color:#f59e0b;"></i> Editar
            </a>
        </div>
        <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}"
           style="display:flex; align-items:center; justify-content:center; gap:.4rem;
                  background:linear-gradient(135deg,#4ec7d2,#00508f); border-radius:8px;
                  padding:.5rem; font-size:.72rem; font-weight:700; color:white;
                  text-decoration:none; transition:all .2s; width:100%;">
            <i class="fas fa-tasks"></i> Gestionar Materias
        </a>
    </div>

</div>
