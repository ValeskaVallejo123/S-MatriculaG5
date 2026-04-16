@extends('layouts.app')

@section('title', 'Usuarios Confirmados')
@section('page-title', 'Usuarios Confirmados')
@section('content-class', 'p-0')

@push('styles')
<style>
.usc-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}
.usc-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.usc-hero-left { display: flex; align-items: center; gap: 1rem; }
.usc-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.usc-hero-icon i { font-size: 1.3rem; color: white; }
.usc-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.usc-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.usc-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.usc-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.usc-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.usc-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

.usc-table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
}
.usc-tbl thead th {
    background: #003b73; color: white; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem; border: none;
}
.usc-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.usc-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.usc-tbl tbody td { padding: .75rem 1rem; vertical-align: middle; font-size: .85rem; color: #334155; }
.usc-tbl tbody tr:last-child { border-bottom: none; }

.rol-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
}

body.dark-mode .usc-wrap  { background: #0f172a; }
body.dark-mode .usc-table-card { background: #1e293b; }
body.dark-mode .usc-tbl tbody td { color: #cbd5e1; }
body.dark-mode .usc-tbl tbody tr { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="usc-wrap">

    <div class="usc-hero">
        <div class="usc-hero-left">
            <div class="usc-hero-icon"><i class="fas fa-user-check"></i></div>
            <div>
                <h2 class="usc-hero-title">Usuarios Confirmados</h2>
                <p class="usc-hero-sub">Cuentas activas y verificadas en el sistema</p>
            </div>
        </div>
        <div class="usc-stat">
            <div class="usc-stat-num">{{ $usuarios->count() }}</div>
            <div class="usc-stat-lbl">Total</div>
        </div>
    </div>

    <div class="usc-body">
        <div class="usc-table-card">
            @if($usuarios->count() == 0)
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-user-check fa-2x" style="display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                    <p style="font-size:.9rem;font-weight:600;color:#003b73;margin:0;">No hay usuarios confirmados.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table usc-tbl mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $u)
                            <tr>
                                <td style="font-weight:700;color:#003b73;">{{ $u->name }}</td>
                                <td style="color:#64748b;">{{ $u->email }}</td>
                                <td>
                                    @php
                                        $coloresRol = [
                                            'Super Administrador' => 'background:#1e293b;color:white;',
                                            'Administrador'       => 'background:#475569;color:white;',
                                            'Profesor'            => 'background:rgba(78,199,210,.15);color:#00508f;border:1.5px solid #b2e8ed;',
                                            'Estudiante'          => 'background:rgba(0,80,143,.1);color:#00508f;border:1.5px solid #bfd9ea;',
                                            'Padre'               => 'background:#f0fdf4;color:#166534;border:1.5px solid #86efac;',
                                        ];
                                        $nombre = $u->rol->nombre ?? 'Sin rol';
                                        $estilo = $coloresRol[$nombre] ?? 'background:#f1f5f9;color:#475569;';
                                    @endphp
                                    <span class="rol-badge" style="{{ $estilo }}">{{ $nombre }}</span>
                                </td>
                                <td style="color:#64748b;font-size:.82rem;">{{ $u->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
