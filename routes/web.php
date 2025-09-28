<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Páginas Volt con permisos
    Volt::route('/users', 'pages.users')->name('users.index')->middleware('can:users.view');
    Volt::route('/roles', 'pages.roles')->name('roles.index')->middleware('can:roles.view');
});
