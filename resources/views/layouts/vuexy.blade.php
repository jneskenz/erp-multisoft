<!DOCTYPE html>

@props(['apariencia' => 'vertical',])

<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="light-style {{ $apariencia == 'vertical' ? 'layout-navbar-fixed' : 'test' }}  layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{  asset('vuexy').'/' }}"
  data-template="{{ $apariencia == 'vertical' ? 'vertical-menu-template-starter' : 'horizontal-menu-template-starter' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('vuexy/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('vuexy/vendor/fonts/tabler-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('vuexy/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('vuexy/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('vuexy/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('vuexy/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset('vuexy/vendor/js/helpers.js') }}"></script>

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('vuexy/vendor/js/template-customizer.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file to customize your theme -->
    <script src="{{ asset('vuexy/js/config.js') }}"></script>

    @livewireStyles
    

</head>

<body>


    @if($apariencia == 'vertical')

    <!-- Layout wrapper | vertical -->

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu principal -->
            @include('layouts.vuexy.sidebar')
            <!-- / Menu principal -->

            <div class="layout-page">

                <!-- Navbar -->
                @include('layouts.vuexy.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                        @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.vuexy.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->

            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

    </div>

    @else

    <!-- Layout wrapper | horizontal -->

    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">

            <!-- Menu principal -->
            @include('layouts.vuexy.headerbar')
            <!-- / Menu principal -->

            <div class="layout-page">

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Menu -->
                    @include('layouts.vuexy.menu')
                    <!-- / Menu -->

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.vuexy.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->

            </div>

        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

    </div>


    @endif


    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('vuexy/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vuexy/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vuexy/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vuexy/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('vuexy/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('vuexy/vendor/libs/hammer/hammer.js') }}"></script>
    {{-- <script src="{{ asset('vuexy/vendor/libs/i18n/i18n.js') }}"></script> --}}
    <script src="{{ asset('vuexy/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('vuexy/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    @stack('vendor-scripts')

    <!-- Main JS -->
    <script src="{{ asset('vuexy/js/main.js') }}"></script>

    <!-- Page JS -->
    @stack('scripts')

    @livewireScripts

    <!-- Error Counter for SuperAdmin -->
    @auth
        @if(auth()->user()->isSuperAdmin())
            <script>
                // Función para actualizar contador de errores en el sidebar
                function updateErrorCounter() {
                    fetch('{{ route('admin.logs.stats') }}')
                        .then(response => response.json())
                        .then(data => {
                            const errorCount = document.getElementById('errorCount');
                            if (errorCount && data.error_count_today > 0) {
                                errorCount.textContent = data.error_count_today;
                                errorCount.style.display = 'inline';
                            } else if (errorCount) {
                                errorCount.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching log stats:', error);
                        });
                }

                // Actualizar cada 30 segundos
                $(document).ready(function() {
                    updateErrorCounter(); // Ejecutar inmediatamente
                    setInterval(updateErrorCounter, 30000); // Cada 30 segundos
                });
            </script>
        @endif
    @endauth
</body>

</html>
