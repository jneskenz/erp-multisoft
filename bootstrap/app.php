<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/workspace.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middlewares personalizados del ERP Multi-Empresa
        // Fecha de configuración: 3 de octubre de 2025
        $middleware->alias([
            // Middleware para validar acceso de super administradores
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            
            // Middleware para validar acceso a empresas específicas en el ERP
            // Se aplica a todas las rutas que siguen el patrón /{grupo}/{empresa}/{modulo}
            'empresa.access' => \App\Http\Middleware\ValidateEmpresaAccess::class,
            
            // Middleware para validar acceso a grupos empresariales
            // Se aplica a rutas administrativas que no requieren contexto de empresa
            'grupo.access' => \App\Http\Middleware\ValidateGrupoAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
