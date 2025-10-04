@extends('layouts.app-erp')

@section('title', 'Editar Artículo - ERP Multisoft')

@push('styles')
    @livewireStyles
@endpush

@php
    $breadcrumbs = [
        'title' => 'Editar Artículo',
        'description' => 'Modifica la información del artículo ' . $articulo->nombre,
        'icon' => 'ti ti-edit',
        'items' => [
            ['name' => 'Inventario', 'url' => route('home')],
            ['name' => 'Artículos', 'url' => route('articulos.index')],
            ['name' => $articulo->codigo, 'url' => route('articulos.show', $articulo)],
            ['name' => 'Editar', 'url' => '', 'active' => true]
        ],
        'actions' => [
            [
                'name' => 'Ver Detalle',
                'url' => route('articulos.show', $articulo),
                'typeButton' => 'btn-info',
                'icon' => 'ti ti-eye',
                'permission' => 'articulos.view'
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
            @can('articulos.view')
                <a href="{{ route('articulos.index') }}" class="btn btn-label-dark waves-effect">
                    <i class="ti ti-arrow-left me-2"></i>
                    Regresar
                </a>
            @endcan
        </x-slot:extra>
    </x-erp.breadcrumbs>

    @livewire('erp.articulo-form', ['articulo' => $articulo, 'modo' => 'edit'])
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