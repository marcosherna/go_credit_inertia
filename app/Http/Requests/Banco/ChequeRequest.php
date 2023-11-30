<?php

namespace App\Http\Requests\Banco;

use Illuminate\Foundation\Http\FormRequest;

class ChequeRequest extends FormRequest {

    public function authorize(){
        return true;
    }

    public function rules() {
        return [  
            'CHEM_ID' => 'nullable',
            'CHEQ_ID' => 'required',
            'CHEM_NUMERO' => 'required|numeric',
            'CHEM_FECHA' => 'required|date|after_or_equal:today',
            'CHEM_LUGAR' => 'required',
            'CHEM_MONTO' => 'required|numeric|min:0',
            'CHEM_NOMBRE' => 'required',
            'CHEM_MONTOLETRA' => 'required',
            'CHEM_COMENTARIOS' => 'required|string|max:255',
            'CHEM_FECHACAMBIO' => 'nullable',
            'USUA_ID' => 'nullable',
            'CHEM_ESTADO' => 'nullable',
        ];
    }

    public function messages() {
        return [
            'CHEM_FECHA.after_or_equal' => 'La fecha del cheque debe ser mayor o igual a la fecha actual.',
            'CHEM_MONTO.min' => 'El monto del cheque debe ser mayor a 0.',
            'CHEM_MONTO.numeric' => 'El monto del cheque debe ser un número.',
            'CHEM_FECHA.date' => 'La fecha del cheque debe ser una fecha válida.',
            'CHEM_FECHA.required' => 'La fecha del cheque es requerida.',
            'CHEM_LUGAR.required' => 'El lugar del cheque es requerido.',
            'CHEM_MONTO.required' => 'El monto del cheque es requerido.',
            'CHEM_NOMBRE.required' => 'El nombre del cheque es requerido.',
            'CHEM_MONTOLETRA.required' => 'El monto en letras del cheque es requerido.',
            'CHEM_COMENTARIOS.required' => 'Los comentarios del cheque son requeridos.',
            'CHEM_NUMERO.required' => 'El número del cheque es requerido.',
            'CHEQ_ID.required' => 'El número de la chequera es requerido.',
            'CHEM_NUMERO.numeric' => 'El número del cheque debe ser un número.',
            'CHEM_COMENTARIOS.max' => 'Los comentarios del cheque no deben exceder los 255 caracteres.',
            
        ];

    }
}
