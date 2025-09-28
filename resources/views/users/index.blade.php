@extends('layouts.vuexy')

@section('title', 'Gestión de Usuarios - ERP Multisoft')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Gestión de Usuarios</h5>
                <div>
                    <span class="badge bg-label-primary">Total: {{ App\Models\User::count() }} usuarios</span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="alert alert-info d-flex" role="alert">
                            <span class="badge badge-center rounded-pill bg-info border-label-info me-2">
                                <i class="ti ti-user"></i>
                            </span>
                            <div>
                                <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Sistema de Usuarios</h6>
                                <p class="mb-0">Gestiona usuarios, asigna roles y controla permisos del sistema ERP.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            @can('users.create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                    <i class="bx bx-plus me-1"></i>
                                    Crear Usuario
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- Componente Livewire con estilo Vuexy -->
                <div class="table-responsive">
                    <livewire:user-manager />
                </div>
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

<!-- Estadísticas rápidas -->
<div class="row mt-4">
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('vuexy/img/icons/unicons/chart-success.png') }}" alt="usuarios" class="rounded">
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Usuarios Activos</span>
                <h3 class="card-title mb-2">{{ App\Models\User::count() }}</h3>
                <small class="text-success fw-semibold">
                    <i class="bx bx-up-arrow-alt"></i> +100%
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('vuexy/img/icons/unicons/wallet-info.png') }}" alt="admins" class="rounded">
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Administradores</span>
                <h3 class="card-title mb-2">{{ App\Models\User::role('admin')->count() }}</h3>
                <small class="text-info fw-semibold">
                    <i class="bx bx-user-check"></i> Activos
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('vuexy/img/icons/unicons/paypal.png') }}" alt="managers" class="rounded">
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Gerentes</span>
                <h3 class="card-title mb-2">{{ App\Models\User::role('manager')->count() }}</h3>
                <small class="text-warning fw-semibold">
                    <i class="bx bx-user-voice"></i> Gestión
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('vuexy/img/icons/unicons/cc-primary.png') }}" alt="users" class="rounded">
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Usuario Regular</span>
                <h3 class="card-title mb-2">{{ App\Models\User::role('user')->count() }}</h3>
                <small class="text-success fw-semibold">
                    <i class="bx bx-user"></i> Standard
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('vendor-scripts')
<script src="{{ asset('vuexy/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endpush

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