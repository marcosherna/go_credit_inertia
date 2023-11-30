<?php

use App\Http\Controllers\Administracion\ClientesController;
use App\Http\Controllers\Administracion\SolicitudController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Banco\ChequeraController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\Catalogos\EstadoCivilController;
use App\Http\Controllers\Catalogos\PaisController;
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
        Route::put('banco-status/{id}', 'changedStatus')->name('banco.status');
    });
    
    Route::controller(CuentaBancoController::class)->group( function () {
        Route::get('cuenta-banco', 'index')->name('cuenta-banco-layout');
        Route::post('cuenta-banco-create', 'store')->name('cuenta-banco.store');
        Route::put('cuenta-banco-update', 'update')->name('cuenta-banco.update');
        Route::put('cuenta-banco-status/{id}', 'changedStatus')->name('cuenta-banco.status');
    });
    
    Route::controller(ChequeraController::class)->group( function () {
        Route::get('chequera-page', 'index')->name('chequera-layout');
        Route::post('chequera-create', 'store')->name('chequera.store');
        Route::get('chequera-get-cheques/{CHEQ_ID}', 'getCheques')->name('chequera.get-cheques');
        Route::post('chequera-create-cheque', 'createCheque')->name('chequera.create-cheque');
    });
    
    Route::controller(PartidaContableController::class)->group( function () {
        Route::get('modulo-contable-page', 'index')->name('partida-contable-layout');
    });
    
    Route::controller(CatalogoCuentasController::class)->group( function () {
        Route::get('catalogo-cuentas-page', 'index')->name('catalogo-cuentas-layout');
    });

    Route::controller(ClientesController::class)->group( function () {
        Route::get('modulo-clientes-page', 'index')->name('clientes-layout');
        Route::get('cliente-create', 'store')->name('cliente.store');
        Route::get('cliente-helper', 'helper')->name('cliente.helper');
        Route::post('cliente-create', 'create')->name('cliente.create');    
        Route::get('cliente-detalle-page/{id}', 'show')->name('cliente.detalle-layout'); 
        Route::get('cliente-solucitudes/{id}', 'solicitudes')->name('cliente.solicitudes-resource');   
        Route::get('cliente-editar/{id}', 'edit')->name('cliente.editar-layout'); 
        Route::get('cliente-find-all', 'findAll')->name('cliente.findAll-resource');
    });

    Route::controller(SolicitudController::class)->prefix('solicitud')->group( function () {
        Route::get('solicitud-detalle/{id}', 'findById')->name('solicitud.detalle-resource');
        Route::get('solicitud-cuotas/{id}', 'findCuotas')->name('solicitud.cuotas-resource');
        Route::get('solicitud-take-cliente/{id}/{take}', 'findByIdClient')->name('solicitud.take-cliente-creditos-resource');
    });

    Route::controller(PaisController::class)->prefix('Pais')->group( function () {
        Route::get('pais-all-resource', 'getAll')->name('pais.all-resource');
        Route::get('departamentos-pais/{pais_id}', 'departamentosPais')->name('pais.departamentos-pais-resource');
        Route::get('municipios-departamento/{depa_id}', 'municipiosDepartamento')->name('pais.municipios-departamento-resource');
    });

    Route::controller(EstadoCivilController::class)->prefix('EstadoCivil')->group( function () {
        Route::get('estado-civil-all-resource', 'findAll')->name('estado-civil.all-resource');
    });


});
