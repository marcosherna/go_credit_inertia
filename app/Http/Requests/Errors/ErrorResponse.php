<?php

namespace App\Http\Requests\Errors;


class ErrorResponse {
    public $code = 400;
    public $message = 'Error en la petición';
    public $error = null;
    public $data = [];
}
