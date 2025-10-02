@extends('layouts.vuexy')

@section('title', 'Artículos - ERP Multisoft')

@push('styles')
    @livewireStyles
@endpush

@php
    $breadcrumbs = [
        'title' => 'Gestión de Artículos',
        'description' => 'Administra el inventario de artículos del sistema',
        'icon' => 'ti ti-package',
        'items' => [
            ['name' => 'Inventario', 'url' => route('home')],
            ['name' => 'Artículos', 'url' => '', 'active' => true]
        ],
        'actions' => [
            [
                'name' => 'Exportar',
                'url' => '#',
                'typeButton' => 'btn-outline-success',
                'icon' => 'ti ti-download',
                'permission' => 'articulos.view',
                'onclick' => 'exportArticulos()'
            ],
            [
                'name' => 'Nuevo Artículo',
                'url' => route('articulos.create'),
                'typeButton' => 'btn-primary',
                'icon' => 'ti ti-plus',
                'permission' => 'articulos.create'
            ],
        ],
    ];
@endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <x-erp.breadcrumbs :items="$breadcrumbs">
        <x-slot:extra>
            <a href="{{ route('empresas.index') }}" onclick="event.preventDefault(); exportArticulos();" class="btn btn-outline-success waves-effect">
                <i class="ti ti-download me-2"></i>
                Exportar
            </a>
        </x-slot:extra>
    </x-erp.breadcrumbs>


    @livewire('erp.articulos-table')
</div>
@endsection

@push('scripts')
    @livewireScripts
    
    <script>
        function exportArticulos() {
            // Implementar lógica de exportación
            Swal.fire({
                title: 'Exportar Artículos',
                text: 'Selecciona el formato de exportación',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Excel',
                cancelButtonText: 'PDF',
                showDenyButton: true,
                denyButtonText: 'CSV'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Exportar a Excel
                    window.livewire.emit('export', 'excel');
                } else if (result.isDenied) {
                    // Exportar a CSV
                    window.livewire.emit('export', 'csv');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Exportar a PDF
                    window.livewire.emit('export', 'pdf');
                }
            });
        }

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
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        });
    </script>
@endpush