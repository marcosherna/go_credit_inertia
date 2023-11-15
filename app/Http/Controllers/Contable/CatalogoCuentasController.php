<?php

namespace App\Http\Controllers\Contable;

use App\Http\Controllers\Controller;
use App\Models\Colector;
use App\Models\CuentaBanco;
use App\Models\CuentaSucursal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PhpParser\Node\Expr\Cast\Array_;
use PHPUnit\Framework\Constraint\Count;

class MapCuenta {
    public CuentaSucursal $padre;
    public $hijos = [];
}

class CatalogoCuentasController extends Controller {

    public $mapaCuentas = [];
    
    public function index() { 
        $cuentasSucursales =  CuentaSucursal::where('CUEN_ESTADO', 1)
            ->with('sucursal')->orderBy('CUEN_CONTA', 'asc')
            ->get();  

        $cuentaBancos = CuentaBanco::select('CUEB_NUMERO','BANC_ID')
            ->with('banco:BANC_ID,BANC_NOMBRE')->get();
        
        return Inertia::render('contable/CatalogoCuentas', [
            'order' => $this->mapCuenta($cuentasSucursales),
            'cuentasSucursales' => $cuentasSucursales,
            'cuentaBancos' => $cuentaBancos
        ]);
    }


    public function mapCuenta($cuentas) {
        $result = collect(); 
        foreach ($cuentas as $key => $value) {
            $string_numero_cuenta = strval($value->CUEN_CONTA); 
            $cumple_requisitos = strlen($string_numero_cuenta) == 1; 

            if($cumple_requisitos){ 
                $mapCuenta = new MapCuenta();
                $mapCuenta->padre = $value;
                $mapCuenta->hijos = collect();

                foreach($cuentas as $key2 => $value2){
                    $numeros =  strval($value2->CUEN_CONTA);  
                    if($numeros[0] == $string_numero_cuenta){
                        $mapCuenta->hijos->push($value2);
                    }
                }

                $result->push($mapCuenta); 
            } 

        }
        return $result;
    }


    
}
