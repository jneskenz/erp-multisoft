@extends('layouts.vuexy')

@section('title', 'Locales')

@php

    $breadcrumbs = [
        'title' => 'Gestión de Locales',
        'description' => 'Administra los locales del sistema',
        'icon' => 'ti ti-building-store',
        'items' => [
            ['name' => 'Config. Administrativa', 'url' => route('home')],
            ['name' => 'Locales', 'url' => 'javascript:void(0);', 'active' => true],
        ],
    ];

    $dataHeaderCard = [
        'title' => 'Lista de Locales',
        'description' => '',
        'textColor' => 'text-primary',
        'icon' => 'ti ti-building-store',
        'iconColor' => 'bg-label-primary',
        'actions' => [
            [
                'typeAction' => 'btnLink', // btnIdEvent, btnLink, btnToggle, btnInfo
                'typeButton' => 'btn-primary', // btn-primary, btn-info, btn-success, btn-danger, btn-warning, btn-secondary
                'name' => 'Crear Local',
                'url' => route('locales.create'),
                'icon' => 'ti ti-plus',
                'permission' => 'locales.create',
            ],
        ],
    ];


@endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <x-erp.breadcrumbs :items="$breadcrumbs">
        <x-slot:extra>
            <div class="d-flex align-items-center">
                <span class="badge bg-label-primary me-2">
                    <i class="ti ti-building-store"></i>
                </span>
                <span class="text-muted">Total Roles: {{ $locales->count() }}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-label-success me-2">
                    <i class="ti ti-circle-check"></i>
                </span>
                <span class="text-muted">Roles Activas: {{ $locales->where('estado', true)->count() }}</span>
            </div>
        </x-slot:extra>
    </x-erp.breadcrumbs>

    <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header align-items-center justify-content-between border-bottom">
                        <div class="nav-align-top">
                            <ul class="nav nav-pills flex-column flex-md-row">
                                <li class="nav-item mb-2 mb-md-0 me-0 me-md-3">
                                    <a class="nav-link border" href="{{ route('empresas.index') }}">
                                        <i class="ti-xs ti ti-building me-1"></i>
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
                                    <a class="nav-link active" href="javascript:void(0);">
                                        <i class="ti-sm ti ti-building-store me-1"></i>
                                        Locales
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <x-erp.card-header 
                        title="Lista de Locales" 
                        description=""
                        textColor="text-primary"
                        icon="ti ti-building-store"
                        iconColor="bg-label-primary"
                    >
                        @can('locales.create')
                            <a href="{{ route('locales.create') }}" class="btn btn-primary waves-effect">
                                <i class="ti ti-plus me-2"></i>
                                Crear Local
                            </a>
                        @endcan
                    </x-erp.card-header>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bx bx-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bx bx-error-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <!-- Componente Livewire con estilo Vuexy -->
                        @livewire('erp.local-table')
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
    <script>
        // Listener para eventos Livewire
        window.addEventListener('local-updated', function (e) {
            toastr.success(e.detail.message || 'Local actualizado correctamente');
        });

        window.addEventListener('local-deleted', function (e) {
            toastr.success(e.detail.message || 'Local eliminado correctamente');
        });

        window.addEventListener('local-error', function (e) {
            toastr.error(e.detail.message || 'Error al procesar la solicitud');
        });
    </script>
@endsection