<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ $grupoActual->avatar_url ?? asset('vuexy/img/logo/logo.png') }}" alt="Logo" style="max-width: 24px; max-height: 24px;">
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

        {{-- MENU VERTICAL --}}

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('apps.workspace') ? 'active' : '' }}">
            <a href="{{ route('workspace.dashboard', ['grupoempresa' => $grupoActual->slug]) }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-apps"></i>
                <div data-i18n="Analytics">Aplicaciones {{ request()->routeIs('apps.workspace') }}</div>
            </a>
        </li>

        <!-- Gestión de Usuarios -->
        @canany(['users.view', 'roles.view'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">CONTROL ADMINISTRATIVO </span>
            </li>
        @endcanany

        {{-- Config. del sistema --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-device-desktop-cog"></i>
                <div data-i18n="Layouts">Config. del sistema</div>
            </a>

            <ul class="menu-sub">                
                <li class="menu-item">
                    <a href="{{ route('workspace.customization.index', ['grupoempresa' => $grupoActual->slug]) }}" class="menu-link">
                        <div data-i18n="Without navbar">Personalización</div>
                    </a>
                </li>
                {{-- <li class="menu-item">
                    <a href="{{ route('workspace.customization.appearance') }}" class="menu-link">
                        <div data-i18n="Container">Apariencia</div>
                    </a>
                </li> --}}
            </ul>
        </li>
        {{-- Config. del sistema --}}


        {{-- Config. administrativa --}}
        <li class="menu-item open active">
            <a href="javascript:void(0);" class="menu-link menu-toggle ">
                <i class="menu-icon tf-icons ti ti-password-user"></i>
                <div data-i18n="Layouts">Config. Administrativa </div>
            </a>

            <ul class="menu-sub">
                @can('users.view')
                    <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-user"></i>
                            <div data-i18n="Basic">Usuarios</div>
                            @if (App\Models\User::count() > 0)
                                <div class="badge text-bg-primary rounded-pill ms-auto">
                                    {{ App\Models\User::count() }}
                                </div>
                            @endif
                        </a>
                    </li>
                @endcan
                @can('roles.view')
                    <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-shield"></i>
                            <div data-i18n="Basic">Roles y Permisos</div>
                            @if (Spatie\Permission\Models\Role::count() > 0)
                                <div class="badge text-bg-info rounded-pill ms-auto">
                                    {{ Spatie\Permission\Models\Role::count() }}</div>
                            @endif
                        </a>
                    </li>
                @endcan

                @can('empresas.view')
                    <li class="menu-item {{ request()->routeIs('workspace.empresas.*') ? 'active' : '' }}">
                        <a href="{{ route('workspace.empresas.index', ['grupoempresa' => $grupoActual->slug]) }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-building"></i>
                            <div data-i18n="Basic">Empresas 2</div>
                            @if (App\Models\Workspace\Empresa::count() > 0)
                                <div class="badge text-bg-primary rounded-pill ms-auto">
                                    {{ App\Models\Workspace\Empresa::count() }}
                                </div>
                            @endif
                        </a>
                    </li>
                @endcan

                @can('sedes.view')
                    <li class="menu-item {{ request()->routeIs('sedes.*') ? 'active' : '' }}">
                        <a href="{{ route('sedes.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-building-bank"></i>
                            <div data-i18n="Basic">Sedes</div>
                            @if (App\Models\Workspace\Sede::count() > 0)
                                <div class="badge text-bg-primary rounded-pill ms-auto">
                                    {{ App\Models\Workspace\Sede::count() }}</div>
                            @endif
                        </a>
                    </li>
                @endcan
                @can('locales.view')
                    <li class="menu-item {{ request()->routeIs('locales.*') ? 'active' : '' }}">
                        <a href="{{ route('locales.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-building-store"></i>
                            <div data-i18n="Basic">Locales</div>
                            @if (App\Models\Workspace\Local::count() > 0)
                                <div class="badge text-bg-primary rounded-pill ms-auto">
                                    {{ App\Models\Workspace\Local::count() }}
                                </div>
                            @endif
                        </a>
                    </li>
                @endcan
                {{-- acceso solo para superadmin con medelwire --}}

                
            </ul>
        </li>
        {{-- Config. administrativa --}}

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Reporte y Análisis</span>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons ti ti-report"></i>
                <div data-i18n="Support">Integraciones (Rest API)</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons ti ti-report"></i>
                <div data-i18n="Support">Métricas y Reportes</div>
            </a>
        </li>

    </ul>
</aside>
