@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
<div style="display:flex;gap:.5rem;flex-wrap:wrap;">
    <a href="{{ url()->previous() }}"
       style="background:white;color:#00508f;padding:.5rem .85rem;border-radius:7px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.4rem;border:1.5px solid #00508f;font-size:0.8rem;transition:all .2s;">
        <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Volver
    </a>
    <a href="{{ route('estudiantes.create') }}"
       style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);color:white;padding:.5rem .85rem;border-radius:7px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.4rem;border:none;box-shadow:0 2px 8px rgba(78,199,210,0.3);font-size:0.8rem;">
        <i class="fas fa-plus" style="font-size:.75rem;"></i> Nuevo Estudiante
    </a>
</div>
@endsection

@push('styles')
<style>
:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --teal:       #4ec7d2;
    --teal-light: rgba(78,199,210,0.10);
    --border:     #e8edf4;
    --surface:    #f5f8fc;
    --text-main:  #0d2137;
    --text-muted: #6b7a90;
    --green:      #10b981;
    --amber:      #f59e0b;
    --red:        #ef4444;
    --purple:     #8b5cf6;
    --radius-lg:  12px;
    --radius-sm:  6px;
    --shadow-sm:  0 1px 3px rgba(0,59,115,0.07);
    --shadow-md:  0 4px 14px rgba(0,59,115,0.10);
}

/* Stats */
.est-stats {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: .75rem;
    margin-bottom: 1.1rem;
}
@media(max-width:900px){ .est-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:540px){ .est-stats { grid-template-columns: 1fr 1fr; gap:.6rem; } }

.est-stat {
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    padding: .85rem 1rem;
    display: flex; align-items: center; gap: .75rem;
    box-shadow: var(--shadow-sm);
    transition: transform .2s, box-shadow .2s;
    position: relative; overflow: hidden;
}
.est-stat::before {
    content: ''; position: absolute;
    top: 0; left: 0; width: 3px; height: 100%;
}
.est-stat-total::before   { background: var(--green); }
.est-stat-active::before  { background: var(--teal); }
.est-stat-inactive::before{ background: var(--amber); }
.est-stat-new::before     { background: var(--purple); }
.est-stat:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); }

.est-stat-icon {
    width: 38px; height: 38px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1rem;
}
.est-stat-total   .est-stat-icon { background: rgba(16,185,129,.10);  color: var(--green); }
.est-stat-active  .est-stat-icon { background: var(--teal-light);     color: var(--teal); }
.est-stat-inactive .est-stat-icon{ background: rgba(245,158,11,.10);  color: var(--amber); }
.est-stat-new     .est-stat-icon { background: rgba(139,92,246,.10);  color: var(--purple); }

.est-stat-lbl { font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:var(--text-muted); margin-bottom:.1rem; }
.est-stat-num { font-size:1.55rem; font-weight:800; color:var(--blue-dark); line-height:1; }
.est-stat-sub { font-size:.68rem; color:var(--text-muted); }

/* Toolbar */
.est-toolbar {
    background: white; border: 1px solid var(--border);
    border-radius: var(--radius-lg); padding: .7rem 1rem;
    margin-bottom: 1rem; display: flex; align-items: center;
    gap: .75rem; flex-wrap: wrap; box-shadow: var(--shadow-sm);
}
.est-search-wrap { position: relative; flex: 1; min-width: 200px; }
.est-search-wrap > .search-icon {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted); font-size: .78rem; pointer-events: none;
}
.search-spinner {
    position: absolute; right: 9px; top: 50%;
    transform: translateY(-50%);
    width: 12px; height: 12px;
    border: 2px solid var(--border); border-top-color: var(--teal);
    border-radius: 50%; display: none;
    animation: spin .6s linear infinite;
}
@keyframes spin { to { transform: translateY(-50%) rotate(360deg); } }

.est-search {
    width: 100%; padding: .42rem 1.8rem .42rem 2.1rem;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: .82rem; background: var(--surface); outline: none;
    transition: border-color .2s; font-family: inherit; color: var(--text-main);
}
.est-search:focus { border-color: var(--teal); background: white; }
.est-search.s-loading { border-color: var(--amber); }
.est-search.s-found   { border-color: var(--teal); }
.est-search.s-empty   { border-color: var(--red); }

