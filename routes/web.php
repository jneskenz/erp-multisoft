<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\Erp\EmpresaController;
use App\Http\Controllers\Erp\SedeController;
use App\Http\Controllers\Erp\LocalController;
use App\Http\Controllers\Erp\TipoLocalController;
use App\Http\Controllers\Erp\ArticuloController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\GrupoEmpresarialController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Ruta de prueba
    Route::get('/test', function () {
        return view('test');
    })->name('test');
    
    // Rutas de usuarios
    Route::resource('users', UserController::class);
    
    // Rutas de roles
    Route::resource('roles', RoleController::class);

    Route::resource('empresas', EmpresaController::class);

    // Rutas de sedes
    Route::resource('sedes', SedeController::class);

    // Rutas de locales
    Route::resource('locales', LocalController::class);
    Route::post('locales/{locale}/toggle-status', [LocalController::class, 'toggleStatus'])->name('locales.toggle-status');

    // Rutas de artículos
    Route::resource('articulos', ArticuloController::class);
    Route::post('articulos/{articulo}/toggle-status', [ArticuloController::class, 'toggleStatus'])->name('articulos.toggle-status');

    // Rutas de tipos de locales (API para modales)
    Route::prefix('api/tipo-locales')->name('tipo-locales.')->group(function () {
        Route::get('/', [TipoLocalController::class, 'index'])->name('index');
        Route::post('/', [TipoLocalController::class, 'store'])->name('store');
        Route::get('/{tipoLocal}', [TipoLocalController::class, 'show'])->name('show');
        Route::put('/{tipoLocal}', [TipoLocalController::class, 'update'])->name('update');
        Route::delete('/{tipoLocal}', [TipoLocalController::class, 'destroy'])->name('destroy');
    });

    // Rutas de personalización
    Route::prefix('customization')->name('customization.')->group(function () {
        Route::get('/', [CustomizationController::class, 'index'])->name('index');
        Route::post('/update', [CustomizationController::class, 'update'])->name('update');
        Route::post('/reset', [CustomizationController::class, 'reset'])->name('reset');
        Route::get('/settings', [CustomizationController::class, 'getSettings'])->name('settings');
    });

    // Rutas de administración de logs (solo para superadmin)
    Route::prefix('admin')->name('admin.')->middleware('superadmin')->group(function () {
        Route::get('logs', [LogController::class, 'index'])->name('logs.index');
        Route::get('logs/dashboard', function () {
            return view('admin.logs.dashboard');
        })->name('logs.dashboard');
        Route::get('logs/stats', [LogController::class, 'stats'])->name('logs.stats');
        Route::get('logs/{filename}', [LogController::class, 'show'])->name('logs.show');
        Route::get('logs/{filename}/download', [LogController::class, 'download'])->name('logs.download');
        Route::delete('logs/{filename}', [LogController::class, 'delete'])->name('logs.delete');
        Route::post('logs/clean', [LogController::class, 'clean'])->name('logs.clean');

        // Rutas de Grupos Empresariales
        Route::resource('grupo-empresarial', GrupoEmpresarialController::class)->names([
            'index' => 'grupo-empresarial.index',
            'create' => 'grupo-empresarial.create',
            'store' => 'grupo-empresarial.store',
            'show' => 'grupo-empresarial.show',
            'edit' => 'grupo-empresarial.edit',
            'update' => 'grupo-empresarial.update',
            'destroy' => 'grupo-empresarial.destroy',
        ]);
        Route::post('grupo-empresarial/{grupoEmpresarial}/toggle-status', [GrupoEmpresarialController::class, 'toggleStatus'])->name('grupo-empresarial.toggle-status');
    });

});
