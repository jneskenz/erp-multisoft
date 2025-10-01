{{-- horizontal-menu --}}
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
   <div class="container-xxl">
     <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
       <a href="index.html" class="app-brand-link">
         <span class="app-brand-logo demo">
           <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
             <path
               fill-rule="evenodd"
               clip-rule="evenodd"
               d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
               fill="#7367F0" />
             <path
               opacity="0.06"
               fill-rule="evenodd"
               clip-rule="evenodd"
               d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
               fill="#161616" />
             <path
               opacity="0.06"
               fill-rule="evenodd"
               clip-rule="evenodd"
               d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
               fill="#161616" />
             <path
               fill-rule="evenodd"
               clip-rule="evenodd"
               d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
               fill="#7367F0" />
           </svg>
         </span>
         <span class="app-brand-text demo menu-text fw-bold">Multisoft</span>
       </a>

       <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
         <i class="ti ti-x ti-md align-middle"></i>
       </a>
     </div>

     <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
       <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
         <i class="ti ti-menu-2 ti-md"></i>
       </a>
     </div>

     <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
       <div class="navbar-nav align-items-center">
         <div class="nav-item dropdown-style-switcher dropdown">
           <a
             class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
             href="javascript:void(0);"
             data-bs-toggle="dropdown">
             <i class="ti ti-md"></i>
           </a>
           <ul class="dropdown-menu dropdown-menu-start dropdown-styles">
             <li>
               <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                 <span class="align-middle"><i class="ti ti-sun me-3"></i>Claro</span>
               </a>
             </li>
             <li>
               <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                 <span class="align-middle"><i class="ti ti-moon-stars me-3"></i>Oscuro</span>
               </a>
             </li>
             <li>
               <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                 <span class="align-middle"><i class="ti ti-device-desktop-analytics me-3"></i>Sistema</span>
               </a>
             </li>
           </ul>
         </div>
       </div>

       <ul class="navbar-nav flex-row align-items-center ms-auto">
         <!-- User -->
         <li class="nav-item navbar-dropdown dropdown-user dropdown">
           <a
             class="nav-link dropdown-toggle hide-arrow p-0"
             href="javascript:void(0);"
             data-bs-toggle="dropdown">
             <div class="avatar avatar-online">
               <img src="{{ asset('vuexy/img/avatars/1.png') }}" alt class="rounded-circle" />
             </div>
           </a>
           <ul class="dropdown-menu dropdown-menu-end">
             <li>
               <a class="dropdown-item mt-0" href="#">
                 <div class="d-flex align-items-center">
                   <div class="flex-shrink-0 me-2">
                     <div class="avatar avatar-online">
                       <img src="{{ asset('vuexy/img/avatars/1.png') }}" alt class="rounded-circle" />
                     </div>
                   </div>
                   <div class="flex-grow-1">
                     <h6 class="mb-0">John Doe</h6>
                     <small class="text-muted">Admin</small>
                   </div>
                 </div>
               </a>
             </li>
             <li>
               <div class="dropdown-divider my-1 mx-n2"></div>
             </li>
             <li>
               <a class="dropdown-item" href="#">
                 <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">Mi cuenta</span>
               </a>
             </li>
             <li>
               <a class="dropdown-item" href="#">
                 <i class="ti ti-settings me-3 ti-md"></i><span class="align-middle">Ajustes</span>
               </a>
             </li>
             <li>
               <a class="dropdown-item" href="#">
                 <span class="d-flex align-items-center align-middle">
                   <i class="flex-shrink-0 ti ti-file-dollar me-3 ti-md"></i>
                   <span class="flex-grow-1 align-middle">Notificaciones</span>
                   <span class="flex-shrink-0 badge bg-danger d-flex align-items-center justify-content-center">4</span>
                 </span>
               </a>
             </li>
             <li>
               <div class="dropdown-divider my-1 mx-n2"></div>
             </li>
             <li>
               <div class="d-grid px-2 pt-2 pb-1">
                 <a class="btn btn-sm btn-danger d-flex" href="javascript:void(0);">
                   <small class="align-middle">Cerrar sesión</small>
                   <i class="ti ti-logout ms-2 ti-14px"></i>
                 </a>
               </div>
             </li>
           </ul>
         </li>
         <!--/ User -->
       </ul>
     </div>
   </div>
</nav>
 {{-- / horizontal-menu --}}