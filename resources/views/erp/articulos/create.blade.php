@extends('layouts.vuexy')

@section('title', 'Crear Artículo - ERP Multisoft')

@push('styles')
    @livewireStyles
@endpush

@php
    $breadcrumbs = [
        'title' => 'Crear Artículo',
        'description' => 'Registra un nuevo artículo en el inventario',
        'icon' => 'ti ti-package',
        'items' => [
            ['name' => 'Inventario', 'url' => route('home')],
            ['name' => 'Artículos', 'url' => route('articulos.index')],
            ['name' => 'Crear', 'url' => '', 'active' => true]
        ],
    ];
@endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <x-erp.breadcrumbs :items="$breadcrumbs">
        <x-slot:acciones>
            @can('articulos.view')
            <a href="{{ route('articulos.index') }}" class="btn btn-label-dark waves-effect">
                <i class="ti ti-arrow-left me-2"></i>
                Regresar
            </a>
            @endcan
        </x-slot:extra>
    </x-erp.breadcrumbs>

    @livewire('erp.articulo-form', ['modo' => 'create'])
</div>
@endsection

@push('scripts')
    @livewireScripts
    
    <script>
        // Escuchar eventos de Livewire para mostrar alertas
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-alert', (event) => {
                const data = event[0];
                let icon = 'info';
                
                switch(data.type) {
                    case 'success':
                        icon = 'success';
                        break;
                    case 'error':
                        icon = 'error';
                        break;
                    case 'warning':
                        icon = 'warning';
                        break;
                }
                
                Swal.fire({
                    title: data.type === 'error' ? 'Error' : (data.type === 'success' ? 'Éxito' : 'Información'),
                    text: data.message,
                    icon: icon,
                    timer: data.type === 'success' ? 2000 : 4000,
                    showConfirmButton: data.type === 'error'
                });
            });
        });
    </script>
@endpush