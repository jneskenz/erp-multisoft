@extends('layouts.vuexy')

@section('title', 'Gestión de Empresas - ERP Multisoft')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-building me-2"></i>
                    Gestión de Empresas
                </h5>
                <div>
                    <span class="badge bg-label-primary">Total: {{ $empresas->count() }} empresas</span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="alert alert-info d-flex" role="alert">
                            <span class="badge badge-center rounded-pill bg-info border-label-info p-3 me-2">
                                <i class="bx bx-building fs-6"></i>
                            </span>
                            <div>
                                <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Sistema de Empresas</h6>
                                <p class="mb-0">Administra las empresas del sistema ERP Multisoft.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            @can('empresas.create')
                                <a href="{{ route('empresas.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus me-1"></i>
                                    Nueva Empresa
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- Mensajes de estado -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible d-flex" role="alert">
                        <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                            <i class="bx bx-check fs-6"></i>
                        </span>
                        <div>
                            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">¡Éxito!</h6>
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible d-flex" role="alert">
                        <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">
                            <i class="bx bx-x fs-6"></i>
                        </span>
                        <div>
                            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Error</h6>
                            <p class="mb-0">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Tabla de empresas -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><i class="bx bx-building me-2"></i>Empresa</th>
                                <th><i class="bx bx-id-card me-2"></i>RUC</th>
                                <th><i class="bx bx-envelope me-2"></i>Email</th>
                                <th><i class="bx bx-phone me-2"></i>Teléfono</th>
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
                                                        {{ strtoupper(substr($empresa->nombre, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $empresa->nombre }}</span>
                                                <small class="text-muted">{{ $empresa->direccion }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $empresa->ruc }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $empresa->email ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $empresa->telefono ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($empresa->activo)
                                            <span class="badge bg-label-success">
                                                <i class="bx bx-check-circle me-1"></i>
                                                Activa
                                            </span>
                                        @else
                                            <span class="badge bg-label-secondary">
                                                <i class="bx bx-x-circle me-1"></i>
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>
                                    @canany(['empresas.edit', 'empresas.delete'])
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('empresas.show', $empresa) }}">
                                                        <i class="bx bx-show-alt me-1"></i> Ver Detalles
                                                    </a></li>
                                                    @can('empresas.edit')
                                                        <li><a class="dropdown-item" href="{{ route('empresas.edit', $empresa) }}">
                                                            <i class="bx bx-edit-alt me-1"></i> Editar
                                                        </a></li>
                                                    @endcan
                                                    @can('empresas.delete')
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><form action="{{ route('empresas.destroy', $empresa) }}" method="POST" 
                                                                  onsubmit="return confirm('¿Estás seguro de eliminar esta empresa?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bx bx-trash me-1"></i> Eliminar
                                                            </button>
                                                        </form></li>
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
                                            <img src="{{ asset('assets/vuexy/img/illustrations/page-misc-error-light.png') }}" 
                                                 alt="No empresas" width="120" class="mb-3">
                                            <h6 class="mb-1">No se encontraron empresas</h6>
                                            <p class="text-muted mb-0">Comienza creando tu primera empresa en el sistema.</p>
                                            @can('empresas.create')
                                                <a href="{{ route('empresas.create') }}" class="btn btn-primary mt-2">
                                                    <i class="bx bx-plus me-1"></i>
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
                @if(method_exists($empresas, 'links'))
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
                        <img src="{{ asset('assets/vuexy/img/icons/unicons/chart-success.png') }}" alt="empresas" class="rounded">
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Empresas</span>
                <h3 class="card-title mb-2">{{ $empresas->count() }}</h3>
                <small class="text-success fw-semibold">
                    <i class="bx bx-up-arrow-alt"></i> Registradas
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('assets/vuexy/img/icons/unicons/wallet-info.png') }}" alt="activas" class="rounded">
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Empresas Activas</span>
                <h3 class="card-title mb-2">{{ $empresas->where('activo', true)->count() }}</h3>
                <small class="text-info fw-semibold">
                    <i class="bx bx-check-circle"></i> Operativas
                </small>
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
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });
});
</script>
@endpush