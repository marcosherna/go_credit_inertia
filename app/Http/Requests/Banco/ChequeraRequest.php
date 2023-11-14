<?php

namespace App\Http\Requests\Banco;

use Illuminate\Foundation\Http\FormRequest;

class ChequeraRequest extends FormRequest {

    public function authorize() {
        return true;
    }

 
    public function rules() {
        return [
            'CUEB_NUMERO' => 'required|string|max:20',
            'CHEQ_DESDE' => 'required|numeric',
            'CHEQ_HASTA' => 'required|numeric',
            'CHEQ_CANTIDAD' =>  'required|numeric',
            'CHEQ_PENDIENTES' => 'required|numeric',
            'CHEQ_REFERENCIA' => 'nullable|string|max:100',
            'CHEQ_FECHA' => 'required|date',
            'CHEQ_GENERACION' => 'required|string|max:20',
            'CHEQ_VERIFICADOR' => 'required|string|max:20',
            'CHEQ_ESTADO' => 'required|numeric',
        ];
    }

    public function messages() {
        return [
            'CUEBA_NUMERO.required' => 'El campo número de cuenta es requerido',
            'CUEBA_NUMERO.regex' => 'El campo número de cuenta solo acepta letras y números',
            'CHEQ_DESDE.required' => 'El campo desde es requerido',
            'CHEQ_HASTA.required' => 'El campo hasta es requerido',
            'CHEQ_CANTIDAD.required' => 'El campo cantidad es requerido',
            'CHEQ_PENDIENTES.required' => 'El campo pendientes es requerido',
            'CHEQ_REFERENCIA.required' => 'El campo referencia es requerido',
            'CHEQ_FECHA.required' => 'El campo fecha es requerido',
            'CHEQ_GENERACION.required' => 'El campo generación es requerido',
            'CHEQ_VERIFICADOR.required' => 'El campo verificador es requerido',
            'CHEQ_ESTADO.required' => 'El campo estado es requerido',
            'CHEQ_DESDE.numeric' => 'El campo desde debe ser numérico',
            'CHEQ_HASTA.numeric' => 'El campo hasta debe ser numérico',
            'CHEQ_CANTIDAD.numeric' => 'El campo cantidad debe ser numérico',
            'CHEQ_PENDIENTES.numeric' => 'El campo pendientes debe ser numérico',
            'CHEQ_ESTADO.numeric' => 'El campo estado debe ser numérico',
            'CHEQ_REFERENCIA.max' => 'El campo referencia debe tener máximo 100 caracteres',
            'CHEQ_GENERACION.max' => 'El campo generación debe tener máximo 20 caracteres',
            'CHEQ_VERIFICADOR.max' => 'El campo verificador debe tener máximo 20 caracteres',
        ];
    }
}
