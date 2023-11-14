<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Banco\ChequeraController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\CuentaBanco\CuentaBancoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(LoginController::class)->group( function () {
    Route::get('/', 'index')->name('welcome'); 
});


Route::controller(BancoController::class)->group( function () {
    Route::get('/banco', 'index')->name('banco-layout');
    Route::post('banco-create', 'store')->name('banco.store');
    Route::put('banco-update', 'update')->name('banco.update');
});

Route::controller(CuentaBancoController::class)->group( function () {
    Route::get('cuenta-banco', 'index')->name('cuenta-banco-layout');
    Route::post('cuenta-banco-create', 'store')->name('cuenta-banco.store');
    Route::put('cuenta-banco-update', 'update')->name('cuenta-banco.update');
});

Route::controller(ChequeraController::class)->group( function () {
    Route::get('chequera-page', 'index')->name('chequera-layout');
});
 
 
 
/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


/*Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
*/