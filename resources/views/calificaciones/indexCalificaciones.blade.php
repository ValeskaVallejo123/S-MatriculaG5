@extends('layouts.app')

@section('title', 'Visualización de Calificaciones')

@section('content')
    <main class="main-content">
        <div class="content-wrapper">
            {{-- Encabezado de página --}}
            <div class="page-header">
                <div class=""><i class="fas fa-book"></i></div>
                <h1>Calificaciones</h1>
                <div class="header-divider"></div>
            </div>

            {{-- Filtros --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <h2>Filtrar Calificaciones</h2>
                    <p>Seleccione los criterios deseados</p>
                </div>
                <div class="form-card-body">
                    <form method="GET" action="{{ route('calificaciones.index') }}">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="periodo_id">Período académico</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-calendar-alt input-icon"></i>
                                    <select name="periodo_id" id="periodo_id" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($periodos as $p)
                                            <option value="{{ $p->id }}" {{ request('periodo_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->nombre_periodo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="materia_id">Materia</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-book-open input-icon"></i>
                                    <select name="materia_id" id="materia_id" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach($materias as $m)
                                            <option value="{{ $m->id }}" {{ request('materia_id') == $m->id ? 'selected' : '' }}>
                                                {{ $m->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="align-self:end;">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabla de calificaciones --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h2>Listado de Calificaciones</h2>
                    <p>Detalle por materia y período</p>
                </div>
                <div class="form-card-body p-0">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="table-primary">
                        <tr>
                            <th>Materia</th>
                            <th>Período</th>
                            <th>Nota</th>
                            <th>Rendimiento</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($calificaciones as $c)
                            @php
                                $rendimiento = $c->nota >= 85 ? 'Excelente' : ($c->nota >= 70 ? 'Bueno' : 'Bajo');
                                $clase = $c->nota < 70 ? 'table-danger' : ($c->nota >= 85 ? 'table-success' : '');
                            @endphp
                            <tr class="{{ $clase }}">
                                <td>{{ $c->materia->nombre }}</td>
                                <td>{{ $c->periodo->nombre_periodo }}</td>
                                <td><strong>{{ $c->nota }}</strong></td>
                                <td>{{ $rendimiento }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No hay calificaciones disponibles.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{-- Promedio general --}}
                    <div class="alert mt-3 text-center">
                        Promedio general: <strong>{{ $promedio ? number_format($promedio, 2) : 'N/A' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('styles')
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
                color: #2c3e50;
            }

            .main-content {
                margin-left: 0;
                padding: 30px;
                min-height: 100vh;
                display: flex;
                justify-content: center;
            }

            .content-wrapper {
                width: 100%;
                max-width: 700px;
            }

            .page-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .page-icon {
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.3rem;
                margin-bottom: 10px;
            }

            .header-divider {
                width: 50px;
                height: 3px;
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                margin: 10px auto 0;
                border-radius: 2px;
            }

            .form-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.07);
                overflow: hidden;
                margin-bottom: 20px;
            }

            .form-card-header {
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                padding: 15px 20px;
                color: white;
            }

            .form-card-header h2 {
                font-size: 1rem;
                font-weight: 700;
            }

            .form-card-header p {
                font-size: 0.7rem;
            }

            .form-card-body {
                padding: 20px;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .form-group label {
                font-size: 0.75rem;
                font-weight: 600;
                margin-bottom: 4px;
                display: block;
            }

            .input-wrapper {
                position: relative;
            }

            .input-icon {
                position: absolute;
                left: 8px;
                top: 50%;
                transform: translateY(-50%);
                color: #00BCD4;
                font-size: 0.8rem;
            }

            .form-control {
                width: 100%;
                padding: 8px 8px 8px 30px;
                border: 2px solid #e0f7fa;
                border-radius: 6px;
                font-size: 0.8rem;
                background: #f1f8fb;
                transition: all 0.3s;
            }

            .form-control:focus {
                border-color: #00BCD4;
                background: white;
            }

            .btn-primary {
                background: linear-gradient(135deg, #00BCD4, #00ACC1);
                color: white;
                font-weight: 600;
                border-radius: 6px;
                padding: 8px;
                border: none;
                cursor: pointer;
            }

            table.table th, table.table td {
                vertical-align: middle !important;
            }

            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

