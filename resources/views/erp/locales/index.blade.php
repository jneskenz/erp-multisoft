@extends('layouts.vuexy')

@section('title', 'Locales')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Gestión de Locales</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Locales</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @livewire('erp.local-table')

</div>
@endsection

@section('page-script')
    <script>
        // Listener para eventos Livewire
        window.addEventListener('local-updated', function (e) {
            toastr.success(e.detail.message || 'Local actualizado correctamente');
        });

        window.addEventListener('local-deleted', function (e) {
            toastr.success(e.detail.message || 'Local eliminado correctamente');
        });

        window.addEventListener('local-error', function (e) {
            toastr.error(e.detail.message || 'Error al procesar la solicitud');
        });
    </script>
@endsection