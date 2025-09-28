<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Ruta de prueba
    Route::get('/test', function () {
        return view('test');
    })->name('test');
    
    // Rutas de usuarios
    Route::resource('users', UserController::class);
    
    // Rutas de roles
    Route::resource('roles', RoleController::class);
});
