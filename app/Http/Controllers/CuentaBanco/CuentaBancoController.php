<?php

namespace App\Http\Controllers\CuentaBanco;

use App\Http\Controllers\Controller;
use App\Http\Requests\CuentaBanco\CuentaBancoRequest;
use App\Models\Banco;
use App\Models\CuentaBanco;
use App\Models\CuentaSucursal;
use App\Models\TipoCuenta;
use Carbon\Exceptions\Exception;
use Inertia\Inertia;

class CuentaBancoController extends Controller {
    
    public function __invoke() {
        
    }

    public function index() { 
        $cuentasBanco = CuentaBanco::with('banco:BANC_ID,BANC_NOMBRE',
            'tipoCuenta:TIPO_ID,TIPO_NOMBRE',
            'cuentaSucursal:CUEN_ID,CUEN_NOMBRE')->get(); 
          
        $cuentasSucursales = CuentaSucursal::select('CUEN_ID','CUEN_NOMBRE','SUCU_ID')
            ->with('sucursal:SUCU_ID,SUCU_NOMBRE')
            ->where('CUEN_ESTADO', 1)->get();
            
        $bancos = Banco::select('BANC_ID','BANC_NOMBRE')
            ->where('BANC_ESTADO',1)->get();


        return Inertia::render('Banco/CuentaBanco', [
            'cuentaBancos' => $cuentasBanco,
            'tiposCuenta' => TipoCuenta::select('TIPO_ID','TIPO_NOMBRE')->where('TIPO_ESTADO', 1)->get(),
            'cuentasSucursales' => $cuentasSucursales,
            'bancos' => $bancos 
        ]);
    }

    public function store(CuentaBancoRequest $request){
        try { 
            $cuentaBanco = new CuentaBanco();
            $cuentaBanco->CUEB_NUMERO = $request->CUEB_NUMERO;
            $cuentaBanco->CUEB_DETALLE = $request->CUEB_DETALLE;
            $cuentaBanco->CUEN_ID = $request->CUEN_ID;
            $cuentaBanco->BANC_ID = $request->BANC_ID;
            $cuentaBanco->TIPC_ID = $request->TIPC_ID;
            $cuentaBanco->CUEB_ESTADO = $request->CUEB_ESTADO;
            $cuentaBanco->CUEB_NUMERO = $request->CUEB_NUMERO;
            $cuentaBanco->InsertQuerySql();
            session()->flash('message', 'Cuenta de banco creada correctamente');
        } catch (\Exception $e) {
            // Si hay un error, devolver una respuesta JSON con el mensaje de error 
        }
    }

    public function update(CuentaBancoRequest $request){
        try {
            $cuentaBanco = CuentaBanco::findOrFail($request->CUEB_NUMERO);
            $cuentaBanco->CUEB_DETALLE = $request->CUEB_DETALLE;
            $cuentaBanco->CUEN_ID = $request->CUEN_ID;
            $cuentaBanco->BANC_ID = $request->BANC_ID;
            $cuentaBanco->TIPC_ID = $request->TIPC_ID;
            $cuentaBanco->CUEB_ESTADO = $request->CUEB_ESTADO;
            $cuentaBanco->save();
        } catch (\Throwable $th) {  
            
        }
    }

    public function changedStatus($CUEN_ID){
        try {
            $cuenta = CuentaBanco::findOrFail($CUEN_ID);
            if(!$cuenta){
                throw new \Exception('La cuenta no existe');
            }
            $cuenta->CUEB_ESTADO = !$cuenta->CUEB_ESTADO;
            $cuenta->save();
        } catch (\Exception $th) {
            throw $th;
        }
    }
}
