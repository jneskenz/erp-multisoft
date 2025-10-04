@extends('layouts.app-erp')

@section('title', 'Crear Local')

@php

    $breadcrumbs = [
        'title' => 'Gestión de Locales',
        'description' => 'Administra los locales del sistema',
        'icon' => 'ti ti-building',
        'items' => [
            ['name' => 'Config. Administrativa', 'url' => route('home')],
            ['name' => 'Locales', 'url' => route('locales.index')],
            ['name' => 'Crear local', 'url' => 'javascript:void(0);'],
        ],
        'actions' => [
            [
                'name' => 'Regresar',
                'url' => route('locales.index'),
                'typeButton' => 'btn-label-dark',
                'icon' => 'ti ti-arrow-left',
                'permission' => 'locales.view',
            ],
        ],
    ];

    $dataHeaderCard = [
        'title' => 'Formulario de registro',
        'description' => '',
        'textColor' => '',
        'icon' => 'ti ti-plus',
        'iconColor' => 'bg-label-info',
        'actions' => [],
    ];

@endphp


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

    <x-erp.breadcrumbs :items="$breadcrumbs">
        <x-slot:extra>
            @can('locales.view')
            <a href="{{ route('locales.index') }}" class="btn btn-label-dark waves-effect">
                <i class="ti ti-arrow-left me-2"></i>
                Regresar
            </a>
            @endcan
        </x-slot:extra>
    </x-erp.breadcrumbs>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    
                    <x-erp.card-header 
                        title="Formulario de registro" 
                        description=""
                        textColor="text-plus"
                        icon="ti ti-building"
                        iconColor="bg-label-info"
                    >
                    </x-erp.card-header>

                    <div class="card-body">

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="ti ti-error me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('locales.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="descripcion" class="form-label">Descripción <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                                        id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required
                                        placeholder="Ej: Local Principal Centro">
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="codigo" class="form-label">Código <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                        id="codigo" name="codigo" value="{{ old('codigo') }}" required
                                        placeholder="Ej: LOC001" style="text-transform: uppercase">
                                    @error('codigo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Solo letras, números, guiones y guiones bajos</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tipo_local_id" class="form-label">Tipo de Local</label>
                                <div class="input-group">
                                    <select class="form-select @error('tipo_local_id') is-invalid @enderror" 
                                            id="tipo_local_id" name="tipo_local_id">
                                        <option value="">Seleccionar tipo de local...</option>
                                        @foreach($tipoLocales as $tipo)
                                            <option value="{{ $tipo->id }}" 
                                                {{ old('tipo_local_id') == $tipo->id ? 'selected' : '' }}>
                                                {{ $tipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-primary" id="btnManageTipoLocal">
                                        <i class="ti ti-settings"></i>
                                    </button>
                                </div>
                                @error('tipo_local_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sede_id" class="form-label">Sede <span class="text-danger">*</span></label>
                                <select class="form-select @error('sede_id') is-invalid @enderror" id="sede_id"
                                    name="sede_id" required>
                                    <option value="">Seleccionar sede...</option>
                                    @foreach ($sedes as $sede)
                                        <option value="{{ $sede->id }}"
                                            {{ old('sede_id') == $sede->id ? 'selected' : '' }}>
                                            {{ $sede->nombre }} - {{ $sede->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sede_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3"
                                    placeholder="Dirección completa del local">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control @error('correo') is-invalid @enderror"
                                        id="correo" name="correo" value="{{ old('correo') }}"
                                        placeholder="correo@empresa.com">
                                    @error('correo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                        id="telefono" name="telefono" value="{{ old('telefono') }}"
                                        placeholder="+51 987654321">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                                        id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}"
                                        placeholder="+51 987654321">
                                    @error('whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="estado" name="estado"
                                        value="1" {{ old('estado', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="estado">
                                        Local activo
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('locales.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-x me-1"></i>
                                    Cancelar
                                </a>
                                @can('locales.create')
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i>
                                    Guardar Local
                                </button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-help-circle me-2"></i>
                            Ayuda
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="ti ti-info-circle me-1"></i>
                                Información importante
                            </h6>
                            <ul class="mb-0 ps-3">
                                <li>El código debe ser único en todo el sistema</li>
                                <li>Los campos marcados con (*) son obligatorios</li>
                                <li>El local estará asociado a la sede seleccionada</li>
                                <li>Puedes modificar esta información posteriormente</li>
                            </ul>
                        </div>

                        <div class="mt-3">
                            <h6>Formato de código recomendado:</h6>
                            <code>LOC001, LOC002, LOC003...</code>
                            <p class="text-muted mt-2">
                                <small>Usa un formato consistente para facilitar la identificación</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal para gestionar tipos de locales -->
<div class="modal fade" id="modalTipoLocal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTipoLocalTitle">Gestionar Tipo de Local</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTipoLocal">
                <div class="modal-body">
                    <input type="hidden" id="tipoLocalId" name="id">
                    
                    <div class="mb-3">
                        <label for="nombreTipoLocal" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombreTipoLocal" name="nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcionTipoLocal" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionTipoLocal" name="descripcion" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="estadoTipoLocal" name="estado" checked>
                            <label class="form-check-label" for="estadoTipoLocal">
                                Activo
                            </label>
                        </div>
                        <div class="alert alert-warning mt-2 d-none" id="alertEstadoDesactivado">
                            <i class="ti ti-alert-triangle me-1"></i>
                            <strong>Atención:</strong> Al desmarcar esta opción, el tipo de local no estará disponible para nuevos registros.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <span id="btnSubmitText">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('page-script')
    <script>
        // Auto-generar código basado en descripción
        document.getElementById('descripcion').addEventListener('input', function() {
            const descripcion = this.value.toUpperCase();
            const codigoField = document.getElementById('codigo');

            if (codigoField.value === '') {
                // Generar código simple basado en las primeras letras
                const palabras = descripcion.split(' ');
                let codigo = '';

                if (palabras.length >= 2) {
                    codigo = palabras[0].substring(0, 3) + palabras[1].substring(0, 3);
                } else {
                    codigo = descripcion.substring(0, 6);
                }

                // Limpiar caracteres especiales
                codigo = codigo.replace(/[^A-Z0-9]/g, '');
                codigoField.value = codigo;
            }
        });

        // Convertir código a mayúsculas
        document.getElementById('codigo').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Gestión del modal de tipos de locales
        const modalTipoLocal = new bootstrap.Modal(document.getElementById('modalTipoLocal'));
        const formTipoLocal = document.getElementById('formTipoLocal');
        const selectTipoLocal = document.getElementById('tipo_local_id');
        const estadoCheckbox = document.getElementById('estadoTipoLocal');
        const alertEstado = document.getElementById('alertEstadoDesactivado');
        let editingTipoLocalId = null;

        // Mostrar/ocultar alerta según el estado del checkbox
        estadoCheckbox.addEventListener('change', function() {
            if (this.checked) {
                alertEstado.classList.add('d-none');
            } else {
                alertEstado.classList.remove('d-none');
            }
        });

        // Abrir modal para crear o editar
        document.getElementById('btnManageTipoLocal').addEventListener('click', function() {
            const selectedValue = selectTipoLocal.value;
            
            if (selectedValue) {
                // Editar tipo existente
                editingTipoLocalId = selectedValue;
                loadTipoLocal(selectedValue);
                document.getElementById('modalTipoLocalTitle').textContent = 'Editar Tipo de Local';
                document.getElementById('btnSubmitText').textContent = 'Actualizar';
            } else {
                // Crear nuevo tipo
                editingTipoLocalId = null;
                formTipoLocal.reset();
                document.getElementById('estadoTipoLocal').checked = true;
                alertEstado.classList.add('d-none'); // Ocultar alerta al crear nuevo
                document.getElementById('modalTipoLocalTitle').textContent = 'Nuevo Tipo de Local';
                document.getElementById('btnSubmitText').textContent = 'Guardar';
            }
            
            modalTipoLocal.show();
        });

        // Cargar datos del tipo de local para edición
        function loadTipoLocal(id) {
            fetch(`/api/tipo-locales/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tipoLocalId').value = data.id;
                    document.getElementById('nombreTipoLocal').value = data.nombre;
                    document.getElementById('descripcionTipoLocal').value = data.descripcion || '';
                    document.getElementById('estadoTipoLocal').checked = data.estado;
                    
                    // Mostrar/ocultar alerta según el estado cargado
                    if (data.estado) {
                        alertEstado.classList.add('d-none');
                    } else {
                        alertEstado.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los datos del tipo de local');
                });
        }

        // Manejar envío del formulario
        formTipoLocal.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(formTipoLocal);
            const data = {
                nombre: formData.get('nombre'),
                descripcion: formData.get('descripcion'),
                estado: formData.get('estado') ? true : false
            };
            
            // Verificar si el estado está desmarcado y requiere confirmación
            if (!data.estado) {
                const confirmMessage = `⚠️ ADVERTENCIA: Está a punto de crear el tipo de local "${data.nombre}" en estado DESACTIVADO.\n\n` +
                                     `Al crear este tipo de local desactivado:\n` +
                                     `• No aparecerá en la lista de selección para nuevos locales\n` +
                                     `• Tendrá que activarlo posteriormente si desea usarlo\n\n` +
                                     `¿Está seguro de que desea continuar?`;
                
                if (!confirm(confirmMessage)) {
                    return; // Cancelar la operación
                }
                
                // Segunda confirmación más específica
                const finalConfirmMessage = `🔴 CONFIRMACIÓN FINAL\n\n` +
                                          `¿Confirma que desea crear el tipo de local "${data.nombre}" DESACTIVADO?\n\n` +
                                          `Puede activarlo posteriormente desde el listado de tipos.`;
                
                if (!confirm(finalConfirmMessage)) {
                    return; // Cancelar la operación
                }
            }
            
            const url = editingTipoLocalId ? `/api/tipo-locales/${editingTipoLocalId}` : '/api/tipo-locales';
            const method = editingTipoLocalId ? 'PUT' : 'POST';
            
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    modalTipoLocal.hide();
                    refreshTipoLocalSelect();
                    
                    // Mensaje específico si se creó desactivado
                    if (!data.estado) {
                        alert(`✅ ${result.message}\n\n⚠️ El tipo de local "${data.nombre}" fue creado DESACTIVADO y no aparecerá en la lista de selección hasta que lo active.`);
                    } else {
                        alert(result.message);
                    }
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
        });

        // Refrescar el select de tipos de locales
        function refreshTipoLocalSelect() {
            fetch('/api/tipo-locales')
                .then(response => response.json())
                .then(data => {
                    const currentValue = selectTipoLocal.value;
                    selectTipoLocal.innerHTML = '<option value="">Seleccionar tipo de local...</option>';
                    
                    data.forEach(tipo => {
                        if (tipo.estado) {
                            const option = new Option(tipo.nombre, tipo.id);
                            selectTipoLocal.add(option);
                        }
                    });
                    
                    // Restaurar selección si existía
                    if (currentValue) {
                        selectTipoLocal.value = currentValue;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
