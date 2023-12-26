<?php

namespace App\Http\Requests\Administracion;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [ 
            'SOLI_FECHA' => 'required|string',
            'EMPL_ID' => 'nullable|string',
            'CLIE_ID' => 'required|string|max:20',
            'SOLI_MONTO' => 'required|numeric|min:0',
            'TIPO_ID' => 'required|string|max:20',
            'GARA_ID' => 'required|string|max:20',
            'PLAZ_ID' => 'required|string|max:20',
            'FORM_ID' => 'required|string|max:20',
            'TIPT_ID' => 'required|string|max:20',
            'TASA_ID' => 'required|string|max:20',
            'SOLI_TIPOTASA' => 'nullable|integer',
            'SOLI_OMITIRDOM' => 'required|integer',
            'SOLI_DISPERSAR' => 'required|integer',
            'SOLI_CATEGORIA' => 'nullable|string|max:20',
            'SOLI_FECHAAPROB' => 'nullable|date',
            'SOLI_FECHAVENCIMIENTO' => 'required|date',
            'SOLI_OBSERVACION' => 'required|string|max:200',
            'SOLI_CONDICIONES' => 'required|string|max:200',
            'SOLI_OTROS' => 'nullable',
            'SOLI_ESTADO' => 'nullable|integer',
        ];
    }

    public function messages() {
        return [   
            'SOLI_FECHA.required' => 'El campo : es obligatorio.', 
            'EMPL_ID.string' => 'El campo : debe ser de tipo string.', 
            'CLIE_ID.required' => 'El campo : es obligatorio.',
            'CLIE_ID.string' => 'El campo : debe ser de tipo string.',
            'CLIE_ID.max' => 'El campo : no debe ser mayor a 20 caracteres.',
            'SOLI_MONTO.required' => 'El campo : es obligatorio.',
            'SOLI_MONTO.numeric' => 'El campo : debe ser de tipo numeric.',
            'TIPO_ID.required' => 'El campo : es obligatorio.',
            'TIPO_ID.string' => 'El campo : debe ser de tipo string.',
            'TIPO_ID.max' => 'El campo : no debe ser mayor a 20 caracteres.',
            'GARA_ID.required' => 'El campo : es obligatorio.',
            'GARA_ID.string' => 'El campo : debe ser de tipo string.',
            'GARA_ID.max' => 'El campo : no debe ser mayor a 20 caracteres.',
            'PLAZ_ID.required' => 'El campo : es obligatorio.',
            'PLAZ_ID.string' => 'El campo : debe ser de tipo string.',
            'PLAZ_ID.max' => 'El campo : no debe ser mayor a 20 caracteres.',
            'FORM_ID.required' => 'El campo : es obligatorio.',
            'FORM_ID.string' => 'El campo : debe ser de tipo string.',
            'FORM_ID.max' => 'El campo : no debe ser mayor a 20 caracteres.',
            'SOLI_CONDICIONES.required' => 'El campo : es obligatorio.',
            'SOLI_CONDICIONES.string' => 'El campo : debe ser de tipo string.',
            'SOLI_CONDICIONES.max' => 'El campo : no debe ser mayor a 200 caracteres.',
            'SOLI_OBSERVACION.required' => 'El campo : es obligatorio.',
            'SOLI_OBSERVACION.string' => 'El campo : debe ser de tipo string.',
            'SOLI_OBSERVACION.max' => 'El campo : no debe ser mayor a 200 caracteres.',
            'SOLI_FECHAVENCIMIENTO.required' => 'El campo : es obligatorio.',
            'SOLI_FECHAVENCIMIENTO.date' => 'El campo : debe ser de tipo date.',    
        ];
    }
}
