<?php

use App\Http\Controllers\Administracion\AplicarPagosController;
use App\Http\Controllers\Administracion\ColecturiaController;
use App\Http\Controllers\Administracion\ModuloCajaController;
use App\Http\Controllers\Banco\ChequeraController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\CuentaBanco\CuentaBancoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(BancoController::class)->group( function () {
    Route::get('banco-page', 'index')->name('banco-layout');
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
    Route::get('chequera-get-cheques/{CHEQ_ID}', 'getCheques')->name('chequera.get-cheques');
    Route::post('chequera-create-cheque', 'createCheque')->name('chequera.create-cheque'); 
    Route::post('chequera-create', 'store')->name('chequera.store');
    Route::put('chequera-update-status/{CHEQ_ID}', 'cambiarEstadoChequera')->name('chequera.update-status');
});