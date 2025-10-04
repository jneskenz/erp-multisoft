<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ config('app.name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase text-center pt-1 ">
            <span class="menu-header-text">Magdalena del Mar</span>
        </li>

        {{-- MENU VERTICAL --}}

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Gestión de Usuarios -->
        @canany(['users.view', 'roles.view'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Admin. del Sistema</span>
            </li>
        @endcanany

        <!-- Módulos del ERP -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Módulos ERP</span>
        </li>

        <!-- Inventario -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-package"></i>
                <div data-i18n="Layouts">Inventario</div>
            </a>

            <ul class="menu-sub">
                
                @can('articulos.view')
                    <li class="menu-item {{ request()->routeIs('articulos.*') ? 'active' : '' }}">
                        <a href="{{ route('articulos.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-package"></i>
                            <div data-i18n="Basic">Artículos</div>
                            @if (App\Models\Erp\Articulo::count() > 0)
                                <div class="badge text-bg-primary rounded-pill ms-auto">
                                    {{ App\Models\Erp\Articulo::count() }}
                                </div>
                            @endif
                        </a>
                    </li>
                @endcan

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without menu">Productos</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">Categorías</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Container">Stock</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Container">Kardex</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Ventas -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                <div data-i18n="Account Settings">Ventas</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Account">Clientes</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Notifications">Facturas</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Connections">Reportes</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Compras -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-shopping-bag"></i>
                <div data-i18n="Authentications">Compras</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Basic">Proveedores</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Basic">Órdenes</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Basic">Recepciones</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Finanzas -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-coins"></i>
                <div data-i18n="Misc">Finanzas</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Error">Cuentas por Cobrar</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Under Maintenance">Cuentas por Pagar</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Under Maintenance">Estados Financieros</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Módulos del CRM -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Módulos CRM</span>
        </li>

        <!-- Recursos Humanos -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Módulo RR.HH.</span>
        </li>

        <!-- Reportes -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Reportes y Analytics</span>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons ti ti-report"></i>
                <div data-i18n="Support">Reportes</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons ti ti-report-analytics"></i>
                <div data-i18n="Documentation">Analytics</div>
            </a>
        </li>
    </ul>
</aside>
