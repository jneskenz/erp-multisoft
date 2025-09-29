@extends('layouts.vuexy')

@section('title', 'Gestión de Empresas - ERP Multisoft')

@php

    $dataBreadcrumb = [
        'title' => 'Gestión de Empresas',
        'description' => 'Administra las empresas del sistema ERP Multisoft.',
        'icon' => 'ti ti-building',
        'breadcrumbs' => [
            ['name' => 'Admin. del Sistema', 'url' => route('home')],
            ['name' => 'Empresas', 'url' => route('empresas.index'), 'active' => true],
        ],
        //   'actions' => [
        //      ['name' => 'Nueva Empresa', 'url' => route('empresas.create'), 'icon' => 'ti ti-plus', 'permission' => 'empresas.create'],
        //      ['name' => 'Importar Empresas', 'url' => route('empresas.create'), 'icon' => 'ti ti-upload', 'permission' => 'empresas.create']
        //   ],
        'stats' => [
            [
                'name' => 'Total Empresas',
                'value' => $empresas->count(),
                'icon' => 'ti ti-building',
                'color' => 'bg-label-primary',
            ],
            [
                'name' => 'Empresas Activas',
                'value' => $empresas->where('estado', true)->count(),
                'icon' => 'ti ti-circle-check',
                'color' => 'bg-label-success',
            ],
        ],
    ];

    $dataHeaderCard = [
        'title' => 'Sistema de Empresas',
        'description' => 'Administra las empresas del sistema.',
        'icon' => 'ti ti-building',
        'bgColor' => 'alert-info',
        'allowClose' => false,
        'actions' => [
            [
                'name' => 'Crear Empresa',
                'url' => route('empresas.create'),
                'icon' => 'ti ti-plus',
                'permission' => 'empresas.create',
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
                                    <a class="nav-link active" href="javascript:void(0);">
                                        <i class="ti-sm ti ti-building me-1"></i>
                                        Empresas
                                    </a>
                                </li>
                                <li class="nav-item mb-2 mb-md-0 me-0 me-md-3">
                                    <a class="nav-link border" href="{{ route('sedes.index') }}">
                                        <i class="ti-xs ti ti-building-bank me-1"></i>
                                        Sedes
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

                        <!-- Tabla de empresas -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Empresa</th>
                                        <th>RUC</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th class="text-center">Estado</th>
                                        @canany(['empresas.edit', 'empresas.delete'])
                                            <th class="text-center">Acciones</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse($empresas as $empresa)
                                        <tr>
                                            <td>
                                                <span class="badge bg-label-secondary">#{{ $empresa->id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar me-3">
                                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                                {{ strtoupper(substr($empresa->nombre_comercial, 0, 2)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $empresa->nombre_comercial }}</span>
                                                        <small class="text-muted">{{ $empresa->direccion }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $empresa->numerodocumento }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $empresa->correo ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $empresa->telefono ?? 'N/A' }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($empresa->estado)
                                                    <span class="badge bg-label-success">
                                                        <i class="ti ti-circle-check me-1"></i>
                                                        Activa
                                                    </span>
                                                @else
                                                    <span class="badge bg-label-secondary">
                                                        <i class="ti ti-circle-x me-1"></i>
                                                        Inactiva
                                                    </span>
                                                @endif
                                            </td>
                                            @canany(['empresas.edit', 'empresas.delete'])
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('empresas.show', $empresa) }}">
                                                                    <i class="ti ti-clipboard-list"></i> Ver Detalles
                                                                </a></li>
                                                            @can('empresas.edit')
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('empresas.edit', $empresa) }}">
                                                                        <i class="ti ti-edit me-1"></i> Editar
                                                                    </a></li>
                                                            @endcan
                                                            @can('empresas.delete')
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('empresas.destroy', $empresa) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('¿Estás seguro de eliminar esta empresa?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="ti ti-trash me-1"></i> Eliminar
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endcan
                                                        </ul>
                                                    </div>
                                                </td>
                                            @endcanany
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="{{ asset('vuexy/img/illustrations/page-misc-error.png') }}"
                                                        alt="No empresas" width="120" class="mb-3">
                                                    <h6 class="mb-1">No se encontraron empresas</h6>
                                                    <p class="text-muted mb-0">Comienza creando tu primera empresa en el
                                                        sistema.</p>
                                                    @can('empresas.create')
                                                        <a href="{{ route('empresas.create') }}" class="btn btn-primary mt-2">
                                                            <i class="ti ti-plus me-1"></i>
                                                            Crear Primera Empresa
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
                        @if (method_exists($empresas, 'links'))
                            <div class="d-flex justify-content-center">
                                {{ $empresas->links() }}
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
                                <img src="{{ asset('vuexy/img/backgrounds/speaker.png') }}" alt="empresas"
                                    class="rounded">
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Empresas</span>
                        <h3 class="card-title mb-2">{{ $empresas->count() }}</h3>
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
                        <span class="fw-semibold d-block mb-1">Empresas Activas</span>
                        <h3 class="card-title mb-2">{{ $empresas->where('estado', true)->count() }}</h3>
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
