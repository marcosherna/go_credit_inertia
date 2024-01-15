<?php
 
use App\Http\Controllers\Administracion\ClientesController;
use App\Http\Controllers\Administracion\CreditosDesembolsadosController; 
use App\Http\Controllers\Administracion\SolicitudController; 
use App\Http\Controllers\Catalogos\EstadoCivilController;
use App\Http\Controllers\Catalogos\FormaPagoController;
use App\Http\Controllers\Catalogos\GarantiasController;
use App\Http\Controllers\Catalogos\PaisController;
use App\Http\Controllers\Catalogos\PlazosController;
use App\Http\Controllers\Catalogos\ReferenciasController;
use App\Http\Controllers\Catalogos\TasaInteresController;
use App\Http\Controllers\Catalogos\TipoCreditoController;
use App\Http\Controllers\Catalogos\TipoInteresController;
use App\Http\Controllers\Contable\CatalogoCuentasController;
use App\Http\Controllers\Contable\PartidaContableController;
use App\Http\Controllers\Creditos\CreditosController;
use App\Http\Controllers\Creditos\CreditosPorAprobarController;
use App\Http\Controllers\Creditos\CreditosPorProcesarController;
use App\Http\Controllers\Creditos\DetalleCreditosController; 
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

    
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified','flash'])->group(function () { 
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard'); 
    
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
        Route::get('clente-seach/{query?}', 'search')->name('cliente.search-resource');
    });

    Route::controller(SolicitudController::class)->prefix('solicitud')->group( function () {
        Route::get('solicitud-detalle/{id}', 'findById')->name('solicitud.detalle-resource');
        Route::get('solicitud-cuotas/{id}', 'findCuotas')->name('solicitud.cuotas-resource');
        Route::get('solicitud-take-cliente/{id}/{take}', 'findByIdClient')->name('solicitud.take-cliente-creditos-resource');
        Route::post('solicitud-create', 'store')->name('solicitud.store');
        Route::put('solicitud-update/{id}/{status}', 'changedStatus')->name('solicitud-status.update');
        Route::get('solicitud-find', 'find')->name('solicitud.find-resource');
        Route::get('solicitud-search/{query?}', 'search')->name('solicitud.search-resource');
        Route::put('solicitud-update/{id}', 'edit')->name('solicitud.edit-resource');
    });

    Route::controller(PaisController::class)->prefix('Pais')->group( function () {
        Route::get('pais-all-resource', 'getAll')->name('pais.all-resource');
        Route::get('departamentos-pais/{pais_id}', 'departamentosPais')->name('pais.departamentos-pais-resource');
        Route::get('municipios-departamento/{depa_id}', 'municipiosDepartamento')->name('pais.municipios-departamento-resource');
    });

    Route::controller(EstadoCivilController::class)->prefix('EstadoCivil')->group( function () {
        Route::get('estado-civil-all-resource', 'findAll')->name('estado-civil.all-resource');
    });


    Route::controller(CreditosController::class)->prefix('Creditos')->group( function () { 
        Route::get('creditos-page', 'index')->name('creditos-layout'); 
        Route::get('search', 'search')->name('creditos.search');
        Route::get('fillter-by-status/{status?}', 'fillterByStatus')->name('creditos.fillter-by-status');
        Route::get('combo-box-cliente', 'ComboBoxCliente')->name('creditos.combo-box-cliente');
        Route::get('findAll-resourse', 'findAll')->name('creditos.findAll-resourse');
    });

    Route::controller(CreditosPorAprobarController::class)->prefix('CreditosPorAprobar')->group( function () {
        Route::get('creditos-por-aprobar-page', 'index')->name('creditos-por-aprobar-layout');
       
    });

    Route::controller(CreditosPorProcesarController::class)->prefix('CreditosPorProcesar')->group( function () {
        Route::get('creditos-por-procesar-page', 'index')->name('creditos-por-procesar-layout');
        Route::put('observar-credito', 'observarCredito')->name('creditos-por-aprobar-observar-credito');
    });
    Route::controller(CreditosDesembolsadosController::class)->prefix('modulo-caja')->group( function () {
        Route::get('creditos-desembolsados-page', 'index')->name('creditos-desembolsados-layout');
    });

    Route::controller(DetalleCreditosController::class)->prefix('DetalleCreditos')->group( function () {
        Route::get('detalle-creditos-page/{CLIE_ID}/{SOLI_ID?}', 'index')->name('detalle-creditos-layout');
    });
 
    Route::controller(TipoCreditoController::class)->group( function () {
        Route::get('tipos-resource', 'Combo')->name('tipos-creditos-resource');
    }); 
    
    Route::controller(GarantiasController::class)->group( function () {
        Route::get('garantias-resource', 'Combo')->name('garantias-resource');
    });


    Route::controller(PlazosController::class)->group( function () {
        Route::get('plazos-resource', 'Combo')->name('plazos-resource');
    });

    Route::controller(FormaPagoController::class)->group( function () {
        Route::get('formas-pago-resource', 'Combo')->name('formas-pago-resource');
    });

    Route::controller(TasaInteresController::class)->group( function () {
        Route::get('tasa-interes-resource', 'Combo')->name('tasa-interes-resource');
    });


    Route::controller(TipoInteresController::class)->group( function () {
        Route::get('tipo-interes-resource', 'Combo')->name('tipo-interes-resource');
    });

    Route::controller(ReferenciasController::class)->prefix('referencias')->group( function() {
       Route::get('exist/{REFE_DUI}', 'exist')->name('referencias.exist'); 
    });

});
