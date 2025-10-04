<?php

/**
 * Rutas del Sistema ERP Multi-Empresa - Workspace por Grupo
 * 
 * Fecha de creación: 4 de octubre de 2025
 * 
 * Este archivo define todas las rutas del WORKSPACE que siguen el patrón:
 * /{grupoempresa}/
 * 
 * Ejemplos:
 * - /demo/ (Dashboard del grupo Demo)
 * - /alpha/apps (Aplicaciones del grupo Alpha)
 * - /beta/configuracion (Configuración del grupo Beta)
 * 
 * Todas las rutas están protegidas por:
 * 1. Middleware de autenticación (auth)
 * 2. Middleware de validación de grupo empresarial (ValidateGrupoAccess)
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Workspace\AppsController;
use App\Http\Controllers\Workspace\CustomizationController;

/*
|--------------------------------------------------------------------------
| Rutas del Workspace por Grupo Empresarial
|--------------------------------------------------------------------------
|
| Todas las rutas siguen el patrón /{grupoempresa}/ y están protegidas
| por middleware de autenticación y validación de acceso al grupo.
|
*/

Route::group([
    'prefix' => '/{grupoempresa}',
    'middleware' => ['auth', 'grupo.access'], // Middleware registrado correctamente
    'where' => [
        'grupoempresa' => '[a-zA-Z0-9\-]+', // Solo letras, números y guiones
    ]
], function () {
    
    /*
    |--------------------------------------------------------------------------
    | Dashboard Principal del Grupo
    |--------------------------------------------------------------------------
    */
    Route::get('/', [AppsController::class, 'index'])
        ->name('workspace.dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | Aplicaciones del Grupo
    |--------------------------------------------------------------------------
    */
    Route::get('/apps', [AppsController::class, 'index'])
        ->name('workspace.apps');
    
    /*
    |--------------------------------------------------------------------------
    | Configuración del Grupo
    |--------------------------------------------------------------------------
    */
    Route::prefix('configuracion')->name('workspace.config.')->group(function () {
        Route::get('/', [AppsController::class, 'configuracion'])->name('index');
        Route::get('/empresas', [AppsController::class, 'empresas'])->name('empresas');
        Route::get('/usuarios', [AppsController::class, 'usuarios'])->name('usuarios');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Reportes del Grupo
    |--------------------------------------------------------------------------
    */
    Route::prefix('reportes')->name('workspace.reportes.')->group(function () {
        Route::get('/', [AppsController::class, 'reportes'])->name('index');
        Route::get('/general', [AppsController::class, 'reporteGeneral'])->name('general');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Rutas adicionales según necesidades
    |--------------------------------------------------------------------------
    | 
    | Aquí puedes agregar más rutas específicas para el workspace del grupo:
    | - /perfil - Perfil del grupo empresarial
    | - /settings - Configuraciones avanzadas
    | - /analytics - Análisis y estadísticas
    */

    // agrega aqui personalizaciones o nuevas rutas segun se requiera
    Route::prefix('customization')->name('workspace.customization.')->group(function () {
        Route::get('/', [CustomizationController::class, 'index'])->name('index');
        Route::post('/update', [CustomizationController::class, 'update'])->name('update');
        Route::post('/reset', [CustomizationController::class, 'reset'])->name('reset');
        Route::get('/settings', [CustomizationController::class, 'getSettings'])->name('settings');
    });

});

/*
|--------------------------------------------------------------------------
| Rutas de Fallback y Redirección
|--------------------------------------------------------------------------
*/

// Ruta para cuando se accede sin especificar grupo
Route::fallback(function () {
    if (Auth::check()) {
        return redirect('/apps')->with('info', 'Seleccione un grupo empresarial para continuar');
    }
    return redirect()->route('login');
});