.est-badge-info { display:flex; align-items:center; gap:.9rem; flex-shrink:0; }
.est-badge-info span { display:flex; align-items:center; gap:.3rem; font-size:.78rem; }

.est-perpage { display:flex; align-items:center; gap:.35rem; font-size:.78rem; color:var(--text-muted); flex-shrink:0; }
.est-perpage select {
    padding: .28rem .5rem;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: .78rem; color: var(--text-main);
    background: var(--surface); outline: none; cursor: pointer;
}
.est-perpage select:focus { border-color: var(--teal); }

/* Tabla card */
.est-card {
    background: white; border: 1px solid var(--border);
    border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);
}
.est-card-head {
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
    padding: .7rem 1.1rem; display: flex; align-items: center; gap: .5rem;
}
.est-card-head i    { color: var(--teal); font-size: .88rem; }
.est-card-head span { color: white; font-weight: 700; font-size: .88rem; }

/* Tabla con ancho fijo */
.est-tbl { width: 100%; border-collapse: collapse; table-layout: fixed; }

.est-tbl thead th {
    background: var(--surface); padding: .5rem .8rem;
    font-size: .63rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--text-muted);
    border-bottom: 1.5px solid var(--border);
    overflow: hidden; white-space: nowrap;
}
.est-tbl thead th.tc { text-align: center; }

