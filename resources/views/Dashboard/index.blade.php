@extends('layouts.app')

@section('title', 'Permisos por Rol')
@section('page-title', 'Gestión de Permisos')

@section('content')
<div class="container-fluid px-4">

    <!-- Header descriptivo -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-start gap-3">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-shield-alt" style="font-size: 1.4rem; color: white;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1" style="color: #003b73;">Sistema de Permisos y Roles</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                        Este sistema utiliza un modelo de permisos basado en roles. Cada usuario tiene asignado un rol que determina sus capacidades dentro del sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Roles -->
    <div class="row g-4 mb-4">

        <!-- SUPER ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border: 2px solid #fca5a5 !important; overflow: hidden;">
                <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fas fa-user-shield" style="font-size: 1.4rem; color: #ef4444;"></i>
                            </div>
                            <div>
                                <h5 class="text-white fw-bold mb-0">Super Administrador</h5>
                                <small class="text-white" style="opacity: 0.85;">Acceso Total al Sistema</small>
                            </div>
                        </div>
                        <span class="badge bg-white text-danger fw-bold">MÁXIMO</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Capacidades -->
                    <div class="card border-0 mb-3" style="background: #f9fafb; border-radius: 10px;">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-3" style="color: #003b73;">
                                <i class="fas fa-bolt me-2 text-warning"></i>Capacidades Especiales
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Acceso completo a <strong>todas las funciones</strong> del sistema</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Puede <strong>crear, editar y eliminar administradores</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Asigna y modifica <strong>permisos de otros usuarios</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Acceso a <strong>configuración del sistema</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Gestiona <strong>periodos académicos y cupos</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-0">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Visualiza <strong>todas las estadísticas y reportes</strong></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Aviso -->
                    <div class="alert alert-danger border-0 mb-0" style="background: rgba(239,68,68,0.08); border-left: 4px solid #ef4444 !important; border-radius: 8px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-exclamation-triangle text-danger mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="fw-semibold text-danger mb-1" style="font-size: 0.85rem;">Importante</p>
                                <p class="text-danger mb-0" style="font-size: 0.8rem; opacity: 0.85;">Este rol debe ser asignado solo a usuarios de máxima confianza ya que tiene control total sobre el sistema.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border: 2px solid #93c5fd !important; overflow: hidden;">
                <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fas fa-user-cog" style="font-size: 1.4rem; color: #00508f;"></i>
                            </div>
                            <div>
                                <h5 class="text-white fw-bold mb-0">Administrador</h5>
                                <small class="text-white" style="opacity: 0.85;">Permisos Personalizables</small>
                            </div>
                        </div>
                        <span class="badge bg-white fw-bold" style="color: #00508f;">LIMITADO</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Permisos disponibles -->
                    <div class="card border-0 mb-3" style="background: #f9fafb; border-radius: 10px;">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1" style="color: #003b73;">
                                <i class="fas fa-clipboard-list me-2" style="color: #4ec7d2;"></i>Permisos Disponibles
                            </h6>
                            <p class="text-muted mb-3" style="font-size: 0.8rem;">El Super Admin puede asignar los siguientes permisos:</p>
                            <div class="d-flex flex-column gap-2">
                                @foreach($permisos as $key => $nombre)
                                <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: white; border: 1px solid #e2e8f0;">
                                    <i class="fas fa-check-circle text-success flex-shrink-0"></i>
                                    <span style="font-size: 0.875rem; color: #374151;">{{ $nombre }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Restricciones -->
                    <div class="alert alert-warning border-0 mb-0" style="background: rgba(245,158,11,0.08); border-left: 4px solid #f59e0b !important; border-radius: 8px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-info-circle text-warning mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="fw-semibold text-warning mb-1" style="font-size: 0.85rem;">Restricciones</p>
                                <ul class="mb-0 ps-3" style="font-size: 0.8rem; color: #92400e;">
                                    <li>No puede gestionar otros administradores</li>
                                    <li>No tiene acceso a configuración del sistema</li>
                                    <li>Solo puede realizar acciones según permisos asignados</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabla Comparativa -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%);">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-table me-2"></i>Tabla Comparativa de Permisos
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Módulo / Función</th>
                            <th class="text-center px-4 py-3">Super Admin</th>
                            <th class="text-center px-4 py-3">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dashboard -->
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Dashboard</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                        </tr>

                        <!-- Gestionar Administradores -->
                        <tr style="background: rgba(239,68,68,0.04);">
                            <td class="px-4 py-3 fw-semibold">Gestionar Administradores</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-times-circle text-danger fs-5"></i></td>
                        </tr>

                        @foreach($permisos as $key => $nombre)
                        <tr>
                            <td class="px-4 py-3 fw-semibold">{{ $nombre }}</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center">
                                <span class="badge" style="background: rgba(0,80,143,0.1); color: #00508f; font-size: 0.75rem;">Configurable</span>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Configuración del Sistema -->
                        <tr style="background: rgba(239,68,68,0.04);">
                            <td class="px-4 py-3 fw-semibold">Configuración del Sistema</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-times-circle text-danger fs-5"></i></td>
                        </tr>

                        <!-- Cambiar Contraseña -->
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Cambiar Contraseña (propia)</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botón volver -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('admins.index') }}" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
            <i class="fas fa-users me-2"></i>Gestionar Administradores
        </a>
    </div>

    {{-- ─── Tabs ─── --}}
    <div class="tab-bar">
        <button class="tab-btn active" data-tab="config">Configurar permisos</button>
        <button class="tab-btn" data-tab="resumen">Resumen de roles</button>
    </div>

    {{-- ════════════ TAB: CONFIGURAR ════════════ --}}
    <div class="tab-pane active" id="tab-config">

        @if(auth()->user()->rol === 'super_admin')

        {{-- Alertas --}}
        @if(session('success'))
        <div class="flash-ok">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="flash-err">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admins.asignar-permisos') }}" method="POST" id="formPermisos">
            @csrf
            @method('PUT')
            <input type="hidden" name="admin_id" id="inputAdminId" value="{{ old('admin_id') }}">

            <div class="rp-layout">

                {{-- ── Sidebar ── --}}
                <aside class="sidebar">
                    <div class="sidebar-title">Administradores</div>
                    <div class="search-wrap">
                        <input type="text" id="searchInput" placeholder="Buscar usuario..." autocomplete="off">
                    </div>
                    <div class="user-list" id="userList">
                        @foreach($admins as $admin)
                        @php
                            $palette  = ['#6366f1','#14b8a6','#f59e0b','#ec4899','#8b5cf6','#0ea5e9','#84cc16','#ef4444'];
                            $color    = $palette[$loop->index % count($palette)];
                            $initial  = strtoupper(mb_substr($admin->name, 0, 1));
                        @endphp
                        <div class="user-item {{ old('admin_id') == $admin->id ? 'active' : '' }}"
                             data-id="{{ $admin->id }}"
                             data-name="{{ $admin->name }}"
                             data-email="{{ $admin->email }}"
                             data-rol="{{ $admin->rol }}"
                             data-permisos="{{ json_encode($admin->permisos ?? []) }}"
                             data-color="{{ $color }}"
                             data-initial="{{ $initial }}">
                            <div class="u-avatar" style="background:{{ $color }}">{{ $initial }}</div>
                            <div class="u-info">
                                <strong>{{ $admin->name }}</strong>
                                <span>{{ $admin->email }}</span>
                            </div>
                            <span class="rbadge {{ $admin->rol === 'super_admin' ? 'sa' : 'ad' }}">
                                {{ $admin->rol === 'super_admin' ? 'SA' : 'Admin' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <div class="no-results" id="noResults">Sin resultados</div>
                </aside>

                {{-- ── Panel derecho ── --}}
                <div class="main-panel">

                    {{-- Estado vacío --}}
                    <div class="state-empty" id="stateEmpty">
                        <div class="icon-wrap">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3>Selecciona un administrador</h3>
                        <p>Elige un usuario de la lista para<br>configurar su rol y permisos de acceso.</p>
                    </div>

                    {{-- Panel activo --}}
                    <div id="stateActive" class="{{ old('admin_id') ? '' : 'hidden' }}">

                        {{-- Header --}}
                        <div class="panel-head">
                            <div class="panel-user-info">
                                <div class="u-avatar" id="pAvatar" style="background:#6366f1;width:40px;height:40px;font-size:.85rem">?</div>
                                <div>
                                    <div class="name"  id="pName">—</div>
                                    <div class="email" id="pEmail">—</div>
                                </div>
                            </div>
                            <span class="rbadge ad" id="pRolBadge">Admin</span>
                        </div>

                        {{-- Body --}}
                        <div class="panel-body">

                            {{-- Rol --}}
                            <div>
                                <div class="sec-label">Rol</div>
                                <div class="rol-options">

                                    <label class="rol-opt" id="optAdmin">
                                        <input type="radio" name="rol" value="admin" id="rolAdmin">
                                        <div class="rol-icon admin">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        <div class="rol-text">
                                            <h4>Administrador</h4>
                                            <p>Permisos personalizables</p>
                                        </div>
                                        <div class="rol-check">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </label>

                                    <label class="rol-opt" id="optSA">
                                        <input type="radio" name="rol" value="super_admin" id="rolSA">
                                        <div class="rol-icon sa">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        </div>
                                        <div class="rol-text">
                                            <h4>Super Admin</h4>
                                            <p>Acceso total al sistema</p>
                                        </div>
                                        <div class="rol-check">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </label>

                                </div>
                            </div>

                            {{-- Permisos --}}
                            <div class="perms-section hidden" id="permsSection">
                                <div class="perms-head">
                                    <div class="sec-label" style="margin:0;flex:1">Permisos</div>
                                    <div class="perms-actions">
                                        <button type="button" class="link-btn" id="btnAll">Todos</button>
                                        <span style="color:#d1d5db">·</span>
                                        <button type="button" class="link-btn red" id="btnNone">Ninguno</button>
                                    </div>
                                </div>
                                <div class="perms-grid" style="margin-top:10px">
                                    @foreach($permisos as $key => $nombre)
                                    <label class="perm-item" id="w-{{ $key }}">
                                        <input type="checkbox" name="permisos[]" value="{{ $key }}"
                                               class="perm-cb" {{ in_array($key, old('permisos', [])) ? 'checked' : '' }}>
                                        {{ $nombre }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Aviso SA --}}
                            <div class="sa-alert hidden" id="saAlert">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>Este usuario tendrá <strong>control total</strong> sobre el sistema. Asegúrate de que sea de máxima confianza.</span>
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="form-footer">
                            <button type="button" class="btn btn-ghost" id="btnCancel">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Guardar cambios
                            </button>
                        </div>

                    </div>{{-- /stateActive --}}
                </div>{{-- /main-panel --}}
            </div>{{-- /rp-layout --}}
        </form>

        @else
        <div class="main-panel">
            <div class="state-empty">
                <div class="icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3>Acceso restringido</h3>
                <p>Solo el Super Administrador puede gestionar<br>roles y permisos del sistema.</p>
            </div>
        </div>
        @endif

    </div>{{-- /tab-config --}}

    {{-- ════════════ TAB: RESUMEN ════════════ --}}
    <div class="tab-pane" id="tab-resumen">

        {{-- Cards compactas de rol --}}
        <div class="roles-summary mb-5">
            <div class="role-card-sm">
                <div class="rcs-head sa-head">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Super Administrador · Acceso total
                </div>
                <div class="rcs-body">
                    @foreach(['Todas las funciones del sistema','Gestionar administradores','Asignar y modificar permisos','Configuración del sistema','Periodos académicos y cupos','Estadísticas y reportes completos'] as $cap)
                    <div class="rcs-item">
                        <svg class="ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        {{ $cap }}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="role-card-sm">
                <div class="rcs-head ad-head">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Administrador · Permisos limitados
                </div>
                <div class="rcs-body">
                    <div class="rcs-item"><svg class="ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Acceso según permisos asignados</div>
                    <div class="rcs-item"><svg class="ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Cambiar su propia contraseña</div>
                    <div class="rcs-item"><svg class="no" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Gestionar otros administradores</div>
                    <div class="rcs-item"><svg class="no" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Configuración del sistema</div>
                    <div class="rcs-item"><svg class="no" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Modificar roles y permisos</div>
                </div>
            </div>
        </div>

        {{-- Tabla comparativa compacta --}}
        <div class="main-panel overflow-hidden">
            <div style="padding:14px 18px;border-bottom:1px solid var(--border);background:var(--bg)">
                <span style="font-size:.8rem;font-weight:700;color:var(--text)">Tabla comparativa de permisos</span>
            </div>
            <div class="overflow-x-auto">
                <table class="cmp-table">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Super Admin</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dashboard</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                        </tr>
                        <tr class="denied">
                            <td>Gestionar Administradores</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-no" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
                        </tr>
                        @foreach($permisos as $key => $nombre)
                        <tr>
                            <td>{{ $nombre }}</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><span class="badge-cfg">Configurable</span></td>
                        </tr>
                        @endforeach
                        <tr class="denied">
                            <td>Configuración del Sistema</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-no" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
                        </tr>
                        <tr>
                            <td>Cambiar contraseña propia</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- /tab-resumen --}}

</div>
@endsection
