@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>¡Bienvenido a tu Dashboard!</h4>
                    <p class="mb-3">{{ __('You are logged in!') }}</p>
                    
                    <!-- Test Bootstrap components -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="alert alert-info" role="alert">
                                <h5 class="alert-heading">Bootstrap funciona correctamente!</h5>
                                <p>Este es un ejemplo de una alerta de Bootstrap.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Abrir Modal de Prueba
                            </button>
                        </div>
                    </div>

                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="btn-group" role="group">
                        @can('users.view')
                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Gestionar Usuarios</a>
                        @endcan
                        @can('roles.view')
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Gestionar Roles</a>
                        @endcan
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Modal Bootstrap</button>
                    </div>

                    <!-- Componente Livewire -->
                    @can('users.view')
                        <div class="mt-4">
                            <livewire:user-manager />
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal de Prueba</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¡Bootstrap JavaScript funciona correctamente!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
