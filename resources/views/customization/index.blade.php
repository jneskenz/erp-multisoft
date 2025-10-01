@extends('layouts.vuexy')

@section('title', 'Personalización del Sistema')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb Component -->
    @include('layouts.vuexy.breadcrumb', $dataBreadcrumb)

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('layouts.vuexy.header-card', $dataHeaderCard)

                <div class="card-body">
                    <!-- Mensajes de estado -->
                    <div id="message-container" class="mb-3" style="display: none;">
                        <div class="alert alert-success alert-dismissible d-flex" role="alert">
                            <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                            <div>
                                <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">¡Éxito!</h6>
                                <p class="mb-0" id="message-text"></p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>

                    <form id="customization-form">
                        @csrf
                        
                        <div class="row">
                            <!-- Configuración de Tema -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ti ti-sun me-2"></i>
                                            Configuración de Tema
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Modo de tema -->
                                        <div class="mb-3">
                                            <label class="form-label">Modo de Tema</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="theme_light">
                                                            <input name="theme_mode" class="form-check-input" type="radio" value="light" id="theme_light" {{ $customization->theme_mode == 'light' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <i class="ti ti-sun"></i>
                                                                <span class="fw-medium">Claro</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="theme_dark">
                                                            <input name="theme_mode" class="form-check-input" type="radio" value="dark" id="theme_dark" {{ $customization->theme_mode == 'dark' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <i class="ti ti-moon"></i>
                                                                <span class="fw-medium">Oscuro</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="theme_system">
                                                            <input name="theme_mode" class="form-check-input" type="radio" value="system" id="theme_system" {{ $customization->theme_mode == 'system' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <i class="ti ti-device-desktop"></i>
                                                                <span class="fw-medium">Sistema</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Color de tema -->
                                        <div class="mb-3">
                                            <label class="form-label">Color del Tema</label>
                                            <div class="row">
                                                @foreach(\App\Models\UserCustomization::getThemeColors() as $color => $hex)
                                                <div class="col-3 mb-2">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="color_{{ $color }}">
                                                            <input name="theme_color" class="form-check-input" type="radio" value="{{ $color }}" id="color_{{ $color }}" {{ $customization->theme_color == $color ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="badge" style="background-color: {{ $hex }}; width: 20px; height: 20px;"></span>
                                                                <span class="fw-medium">{{ ucfirst($color) }}</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="col-3 mb-2">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="color_custom">
                                                            <input name="theme_color" class="form-check-input" type="radio" value="custom" id="color_custom" {{ $customization->theme_color == 'custom' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <i class="ti ti-palette"></i>
                                                                <span class="fw-medium">Personalizado</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2" id="custom-color-container" style="display: {{ $customization->theme_color == 'custom' ? 'block' : 'none' }}">
                                                <input type="color" class="form-control form-control-color" name="custom_color" value="{{ $customization->custom_color ?? '#696cff' }}" title="Elegir color personalizado">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Configuración de Fuente -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ti ti-typography me-2"></i>
                                            Configuración de Fuente
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Familia de fuente -->
                                        <div class="mb-3">
                                            <label for="font_family" class="form-label">Familia de Fuente</label>
                                            <select class="form-select" name="font_family" id="font_family">
                                                @foreach(\App\Models\UserCustomization::getFontFamilies() as $value => $name)
                                                    <option value="{{ $value }}" {{ $customization->font_family == $value ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Tamaño de fuente -->
                                        <div class="mb-3">
                                            <label class="form-label">Tamaño de Fuente</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="font_small">
                                                            <input name="font_size" class="form-check-input" type="radio" value="small" id="font_small" {{ $customization->font_size == 'small' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium" style="font-size: 12px;">Pequeña</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="font_medium">
                                                            <input name="font_size" class="form-check-input" type="radio" value="medium" id="font_medium" {{ $customization->font_size == 'medium' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium" style="font-size: 14px;">Mediana</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="font_large">
                                                            <input name="font_size" class="form-check-input" type="radio" value="large" id="font_large" {{ $customization->font_size == 'large' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium" style="font-size: 16px;">Grande</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Configuración de Layout -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ti ti-layout-dashboard me-2"></i>
                                            Configuración de Layout
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Tipo de layout -->
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Layout</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="layout_vertical">
                                                            <input name="layout_type" class="form-check-input" type="radio" value="vertical" id="layout_vertical" {{ $customization->layout_type == 'vertical' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <i class="ti ti-layout-sidebar-left"></i>
                                                                <span class="fw-medium">Vertical</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="layout_horizontal">
                                                            <input name="layout_type" class="form-check-input" type="radio" value="horizontal" id="layout_horizontal" {{ $customization->layout_type == 'horizontal' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <i class="ti ti-layout-navbar"></i>
                                                                <span class="fw-medium">Horizontal</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Container del layout -->
                                        <div class="mb-3">
                                            <label class="form-label">Contenedor</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="container_fluid">
                                                            <input name="layout_container" class="form-check-input" type="radio" value="fluid" id="container_fluid" {{ $customization->layout_container == 'fluid' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium">Fluido</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="container_boxed">
                                                            <input name="layout_container" class="form-check-input" type="radio" value="boxed" id="container_boxed" {{ $customization->layout_container == 'boxed' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium">Caja</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="container_detached">
                                                            <input name="layout_container" class="form-check-input" type="radio" value="detached" id="container_detached" {{ $customization->layout_container == 'detached' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium">Separado</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Configuración de Navbar -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ti ti-layout-navbar me-2"></i>
                                            Configuración de Navbar
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Tipo de navbar -->
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Navbar</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="navbar_fixed">
                                                            <input name="navbar_type" class="form-check-input" type="radio" value="fixed" id="navbar_fixed" {{ $customization->navbar_type == 'fixed' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium">Fijo</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="navbar_static">
                                                            <input name="navbar_type" class="form-check-input" type="radio" value="static" id="navbar_static" {{ $customization->navbar_type == 'static' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium">Estático</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content" for="navbar_hidden">
                                                            <input name="navbar_type" class="form-check-input" type="radio" value="hidden" id="navbar_hidden" {{ $customization->navbar_type == 'hidden' ? 'checked' : '' }}>
                                                            <span class="custom-option-header">
                                                                <span class="fw-medium">Oculto</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Opciones adicionales -->
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="navbar_blur" id="navbar_blur" {{ $customization->navbar_blur ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="navbar_blur">
                                                        Efecto Blur
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6" id="sidebar-options" style="display: {{ $customization->layout_type == 'vertical' ? 'block' : 'none' }}">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="sidebar_collapsed" id="sidebar_collapsed" {{ $customization->sidebar_collapsed ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sidebar_collapsed">
                                                        Sidebar Colapsado
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="ti ti-check me-1"></i>
                                Guardar Configuración
                            </button>
                            <button type="button" class="btn btn-label-warning" onclick="resetToDefaults()">
                                <i class="ti ti-refresh me-1"></i>
                                Restablecer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const form = document.getElementById('customization-form');
    const resetBtn = document.getElementById('reset-btn');
    const resetHeaderBtn = document.getElementById('reset-header-btn');

    // Función para mostrar alertas
    function showAlert(type, message) {
        const alertsContainer = document.getElementById('customization-alerts');
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible d-flex" role="alert">
                <span class="alert-icon rounded">
                    <i class="ti ti-${type === 'success' ? 'check' : 'x'}"></i>
                </span>
                <div>
                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">
                        ${type === 'success' ? '¡Éxito!' : 'Error'}
                    </h6>
                    <p class="mb-0">${message}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        alertsContainer.innerHTML = alertHtml;
        
        // Auto-dismiss después de 5 segundos
        setTimeout(() => {
            const alert = alertsContainer.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }

    // Función para aplicar cambios en tiempo real
    function applyRealtimeChanges() {
        const formData = new FormData(form);
        
        // Aplicar modo de tema
        const themeMode = formData.get('theme_mode');
        const html = document.documentElement;
        
        // Remover clases anteriores de tema
        html.classList.remove('light-style', 'dark-style');
        
        if (themeMode === 'dark') {
            html.classList.add('dark-style');
            html.setAttribute('data-theme', 'theme-dark');
        } else if (themeMode === 'light') {
            html.classList.add('light-style');
            html.setAttribute('data-theme', 'theme-default');
        } else { // system
            // Detectar preferencia del sistema
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                html.classList.add('dark-style');
                html.setAttribute('data-theme', 'theme-dark');
            } else {
                html.classList.add('light-style');
                html.setAttribute('data-theme', 'theme-default');
            }
        }

        // Aplicar color de tema
        const themeColor = formData.get('theme_color');
        const customColor = formData.get('custom_color');
        
        let primaryColor = '#696cff'; // Default
        
        if (themeColor === 'custom' && customColor) {
            primaryColor = customColor;
        } else {
            const themeColors = {
                'default': '#696cff',
                'cyan': '#00bcd4',
                'purple': '#9c27b0',
                'orange': '#ff9800',
                'red': '#f44336',
                'green': '#4caf50',
                'dark': '#424242'
            };
            primaryColor = themeColors[themeColor] || '#696cff';
        }

        // Aplicar color personalizado con CSS custom properties
        document.documentElement.style.setProperty('--bs-primary', primaryColor);
        document.documentElement.style.setProperty('--bs-primary-rgb', hexToRgb(primaryColor));

        // Aplicar fuente
        const fontFamily = formData.get('font_family');
        const fontFamilies = {
            'inter': 'Inter, sans-serif',
            'roboto': 'Roboto, sans-serif',
            'poppins': 'Poppins, sans-serif',
            'open_sans': 'Open Sans, sans-serif',
            'lato': 'Lato, sans-serif'
        };
        
        if (fontFamilies[fontFamily]) {
            document.body.style.fontFamily = fontFamilies[fontFamily];
        }

        // Aplicar tamaño de fuente
        const fontSize = formData.get('font_size');
        const fontSizes = {
            'small': '0.85rem',
            'medium': '0.9375rem',
            'large': '1rem'
        };
        
        if (fontSizes[fontSize]) {
            document.documentElement.style.fontSize = fontSizes[fontSize];
        }

        // Aplicar navbar blur
        const navbarBlur = formData.get('navbar_blur');
        const navbar = document.querySelector('.layout-navbar');
        if (navbar) {
            if (navbarBlur) {
                navbar.style.backdropFilter = 'blur(10px)';
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.85)';
                if (html.classList.contains('dark-style')) {
                    navbar.style.backgroundColor = 'rgba(33, 33, 33, 0.85)';
                }
            } else {
                navbar.style.backdropFilter = '';
                navbar.style.backgroundColor = '';
            }
        }
    }

    // Función para convertir hex a rgb
    function hexToRgb(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? 
            parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) : '105, 108, 255';
    }

    // Event listeners para cambios en tiempo real
    form.addEventListener('change', function(e) {
        applyRealtimeChanges();
        
        // Mostrar/ocultar sección de color personalizado
        if (e.target.name === 'theme_color') {
            const customColorSection = document.getElementById('custom-color-section');
            customColorSection.style.display = e.target.value === 'custom' ? 'block' : 'none';
        }
        
        // Mostrar/ocultar configuraciones de sidebar
        if (e.target.name === 'layout_type') {
            const sidebarSettings = document.getElementById('sidebar-settings');
            sidebarSettings.style.display = e.target.value === 'vertical' ? 'block' : 'none';
        }
    });

    // Event listener para color personalizado
    document.getElementById('custom_color').addEventListener('input', function() {
        if (document.querySelector('input[name="theme_color"]:checked').value === 'custom') {
            applyRealtimeChanges();
        }
    });

    // Función para guardar configuración
    function saveCustomization() {
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Mostrar loading
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Guardando...';
        submitBtn.disabled = true;
        
        fetch('{{ route("customization.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                // Si hay cambios de layout, recargar página
                setTimeout(() => {
                    const layoutType = formData.get('layout_type');
                    const currentTemplate = document.documentElement.getAttribute('data-template');
                    const needsReload = (layoutType === 'horizontal' && currentTemplate.includes('vertical')) ||
                                       (layoutType === 'vertical' && currentTemplate.includes('horizontal'));
                    
                    if (needsReload) {
                        window.location.reload();
                    }
                }, 1000);
            } else {
                showAlert('danger', data.message || 'Error al guardar la configuración');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Error de conexión al guardar la configuración');
        })
        .finally(() => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    // Función para resetear configuración
    function resetCustomization() {
        if (confirm('¿Estás seguro de restablecer todas las configuraciones a los valores por defecto?')) {
            const buttons = [resetBtn, resetHeaderBtn].filter(btn => btn !== null);
            
            buttons.forEach(btn => {
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Restableciendo...';
                btn.disabled = true;
            });
            
            fetch('{{ route("customization.reset") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showAlert('danger', data.message || 'Error al restablecer la configuración');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'Error de conexión al restablecer la configuración');
            })
            .finally(() => {
                buttons.forEach(btn => {
                    btn.innerHTML = btn.id === 'reset-btn' ? '<i class="ti ti-refresh me-1"></i>Restablecer por Defecto' : '<i class="ti ti-refresh me-1"></i>Restablecer';
                    btn.disabled = false;
                });
            });
        }
    }

    // Envío del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveCustomization();
    });

    // Event listeners para botones de reset
    if (resetBtn) {
        resetBtn.addEventListener('click', resetCustomization);
    }
    
    if (resetHeaderBtn) {
        resetHeaderBtn.addEventListener('click', resetCustomization);
    }

    // Aplicar configuración inicial
    applyRealtimeChanges();
});
</script>
@endpush