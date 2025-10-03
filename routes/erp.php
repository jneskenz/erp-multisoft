<?php

/**
 * Rutas del Sistema ERP Multi-Empresa
 * 
 * Fecha de creación: 3 de octubre de 2025
 * 
 * Este archivo define todas las rutas del ERP que siguen el patrón:
 * /{grupo}/{empresa}/{modulo}
 * 
 * Ejemplos:
 * - /demo/alpha/dashboard (Panel de control de empresa Alpha del grupo Demo)
 * - /demo/alpha/ventas (Módulo de ventas de empresa Alpha)
 * - /demo/beta/compras (Módulo de compras de empresa Beta)
 * 
 * Todas las rutas están protegidas por:
 * 1. Middleware de autenticación (auth)
 * 2. Middleware de validación de empresa (empresa.access)
 * 3. Verificación de roles de cliente ERP
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Erp\DashboardController;
use App\Http\Controllers\Erp\VentasController;
use App\Http\Controllers\Erp\ComprasController;

/*
|--------------------------------------------------------------------------
| Rutas del ERP Multi-Empresa
|--------------------------------------------------------------------------
|
| Todas las rutas del ERP siguen el patrón /{grupo}/{empresa}/{modulo}
| y están protegidas por middleware de autenticación y validación de empresa.
|
*/

// Grupo de rutas con patrón dinámico de empresa
Route::group([
    'prefix' => '{grupo}/{empresa}',
    'middleware' => ['auth', 'empresa.access'],
    'where' => [
        'grupo' => '[a-zA-Z0-9\-]+',    // Solo letras, números y guiones
        'empresa' => '[a-zA-Z0-9\-]+',  // Solo letras, números y guiones
    ]
], function () {
    
    /*
    |--------------------------------------------------------------------------
    | Dashboard Principal del ERP
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('erp.dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | Módulo de Ventas
    |--------------------------------------------------------------------------
    | 
    | Maneja todas las operaciones relacionadas con ventas:
    | - Listado de ventas
    | - Creación de nuevas ventas
    | - Edición y eliminación de ventas existentes
    | - Reportes de ventas
    */
    Route::prefix('ventas')->name('erp.ventas.')->group(function () {
        Route::get('/', [VentasController::class, 'index'])->name('index');
        Route::get('/crear', [VentasController::class, 'create'])->name('create');
        Route::post('/', [VentasController::class, 'store'])->name('store');
        Route::get('/{id}', [VentasController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [VentasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VentasController::class, 'update'])->name('update');
        Route::delete('/{id}', [VentasController::class, 'destroy'])->name('destroy');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Módulo de Compras
    |--------------------------------------------------------------------------
    | 
    | Maneja todas las operaciones relacionadas con compras:
    | - Listado de compras y órdenes de compra
    | - Gestión de proveedores
    | - Control de inventario
    */
    Route::prefix('compras')->name('erp.compras.')->group(function () {
        Route::get('/', [ComprasController::class, 'index'])->name('index');
        Route::get('/crear', [ComprasController::class, 'create'])->name('create');
        Route::post('/', [ComprasController::class, 'store'])->name('store');
        Route::get('/{id}', [ComprasController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [ComprasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ComprasController::class, 'update'])->name('update');
        Route::delete('/{id}', [ComprasController::class, 'destroy'])->name('destroy');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Módulos Futuros del ERP
    |--------------------------------------------------------------------------
    | 
    | Aquí se pueden agregar más módulos según las necesidades:
    | - /contabilidad - Módulo de contabilidad y finanzas
    | - /inventario - Gestión de inventario y almacenes
    | - /recursos-humanos - Gestión de personal
    | - /reportes - Reportes y analytics
    | - /configuracion - Configuración de la empresa
    */
});

/*
|--------------------------------------------------------------------------
| Rutas de Redirección
|--------------------------------------------------------------------------
| 
| Rutas para manejar redirecciones cuando el usuario accede sin especificar
| una empresa o módulo específico.
*/

// Redirección cuando se accede solo al grupo (ej: /demo)
Route::get('/{grupo}', function ($grupo) {
    // TODO: Implementar lógica para redireccionar a la empresa por defecto del usuario
    // Por ahora, redirecciona al login
    return redirect()->route('login')->with('info', 'Seleccione una empresa para continuar');
})->where('grupo', '[a-zA-Z0-9\-]+')->name('erp.grupo');

// Redirección cuando se accede al grupo y empresa sin módulo (ej: /demo/alpha)
Route::get('/{grupo}/{empresa}', function ($grupo, $empresa) {
    // Redireccionar al dashboard por defecto
    return redirect()->route('erp.dashboard', compact('grupo', 'empresa'));
})->where([
    'grupo' => '[a-zA-Z0-9\-]+',
    'empresa' => '[a-zA-Z0-9\-]+'
])->middleware(['auth', 'empresa.access'])->name('erp.empresa');