.est-tbl tbody td {
    padding: .5rem .8rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: .8rem; color: var(--text-main);
    vertical-align: middle; overflow: hidden;
}
.est-tbl tbody td.tc { text-align: center; }
.est-tbl tbody tr:last-child td { border-bottom: none; }
.est-tbl tbody tr { transition: background .12s; }
.est-tbl tbody tr:hover { background: #f7fbff; }

/* Número fila */
.row-num {
    width: 22px; height: 22px; border-radius: 5px;
    background: var(--surface); border: 1px solid var(--border);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .65rem; font-weight: 700; color: var(--text-muted);
}

/* Avatar */
.est-av {
    width: 30px; height: 30px; border-radius: 7px; background: #dde8f5;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
    flex-shrink: 0;
}
.est-av img { width: 100%; height: 100%; object-fit: cover; }
.av-txt { font-size: .68rem; font-weight: 700; color: var(--blue-mid); }

.est-name  {
    font-weight: 600; color: var(--blue-dark); font-size: .82rem;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.est-email {
    font-size: .68rem; color: var(--text-muted); margin-top: 1px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

/* DNI */
.est-dni {
    font-family: 'Courier New', monospace;
    font-size: .75rem; color: var(--blue-mid); font-weight: 600;
    background: rgba(0,80,143,.06); padding: .15rem .4rem;
    border-radius: 4px; white-space: nowrap;
    display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis;
}

/* Chips */
.chip {
    display: inline-flex; align-items: center;
    padding: .15rem .55rem; border-radius: 999px;
    font-size: .67rem; font-weight: 600; white-space: nowrap;
}
.chip-teal { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.3); }
.chip-blue { background: rgba(0,80,143,.07); color: var(--blue-dark); border: 1px solid rgba(0,80,143,.18); }

/* Estado */
.badge-estado {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .18rem .55rem; border-radius: 999px; font-size: .67rem; font-weight: 700;
}
.badge-activo   { background: rgba(78,199,210,.13); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
.badge-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
.dot-teal { background: var(--teal); }
.dot-red  { background: var(--red); }

/* Botones acción — más pequeños */
.act-btn {
    width: 26px; height: 26px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 6px; text-decoration: none;
    transition: all .15s; font-size: .72rem;
    background: white; cursor: pointer; border: none;
    flex-shrink: 0;
}
.act-historial { background: #f1f5f9 !important; color: #00508f !important; border: 1px solid #dde6f0 !important; }
.act-historial:hover { background: #00508f !important; color: white !important; }
.act-view { border: 1px solid #b0d0ea !important; color: var(--blue-mid); }
.act-edit { border: 1px solid #9de0e6 !important; color: var(--teal); }
.act-del  { border: 1px solid #fca5a5 !important; color: var(--red); }
.act-view:hover { background: var(--blue-mid) !important; color: white !important; }
.act-edit:hover { background: var(--teal) !important;     color: white !important; }
.act-del:hover  { background: var(--red) !important;      color: white !important; }

/* Grupo acciones */
.act-group { display: inline-flex; gap: 3px; align-items: center; }

/* Empty */
.est-empty { padding: 3rem 1rem; text-align: center; }
.est-empty i  { font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
.est-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .3rem; font-size: .9rem; }
.est-empty p  { font-size: .8rem; color: var(--text-muted); margin-bottom: 1rem; }
.btn-create-empty {
    display: inline-flex; align-items: center; gap: .4rem; padding: .45rem 1rem;
    background: linear-gradient(135deg,#4ec7d2,#00508f); color: white;
    border-radius: 7px; text-decoration: none; font-weight: 600; font-size: .8rem;
}

/* Footer */
.est-footer {
    padding: .65rem 1rem; border-top: 1px solid var(--border);
    background: var(--surface);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .4rem;
}
.est-footer-info { font-size: .73rem; color: var(--text-muted); }

/* Paginación */
.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 6px; margin: 0 1px;
    border: 1px solid var(--border); color: var(--blue-mid);
    padding: .22rem .55rem; font-size: .75rem; transition: all .15s;
}
.pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--teal), var(--blue-mid));
    border-color: var(--teal); color: white;
}
.pagination .page-item.disabled .page-link { opacity: .4; }

/* Responsive */
@media(max-width:768px) {
    .est-toolbar { flex-direction: column; align-items: stretch; gap: .6rem; }
    .est-search-wrap { min-width: unset; }
    .est-badge-info { justify-content: center; flex-wrap: wrap; }
    .est-perpage { justify-content: center; }
    .est-tbl thead th:nth-child(2), .est-tbl tbody td:nth-child(2),
    .est-tbl thead th:nth-child(6), .est-tbl tbody td:nth-child(6) { display: none; }
    .est-footer { flex-direction: column; align-items: center; gap: .5rem; }
}
@media(max-width:480px) {
    .est-stats { grid-template-columns: repeat(2,1fr); gap: .5rem; }
    .est-stat  { padding: .7rem .8rem; }
    .est-stat-num { font-size: 1.3rem; }
    .est-tbl thead th:nth-child(4), .est-tbl tbody td:nth-child(4) { display: none; }
    .est-email { display: none; }
    .act-btn { width: 22px; height: 22px; font-size: .65rem; }
}
</style>
@endpush

@section('content')
<div>

    {{-- Stats --}}
    <div class="est-stats">
        <div class="est-stat est-stat-total">
            <div class="est-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="est-stat-lbl">Total</div>
                <div class="est-stat-num" id="statTotal">{{ $estudiantes->total() }}</div>
                <div class="est-stat-sub">Estudiantes</div>
            </div>
        </div>
        <div class="est-stat est-stat-active">
            <div class="est-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="est-stat-lbl">Activos</div>
                <div class="est-stat-num">{{ $estudiantes->getCollection()->where('estado','activo')->count() }}</div>
                <div class="est-stat-sub">En el sistema</div>
            </div>
        </div>
        <div class="est-stat est-stat-inactive">
            <div class="est-stat-icon"><i class="fas fa-user-slash"></i></div>
            <div>
                <div class="est-stat-lbl">Inactivos</div>
                <div class="est-stat-num">{{ $estudiantes->getCollection()->where('estado','inactivo')->count() }}</div>
                <div class="est-stat-sub">Suspendidos</div>
            </div>
        </div>
        <div class="est-stat est-stat-new">
            <div class="est-stat-icon"><i class="fas fa-user-plus"></i></div>
            <div>
                <div class="est-stat-lbl">Nuevos Hoy</div>
                <div class="est-stat-num">{{ $estudiantes->getCollection()->filter(fn($e) => $e->created_at && $e->created_at->isToday())->count() }}</div>
                <div class="est-stat-sub">Registrados</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="est-toolbar">
        <div class="est-search-wrap">
            <i class="fas fa-search search-icon"></i>
            <input type="text"
                   id="searchInput"
                   class="est-search"
                   placeholder="Buscar por nombre, DNI, grado..."
                   value="{{ request('buscar') }}"
                   autocomplete="off">
            <div class="search-spinner" id="searchSpinner"></div>
        </div>
        <div class="est-badge-info">
            <span>
                <i class="fas fa-users" style="color:var(--blue-mid);font-size:.75rem;"></i>
                <strong id="totalBadge" style="color:var(--blue-mid);">{{ $estudiantes->total() }}</strong>
                <span style="color:var(--text-muted);">Total</span>
            </span>
            <span>
                <i class="fas fa-check-circle" style="color:var(--teal);font-size:.75rem;"></i>
                <strong style="color:var(--teal);">{{ $estudiantes->getCollection()->where('estado','activo')->count() }}</strong>
                <span style="color:var(--text-muted);">Activos</span>
            </span>
        </div>
        <div class="est-perpage">
            <span>Mostrar:</span>
            <select id="perPageSelect">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="est-card">
        <div class="est-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Lista de Estudiantes</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="est-tbl" id="studentsTable">
                <thead>
                    <tr>
                        <th class="tc" style="width:38px;">#</th>
                        <th style="width:44px;">Foto</th>
                        <th>Nombre</th>
                        <th style="width:120px;">DNI</th>
                        <th class="tc" style="width:115px;">Grado</th>
                        <th class="tc" style="width:70px;">Secc.</th>
                        <th class="tc" style="width:90px;">Estado</th>
                        <th class="tc" style="width:130px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="estudiantesBody">
                    @include('estudiantes.partials.tabla')
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="est-footer" id="estFooter">
            <span class="est-footer-info" id="estFooterInfo">
                Mostrando {{ $estudiantes->firstItem() }}–{{ $estudiantes->lastItem() }}
                de {{ $estudiantes->total() }} estudiantes
            </span>
            <div id="estPagination">
                @include('estudiantes.partials.paginacion')
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input         = document.getElementById('searchInput');
    const tbody         = document.getElementById('estudiantesBody');
    const footer        = document.getElementById('estFooter');
    const infoSpan      = document.getElementById('estFooterInfo');
    const pagDiv        = document.getElementById('estPagination');
    const totalBadge    = document.getElementById('totalBadge');
    const statTotal     = document.getElementById('statTotal');
    const spinner       = document.getElementById('searchSpinner');
    const perPageSelect = document.getElementById('perPageSelect');
    let   timer         = null;

    document.addEventListener('click', function (e) {
        const link = e.target.closest('#estPagination a');
        if (!link) return;
        e.preventDefault();
        const url = new URL(link.href);
        const q   = input.value.trim();
        if (q) url.searchParams.set('buscar', q);
        url.searchParams.set('per_page', perPageSelect.value);
        buscar(q, url.toString());
    });

    input.addEventListener('input', function () {
        clearTimeout(timer);
        setEstado('loading');
        timer = setTimeout(() => buscar(this.value.trim()), 350);
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { this.value = ''; buscar(''); }
    });

    perPageSelect.addEventListener('change', function () {
        const q   = input.value.trim();
        const url = buildUrl(q);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        buscar(q, url.toString());
    });

    function buildUrl(q) {
        const url = new URL(window.location.href);
        if (q) { url.searchParams.set('buscar', q); }
        else   { url.searchParams.delete('buscar'); }
        url.searchParams.set('per_page', perPageSelect.value);
        url.searchParams.delete('page');
        return url;
    }

    function setEstado(estado) {
        input.classList.remove('s-loading','s-found','s-empty');
        spinner.style.display = 'none';
        if (estado === 'loading') { input.classList.add('s-loading'); spinner.style.display = 'block'; }
        else if (estado === 'found') input.classList.add('s-found');
        else if (estado === 'empty') input.classList.add('s-empty');
    }

    function buscar(q, urlOverride) {
        const url = urlOverride ? new URL(urlOverride) : buildUrl(q);
        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            tbody.innerHTML  = data.html;
            pagDiv.innerHTML = data.pagination;

            infoSpan.textContent = data.total === 0
                ? (q ? `Sin resultados para "${q}"` : 'No hay estudiantes registrados')
                : (q ? `${data.desde}–${data.hasta} de ${data.total} resultado(s) para "${q}"`
                     : `Mostrando ${data.desde}–${data.hasta} de ${data.total} estudiantes`);

            if (totalBadge) totalBadge.textContent = data.total;
            if (statTotal)  statTotal.textContent  = data.total;

            setEstado(!q ? '' : data.total > 0 ? 'found' : 'empty');
            footer.style.display = data.total > 0 ? 'flex' : 'none';
            history.replaceState(null, '', buildUrl(q).toString());
        })
        .catch(() => setEstado('empty'));
    }

    if (input.value) setEstado('found');
});
</script>
@endpush