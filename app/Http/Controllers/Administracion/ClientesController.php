<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\ClienteRequest;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\EstadoCivil;
use App\Models\Municipio;
use App\Models\Pais;
use App\Models\Solicitud;
use App\Models\Sucursal;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ClientesController extends Controller {
    
    public function index() {
        $clientes = Cliente::select('CLIE_ID','CLIE_NOMBRE','CLIE_NOMBRE2','CLIE_APELLIDO','CLIE_APELLIDO2', 
            'CLIE_SEXO','ESTA_ID','PAIS_NAC', 'DEPA_NAC','CLIE_FECHANAC','CLIE_DOCIDEN', 
            'CLIE_DOCFISCAL', 'CLIE_DIRECCION','CLIE_TEL','CLIE_TEL2','CLIE_MAIL', 
            'CLIE_PROFESION','CLIE_TIPOEMPLEO','CLIE_SCORE','CLIE_ESTADO')
                ->with('paisNacimiento:PAIS_ID,PAIS_NOMBRE', 
                    'departamentoNacimiento:DEPA_ID,DEPA_NOMBRE') 
                ->paginate(50);

        return Inertia::render('Administracion/Clientes', 
            ['clientes' => $clientes]
        );
    }

    public function store() {
        $estadosCiviles = EstadoCivil::select('ESTA_ID','ESTA_NOMBRE','ESTA_ESTADO')->get();
        $paises = Pais::select('PAIS_ID','PAIS_NOMBRE','PAIS_ESTADO')->where('PAIS_ESTADO', 1)->get();

        $sucursales = Sucursal::select('SUCU_ID','SUCU_NOMBRE','SUCU_ESTADO')->where('SUCU_ESTADO', 1)->get();
        $empresas = Empresa::select('EMPR_ID','EMPR_NOMBRE','EMPR_ESTADO')->where('EMPR_ESTADO', 1)->get();

        return Inertia::render('Administracion/partials/CrearCliente', [
            'estadosCiviles' => $estadosCiviles,
            'paises' => $paises, 
            'sucursales' => $sucursales,
            'empresas' => $empresas, 
        ]); 
    }


    public function create(ClienteRequest $request){ 
        try {
            $cliente = new Cliente();
            $cliente->CLIE_NOMBRE = $request->CLIE_NOMBRE; 
            $cliente->CLIE_NOMBRE2 = $request->CLIE_NOMBRE2; 
            $cliente->CLIE_NOMBRE3 = $request->CLIE_NOMBRE3; 
            $cliente->CLIE_APELLIDO = $request->CLIE_APELLIDO; 
            $cliente->CLIE_APELLIDO2 = $request->CLIE_APELLIDO2;
            $cliente->CLIE_APELLIDO3 = $request->CLIE_APELLIDO3; 
            $cliente->CLIE_SEXO = $request->CLIE_SEXO; 
            $cliente->ESTA_ID = $request->ESTA_ID; 
            $cliente->PAIS_NAC = $request->PAIS_NAC; 
            $cliente->DEPA_NAC = $request->DEPA_NAC; 
            $cliente->CLIE_FECHANAC = $request->CLIE_FECHANAC;
            $cliente->CLIE_DOCIDEN = $request->CLIE_DOCIDEN;
            $cliente->CLIE_DOCIDENVEN = $request->CLIE_DOCIDENVEN;
            $cliente->CLIE_DOCFISCAL = $request->CLIE_DOCFISCAL;
            $cliente->CLIE_PASAPORTE = $request->CLIE_PASAPORTE;
            $cliente->CLIE_OTRODOC = $request->CLIE_OTRODOC;
            $cliente->CLIE_OTRODOC2 = $request->CLIE_OTRODOC2;
            $cliente->CLIE_ANTECEDENTES = $request->CLIE_ANTECEDENTES;
            $cliente->PAIS_ID = $request->PAIS_NAC;
            $cliente->DEPA_ID = $request->DEPA_NAC;
            $cliente->MUNI_ID = $request->MUNI_ID;
            $cliente->CLIE_DIRECCION = $request->CLIE_DIRECCION;
            $cliente->CLIE_TEL = $request->CLIE_TEL;
            $cliente->CLIE_TEL2 = $request->CLIE_TEL2;
            $cliente->CLIE_MAIL = $request->CLIE_MAIL;
            $cliente->CLIE_MAIL2 = $request->CLIE_MAIL2;
            $cliente->CLIE_TIPOCASA = $request->CLIE_TIPOCASA;
            $cliente->CLIE_PROFESION = $request->CLIE_PROFESION;
            $cliente->CLIE_TIPOEMPLEO = $request->CLIE_TIPOEMPLEO;
            $cliente->CLIE_TRABAJO = $request->CLIE_TRABAJO;
            $cliente->CLIE_TRABAJODIR = $request->CLIE_TRABAJODIR;
            $cliente->CLIE_TRABAJOTEL = $request->CLIE_TRABAJOTEL;
            $cliente->CLIE_INGRESOPROM = $request->CLIE_INGRESOPROM;
            $cliente->CLIE_INGRESOS = $request->CLIE_INGRESOS;
            $cliente->CLIE_INGRESOADIC = $request->CLIE_INGRESOADIC;
            $cliente->CLIE_INGRESOORIGEN = $request->CLIE_INGRESOORIGEN;
            $cliente->CLIE_REF1NOMBRE = $request->CLIE_REF1NOMBRE;
            $cliente->CLIE_REF1PARENTESCO = $request->CLIE_REF1PARENTESCO;
            $cliente->CLIE_REF1DIRECCION = $request->CLIE_REF1DIRECCION;
            $cliente->CLIE_REF1TELEFONO = $request->CLIE_REF1TELEFONO;
            $cliente->CLIE_REF2NOMBRE = $request->CLIE_REF2NOMBRE;
            $cliente->CLIE_REF2PARENTESCO = $request->CLIE_REF2PARENTESCO;
            $cliente->CLIE_REF2DIRECCION = $request->CLIE_REF2DIRECCION;
            $cliente->CLIE_REF2TELEFONO = $request->CLIE_REF2TELEFONO;
            $cliente->CLIE_REF3NOMBRE = $request->CLIE_REF3NOMBRE;
            $cliente->CLIE_REF3PARENTESCO = $request->CLIE_REF3PARENTESCO;
            $cliente->CLIE_REF3DIRECCION = $request->CLIE_REF3DIRECCION;
            $cliente->CLIE_REF3TELEFONO = $request->CLIE_REF3TELEFONO;
            $cliente->CLIE_COMENTARIOS = $request->CLIE_COMENTARIOS;
            $cliente->CLIE_OBSERVACIONES = $request->CLIE_OBSERVACIONES;
            $cliente->CLIE_TIPOCLIENTE = $request->CLIE_TIPOCLIENTE;
            $cliente->CLIE_CATEGORIA = $request->CLIE_CATEGORIA;
            $cliente->CLIE_SCORE = $request->CLIE_SCORE;
            $cliente->CLIE_ESTADO = 1; // activo
            $cliente->SUCU_ID = $request->SUCU_ID;
            $cliente->EMPR_ID = $cliente->getEmpresa(Auth::user()->EMPL_ID)->EMPR_ID; // empresa del usuario en sesion
            $cliente->USUA_LOGIN = Auth::user()->USUA_LOGIN;
            $cliente->FECHA_CAMBIO = date('Y-m-d H:i:s'); // fecha actual
            $cliente->insert(); 
        } catch (\Throwable $th) {
            return response()->json($th); 
        }
    }


    public function helper() {
        $paises = Pais::select('PAIS_ID','PAIS_NOMBRE')->where('PAIS_ESTADO', 1)->get(); 
        $municipios = Municipio::select('MUNI_ID','MUNI_NOMBRE')->where('MUNI_ESTADO',1)->get();
        $departamentos = Departamento::select('DEPA_ID','DEPA_NOMBRE')->where('DEPA_ESTADO',1)->get();
        $empresas = Empresa::select('EMPR_ID','EMPR_NOMBRE')->where('EMPR_ESTADO',1)->get();
        $sucursales = Sucursal::select('SUCU_ID','SUCU_NOMBRE')->where('SUCU_ESTADO',1)->get();

        $helper = [ 
            'paises' => $paises, 
            'municipios' => $municipios, 
            'departamentos' => $departamentos, 
            'empresas' => $empresas,
            'sucursales' => $sucursales
        ];

        return response()->json($helper);
    }


    public function show($CLIE_ID){
        $cliente = Cliente::where('CLIE_ID', $CLIE_ID)
            ->with('paisNacimiento:PAIS_ID,PAIS_NOMBRE')
                ->first();
 
                
        return Inertia::render('Administracion/partials/DetalleCliente', [
            'cliente' => $cliente,
            'solicitudes' => $cliente->solicitudeCreditos()
        ]);
    }

    public function edit($CLIE_ID){
        $cliente = Cliente::where('CLIE_ID', $CLIE_ID)->first();

        $estadosCiviles = EstadoCivil::select('ESTA_ID','ESTA_NOMBRE','ESTA_ESTADO')->get();
        $paises = Pais::select('PAIS_ID','PAIS_NOMBRE','PAIS_ESTADO')->where('PAIS_ESTADO', 1)->get();
        $municipios = Municipio::select('MUNI_ID','MUNI_NOMBRE')->where('MUNI_ESTADO',1)->get();
        $departamentos = Departamento::select('DEPA_ID','DEPA_NOMBRE')->where('DEPA_ESTADO',1)->get();
        $empresas = Empresa::select('EMPR_ID','EMPR_NOMBRE','EMPR_ESTADO')->where('EMPR_ESTADO', 1)->get();
        $sucursales = Sucursal::select('SUCU_ID','SUCU_NOMBRE','SUCU_ESTADO')->where('SUCU_ESTADO', 1)->get();

        return Inertia::render('Administracion/partials/EditarCliente', [
            'cliente' => $cliente,
            'estadosCiviles' => $estadosCiviles,
            'paises' => $paises, 
            'municipios' => $municipios, 
            'departamentos' => $departamentos, 
            'empresas' => $empresas,
            'sucursales' => $sucursales
        ]);
    }


    public function solicitudes($CLIE_ID){

        $solicitudes = Solicitud::select('SOLI_ID','SOLI_CATEGORIA','SOLI_FECHAAPROB','SOLI_FECHAVENCIMIENTO','SOLI_MONTO','SOLI_ESTADO')
            ->where('CLIE_ID', $CLIE_ID)  
            ->where('SOLI_ESTADO','!=',99)
            ->get(); 

        return response()->json($solicitudes);
    }


    public function findAll(){
        $clientes = Cliente::select('CLIE_ID','CLIE_NOMBRE','CLIE_NOMBRE2','CLIE_APELLIDO','CLIE_APELLIDO2', 
            'CLIE_SEXO','ESTA_ID','PAIS_NAC', 'DEPA_NAC','CLIE_FECHANAC','CLIE_DOCIDEN', 
            'CLIE_DOCFISCAL', 'CLIE_DIRECCION','CLIE_TEL','CLIE_TEL2','CLIE_MAIL', 
            'CLIE_PROFESION','CLIE_TIPOEMPLEO','CLIE_SCORE','CLIE_ESTADO')
                ->with('paisNacimiento:PAIS_ID,PAIS_NOMBRE', 
                    'departamentoNacimiento:DEPA_ID,DEPA_NOMBRE') 
                ->paginate(10);

        return response()->json($clientes);
    }

    public $clientes = [];
    public function search($query = null){
        $this->clientes = [];
        if($query){
            $this->clientes = Cliente::where('CLIE_NOMBRE','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_NOMBRE2','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_APELLIDO','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_APELLIDO2','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_DOCIDEN','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_DOCFISCAL','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_TEL','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_TEL2','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_MAIL','LIKE', '%'.$query.'%')
                ->orWhere('CLIE_ID','LIKE', '%'.$query.'%')
                ->get();
        }

        $this->clientes->transform(function($item){
            return [
                'CLIE_ID' => $item->CLIE_ID,
                'NOMBRE' => $item->CLIE_NOMBRE.' '.$item->CLIE_NOMBRE2.' '.$item->CLIE_APELLIDO.' '.$item->CLIE_APELLIDO2,
                'MAIL' => $item->CLIE_MAIL ? $item->CLIE_MAIL : 'Sin correo',
                'TELEFONO' => $item->CLIE_TEL ? $item->CLIE_TEL : 'Sin telefono',
                'DOCIDEN' => $item->CLIE_DOCIDEN ? $item->CLIE_DOCIDEN : 'Sin documento',
            ];
        });

        return response()->json($this->clientes);

    }


}
