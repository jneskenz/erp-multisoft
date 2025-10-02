@extends('layouts.app-erp')

@section('title', 'Editar Local')

@php

    $breadcrumbs = [
        'title' => 'Gestión de Locales',
        'description' => '',
        'icon' => 'ti ti-building-store',
        'items' => [
            ['name' => 'Config. Administrativa', 'url' => route('home')],
            ['name' => 'Locales', 'url' => route('locales.index')],
            ['name' => 'Editar local', 'url' => 'javascript:void(0)', 'active' => true],
        ],
        'actions' => [
            [
                'name' => 'Regresar',
                'url' => route('locales.index'),
                'typeButton' => 'btn-label-dark',
                'icon' => 'ti ti-arrow-left',
                'permission' => 'locales.view'
            ],

        ],
    ];

@endphp

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb Component -->
        <x-erp.breadcrumbs :items="$breadcrumbs">
            <x-slot:extra>
                @can('empresas.view')
                <a href="{{ route('empresas.index') }}" class="btn btn-label-dark waves-effect">
                    <i class="ti ti-arrow-left me-2"></i>
                    Regresar
                </a>
                @endcan
            </x-slot:extra>
        </x-erp.breadcrumbs>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">

                    {{-- $dataHeaderCard  --}}
                    <x-erp.card-header 
                        title="Editando el local" 
                        description="{{ $local->nombre_comercial ?? $local->razon_social }}"
                        textColor="text-warning"
                        icon="ti ti-edit"
                        iconColor="bg-warning"
                        estado="{{ $local->estado }}"
                    >
                        @can('locales.view')
                            <a href="{{ route('locales.show', $local) }}" class="btn btn-info waves-effect">
                                <i class="ti ti-list-search me-2"></i>
                                Ver detalle
                            </a>                        
                        @endcan
                    </x-erp.card-header>

                    
                    <div class="card-body">
                        <!-- Mensajes de estado -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible d-flex" role="alert">
                                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                                <div>
                                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">¡Éxito!</h6>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bx bx-error-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <form action="{{ route('locales.update', $local) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('descripcion') is-invalid @enderror" 
                                        id="descripcion" 
                                        name="descripcion" 
                                        value="{{ old('descripcion', $local->descripcion) }}" 
                                        required
                                        placeholder="Ej: Local Principal Centro"
                                    >
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('codigo') is-invalid @enderror" 
                                        id="codigo" 
                                        name="codigo" 
                                        value="{{ old('codigo', $local->codigo) }}" 
                                        required
                                        placeholder="Ej: LOC001"
                                        style="text-transform: uppercase"
                                    >
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
                                                {{ old('tipo_local_id', $local->tipo_local_id) == $tipo->id ? 'selected' : '' }}>
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
                                <select class="form-select @error('sede_id') is-invalid @enderror" id="sede_id" name="sede_id" required>
                                    <option value="">Seleccionar sede...</option>
                                    @foreach($sedes as $sede)
                                        <option value="{{ $sede->id }}" 
                                            {{ old('sede_id', $local->sede_id) == $sede->id ? 'selected' : '' }}>
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
                                <textarea 
                                    class="form-control @error('direccion') is-invalid @enderror" 
                                    id="direccion" 
                                    name="direccion" 
                                    rows="3"
                                    placeholder="Dirección completa del local"
                                >{{ old('direccion', $local->direccion) }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input 
                                        type="email" 
                                        class="form-control @error('correo') is-invalid @enderror" 
                                        id="correo" 
                                        name="correo" 
                                        value="{{ old('correo', $local->correo) }}"
                                        placeholder="correo@empresa.com"
                                    >
                                    @error('correo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('telefono') is-invalid @enderror" 
                                        id="telefono" 
                                        name="telefono" 
                                        value="{{ old('telefono', $local->telefono) }}"
                                        placeholder="+51 987654321"
                                    >
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('whatsapp') is-invalid @enderror" 
                                        id="whatsapp" 
                                        name="whatsapp" 
                                        value="{{ old('whatsapp', $local->whatsapp) }}"
                                        placeholder="+51 987654321"
                                    >
                                    @error('whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="estado" 
                                        name="estado" 
                                        value="1" 
                                        {{ old('estado', $local->estado) ? 'checked' : '' }}
                                    >
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
                                @can('locales.edit')
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i>
                                    Actualizar Local
                                </button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>        

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-info-circle me-2"></i>
                            Información del Local
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-bold">ID:</td>
                                <td>{{ $local->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Creado:</td>
                                <td>{{ $local->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Actualizado:</td>
                                <td>{{ $local->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Estado:</td>
                                <td>
                                    <span class="badge bg-{{ $local->estado ? 'success' : 'secondary' }}">
                                        {{ $local->estado ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-help-circle me-2"></i>
                            Ayuda
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="bx bx-info-circle me-1"></i>
                                Información importante
                            </h6>
                            <ul class="mb-0 ps-3">
                                <li>El código debe ser único en todo el sistema</li>
                                <li>Los campos marcados con (*) son obligatorios</li>
                                <li>Los cambios se aplicarán inmediatamente</li>
                                <li>El historial de cambios se registra automáticamente</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

@endsection

@section('page-script')
    <script>
        console.log('Editando local ID:', {{ $local->id }});
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
                const confirmMessage = `⚠️ ADVERTENCIA: Está a punto de desactivar el tipo de local "${data.nombre}".\n\n` +
                                     `Al desactivar este tipo de local:\n` +
                                     `• No aparecerá en la lista de selección para nuevos locales\n` +
                                     `• Los locales existentes de este tipo mantendrán su configuración\n\n` +
                                     `¿Está seguro de que desea continuar?`;
                
                if (!confirm(confirmMessage)) {
                    return; // Cancelar la operación
                }
                
                // Segunda confirmación más específica
                const finalConfirmMessage = `🔴 CONFIRMACIÓN FINAL\n\n` +
                                          `¿Confirma que desea DESACTIVAR el tipo de local "${data.nombre}"?\n\n` +
                                          `Esta acción afectará la disponibilidad del tipo para futuros registros.`;
                
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
                    
                    // Mensaje específico si se desactivó el tipo
                    if (!data.estado) {
                        alert(`✅ ${result.message}\n\n⚠️ El tipo de local "${data.nombre}" ha sido desactivado y ya no aparecerá en la lista de selección.`);
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