<?php

use App\Http\Controllers\Administracion\AplicarPagosController;
use App\Http\Controllers\Administracion\ArqueoCajaController;
use App\Http\Controllers\Administracion\ColecturiaController;
use App\Http\Controllers\Administracion\ModuloCajaController;
use App\Http\Controllers\Administracion\PagosDiversosController;
use App\Http\Controllers\Administracion\RemesasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(ModuloCajaController::class)->prefix('caja')->group( function () {
    Route::get('', 'index')->name('modulo-caja-layout');
});

Route::controller(AplicarPagosController::class)->prefix('caja')->group( function () {
    Route::get('aplicar-pagos-page', 'index')->name('aplicar-pagos-layout');
    Route::get('all-creditos', 'allCreditos')->name('aplicar-pagos.all-creditos');
    Route::get('search/{query}', 'search')->name('aplicar-pagos.search');
    Route::get('get-detalle-credito/{ID_CREDITO}', 'detalleCredito')->name('aplicar-pagos.detalle-credito');
    Route::get('getByID/{ID_CREDITO}', 'obtenerPorId')->name('aplicar-pagos.obtenerPorId');
});

Route::controller(ColecturiaController::class)->prefix('caja')->group( function () {
    Route::get('colecturia-page', 'index')->name('colecturia-layout');
});
 

Route::controller(RemesasController::class)->prefix('caja')->group( function () {
    Route::get('remesas-page', 'index')->name('remesas-layout');
});

Route::controller(PagosDiversosController::class)->prefix('caja')->group( function () {
    Route::get('pagos-diversos-page', 'index')->name('pagos-diversos-layout');
});

Route::controller(ArqueoCajaController::class)->prefix('caja')->group( function () {
    Route::get('arqueo-caja-page', 'index')->name('arqueo-caja-layout');
});