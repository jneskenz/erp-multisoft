@extends('layouts.vuexy')

@section('title', 'Gestión de Grupos Empresariales')

@php
    $dataBreadcrumb = [
        'title' => 'Grupos Empresariales',
        'description' => 'Administración de grupos empresariales del sistema',
        'icon' => 'ti ti-building-bank',
        'breadcrumbs' => [
            ['name' => 'Configuración del Sistema', 'url' => 'javascript:void(0)'],
            ['name' => 'Grupos Empresariales', 'url' => 'javascript:void(0)', 'active' => true],
        ],
        'actions' => [
            [
                'name' => 'Nuevo Grupo',
                'url' => route('admin.grupo-empresarial.create'),
                'typeButton' => 'btn-primary',
                'icon' => 'ti ti-plus',
                'permission' => 'admin'
            ],
        ],
    ];
@endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @include('layouts.vuexy.breadcrumb', $dataBreadcrumb)

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="ti ti-building-bank me-2"></i>
                Lista de Grupos Empresariales
            </h5>
            <span class="badge bg-primary">{{ $grupos->count() }} grupos</span>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-x me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($grupos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>UUID</th>
                                <th>CÓDIGO</th>
                                <th>GRUPO EMPRESARIAL</th>
                                <th>PAÍS ORIGEN</th>
                                <th>EMPRESAS</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupos as $grupo)
                                <tr>
                                    <td>
                                        <span class="badge bg-label-success">{{ Str::limit($grupo->user_uuid, 10) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">{{ $grupo->codigo }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $grupo->nombre }}</strong>
                                            @if($grupo->descripcion)
                                                <br><small class="text-muted">{{ Str::limit($grupo->descripcion, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ $grupo->pais_origen ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary">{{ $grupo->empresas_count }} empresa(s)</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $grupo->estado ? 'success' : 'danger' }}">
                                            {{ $grupo->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.grupo-empresarial.show', $grupo) }}">
                                                    <i class="ti ti-eye me-2"></i>Ver detalle
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.grupo-empresarial.edit', $grupo) }}">
                                                    <i class="ti ti-edit me-2"></i>Editar
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.grupo-empresarial.toggle-status', $grupo) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="ti ti-{{ $grupo->estado ? 'x' : 'check' }} me-2"></i>
                                                        {{ $grupo->estado ? 'Desactivar' : 'Activar' }}
                                                    </button>
                                                </form>
                                                @if($grupo->empresas_count == 0)
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.grupo-empresarial.destroy', $grupo) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Está seguro de eliminar este grupo empresarial?')">
                                                            <i class="ti ti-trash me-2"></i>Eliminar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-building-bank display-4 text-muted"></i>
                    <h4 class="mt-3">No hay grupos empresariales registrados</h4>
                    <p class="text-muted">Comience creando su primer grupo empresarial</p>
                    <a href="{{ route('admin.grupo-empresarial.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>Crear Grupo Empresarial
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection