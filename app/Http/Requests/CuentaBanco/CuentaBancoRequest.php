<?php

namespace App\Http\Requests\CuentaBanco;

use Illuminate\Foundation\Http\FormRequest;

class CuentaBancoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'CUEB_NUMERO' => 'required|regex:/[a-zA-Z0-9]+/', 
            'CUEB_DETALLE' => 'required|string|max:100', 
            'CUEN_ID' => 'required|string|max:20', 
            'BANC_ID' => 'required|string|max:20', 
            'TIPC_ID' => 'required|string|max:20', 
            'CUEB_ESTADO' => 'nullable|numeric',
        ];
    }

    public function messages() {
        return [
            'CUEB_NUMERO.required' => 'El campo número de cuenta es requerido',
            'CUEB_NUMERO.regex' => 'El campo número de cuenta solo acepta letras y números',
            'CUEB_DETALLE.required' => 'El campo detalle es requerido',
            'CUEN_ID.required' => 'El campo cuenta sucursal es requerido',
            'BANC_ID.required' => 'El campo banco es requerido',
            'TIPC_ID.required' => 'El campo tipo de cuenta es requerido',  
            'CUEB_DETALLE.max' => 'El campo detalle debe tener máximo 100 caracteres'
        ];
        
    }
}
