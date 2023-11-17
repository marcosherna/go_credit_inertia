<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Banco\ChequeraController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\Contable\CatalogoCuentasController;
use App\Http\Controllers\Contable\PartidaContableController;
use App\Http\Controllers\CuentaBanco\CuentaBancoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

  


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(BancoController::class)->group( function () {
        Route::get('modulo-banco-page', 'index')->name('banco-layout');
        Route::post('banco-create', 'store')->name('banco.store');
        Route::put('banco-update', 'update')->name('banco.update');
        Route::patch('banco-status/{id}', 'changedStatus')->name('banco.status');
    });
    
    Route::controller(CuentaBancoController::class)->group( function () {
        Route::get('cuenta-banco', 'index')->name('cuenta-banco-layout');
        Route::post('cuenta-banco-create', 'store')->name('cuenta-banco.store');
        Route::put('cuenta-banco-update', 'update')->name('cuenta-banco.update');
        Route::patch('cuenta-banco-status/{id}', 'changedStatus')->name('cuenta-banco.status');
    });
    
    Route::controller(ChequeraController::class)->group( function () {
        Route::get('chequera-page', 'index')->name('chequera-layout');
    });
    
    Route::controller(PartidaContableController::class)->group( function () {
        Route::get('modulo-contable-page', 'index')->name('partida-contable-layout');
    });
    
    Route::controller(CatalogoCuentasController::class)->group( function () {
        Route::get('catalogo-cuentas-page', 'index')->name('catalogo-cuentas-layout');
    });

});
