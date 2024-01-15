<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Return_;

class AplicarPagosController extends Controller {
    public function index() {
        return Inertia::render('Administracion/AplicarPago');
    }

    public function allCreditos() {
        try {
            $creditos = Solicitud::with('cliente')->where('SOLI_ESTADO', '=', 4)
                ->get();

            $creditos->transform(function ($item, $key) { 
                return [
                    'SOLI_ID' => $item->SOLI_ID, 
                    'CLIENTE' => [
                        'NOMBRE' => $item->cliente->getNombreCompletoAttribute(),
                        'DUI' => $item->cliente->CLIE_DOCIDEN, 
                    ],
                    'MONTO' => $item->SOLI_MONTO,
                    
                ];
            });
            return response()->json($creditos);
        } catch (\Throwable $th) {
            return $th;
        }
    }


    public function search($query) {
        // buscar por id del cliente que esta en la solicitud
        $query = mb_strtolower($query, 'UTF-8');
        $creditos = Solicitud::with('cliente')->where('SOLI_ID', 'LIKE', "%$query%")
            ->orWhere('SOLI_MONTO', 'LIKE', "%$query%")
            ->orWhere('SOLI_FECHA', 'LIKE', "%$query%")
            ->orWhereHas('cliente', function ($q) use ($query) {
                $q->where(DB::raw("LOWER(CONCAT(CLIE_NOMBRE, ' ', CLIE_NOMBRE2, ' ', CLIE_APELLIDO, ' ', CLIE_APELLIDO2))"), 'LIKE', "%{$query}%")
                    ->orWhere('CLIE_APELLIDO', 'LIKE', "%$query%")
                    ->orWhere('CLIE_DOCIDEN', 'LIKE', "%$query%"); 
            })
            ->orWhere('SOLI_MONTO', 'LIKE', "%$query%")
            ->get();

        $creditos->transform(function ($item, $key) { 
            return [
                'SOLI_ID' => $item->SOLI_ID, 
                'CLIENTE' => [
                    'NOMBRE' => $item->cliente->getNombreCompletoAttribute(),
                    'DUI' => $item->cliente->CLIE_DOCIDEN, 
                ],
                'MONTO' => $item->SOLI_MONTO,
            ];
        });
        return response()->json($creditos);
    }

    public function obtenerPorId($SOLI_ID){
        $credito = Solicitud::where('SOLI_ID', '=', $SOLI_ID)
            ->where('SOLI_ESTADO', '=', 4);
        return response()->json($credito);
    }


    public function detalleCredito($ID_CREDITO) {
        try {
            $credito = Solicitud::where('SOLI_ID', $ID_CREDITO)->first();

            $credito->MONTO_TOTAL = $credito->montoMasInteres();
            $credito->CANTIDAD_CUOTAS = $credito->cantidadCuotas();
            $credito->MONTO_CUOTA = $credito->montoCuota();
            $credito->CUOTAS = $credito->cuotas();
            $credito->CLIENTE = [
                'CLIE_ID' => $credito->cliente->CLIE_ID,
                'NOMBRE_COMPLETO' => $credito->cliente->getNombreCompletoAttribute(),
            ];

            $credito->EMPLEADO = [
                'EMPL_ID' => $credito->empleado->EMPL_ID,
                'NOMBRE_COMPLETO' => $credito->empleado->nombreCompleto(),
            ];

            return response()->json(
                $credito->only(
                    'SOLI_ID', 'SOLI_FECHA', 'SOLI_MONTO', 'SOLI_ESTADO', 'MONTO_TOTAL', 'CANTIDAD_CUOTAS', 'MONTO_CUOTA', 'CUOTAS', 'CLIENTE', 'EMPLEADO', 'SOLI_FECHAAPROB')
            );
        } catch (\Throwable $th) {
            return $th;
        }
         
    } 

}
