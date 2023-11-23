<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Pais;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaisController extends Controller {
    
    public function index() {
        return Inertia::render('Catologos/Pais');
    }

    public function store(Request $request) {
        try { 
            $pais = Pais::create($request->validated());   
            if (!$pais) {
                throw new \Exception('Error al crear el pais.');
            } 

            return redirect()->route('pais-layout')->with('success', 'Pais creado.');

        } catch (\Exception $th) {
            return redirect()->route('pais-layout')->with('error', $th->getMessage());
        }
    }

    public function getAll() {
        $paises = Pais::select('PAIS_ID','PAIS_NOMBRE','PAIS_ESTADO')->where('PAIS_ESTADO', 1)->get();
        return response()->json($paises);
    }

    public function departamentosPais($pais_id) {
        $departamentos = Departamento::select('DEPA_ID',
        'DEPA_NOMBRE','PAIS_ID')->where('DEPA_ESTADO', 1)
        ->where('PAIS_ID', $pais_id)->get();

        return response()->json($departamentos);
    }

    public function municipiosDepartamento($depa_id) {
        $municipios =  Municipio::getMunicipiosDepartamento($depa_id);
        return response()->json($municipios);
    }
}
