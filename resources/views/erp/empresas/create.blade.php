@extends('layouts.vuexy')



@section('title', 'Nueva Empresa - ERP Multisoft')



@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-plus me-2"></i> Nueva Empresa
                </h5>
                <div>
                    <a href="{{ route('empresas.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Volver
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="alert alert-info d-flex mb-4" role="alert">
                    <span class="badge badge-center rounded-pill bg-info border-label-info me-2">
                        <i class="ti ti-info-circle"></i>
                    </span>
                    <div>
                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Información Importante</h6>
                        <p class="mb-0">Complete todos los campos requeridos para registrar una nueva empresa en el sistema.</p>
                    </div>
                </div>

                <form action="{{ route('empresas.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Información Básica -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold">
                                <i class="bx bx-building me-2"></i> Información Básica
                            </h6>
                            <hr>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">
                                Nombre de la Empresa <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('nombre') is-invalid @enderror"
                                id="nombre" name="nombre"
                                value="{{ old('nombre') }}"
                                placeholder="Ingrese el nombre de la empresa"
                                required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="ruc" class="form-label">
                                RUC <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('ruc') is-invalid @enderror"
                                id="ruc" name="ruc"
                                value="{{ old('ruc') }}"
                                placeholder="20123456789"
                                maxlength="11"
                                required>
                            @error('ruc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Ingrese el RUC de 11 dígitos</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="direccion" class="form-label">
                                Dirección <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror"
                                id="direccion" name="direccion"
                                rows="3"
                                placeholder="Ingrese la dirección completa de la empresa"
                                required>{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="row mb-4 mt-4">
                        <div class="col-12">
                            <h6 class="fw-bold">
                                <i class="bx bx-phone me-2"></i> Información de Contacto
                            </h6>
                            <hr>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text"
                                class="form-control @error('telefono') is-invalid @enderror"
                                id="telefono" name="telefono"
                                value="{{ old('telefono') }}"
                                placeholder="(01) 123-4567">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email"
                                value="{{ old('email') }}"
                                placeholder="empresa@ejemplo.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="row mb-4 mt-4">
                        <div class="col-12">
                            <h6 class="fw-bold">
                                <i class="bx bx-cog me-2"></i> Configuración
                            </h6>
                            <hr>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="representante_legal" class="form-label">Representante Legal</label>
                            <input type="text"
                                class="form-control @error('representante_legal') is-invalid @enderror"
                                id="representante_legal" name="representante_legal"
                                value="{{ old('representante_legal') }}"
                                placeholder="Nombre del representante legal">
                            @error('representante_legal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input"
                                    type="checkbox"
                                    id="activo" name="activo"
                                    value="1"
                                    {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">Empresa Activa</label>
                            </div>
                            <div class="form-text">La empresa estará disponible para operaciones</div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('empresas.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-x me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-check me-1"></i> Crear Empresa
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Validación del formulario
    const form = document.querySelector('.needs-validation');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    // Formato de RUC
    const rucInput = document.getElementById('ruc');
    if (rucInput) {
        rucInput.addEventListener('input', function(e) {
            // Solo permitir números
            this.value = this.value.replace(/\D/g, '');

            // Limitar a 11 dígitos
            if (this.value.length > 11) {
                this.value = this.value.substr(0, 11);
            }
        });
    }

});
</script>
@endpush
