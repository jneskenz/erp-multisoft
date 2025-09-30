@extends('layouts.vuexy')

@section('title', 'Ver Local')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Local: {{ $local->descripcion }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('locales.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('locales.index') }}">Locales</a></li>
                            <li class="breadcrumb-item active">Ver</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1">Earning Reports</h5>
                            <p class="card-subtitle">Weekly Earnings Overview</p>
                        </div>
                        <div class="dropdown">
                            <button
                                class="btn btn-text-secondary btn-icon rounded-pill text-body-secondary border-0 me-n1 waves-effect"
                                type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-base ti tabler-dots-vertical icon-22px text-body-secondary"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Download</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="ti ti-building"></i>
                            </div>
                            <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Direct Source</h6>
                                    <small class="text-body">Direct link click</small>
                                </div>
                                <div class="d-flex align-content-center flex-wrap gap-3 mb-4 mb-md-0">
                                    <div class="d-flex gap-3">
                                        <a href="javascript:void(0);"
                                            class="btn btn-label-{{ $local->estado ? 'success' : 'warning' }} waves-effect">
                                            <i class="ti ti-{{ $local->estado ? 'check' : 'x' }} me-2"></i>
                                            {{ $local->estado ? 'ACTIVO' : 'SUSPENDIDO' }}
                                        </a>
                                        @can('locales.edit')
                                            <a href="{{ route('locales.edit', $local->id) }}"
                                                class="btn btn-primary btn-sm waves-effect">
                                                <i class="ti ti-edit me-2"></i>
                                                Editar Local
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">

                            <h5 class="card-title mb-0">
                                <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                    <i class="ti ti-building"></i>
                                </div>

                                <h6 class="mb-0">Información del Local</h6>
                                <small class="text-body">Direct link click</small>
                            </h5>
                            <div class="d-flex align-content-center flex-wrap gap-3 mb-4 mb-md-0">
                                <div class="d-flex gap-3">
                                    <a href="#"
                                        class="btn btn-label-{{ $local->estado ? 'success' : 'warning' }} waves-effect">
                                        <i class="ti ti-{{ $local->estado ? 'check' : 'x' }} me-2"></i>
                                        {{ $local->estado ? 'ACTIVO' : 'SUSPENDIDO' }}
                                    </a>
                                    @can('locales.edit')
                                        <a href="{{ route('locales.edit', $local->id) }}" class="btn btn-primary waves-effect">
                                            <i class="ti ti-edit me-2"></i>
                                            Editar Local
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="30%">Descripción:</td>
                                        <td>{{ $local->descripcion }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Código:</td>
                                        <td>
                                            <span class="badge bg-light text-dark fs-6">{{ $local->codigo }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sede:</td>
                                        <td>
                                            {{ $local->sede->nombre ?? 'Sin sede asignada' }}
                                            @if ($local->sede)
                                                <br><small class="text-muted">{{ $local->sede->descripcion }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Dirección:</td>
                                        <td>
                                            @if ($local->direccion)
                                                {{ $local->direccion }}
                                            @else
                                                <span class="text-muted">No especificada</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="30%">Correo:</td>
                                        <td>
                                            @if ($local->correo)
                                                <a href="mailto:{{ $local->correo }}">{{ $local->correo }}</a>
                                            @else
                                                <span class="text-muted">No especificado</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Teléfono:</td>
                                        <td>
                                            @if ($local->telefono)
                                                <a href="tel:{{ $local->telefono }}">{{ $local->telefono }}</a>
                                            @else
                                                <span class="text-muted">No especificado</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">WhatsApp:</td>
                                        <td>
                                            @if ($local->whatsapp)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $local->whatsapp) }}"
                                                    target="_blank">
                                                    {{ $local->whatsapp }}
                                                    <i class="bx bx-link-external ms-1"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">No especificado</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Estado:</td>
                                        <td>
                                            <span class="badge bg-{{ $local->estado ? 'success' : 'secondary' }}">
                                                <i class="bx bx-{{ $local->estado ? 'check' : 'x' }} me-1"></i>
                                                {{ $local->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($local->sede && $local->sede->empresa)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-buildings me-2"></i>
                                Información de la Empresa
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold" width="30%">Empresa:</td>
                                            <td>{{ $local->sede->empresa->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Código:</td>
                                            <td>{{ $local->sede->empresa->codigo }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold" width="30%">Sede:</td>
                                            <td>{{ $local->sede->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Código Sede:</td>
                                            <td>{{ $local->sede->codigo }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-time me-2"></i>
                            Información del Sistema
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-bold">ID:</td>
                                <td>#{{ $local->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Creado:</td>
                                <td>
                                    {{ $local->created_at->format('d/m/Y H:i') }}
                                    <br><small class="text-muted">{{ $local->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Actualizado:</td>
                                <td>
                                    {{ $local->updated_at->format('d/m/Y H:i') }}
                                    <br><small class="text-muted">{{ $local->updated_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Acciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('locales.edit', $local->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i>
                                Editar Local
                            </a>

                            <button type="button" class="btn btn-{{ $local->estado ? 'warning' : 'success' }}"
                                onclick="toggleStatus({{ $local->id }}, {{ $local->estado ? 'false' : 'true' }})">
                                <i class="bx bx-{{ $local->estado ? 'x' : 'check' }} me-1"></i>
                                {{ $local->estado ? 'Desactivar' : 'Activar' }}
                            </button>

                            <hr>

                            <button type="button" class="btn btn-danger"
                                onclick="confirmDelete({{ $local->id }}, '{{ $local->descripcion }}')">
                                <i class="bx bx-trash me-1"></i>
                                Eliminar Local
                            </button>
                        </div>
                    </div>
                </div>

                @if ($local->direccion && config('services.google_maps.api_key'))
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-map me-2"></i>
                                Ubicación
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="ratio ratio-16x9">
                                <iframe
                                    src="https://maps.google.com/maps?q={{ urlencode($local->direccion) }}&output=embed"
                                    style="border:0;" allowfullscreen="" loading="lazy">
                                </iframe>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">{{ $local->direccion }}</small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal de confirmación de eliminación --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bx bx-error-circle display-1 text-warning"></i>
                        <h5 class="mt-3">¿Estás seguro?</h5>
                        <p class="text-muted">
                            Vas a eliminar el local: <br>
                            <strong id="localToDelete"></strong>
                        </p>
                        <p class="text-danger">
                            <small>Esta acción no se puede deshacer.</small>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-trash me-1"></i>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        function confirmDelete(localId, localName) {
            document.getElementById('localToDelete').textContent = localName;
            document.getElementById('deleteForm').action = `{{ route('locales.index') }}/${localId}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function toggleStatus(localId, newStatus) {
            if (confirm('¿Estás seguro de cambiar el estado del local?')) {
                // Implementar llamada AJAX aquí si es necesario
                window.location.href = `{{ route('locales.index') }}/${localId}/toggle-status`;
            }
        }
    </script>
@endsection
