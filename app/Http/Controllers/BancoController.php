<?php

namespace App\Http\Controllers;

use App\Http\Requests\Banco\BancoRequest; 
use App\Models\Banco;
use App\Models\Sucursal;
use Illuminate\Http\Response;

class BancoController extends Controller {

    public $search = '';
    public function __invoke() {
        
    }

    public function index() {
        $bancos = Banco::select('BANC_ID','BANC_NOMBRE','BANC_DETALLE','BANC_ESTADO','SUCU_ID')
        ->with('sucursal:SUCU_ID,SUCU_NOMBRE')
        ->where('BANC_NOMBRE', 'like', '%'.$this->search.'%')
        ->orWhere('BANC_DETALLE', 'like', '%'.$this->search.'%') 
        ->orWhereHas('sucursal', function($query){
            $query->where('SUCU_NOMBRE', 'like', '%'.$this->search.'%');
        })->orWhere('BANC_ID', 'like', '%'.$this->search.'%')->paginate(10);

        return inertia('Banco/ModuloBanco', [
            'paginate' => $bancos, 
            'sucursales' => Sucursal::select('SUCU_ID', 'SUCU_NOMBRE')->get()
        ]);
    }
    
    public function store(BancoRequest $request){  
        try {
            $bancos = new Banco();
            $bancos->BANC_NOMBRE = $request->BANC_NOMBRE;
            $bancos->BANC_DETALLE = $request->BANC_DETALLE;
            $bancos->SUCU_ID = $request->SUCU_ID;
            $bancos->BANC_ESTADO = $request->BANC_ESTADO;
            $bancos->Insert(); 
            session()->flash('message', 'Banco creado correctamente');
        } catch (\Exception $e) {
            // Si hay un error, devolver una respuesta JSON con el mensaje de error
            return response()->json(['error' => 'Error al crear el banco', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } 
    }

    public function update(BancoRequest $request){
        try {
            $banco = Banco::findOrFail($request->BANC_ID);
            $banco->BANC_NOMBRE = $request->BANC_NOMBRE;
            $banco->BANC_DETALLE = $request->BANC_DETALLE;
            $banco->SUCU_ID = $request->SUCU_ID;
            $banco->BANC_ESTADO = $request->BANC_ESTADO;
            $banco->save(); 
        } catch (\Exception $e) {
            // Si hay un error, devolver una respuesta JSON con el mensaje de error
            return response()->json(['error' => 'Error al actualizar el banco', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } 
    }

    public function changedStatus($BANC_ID){
        try {
            $banco = Banco::findOrFail($BANC_ID);
            if(!$banco){
                throw new \Exception('El banco no existe');
            }
            
            $banco->BANC_ESTADO = !$banco->BANC_ESTADO;
            $banco->save();

        } catch (\Exception $th) {
            throw $th;
        }
    }

}

