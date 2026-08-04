@extends('layouts.app')

@section('title', 'Permisos de Padres')
@section('page-title', 'Gestión de Permisos de Padres')

@push('styles')
<style>
    :root {
        --blue-dark:   #003b73;
        --blue-mid:    #00508f;
        --teal:        #4ec7d2;
        --teal-light:  rgba(78,199,210,0.12);
        --border:      #e8edf4;
        --surface:     #f5f8fc;
        --text-main:   #0d2137;
        --text-muted:  #6b7a90;
        --green:       #10b981;
        --red:         #ef4444;
        --purple:      #8b5cf6;
        --radius-lg:   14px;
        --radius-sm:   7px;
        --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .perm-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .perm-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .perm-stats { grid-template-columns: 1fr; } }

    .perm-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .perm-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .perm-stat-total::before  { background: var(--teal); }
    .perm-stat-active::before { background: var(--green); }
    .perm-stat-hijos::before  { background: #f59e0b; }
    .perm-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .perm-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .perm-stat-total  .perm-stat-icon { background: var(--teal-light);      color: var(--teal); }
    .perm-stat-active .perm-stat-icon { background: rgba(16,185,129,.12);    color: var(--green); }
    .perm-stat-hijos  .perm-stat-icon { background: rgba(245,158,11,.12);    color: #f59e0b; }

    .perm-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .perm-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .perm-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .perm-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .perm-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .perm-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .perm-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s;
        font-family: inherit; color: var(--text-main);
    }
    .perm-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .perm-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .perm-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

    /* ── Card tabla ── */
    .perm-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .perm-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .perm-card-head i    { color: var(--teal); font-size: 1rem; }
    .perm-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Tabla sin scroll ── */
    .perm-tbl { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .perm-tbl thead th {
        background: var(--surface); padding: .65rem .85rem;
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .perm-tbl thead th.tc { text-align: center; }
    .perm-tbl thead th.tr { text-align: right; }
    .perm-tbl tbody td {
        padding: .7rem .85rem; border-bottom: 1px solid #f1f5f9;
        font-size: .83rem; color: var(--text-main); vertical-align: middle;
        overflow: hidden; text-overflow: ellipsis;
    }
    .perm-tbl tbody td.tc { text-align: center; }
    .perm-tbl tbody td.tr { text-align: right; }
    .perm-tbl tbody tr:last-child td { border-bottom: none; }
    .perm-tbl tbody tr { transition: background .15s; }
    .perm-tbl tbody tr:hover { background: #f7fbff; }
    .perm-tbl tbody tr.hidden { display: none; }

    /* ── Número de fila ── */
    .row-num {
        width: 24px; height: 24px; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: var(--text-muted);
    }

    /* ── Avatar ── */
    .perm-av {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: inline-flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: .85rem;
        border: 2px solid rgba(78,199,210,.3);
    }
    .perm-name { font-weight: 600; color: var(--blue-dark); font-size: .84rem;
                 white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .perm-sub  { font-size: .71rem; color: var(--text-muted); margin-top: .1rem;
                 white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* ── Badges ── */
    .bpill {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600; white-space: nowrap;
    }
    .b-teal     { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .badge-activo   { background: rgba(78,199,210,.15); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.4); }
    .badge-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .dot-teal { background: var(--teal); }
    .dot-red  { background: var(--red); }

    /* ── Botón configurar ── */
    .act-btn {
        width: 28px; height: 28px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .72rem;
        background: white; cursor: pointer;
        transition: all .15s; text-decoration: none; padding: 0;
    }
    .act-config { border-color: var(--purple); color: var(--purple); }
    .act-config:hover { background: var(--purple); color: white; transform: translateY(-1px); }

    /* ── Empty ── */
    .perm-empty { padding: 4rem 1rem; text-align: center; }
    .perm-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .perm-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .perm-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    /* ── Footer paginación ── */
    .perm-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .5rem;
    }
    .perm-footer-info { font-size: .78rem; color: var(--text-muted); }

    .pagination { margin: 0; }
    .pagination .page-link {
        border-radius: 7px; margin: 0 2px; border: 1.5px solid var(--border);
        color: var(--blue-mid); padding: .28rem .6rem; font-size: .82rem; transition: all .15s;
    }
    .pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); color: var(--blue-dark); }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        border-color: var(--teal); color: white;
        box-shadow: 0 2px 6px rgba(78,199,210,.35);
    }

    .no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }

    @media(max-width:768px) {
        .perm-toolbar { flex-direction: column; align-items: stretch; gap: .75rem; }
        .perm-footer  { flex-direction: column; align-items: center; gap: .75rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="perm-stats">
        <div class="perm-stat perm-stat-total">
            <div class="perm-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="perm-stat-lbl">Total Padres</div>
                <div class="perm-stat-num">{{ $padres->total() }}</div>
                <div class="perm-stat-sub">Registrados</div>
            </div>
        </div>
        <div class="perm-stat perm-stat-active">
            <div class="perm-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="perm-stat-lbl">Activos</div>
                <div class="perm-stat-num">{{ $padres->getCollection()->where('estado', 1)->count() }}</div>
                <div class="perm-stat-sub">Con acceso</div>
            </div>
        </div>
        <div class="perm-stat perm-stat-hijos">
            <div class="perm-stat-icon"><i class="fas fa-child"></i></div>
            <div>
                <div class="perm-stat-lbl">Con Hijos</div>
                <div class="perm-stat-num">{{ $padres->getCollection()->filter(fn($p) => $p->estudiantes->count() > 0)->count() }}</div>
                <div class="perm-stat-sub">Hijos vinculados</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="perm-toolbar">
        <div class="perm-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="perm-search"
                   placeholder="Buscar por nombre, DNI o correo...">
        </div>
        <div class="perm-badge-info">
            <span>
                <i class="fas fa-users" style="color:var(--blue-mid);"></i>
                <strong id="visibleCount" style="color:var(--blue-mid);">{{ $padres->total() }}</strong>
                <span style="color:var(--text-muted);">Total</span>
            </span>
            <span>
                <i class="fas fa-check-circle" style="color:var(--green);"></i>
                <strong style="color:var(--green);">{{ $padres->getCollection()->where('estado', 1)->count() }}</strong>
                <span style="color:var(--text-muted);">Activos</span>
            </span>
        </div>
    </div>

    {{-- ── TABLA ── --}}
    <div class="perm-card">
        <div class="perm-card-head">
            <i class="fas fa-user-lock"></i>
            <span>Lista de Padres y Tutores</span>
        </div>

        <table class="perm-tbl" id="permisosTable">
            <thead>
                <tr>
                    <th style="width:44px;" class="tc">#</th>
                    <th style="width:46px;"></th>
                    <th>Padre / Tutor</th>
                    <th style="width:130px;">DNI</th>
                    <th class="tc" style="width:110px;">Parentesco</th>
                    <th class="tc" style="width:90px;">Hijos</th>
                    <th class="tc" style="width:95px;">Estado</th>
                    <th class="tr" style="width:60px;">Permisos</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($padres as $i => $padre)
                <tr class="padre-row"
                    data-search="{{ strtolower(($padre->nombre ?? '') . ' ' . ($padre->apellido ?? '') . ' ' . ($padre->dni ?? '') . ' ' . ($padre->correo ?? '')) }}">

                    {{-- # --}}
                    <td class="tc">
                        <span class="row-num">{{ $padres->firstItem() + $i }}</span>
                    </td>

                    {{-- Avatar --}}
                    <td>
                        <div class="perm-av">
                            {{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($padre->apellido ?? 'A', 0, 1)) }}
                        </div>
                    </td>

                    {{-- Nombre + correo --}}
                    <td>
                        <div class="perm-name">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                        @if($padre->correo)
                            <div class="perm-sub">
                                <i class="fas fa-envelope" style="font-size:.63rem;"></i> {{ $padre->correo }}
                            </div>
                        @endif
                    </td>

                    {{-- DNI --}}
                    <td>
                        <span style="font-family:'Courier New',monospace;font-size:.8rem;
                                     color:var(--blue-mid);font-weight:600;
                                     background:rgba(0,80,143,.06);padding:.18rem .45rem;
                                     border-radius:5px;">
                            {{ $padre->dni ?? 'N/A' }}
                        </span>
                    </td>

                    {{-- Parentesco --}}
                    <td class="tc">
                        <span class="bpill b-teal">{{ $padre->parentesco_formateado }}</span>
                    </td>

                    {{-- Hijos --}}
                    <td class="tc">
                        <span class="bpill b-teal">
                            <i class="fas fa-child" style="font-size:.68rem;"></i>
                            {{ $padre->estudiantes->count() }}
                            {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                        </span>
                    </td>

                    {{-- Estado --}}
                    <td class="tc">
                        @if($padre->estado)
                            <span class="bpill badge-activo">
                                <span class="dot dot-teal"></span> Activo
                            </span>
                        @else
                            <span class="bpill badge-inactivo">
                                <span class="dot dot-red"></span> Inactivo
                            </span>
                        @endif
                    </td>

                    {{-- Acción: solo configurar permisos --}}
                    <td class="tr">
                        <a href="{{ route('admin.permisos.configurar', $padre->id) }}"
                           class="act-btn act-config" title="Configurar permisos">
                            <i class="fas fa-sliders-h"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="perm-empty">
                            <i class="fas fa-users"></i>
                            <h6>No hay padres registrados</h6>
                            <p>No se encontraron resultados</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($padres->hasPages())
            <div class="perm-footer">
                <span class="perm-footer-info">
                    Mostrando {{ $padres->firstItem() }}–{{ $padres->lastItem() }}
                    de {{ $padres->total() }} padres
                </span>
                {{ $padres->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input        = document.getElementById('searchInput');
    const tbody        = document.getElementById('tableBody');
    const visibleCount = document.getElementById('visibleCount');

    if (!input || !tbody) return;

    input.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();

        const noRow = tbody.querySelector('.no-results-row');
        if (noRow) noRow.remove();

        let visible = 0;

        tbody.querySelectorAll('.padre-row').forEach(function (row) {
            const texto = row.dataset.search || row.textContent.toLowerCase();
            const match = term === '' || texto.includes(term);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        if (visibleCount) visibleCount.textContent = visible;

        if (visible === 0 && term !== '') {
            const tr = document.createElement('tr');
            tr.className = 'no-results-row';
            tr.innerHTML = `<td colspan="8" style="text-align:center;padding:3rem 1rem;">
                <i class="fas fa-search" style="font-size:1.75rem;color:#cbd5e1;display:block;margin-bottom:.75rem;"></i>
                <p style="color:#94a3b8;margin:0;font-size:.85rem;">
                    Sin resultados para <strong style="color:#0d2137;">"${term}"</strong>
                </p>
            </td>`;
            tbody.appendChild(tr);
        }
    });
});
</script>
@endpush