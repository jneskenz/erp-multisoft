<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Usuarios</h5>
        </div>
        <div class="card-body">
            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input 
                        type="text" 
                        class="form-control" 
                        placeholder="Buscar por nombre o email..." 
                        wire:model.live="search"
                    >
                </div>
                <div class="col-md-4">
                    <select class="form-select" wire:model.live="selectedRole">
                        <option value="">Todos los roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Mensajes -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tabla de usuarios -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Fecha de registro</th>
                            @can('users.edit')
                                <th>Acciones</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse($user->roles as $role)
                                        <span class="badge bg-primary me-1">{{ ucfirst($role->name) }}</span>
                                    @empty
                                        <span class="text-muted">Sin rol</span>
                                    @endforelse
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                @can('users.edit')
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Asignar Rol
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach($roles as $role)
                                                    <li>
                                                        <a class="dropdown-item" 
                                                           href="#" 
                                                           wire:click.prevent="assignRole({{ $user->id }}, '{{ $role->name }}')">
                                                            {{ ucfirst($role->name) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No se encontraron usuarios
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
