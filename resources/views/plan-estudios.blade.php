php<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Grados</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Base e Importación de Estilos */
        body {
            background-color: #f4f7f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .gestion-grados { padding: 2rem 0 3rem; max-width: 1200px; margin: 0 auto; }

        /* ===== TU CSS ORIGINAL ===== */
        .stats-header { display: flex; gap: 1.25rem; flex-wrap: wrap; margin-bottom: 2rem; }
        .stat-card {
            display: flex; align-items: center; gap: 1rem; background: white; border-radius: 14px;
            padding: 1.25rem 1.75rem; box-shadow: 0 4px 16px rgba(0,0,0,0.07); flex: 1;
            min-width: 140px; transition: transform 0.2s ease; border-top: 3px solid transparent;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card:nth-child(1) { border-top-color: #00508f; }
        .stat-card:nth-child(2) { border-top-color: #10b981; }
        .stat-card:nth-child(3) { border-top-color: #4ec7d2; }
        .stat-card:nth-child(4) { border-top-color: #6366f1; }
        .stat-card:nth-child(5) { border-top-color: #003b73; }

        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px; display: flex; 
            align-items: center; justify-content: center; font-size: 1.25rem; color: white; flex-shrink: 0;
        }
        .total-icon { background: linear-gradient(135deg, #00508f, #003b73); }
        .activo-icon { background: linear-gradient(135deg, #10b981, #059669); }
        .primaria-icon { background: linear-gradient(135deg, #4ec7d2, #00508f); }
        .basica-icon { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .secundaria-icon { background: linear-gradient(135deg, #00508f, #003b73); }

        .stat-num { display: block; font-size: 1.75rem; font-weight: 700; color: #003b73; line-height: 1; }
        .stat-lbl { font-size: 0.813rem; color: #64748b; font-weight: 500; }

        .filtros-card { background: white; border-radius: 14px; padding: 1.5rem 2rem; box-shadow: 0 4px 16px rgba(0,0,0,0.07); margin-bottom: 1.75rem; }
        .filtros-row { display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; }
        .search-wrap, .select-wrap { position: relative; flex: 1; min-width: 160px; }
        .search-icon, .select-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #00508f; pointer-events: none; }
        .search-input, .filter-select { width: 100%; padding: 0.6rem 1rem 0.6rem 2.75rem; border: 2px solid #bfd9ea; border-radius: 10px; background: #f8fafc; }

        .tabs-row { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 2rem; }
        .tab-btn { padding: 0.6rem 1.5rem; border: 2px solid #e2e8f0; border-radius: 10px; background: white; color: #64748b; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease; }
        .tab-btn.active { background: linear-gradient(135deg, #4ec7d2, #00508f); border-color: transparent; color: white; }

        .grados-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.75rem; }
        .grado-card { background: white; border-radius: 18px; border: 2px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; transition: all 0.3s ease; }
        .grado-card:hover { transform: translateY(-6px); box-shadow: 0 12px 36px rgba(0,0,0,0.12); }

        .gcard-header { padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; border-bottom: 3px solid #e2e8f0; }
        .gcard-numero { width: 64px; height: 64px; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; flex-shrink: 0; }
        .primaria-numero { background: linear-gradient(135deg, #4ec7d2, #00508f); }
        .basica-numero { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .secundaria-numero { background: linear-gradient(135deg, #00508f, #003b73); }

        .nivel-badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .active-dot { background: rgba(16,185,129,0.1); color: #059669; }
        .gcard-actions { padding: 1rem 1.5rem; border-top: 1px solid #f1f5f9; display: flex; gap: 0.625rem; background: #fafbfd; }
        .action-btn { flex: 1; padding: 0.5rem; border-radius: 9px; font-size: 0.84rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; border: 2px solid transparent; }

        /* Estilos específicos de nivel */
        .primaria-card:hover { border-color: #4ec7d2; }
        .basica-card:hover { border-color: #6366f1; }
        .secundaria-card:hover { border-color: #00508f; }

        @media (max-width: 768px) {
            .filtros-row { flex-direction: column; }
            .grados-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #00508f; font-weight: 700;">Gestión Escolar</h2>
        <a href="{{ route('grados.create') }}" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
            <i class="fas fa-plus"></i>
            Nuevo Grado
        </a>
    </div>

    <div class="gestion-grados">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border-left: 4px solid #10b981;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="stats-header">
            <div class="stat-card">
                <div class="stat-icon total-icon"><i class="fas fa-school"></i></div>
                <div class="stat-info">
                    <span class="stat-num">{{ $grados->total() }}</span>
                    <span class="stat-lbl">Total Grados</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon activo-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <span class="stat-num">{{ $grados->where('activo', true)->count() }}</span>
                    <span class="stat-lbl">Activos</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon primaria-icon"><i class="fas fa-child"></i></div>
                <div class="stat-info">
                    <span class="stat-num">{{ $grados->where('nivel', 'primaria')->count() }}</span>
                    <span class="stat-lbl">Primaria</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon basica-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="stat-info">
                    <span class="stat-num">{{ $grados->where('nivel', 'basica')->count() }}</span>
                    <span class="stat-lbl">Básica</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon secundaria-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-info">
                    <span class="stat-num">{{ $grados->where('nivel', 'secundaria')->count() }}</span>
                    <span class="stat-lbl">Secundaria</span>
                </div>
            </div>
        </div>

        <div class="filtros-card">
            <div class="filtros-row">
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar grado...">
                </div>
                <div class="select-wrap">
                    <i class="fas fa-filter select-icon"></i>
                    <select id="filterNivel" class="filter-select">
                        <option value="">Todos los niveles</option>
                        <option value="primaria">Primaria</option>
                        <option value="basica">Básica</option>
                        <option value="secundaria">Secundaria</option>
                    </select>
                </div>
                <div class="select-wrap">
                    <i class="fas fa-list select-icon"></i>
                    <select id="perPageSelect" class="filter-select" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                        <option value="15" {{ request('per_page') == 15 || !request('per_page') ? 'selected' : '' }}>15 por página</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 por página</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="tabs-row">
            <button class="tab-btn active" data-nivel=""><i class="fas fa-th-large"></i> Todos</button>
            <button class="tab-btn primaria-tab" data-nivel="primaria"><i class="fas fa-child"></i> Primaria</button>
            <button class="tab-btn basica-tab" data-nivel="basica"><i class="fas fa-graduation-cap"></i> Básica</button>
            <button class="tab-btn secundaria-tab" data-nivel="secundaria"><i class="fas fa-user-graduate"></i> Secundaria</button>
        </div>

        <div class="grados-grid" id="gradosContainer">
            @forelse($grados as $grado)
                <div class="grado-card {{ strtolower($grado->nivel) }}-card" data-nivel="{{ strtolower($grado->nivel) }}" data-search="{{ strtolower($grado->numero . ' ' . $grado->seccion . ' ' . $grado->nivel . ' ' . $grado->anio_lectivo) }}">
                    <div class="gcard-header">
                        <div class="gcard-numero {{ strtolower($grado->nivel) }}-numero">
                            <span class="num">{{ $grado->numero }}°</span>
                            @if($grado->seccion) <span class="sec">{{ $grado->seccion }}</span> @endif
                        </div>
                        <div class="gcard-meta">
                            <h3 class="gcard-title">{{ $grado->numero }}° Grado @if($grado->seccion) · {{ $grado->seccion }} @endif</h3>
                            <span class="nivel-badge {{ strtolower($grado->nivel) }}-badge">
                                {{ ucfirst($grado->nivel) }}
                            </span>
                        </div>
                        <div class="gcard-status">
                            <span class="status-dot {{ $grado->activo ? 'active-dot' : 'inactive-dot' }}">
                                <i class="fas fa-circle"></i> {{ $grado->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>

                    <div class="gcard-body">
                        <div class="info-row">
                            <div class="info-item"><i class="fas fa-calendar-alt"></i> <span>{{ $grado->anio_lectivo }}</span></div>
                            <div class="info-item"><i class="fas fa-book"></i> <span>{{ $grado->materias->count() }} Materias</span></div>
                        </div>
                    </div>

                    <div class="gcard-actions">
                        <a href="{{ route('grados.show', $grado) }}" class="action-btn view-btn"><i class="fas fa-eye"></i> Ver</a>
                        <a href="{{ route('grados.edit', $grado) }}" class="action-btn edit-btn"><i class="fas fa-edit"></i> Editar</a>
                    </div>
                </div>
            @empty
                <div class="empty-state">No hay registros.</div>
            @endforelse
        </div>

        @if($grados->hasPages())
        <div class="pagination-wrap mt-4">
            {{ $grados->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const filterNivel = document.getElementById('filterNivel');
    const tabBtns = document.querySelectorAll('.tab-btn');
    const cards = document.querySelectorAll('.grado-card');
    const noResults = document.getElementById('noResultsState');

    let activeNivel = '';

    function applyFilter() {
        const term = searchInput.value.toLowerCase().trim();
        const nivel = activeNivel;
        let visible = 0;

        cards.forEach(card => {
            const text = card.dataset.search || card.textContent.toLowerCase();
            const cardNivel = card.dataset.nivel;
            const matchesSearch = !term || text.includes(term);
            const matchesNivel = !nivel || cardNivel === nivel;

            if (matchesSearch && matchesNivel) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });
        if(noResults) noResults.style.display = (visible === 0) ? 'block' : 'none';
    }

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeNivel = this.dataset.nivel;
            filterNivel.value = activeNivel;
            applyFilter();
        });
    });

    filterNivel.addEventListener('change', function () {
        activeNivel = this.value;
        tabBtns.forEach(btn => btn.classList.toggle('active', btn.dataset.nivel === activeNivel));
        applyFilter();
    });

    searchInput.addEventListener('input', applyFilter);
});

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>

</body>
</html>