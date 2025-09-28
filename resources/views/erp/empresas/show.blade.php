@extends('layouts.app')

@section('title', 'Detalle de Empresa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title mb-0">{{ $empresa->nombre }}</h3>
                            <span class="badge badge-{{ $empresa->estado === 'activo' ? 'success' : 'danger' }} mt-1">
                                {{ ucfirst($empresa->estado) }}
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                @can('empresas.edit')
                                    <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                @endcan
                                <a href="{{ route('empresas.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width: 35%;">Nombre</th>
                                        <td>{{ $empresa->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">RUC</th>
                                        <td>{{ $empresa->ruc }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Razón Social</th>
                                        <td>{{ $empresa->razon_social }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Dirección</th>
                                        <td>{{ $empresa->direccion }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Teléfono</th>
                                        <td>{{ $empresa->telefono ?? 'No registrado' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width: 35%;">Email</th>
                                        <td>
                                            @if($empresa->email)
                                                <a href="mailto:{{ $empresa->email }}">{{ $empresa->email }}</a>
                                            @else
                                                No registrado
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Website</th>
                                        <td>
                                            @if($empresa->website)
                                                <a href="{{ $empresa->website }}" target="_blank">{{ $empresa->website }}</a>
                                            @else
                                                No registrado
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Estado</th>
                                        <td>
                                            <span class="badge badge-{{ $empresa->estado === 'activo' ? 'success' : 'danger' }}">
                                                {{ ucfirst($empresa->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Fecha de Registro</th>
                                        <td>{{ $empresa->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Última Actualización</th>
                                        <td>{{ $empresa->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    {{-- Sección de actividades (si tienes Spatie Activity Log configurado) --}}
                    @if($empresa->activities()->exists())
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Historial de Actividades</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Descripción</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($empresa->activities()->latest()->take(10)->get() as $activity)
                                                <tr>
                                                    <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $activity->description }}</td>
                                                    <td>{{ $activity->causer->name ?? 'Sistema' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            @can('empresas.delete')
                                <form method="POST" 
                                      action="{{ route('empresas.destroy', $empresa) }}" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta empresa? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar Empresa
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection