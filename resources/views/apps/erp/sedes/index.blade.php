@extends('layouts.app-erp')

@section('title', 'Gestión de Sedes - ERP Multisoft')

@php

    $breadcrumbs = [
        'title' => 'Gestión de Sede',
        'description' => 'Administra las sedes del sistema',
        'icon' => 'ti ti-building-bank',
        'items' => [
            ['name' => 'Config. Administrativa', 'url' => route('home')],
            ['name' => 'Sedes', 'url' => route('sedes.index')],
        ],
    ];

    $dataHeaderCard = [
        'title' => 'Lista de Sedes',
        'description' => '',
        'textColor' => 'text-primary',
        'icon' => 'ti ti-building-bank',
        'iconColor' => 'bg-label-primary',
        'actions' => [
            [
                'typeAction' => 'btnLink', // btnIdEvent, btnLink, btnToggle, btnInfo
                'typeButton' => 'btn-primary', // btn-primary, btn-info, btn-success, btn-danger, btn-warning, btn-secondary
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
        
        <x-erp.breadcrumbs :items="$breadcrumbs">

            <x-slot:extra>
                <div class="d-flex align-items-center">
                    <span class="badge bg-label-primary me-2">
                        <i class="ti ti-building-bank"></i>
                    </span>
                    <span class="text-muted">Total Sedes: {{ $sedes->count() }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-label-success me-2">
                        <i class="ti ti-circle-check"></i>
                    </span>
                    <span class="text-muted">Sedes Activas: {{ $sedes->where('estado', true)->count() }}</span>
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
                                    <a class="nav-link active" href="javascript:void(0);">
                                        <i class="ti-sm ti ti-building-bank me-1"></i>
                                        Sedes
                                    </a>
                                </li>
                                <li class="nav-item mb-2 mb-md-0 me-0 me-md-3">
                                    <a class="nav-link border" href="{{ route('locales.index') }}">
                                        <i class="ti-xs ti ti-building-store me-1"></i>
                                        Locales
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <x-erp.card-header 
                        title="Lista de Sedes" 
                        description=""
                        textColor="text-primary"
                        icon="ti ti-building-bank"
                        iconColor="bg-label-primary"
                    >
                        @can('sedes.create')
                            <a href="{{ route('sedes.create') }}" class="btn btn-primary waves-effect">
                                <i class="ti ti-plus me-2"></i>
                                Crear Sede
                            </a>
                        @endcan
                    </x-erp.card-header>

                    <div class="card-body">
                        <!-- Componente Livewire con estilo Vuexy -->
                        @livewire('erp.sedes-data-table')
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
