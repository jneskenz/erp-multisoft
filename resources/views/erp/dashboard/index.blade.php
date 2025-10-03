@extends('layouts.app')

@section('title', 'Dashboard - ERP Multi-Empresa')

@section('content')
<div class="container-fluid">
    {{-- 
        Vista del Dashboard Principal del ERP
        Fecha de creación: 3 de octubre de 2025
        
        Esta vista muestra el panel principal del ERP con:
        - Información de la empresa actual
        - Métricas y estadísticas clave
        - Accesos rápidos a módulos principales
    --}}
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="mdi mdi-view-dashboard mr-2"></i>
                    Dashboard - {{ $empresaActual->razon_social }}
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">{{ $grupoActual->nombre }}</li>
                        <li class="breadcrumb-item">{{ $empresaActual->razon_social }}</li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Tarjetas de métricas principales --}}
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Ventas del Mes">Ventas del Mes</h5>
                            <h3 class="my-2 py-1">${{ number_format($metricas['ventas_mes']) }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 10.5%</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="mdi mdi-currency-usd font-20 avatar-title text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Compras del Mes">Compras del Mes</h5>
                            <h3 class="my-2 py-1">${{ number_format($metricas['compras_mes']) }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 5.2%</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="mdi mdi-cart font-20 avatar-title text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Clientes Activos">Clientes Activos</h5>
                            <h3 class="my-2 py-1">{{ number_format($metricas['clientes_activos']) }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 15.8%</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="mdi mdi-account-multiple font-20 avatar-title text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Stock Bajo">Stock Bajo</h5>
                            <h3 class="my-2 py-1">{{ $metricas['productos_stock_bajo'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-warning me-2"><i class="mdi mdi-alert"></i> Atención</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="mdi mdi-package-variant font-20 avatar-title text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Accesos Rápidos</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('erp.ventas.index', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}" 
                               class="btn btn-success btn-lg w-100">
                                <i class="mdi mdi-cash-multiple d-block font-24 mb-2"></i>
                                Módulo de Ventas
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('erp.compras.index', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}" 
                               class="btn btn-primary btn-lg w-100">
                                <i class="mdi mdi-cart-plus d-block font-24 mb-2"></i>
                                Módulo de Compras
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn btn-info btn-lg w-100">
                                <i class="mdi mdi-chart-line d-block font-24 mb-2"></i>
                                Reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Información de la Empresa</h4>
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Razón Social:</td>
                                    <td>{{ $empresaActual->razon_social }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Grupo:</td>
                                    <td>{{ $grupoActual->nombre }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Código:</td>
                                    <td>{{ $empresaActual->codigo }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Estado:</td>
                                    <td>
                                        @if($empresaActual->estado)
                                            <span class="badge bg-success">Activa</span>
                                        @else
                                            <span class="badge bg-danger">Inactiva</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Usuario:</td>
                                    <td>{{ auth()->user()->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Debug info (solo en desarrollo) --}}
    @if(config('app.debug'))
    <div class="row">
        <div class="col-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Debug Info - Sistema Multi-Empresa</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Contexto de Empresa:</h6>
                            <ul class="list-unstyled">
                                <li><strong>URL Actual:</strong> {{ request()->fullUrl() }}</li>
                                <li><strong>Grupo ID:</strong> {{ $grupoActual->id }} ({{ $grupoActual->codigo }})</li>
                                <li><strong>Empresa ID:</strong> {{ $empresaActual->id }} ({{ $empresaActual->codigo }})</li>
                                <li><strong>Usuario ID:</strong> {{ auth()->user()->id }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Rutas Disponibles:</h6>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('erp.dashboard', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}">Dashboard</a></li>
                                <li><a href="{{ route('erp.ventas.index', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}">Ventas</a></li>
                                <li><a href="{{ route('erp.compras.index', ['grupo' => $grupoActual->codigo, 'empresa' => $empresaActual->codigo]) }}">Compras</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection