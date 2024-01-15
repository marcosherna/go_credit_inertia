<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Solicitud;
use Inertia\Inertia;

class DetalleCreditosController extends Controller {
    public function index($CLIE_ID, $SOLI_ID =NULL) {

        $SOLICITUD = NULL;
        if($SOLI_ID != NULL) {
            $SOLICITUD = Solicitud::select('*')
                ->where('SOLI_ID', '=', $SOLI_ID)
                ->first(); 
        }
        $Cliente = Cliente::select('*')
            ->where('CLIE_ID', '=', $CLIE_ID)
            ->first(); 
        
        $Cliente->NOMBRE = $Cliente->CLIE_NOMBRE . ' ' . $Cliente->CLIE_NOMBRE2. ' ' . $Cliente->CLIE_APELLIDO.' '. $Cliente->CLIE_APELLIDO2;

        $Cliente->CLIE_FECHANAC = date('d-m-Y', strtotime($Cliente->CLIE_FECHANAC)); 
        $Cliente->MAILS = $Cliente->getMail();
        $Cliente->TELEFONOS = $Cliente->getTelefonos();
        $Cliente->DIRECCION = $Cliente->getDireccion();
        $Cliente->REFERENCIAS = $Cliente->getReferencias();
        $Cliente->DOCUMENTOS = $Cliente->getDocumentos();
        $Cliente->INFORMACIONLABORAL = $Cliente->getInformacionLaboral();
        $Cliente->INGRESO_ADICIONAL = $Cliente->getIngresosAdicionales();
        

        return Inertia::render('Creditos/CreditosDetalle', [
            'cliente' => $Cliente->only([
                'CLIE_ID',
                'NOMBRE',
                'CLIE_FECHANAC', 
                'CLIE_DOCIDEN',
                'CLIE_DOCIDENVEN',
                'CLIE_DOCFISCAL',
                'MAILS',
                'TELEFONOS',
                'DIRECCION', 
                'REFERENCIAS',
                'CLIE_CATEGORIA',
                'CLIE_COMENTARIOS',
                'DOCUMENTOS',
                'INFORMACIONLABORAL',
                'INGRESO_ADICIONAL',
                'CLIE_SCORE'
            ]), 
            'solicitud' => $SOLICITUD
        ]);
    }
}
