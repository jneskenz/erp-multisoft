<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0693821 15.7368052,26.9316134 C19.9146624,23.7756983 23.9372394,20.006675 27.8074109,15.6295798 C31.6775825,11.2524846 34.6669781,6.84056614 36.7754803,2.39680821 C37.7819209,0.396051134 38.2952826,-1.51594471 38.3146239,-3.34313491 C38.3339762,-5.17032511 37.8730648,-6.93359605 36.9321234,-8.62286825 C36.0151886,-10.2419216 34.8461194,-11.3372494 33.4264767,-11.909331 C32.0068339,-12.4814126 30.5979377,-12.516633 29.2019426,-12.0194777 C27.8059476,-11.5223224 26.4638978,-10.6231604 25.1759774,-9.32292413 L13.7918663,0.358365126 Z"></path>
                    </defs>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-4.000000, -15.000000)" fill="#696cff">
                            <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0693821 15.7368052,26.9316134 C19.9146624,23.7756983 23.9372394,20.006675 27.8074109,15.6295798 C31.6775825,11.2524846 34.6669781,6.84056614 36.7754803,2.39680821 C37.7819209,0.396051134 38.2952826,-1.51594471 38.3146239,-3.34313491 C38.3339762,-5.17032511 37.8730648,-6.93359605 36.9321234,-8.62286825 C36.0151886,-10.2419216 34.8461194,-11.3372494 33.4264767,-11.909331 C32.0068339,-12.4814126 30.5979377,-12.516633 29.2019426,-12.0194777 C27.8059476,-11.5223224 26.4638978,-10.6231604 25.1759774,-9.32292413 L13.7918663,0.358365126 Z"></path>
                        </g>
                    </g>
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ config('app.name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Gestión de Usuarios -->
        @canany(['users.view', 'roles.view'])
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Gestión de Usuarios</span>
        </li>
        @endcanany

        @can('users.view')
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Usuarios</div>
                @if(App\Models\User::count() > 0)
                    <div class="badge badge-center rounded-pill bg-danger w-px-20 h-px-20 ms-auto">{{ App\Models\User::count() }}</div>
                @endif
            </a>
        </li>
        @endcan

        @can('roles.view')
        <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div data-i18n="Basic">Roles y Permisos</div>
                @if(Spatie\Permission\Models\Role::count() > 0)
                    <div class="badge badge-center rounded-pill bg-primary w-px-20 h-px-20 ms-auto">{{ Spatie\Permission\Models\Role::count() }}</div>
                @endif
            </a>
        </li>
        @endcan

        <!-- Módulos del ERP -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Módulos ERP</span>
        </li>

        <!-- Inventario -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Layouts">Inventario</div>
            </a>

            <ul class="menu-sub">
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
            </ul>
        </li>

        <!-- Ventas -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cart-alt"></i>
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
                <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
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
                <i class="menu-icon tf-icons bx bx-money"></i>
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

        <!-- Reportes -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Reportes y Analytics</span>
        </li>
        
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-i18n="Support">Reportes</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-pie-chart-alt-2"></i>
                <div data-i18n="Documentation">Analytics</div>
            </a>
        </li>
    </ul>
</aside>