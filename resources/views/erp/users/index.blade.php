@extends('layouts.app-erp')

@section('title', 'Gestión de Usuarios - ERP Multisoft')

@php
    $breadcrumbs = [
        'title' => 'Gestión de Usuarios',
        'description' => 'Administra los usuarios del sistema ERP Multisoft.',
        'icon' => 'ti ti-users',
        'items' => [
            ['name' => 'Config. Administrativa', 'url' => route('home')],
            ['name' => 'Usuarios', 'url' => route('users.index'), 'active' => true]
        ],
    ];

@endphp


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

     {{-- @include('layouts.vuexy.breadcrumb', $dataBreadcrumb) --}}

    <x-erp.breadcrumbs :items="$breadcrumbs">

        <x-slot:extra>
            <div class="d-flex align-items-center">
                <span class="badge bg-label-primary me-2">
                    <i class="ti ti-users"></i>
                </span>
                <span class="text-muted">Total Usuarios: {{ $users->count() }}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-label-success me-2">
                    <i class="ti ti-circle-check"></i>
                </span>
                <span class="text-muted">Total Usuarios Activos: {{ $users->where('estado', true)->count() }}</span>
            </div>
        </x-slot:extra>
        {{-- botones de accion --}}
        <x-slot:acciones>
            @can('users.create')
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('users.create') }}" class="btn btn-label-primary waves-effect">
                        <i class="ti ti-upload me-2"></i>
                        Importar Usuarios
                    </a>
                </div>
            @endcan
            {{-- @can('users.create')
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('users.create') }}" class="btn btn-primary waves-effect">
                        <i class="ti ti-plus me-2"></i>
                        Crear Usuario
                    </a>
                </div>
            @endcan             --}}
        </x-slot:acciones>

    </x-erp.breadcrumbs>

    <div class="row">
        <div class="col-12">
            <div class="card">

                {{-- Header Card con slot --}}
                <x-erp.card-header 
                    title="Lista de Usuarios" 
                    description="Gestiona usuarios y asigna roles" 
                    textColor="text-primary" 
                    icon="ti ti-users" 
                    iconColor="alert-primary"
                >
                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="ti ti-plus me-2"></i>
                        Crear Usuario
                    </button>
                </x-erp.card-header>

                <div class="card-body">
                    <!-- Componente Livewire con estilo Vuexy -->
                    <div class="table-responsive">
                        <livewire:user-manager />
                    </div>
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
                            <img src="{{ asset('vuexy/img/avatars/4.png') }}" alt="usuarios" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Usuarios Activos</span>
                    <h3 class="card-title mb-2">{{ App\Models\User::count() }}</h3>
                    <small class="text-success fw-semibold">
                        <i class="ti ti-arrow-up"></i> +100%
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('vuexy/img/avatars/2.png') }}" alt="admins" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Administradores</span>
                    <h3 class="card-title mb-2">{{ App\Models\User::role('admin')->count() }}</h3>
                    <small class="text-info fw-semibold">
                        <i class="ti ti-user-check"></i> Activos
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('vuexy/img/avatars/4.png') }}" alt="managers" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Gerentes</span>
                    <h3 class="card-title mb-2">{{ App\Models\User::role('manager')->count() }}</h3>
                    <small class="text-warning fw-semibold">
                        <i class="ti ti-user-share"></i> Gestión
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('vuexy/img/avatars/6.png') }}" alt="users" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Usuario Regular</span>
                    <h3 class="card-title mb-2">{{ App\Models\User::role('user')->count() }}</h3>
                    <small class="text-success fw-semibold">
                        <i class="ti ti-user"></i> Standard
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear usuario -->
    @can('users.create')
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">
                        <i class="bx bx-user-plus me-2"></i>
                        Crear Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-mb-3">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre completo" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="usuario@ejemplo.com" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-mb-3">
                                <label for="role" class="form-label">Rol</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Seleccionar rol...</option>
                                    @foreach(Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x me-1"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i>
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush
