<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Solicitud;
use App\Models\TipoCredito;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Ignition\Contracts\Solution;

class CreditosController extends Controller {

    public function __construct() { 
    }

    public $solicitudes;


    public function index() { 
        $this->solicitudes = Solicitud::select('*')
            ->with('cliente')
            ->paginate(20);

        $this->solicitudes->transform(function ($item) {
            $item->SOLI_MONTO = number_format($item->SOLI_MONTO, 2, ',', '.');
            $item->SOLI_CUOTA = number_format($item->SOLI_CUOTA, 2, ',', '.');
            $item->SOLI_PLAZO = number_format($item->SOLI_PLAZO, 2, ',', '.');
            $item->cliente->NOMBRE = $item->cliente->CLIE_NOMBRE . ' ' . $item->cliente->CLIE_NOMBRE2. ' ' . $item->cliente->CLIE_APELLIDO.' '. $item->cliente->CLIE_APELLIDO2;
            return $item;
        });

        return Inertia::render('Creditos/Solicitud', [
            'response' => $this->solicitudes, 
            'count' => Solicitud::count()
        ]);
    }


    //method for search solicitudes
    public function search(Request $request) {
        $solicitudes = Solicitud::select('*')
            ->where('SOLI_NOMBRE', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_APELLIDO', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_CEDULA', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_TELEFONO', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_CORREO', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_DIRECCION', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_MONTO', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_PLAZO', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_CUOTA', 'LIKE', '%' . $request->search . '%')
            ->orWhere('SOLI_ESTADO', 'LIKE', '%' . $request->search . '%')
            ->paginate(20);

        return Inertia::render('Creditos/Solicitud', [
            'response' => $solicitudes
        ]);
    }


    public function fillterByStatus($status) {
        $this->solicitudes = Solicitud::select('*')
            ->where('SOLI_ESTADO', $status)
            ->paginate(20); 

        $this->solicitudes->transform(function ($item) {
                $item->SOLI_MONTO = number_format($item->SOLI_MONTO, 2, ',', '.');
                $item->SOLI_CUOTA = number_format($item->SOLI_CUOTA, 2, ',', '.');
                $item->SOLI_PLAZO = number_format($item->SOLI_PLAZO, 2, ',', '.');
                $item->cliente->NOMBRE = $item->cliente->CLIE_NOMBRE . ' ' . $item->cliente->CLIE_NOMBRE2. ' ' . $item->cliente->CLIE_APELLIDO.' '. $item->cliente->CLIE_APELLIDO2;
                return $item;
            });

        return response()->json($this->solicitudes);
    }


    public function ComboBoxCliente(){
        $clientes = Cliente::select('CLIE_ID','CLIE_NOMBRE','CLIE_NOMBRE2','CLIE_APELLIDO','CLIE_APELLIDO2')->get();
        $clientes->transform(function ($item) {
            $item->NOMBRE = $item->CLIE_NOMBRE . ' ' . $item->CLIE_NOMBRE2. ' ' . $item->CLIE_APELLIDO.' '. $item->CLIE_APELLIDO2;
            return [
                'CLIE_ID' => $item->CLIE_ID,
                'NOMBRE' => $item->NOMBRE
            ];
        });

        return response()->json($clientes);
    }

    public function ComboBoxTipoCredito(){
        $tiposCredito = TipoCredito::select('TIPO_ID','TIPO_NOMBRE')
            ->where('TIPO_ESTADO', 1)
            ->get();
        return response()->json($tiposCredito);
    } 


    public function findAll(){
        $this->solicitudes = Solicitud::select('*')
            ->with('cliente')
            ->paginate(20);

        $this->solicitudes->transform(function ($item) {
            $item->SOLI_MONTO = number_format($item->SOLI_MONTO, 2, ',', '.');
            $item->SOLI_CUOTA = number_format($item->SOLI_CUOTA, 2, ',', '.');
            $item->SOLI_PLAZO = number_format($item->SOLI_PLAZO, 2, ',', '.');
            $item->cliente->NOMBRE = $item->cliente->CLIE_NOMBRE . ' ' . $item->cliente->CLIE_NOMBRE2. ' ' . $item->cliente->CLIE_APELLIDO.' '. $item->cliente->CLIE_APELLIDO2;
            return $item;
        });
        return response()->json($this->solicitudes);
    }

}
