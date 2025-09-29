@extends('layouts.vuexy')

@section('title', 'Gestión de Sedes - ERP Multisoft')

@php

    $dataBreadcrumb = [
        'title' => 'Gestión de Sede',
        'description' => 'Administra las sedes del sistema',
        'icon' => 'ti ti-building-bank',
        'breadcrumbs' => [
            ['name' => 'Admin. del Sistema', 'url' => route('home')],
            ['name' => 'Sedes', 'url' => route('sedes.index'), 'active' => true],
        ],
        'stats' => [
            [
                'name' => 'Total Sedes',
                'value' => $sedes->count(),
                'icon' => 'ti ti-building',
                'color' => 'bg-label-primary',
            ],
            [
                'name' => 'Sedes Activas',
                'value' => $sedes->where('estado', true)->count(),
                'icon' => 'ti ti-circle-check',
                'color' => 'bg-label-success',
            ],
        ],
    ];

    $dataHeaderCard = [
        'title' => 'Sistema de Sedes',
        'description' => 'Administra las sedes del sistema.',
        'icon' => 'ti ti-building',
        'bgColor' => 'alert-info',
        'allowClose' => false,
        'actions' => [
            [
                'name' => 'Crear Sede',
                'url' => route('sedes.create'),
                'icon' => 'ti ti-plus',
                'permission' => 'sedes.create',
            ],
        ],
    ];

@endphp


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        @include('layouts.vuexy.breadcrumb', $dataBreadcrumb)

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header align-items-center justify-content-between border-bottom">
                        <div class="nav-align-top">
                            <ul class="nav nav-pills flex-column flex-md-row">
                                <li class="nav-item mb-2 mb-md-0 me-0 me-md-3">
                                    <a class="nav-link" href="{{ route('sedes.index') }}">
                                        <i class="ti-xs ti ti-building me-1"></i>
                                        Sedes
                                    </a>
                                </li>
                                <li class="nav-item mb-2 mb-md-0 me-0 me-md-3">
                                    <a class="nav-link active border" href="javascript:void(0);">
                                        <i class="ti-sm ti ti-building-bank me-1"></i>
                                        Sede
                                    </a>
                                </li>
                                <li class="nav-item mb-2 mb-md-0 me-0 me-md-3">
                                    <a class="nav-link border" href="pages-account-settings-billing.html">
                                        <i class="ti-xs ti ti-building-store me-1"></i>
                                        Locales
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @include('layouts.vuexy.header-card', $dataHeaderCard)

                    <div class="card-body">
                        <!-- Componente Livewire con estilo Vuexy -->
                        <div class="table-responsive">
                            <livewire:erp.sedes-data-table />
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Mensajes de estado -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible d-flex" role="alert">
                                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                                <div>
                                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">¡Éxito!</h6>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible d-flex" role="alert">
                                <span class="alert-icon rounded"><i class="ti ti-x"></i></span>
                                <div>
                                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Error</h6>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Tabla de sedes -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>EMPRESA</th>
                                        <th>SEDE</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th class="text-center">ESTADO</th>
                                        @canany(['sedes.edit', 'sedes.delete'])
                                            <th class="text-center">ACCIONES</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse($sedes as $sede)
                                        <tr>
                                            <td>{{ $sede->id }}</td>
                                            <td>{{ $sede->empresa->nombre_comercial }}</td>
                                            <td>{{ $sede->nombre }}</td>
                                            <td>{{ $sede->descripcion }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-label-{{ $sede->estado == 1 ? 'success' : 'danger' }} me-1">{{ $sede->estado == 1 ? 'Activo' : 'Inactivo' }}</span>
                                            </td>
                                            <td class="text-center">
                                                @can('sedes.edit')
                                                    <a href="{{ route('sedes.edit', $sede) }}" data-bs-toggle="tooltip" title="Editar">
                                                        <span class="badge bg-label-primary px-2">
                                                            <i class="ti ti-pencil"></i>
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('sedes.delete')
                                                    <form action="{{ route('sedes.destroy', $sede) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta sede?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-label-danger border-0 px-2" data-bs-toggle="tooltip" title="Eliminar">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="{{ asset('vuexy/img/illustrations/auth-register-illustration-light.png') }}"
                                                        alt="No sedes" width="120" class="mb-3">
                                                    <h6 class="mb-1">No se encontraron sedes</h6>
                                                    <p class="text-muted mb-0">Comienza creando tu primera sede en el
                                                        sistema.</p>
                                                    @can('sedes.create')
                                                        <a href="{{ route('sedes.create') }}" class="btn btn-primary mt-2">
                                                            <i class="ti ti-plus me-1"></i>
                                                            Crear Primera Sede
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación si es necesario -->
                        @if (method_exists($sedes, 'links'))
                            <div class="d-flex justify-content-center">
                                {{ $sedes->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('vuexy/img/backgrounds/speaker.png') }}" alt="sedes"
                                    class="rounded">
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Sedes</span>
                        <h3 class="card-title mb-2">{{ $sedes->count() }}</h3>
                        <small class="text-success fw-semibold">
                            <i class="ti ti-up-arrow-alt"></i> Registradas
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('vuexy/img/backgrounds/speaker.png') }}" alt="activas"
                                    class="rounded">
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Sedes Activas</span>
                        <h3 class="card-title mb-2">{{ $sedes->where('estado', true)->count() }}</h3>
                        <small class="text-info fw-semibold">
                            <i class="ti ti-check-circle"></i> Operativas
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>
@endpush
