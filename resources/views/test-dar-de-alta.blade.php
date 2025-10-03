<!DOCTYPE html>
<html>
<head>
    <title>Test de Dar de Alta Lead Cliente</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .card { border: 1px solid #ddd; padding: 20px; margin: 10px 0; border-radius: 5px; }
        .btn { padding: 10px 15px; margin: 5px; border: none; border-radius: 3px; cursor: pointer; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-primary { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <h1>Test de Funcionalidad: Dar de Alta Lead Cliente</h1>
    
    <div class="card">
        <h3>Leads Clientes Disponibles</h3>
        @foreach($leads as $lead)
        <div style="border-bottom: 1px solid #eee; padding: 10px; margin: 10px 0;">
            <h4>{{ $lead->empresa }} ({{ $lead->cliente }})</h4>
            <p><strong>Email:</strong> {{ $lead->correo }}</p>
            <p><strong>RUC:</strong> {{ $lead->ruc }}</p>
            <p><strong>Plan:</strong> {{ $lead->plan_interes }}</p>
            <p><strong>Estado:</strong> {{ $lead->estado ? 'Activo' : 'Inactivo' }}</p>
            
            <button class="btn btn-success" onclick="darDeAlta({{ $lead->id }}, '{{ $lead->empresa }}', '{{ $lead->cliente }}')">
                Dar de Alta
            </button>
        </div>
        @endforeach
    </div>

    <div class="card">
        <h3>Roles Disponibles</h3>
        @foreach($roles as $role)
        <div style="padding: 5px;">
            <strong>{{ $role->name }}</strong> - {{ $role->permissions->count() }} permisos
        </div>
        @endforeach
    </div>

    <script>
        function darDeAlta(leadId, empresaName, clienteName) {
            Swal.fire({
                title: '¿Dar de Alta Lead Cliente?',
                html: `
                    <div class="text-start">
                        <p>¿Está seguro de dar de alta el lead?</p>
                        <ul class="list-unstyled mt-3">
                            <li><strong>Empresa:</strong> ${empresaName}</li>
                            <li><strong>Cliente:</strong> ${clienteName}</li>
                        </ul>
                        <div class="alert alert-info mt-3" style="background-color: #d1ecf1; padding: 10px; border-radius: 5px;">
                            <strong>Esto creará:</strong>
                            <ul class="mb-0 mt-2">
                                <li>✓ Un grupo empresarial</li>
                                <li>✓ Un usuario de acceso</li>
                                <li>✓ Asignación de rol según plan</li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, dar de alta',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Procesando...',
                        text: 'Creando grupo empresarial y usuario',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    // Enviar con fetch
                    fetch(`/admin/lead-cliente/${leadId}/dar-de-alta`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '¡Éxito!',
                                html: `
                                    <div class="text-start">
                                        <p>${data.message}</p>
                                        <div style="background-color: #d4edda; padding: 10px; border-radius: 5px; margin-top: 15px;">
                                            <strong>Detalles:</strong>
                                            <ul class="mb-0 mt-2">
                                                <li><strong>Empresa:</strong> ${data.data.empresa}</li>
                                                <li><strong>Usuario:</strong> ${data.data.usuario_email}</li>
                                                <li><strong>Rol:</strong> ${data.data.rol_asignado}</li>
                                                <li><strong>Grupo ID:</strong> ${data.data.grupo_empresarial_id}</li>
                                                <li><strong>Usuario ID:</strong> ${data.data.user_id}</li>
                                            </ul>
                                        </div>
                                    </div>
                                `,
                                icon: 'success',
                                confirmButtonText: 'Entendido'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud',
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>