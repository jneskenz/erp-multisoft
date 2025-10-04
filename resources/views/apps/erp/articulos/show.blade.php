@extends('layouts.app-erp')

@section('title', $articulo->nombre . ' - ERP Multisoft')

@push('styles')
    @livewireStyles
@endpush

@php
    $breadcrumbs = [
        'title' => 'Detalle del Artículo',
        'description' => 'Información completa del artículo ' . $articulo->codigo,
        'icon' => 'ti ti-eye',
        'items' => [
            ['name' => 'Inventario', 'url' => route('home')],
            ['name' => 'Artículos', 'url' => route('articulos.index')],
            ['name' => $articulo->codigo, 'url' => '', 'active' => true]
        ],
        'actions' => [
            [
                'name' => 'Editar',
                'url' => route('articulos.edit', $articulo),
                'typeButton' => 'btn-warning',
                'icon' => 'ti ti-edit',
                'permission' => 'articulos.edit'
            ],
            [
                'name' => 'Volver a Lista',
                'url' => route('articulos.index'),
                'typeButton' => 'btn-label-dark',
                'icon' => 'ti ti-arrow-left',
                'permission' => 'articulos.view'
            ],
        ],
    ];
@endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <x-erp.breadcrumbs :items="$breadcrumbs">
        <x-slot:extra>
            @can('empresas.view')
            <a href="{{ route('empresas.index') }}" class="btn btn-label-dark waves-effect">
                <i class="ti ti-arrow-left me-2"></i>
                Regresar
            </a>
            @endcan
        </x-slot:extra>
    </x-erp.breadcrumbs>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <!-- Información Básica -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-info-circle me-2"></i>
                        Información General
                    </h5>
                    <div class="text-end">
                        <span class="badge bg-{{ $articulo->estado ? 'success' : 'danger' }} me-1 mb-1 mb-md-0">
                            {{ $articulo->estado_texto }}
                        </span>
                        @if($articulo->inventariable)
                            <span class="badge bg-info me-1 mb-1 mb-md-0">Inventariable</span>
                        @endif
                        @if($articulo->vendible)
                            <span class="badge bg-primary me-1 mb-1 mb-md-0">Vendible</span>
                        @endif
                        @if($articulo->comprable)
                            <span class="badge bg-secondary me-1 mb-1 mb-md-0">Comprable</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" style="width: 30%">Código:</td>
                                    <td>
                                        <span class="badge bg-light text-dark fs-6">{{ $articulo->codigo }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Nombre:</td>
                                    <td class="fs-5 fw-semibold">{{ $articulo->nombre }}</td>
                                </tr>
                                @if($articulo->descripcion)
                                    <tr>
                                        <td class="fw-bold">Descripción:</td>
                                        <td>{{ $articulo->descripcion }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="fw-bold">Marca:</td>
                                    <td>
                                        @if($articulo->marca)
                                            <span class="badge bg-info">{{ $articulo->marca }}</span>
                                        @else
                                            <span class="text-muted">No especificada</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Modelo:</td>
                                    <td>{{ $articulo->modelo ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Unidad de Medida:</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $articulo->unidad_medida }}</span>
                                    </td>
                                </tr>
                                @if($articulo->ubicacion)
                                    <tr>
                                        <td class="fw-bold">Ubicación:</td>
                                        <td>
                                            <i class="ti ti-map-pin me-1"></i>
                                            {{ $articulo->ubicacion }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-4 text-center">
                            @if($articulo->imagen)
                                <img src="{{ Storage::url($articulo->imagen) }}" 
                                     alt="{{ $articulo->nombre }}" 
                                     class="img-fluid rounded border"
                                     style="max-height: 200px;">
                            @else
                                <div class="bg-light rounded border d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <div class="text-center">
                                        <i class="ti ti-package display-4 text-muted"></i>
                                        <p class="text-muted mt-2">Sin imagen</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Especificaciones Técnicas -->
            @if($articulo->especificaciones && count($articulo->especificaciones) > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-list-details me-2"></i>
                            Especificaciones Técnicas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($articulo->especificaciones as $clave => $valor)
                                <div class="col-md-6 mb-2">
                                    <strong>{{ $clave }}:</strong> 
                                    <span class="text-muted">{{ $valor }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Historial de Actividad -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-clock me-2"></i>
                        Información del Sistema
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td class="fw-bold">ID:</td>
                            <td>{{ $articulo->id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Creado:</td>
                            <td>{{ $articulo->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Actualizado:</td>
                            <td>{{ $articulo->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @if($articulo->updated_at != $articulo->created_at)
                            <tr>
                                <td class="fw-bold">Última modificación:</td>
                                <td>{{ $articulo->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Información Financiera -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-currency-dollar me-2"></i>
                        Información Financiera
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Precio de Costo:</span>
                        <span class="text-danger fs-5">S/ {{ number_format($articulo->precio_costo, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Precio de Venta:</span>
                        <span class="text-success fs-5">S/ {{ number_format($articulo->precio_venta, 2) }}</span>
                    </div>

                    @if($articulo->precio_costo > 0)
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Margen de Ganancia:</span>
                            <span class="badge bg-{{ $articulo->margen_ganancia > 0 ? 'success' : 'danger' }} fs-6">
                                {{ number_format($articulo->margen_ganancia, 2) }}%
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información de Stock -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-package me-2"></i>
                        Estado del Inventario
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h2 class="text-{{ $articulo->estado_stock == 'bajo' ? 'danger' : ($articulo->estado_stock == 'alto' ? 'warning' : 'success') }}">
                            {{ $articulo->stock_actual }}
                        </h2>
                        <p class="text-muted">{{ $articulo->unidad_medida }} disponibles</p>
                        
                        @if($articulo->estado_stock == 'bajo')
                            <div class="alert alert-danger">
                                <i class="ti ti-alert-triangle me-2"></i>
                                <strong>¡Stock Bajo!</strong><br>
                                Se recomienda reabastecer
                            </div>
                        @elseif($articulo->estado_stock == 'alto')
                            <div class="alert alert-warning">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Stock Alto</strong><br>
                                Considere ajustar compras
                            </div>
                        @else
                            <div class="alert alert-success">
                                <i class="ti ti-check me-2"></i>
                                <strong>Stock Normal</strong><br>
                                Nivel óptimo
                            </div>
                        @endif
                    </div>

                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <small class="text-muted">Mínimo</small>
                                <div class="fw-bold text-danger">{{ $articulo->stock_minimo }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <small class="text-muted">Actual</small>
                                <div class="fw-bold text-primary">{{ $articulo->stock_actual }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <small class="text-muted">Máximo</small>
                                <div class="fw-bold text-success">{{ $articulo->stock_maximo }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Barra de progreso del stock -->
                    <div class="mt-3">
                        @php
                            $porcentaje = $articulo->stock_maximo > 0 ? ($articulo->stock_actual / $articulo->stock_maximo) * 100 : 0;
                            $porcentaje = min(100, $porcentaje);
                        @endphp
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-{{ $articulo->estado_stock == 'bajo' ? 'danger' : ($articulo->estado_stock == 'alto' ? 'warning' : 'success') }}" 
                                 role="progressbar" 
                                 style="width: {{ $porcentaje }}%">
                            </div>
                        </div>
                        <small class="text-muted">{{ number_format($porcentaje, 1) }}% del stock máximo</small>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-bolt me-2"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @can('articulos.edit')
                            <a href="{{ route('articulos.edit', $articulo) }}" 
                               class="btn btn-warning">
                                <i class="ti ti-edit me-2"></i>
                                Editar Artículo
                            </a>
                        @endcan

                        @can('articulos.edit')
                            <button class="btn btn-{{ $articulo->estado ? 'secondary' : 'success' }}" 
                                    onclick="toggleStatus({{ $articulo->id }})">
                                <i class="ti ti-{{ $articulo->estado ? 'eye-off' : 'check' }} me-2"></i>
                                {{ $articulo->estado ? 'Desactivar' : 'Activar' }}
                            </button>
                        @endcan

                        <button class="btn btn-info" onclick="imprimirFicha()">
                            <i class="ti ti-printer me-2"></i>
                            Imprimir Ficha
                        </button>

                        @can('articulos.delete')
                            <button class="btn btn-danger" 
                                    onclick="eliminarArticulo({{ $articulo->id }})">
                                <i class="ti ti-trash me-2"></i>
                                Eliminar
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function toggleStatus(articuloId) {
            Swal.fire({
                title: '¿Cambiar estado?',
                text: 'Esta acción cambiará el estado del artículo',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/articulos/${articuloId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Éxito!', data.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
                    });
                }
            });
        }

        function eliminarArticulo(articuloId) {
            Swal.fire({
                title: '¿Eliminar artículo?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/articulos/${articuloId}`;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function imprimirFicha() {
            Swal.fire({
                title: 'Imprimir Ficha',
                text: 'Funcionalidad de impresión en desarrollo',
                icon: 'info'
            });
        }
    </script>
@endpush