<?php

namespace App\Http\Requests\Banco;

use Illuminate\Foundation\Http\FormRequest;

class BancoRequest extends FormRequest
{
     
    public function authorize() {
        return true;
    }

   
    public function rules() {
        return [
            'BANC_NOMBRE' => 'required',  
            'BANC_DETALLE' => 'required|string|max:255', 
            'SUCU_ID' => 'required|numeric|min:1|not_in:0', 
            'BANC_ESTADO' => 'required|numeric|min:0|max:1',
        ];
    }

    public function messages() {
        return [
            'BANC_NOMBRE.required' => 'El campo nombre es requerido',
            'BANC_DETALLE.required' => 'El campo detalle es requerido',
            'SUCU_ID.required' => 'El campo sucursal es requerido',
            'BANC_ESTADO.required' => 'El campo estado es requerido',
            'BANC_DETALLE.max' => 'El campo detalle debe tener máximo 255 caracteres',
            'SUCU_ID.min' => 'El campo sucursal debe ser mayor a 0',
        ];
    }
}
