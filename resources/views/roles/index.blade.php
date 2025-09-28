@extends('layouts.vuexy')

@section('title', 'Gestión de Roles - ERP Multisoft')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Gestión de Roles y Permisos</h5>
                <div>
                    <span class="badge bg-label-success">Total: {{ Spatie\Permission\Models\Role::count() }} roles</span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="alert alert-warning d-flex" role="alert">
                            <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2">
                                <i class="bx bx-shield fs-6"></i>
                            </span>
                            <div>
                                <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Control de Acceso</h6>
                                <p class="mb-0">Administra roles y permisos para controlar el acceso a diferentes módulos del sistema ERP.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-end">
                            @can('roles.create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                                    <i class="bx bx-plus me-1"></i>
                                    Crear Rol
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- Lista de roles -->
                <div class="row">
                    @foreach(Spatie\Permission\Models\Role::all() as $role)
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">
                                                @if($role->name === 'admin')
                                                    <i class="bx bx-crown text-warning me-2"></i>
                                                @elseif($role->name === 'manager')
                                                    <i class="bx bx-user-voice text-info me-2"></i>
                                                @else
                                                    <i class="bx bx-user text-success me-2"></i>
                                                @endif
                                                {{ ucfirst($role->name) }}
                                            </h5>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="roleCard{{ $role->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="roleCard{{ $role->id }}">
                                                @can('roles.edit')
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="bx bx-edit-alt me-1"></i> Editar
                                                    </a>
                                                @endcan
                                                @can('roles.delete')
                                                    @if($role->name !== 'admin')
                                                        <a class="dropdown-item text-danger" href="javascript:void(0);">
                                                            <i class="bx bx-trash me-1"></i> Eliminar
                                                        </a>
                                                    @endif
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="d-flex align-items-center mb-2">
                                                    <i class="bx bx-user text-muted me-1"></i>
                                                    <span class="fw-normal">Usuarios</span>
                                                </h6>
                                                <h4 class="mb-0">{{ App\Models\User::role($role->name)->count() }}</h4>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="d-flex align-items-center mb-2">
                                                    <i class="bx bx-lock-open text-muted me-1"></i>
                                                    <span class="fw-normal">Permisos</span>
                                                </h6>
                                                <h4 class="mb-0">{{ $role->permissions->count() }}</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Permisos del rol -->
                                    @if($role->permissions->count() > 0)
                                        <div class="mt-3">
                                            <h6 class="card-title">Permisos Asignados:</h6>
                                            <div class="demo-inline-spacing">
                                                @foreach($role->permissions->take(6) as $permission)
                                                    <span class="badge bg-label-primary">{{ $permission->name }}</span>
                                                @endforeach
                                                @if($role->permissions->count() > 6)
                                                    <span class="badge bg-label-secondary">+{{ $role->permissions->count() - 6 }} más</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Descripción del rol -->
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            @if($role->name === 'admin')
                                                Acceso completo al sistema. Control total sobre usuarios, configuraciones y módulos.
                                            @elseif($role->name === 'manager')
                                                Gestión operativa del sistema. Acceso a reportes y administración de datos.
                                            @else
                                                Acceso estándar del sistema. Funcionalidades básicas de consulta y operación.
                                            @endif
                                        </small>
                                    </div>

                                    @can('roles.edit')
                                        <div class="mt-3 pt-3 border-top">
                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}">
                                                <i class="bx bx-edit me-1"></i>
                                                Gestionar Permisos
                                            </button>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tabla de permisos del sistema -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bx bx-key me-2"></i>
                                    Permisos del Sistema
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Permiso</th>
                                                <th>Admin</th>
                                                <th>Manager</th>
                                                <th>User</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(Spatie\Permission\Models\Permission::all() as $permission)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $permission->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ ucwords(str_replace('.', ' ', $permission->name)) }}</small>
                                                    </td>
                                                    @foreach(['admin', 'manager', 'user'] as $roleName)
                                                        @php
                                                            $role = Spatie\Permission\Models\Role::where('name', $roleName)->first();
                                                            $hasPermission = $role && $role->hasPermissionTo($permission);
                                                        @endphp
                                                        <td>
                                                            @if($hasPermission)
                                                                <span class="badge bg-success">
                                                                    <i class="bx bx-check"></i> Sí
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">
                                                                    <i class="bx bx-x"></i> No
                                                                </span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear rol -->
@can('roles.create')
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">
                    <i class="bx bx-shield-plus me-2"></i>
                    Crear Nuevo Rol
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="role_name" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="role_name" name="name" placeholder="Ej: editor, supervisor, etc." required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Permisos del Rol</label>
                            <div class="row">
                                @foreach(Spatie\Permission\Models\Permission::all() as $permission)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ ucwords(str_replace('.', ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
                        Crear Rol
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
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
    
    // Seleccionar todos los permisos
    $('#selectAllPermissions').change(function() {
        $('input[name="permissions[]"]').prop('checked', this.checked);
    });
});
</script>
@endpush