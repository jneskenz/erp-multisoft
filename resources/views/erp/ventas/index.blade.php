@extends('layouts.app-erp')

@section('title', 'Ventas - ERP Multi-Empresa')

@section('content')
<div class="container-fluid">
    {{-- 
        Vista del Módulo de Ventas
        Fecha de creación: 3 de octubre de 2025
        
        Esta vista muestra el listado de ventas de la empresa actual
    --}}
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="mdi mdi-cash-multiple mr-2"></i>
                    Módulo de Ventas - {{ $empresaActual->razon_social }}
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('erp.dashboard', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Ventas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas de ventas --}}
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted fw-normal mt-0">Total Ventas del Mes</h5>
                    <h3 class="my-2 py-1 text-success">${{ number_format($estadisticas['total_ventas_mes']) }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                        Mes actual
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted fw-normal mt-0">Clientes Activos</h5>
                    <h3 class="my-2 py-1 text-primary">{{ number_format($estadisticas['total_clientes']) }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-info me-2"><i class="mdi mdi-account-multiple"></i></span>
                        Total de clientes
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted fw-normal mt-0">Meta Mensual</h5>
                    <h3 class="my-2 py-1 text-warning">${{ number_format($estadisticas['meta_mensual']) }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-warning me-2"><i class="mdi mdi-target"></i></span>
                        Objetivo del mes
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de ventas --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h4 class="header-title">Listado de Ventas</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end">
                                <a href="{{ route('erp.ventas.create', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}" 
                                   class="btn btn-success">
                                    <i class="mdi mdi-plus"></i> Nueva Venta
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($ventas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventas as $venta)
                                        <tr>
                                            <td>{{ $venta->id }}</td>
                                            <td>{{ $venta->cliente_nombre }}</td>
                                            <td>{{ $venta->fecha_venta }}</td>
                                            <td>${{ number_format($venta->total) }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $venta->estado }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('erp.ventas.show', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo, 'id' => $venta->id]) }}" 
                                                       class="btn btn-sm btn-info" title="Ver">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('erp.ventas.edit', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo, 'id' => $venta->id]) }}" 
                                                       class="btn btn-sm btn-warning" title="Editar">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="avatar-lg bg-light rounded-circle mx-auto mb-3">
                                <i class="mdi mdi-cash-multiple font-32 avatar-title text-muted"></i>
                            </div>
                            <h5 class="text-muted">No hay ventas registradas</h5>
                            <p class="text-muted mb-4">
                                Comience agregando su primera venta para esta empresa.
                            </p>
                            <a href="{{ route('erp.ventas.create', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}" 
                               class="btn btn-success">
                                <i class="mdi mdi-plus me-1"></i> Crear Primera Venta
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Información de contexto de empresa --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="mdi mdi-information"></i>
                        Contexto de Empresa - Sistema Multi-Empresa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Empresa Actual:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Razón Social:</strong> {{ $empresaActual->razon_social }}</li>
                                <li><strong>Código:</strong> {{ $empresaActual->codigo }}</li>
                                <li><strong>ID:</strong> {{ $empresaActual->id }}</li>
                                <li><strong>Estado:</strong> 
                                    @if($empresaActual->estado)
                                        <span class="badge bg-success">Activa</span>
                                    @else
                                        <span class="badge bg-danger">Inactiva</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Grupo Empresarial:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Nombre:</strong> {{ $grupoActual->nombre }}</li>
                                <li><strong>Código:</strong> {{ $grupoActual->codigo }}</li>
                                <li><strong>ID:</strong> {{ $grupoActual->id }}</li>
                                <li><strong>Usuario:</strong> {{ auth()->user()->name }} ({{ auth()->user()->email }})</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>URL Pattern del ERP Multi-Empresa:</h6>
                        <code>{{ request()->fullUrl() }}</code>
                        <p class="text-muted mt-2">
                            Estructura: <code>/{grupo}/{empresa}/ventas</code> - 
                            Este patrón permite que cada empresa tenga su propio contexto de datos aislado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Funcionalidades específicas del módulo de ventas
// Fecha: 3 de octubre de 2025

document.addEventListener('DOMContentLoaded', function() {
    console.log('Módulo de Ventas cargado para empresa:', '{{ $empresaActual->codigo }}');
    
    // TODO: Agregar funcionalidades interactivas como:
    // - Filtros de búsqueda
    // - Paginación
    // - Exportación de datos
    // - Confirmaciones de eliminación
});
</script>
@endsection