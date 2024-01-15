<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ColecturiaController extends Controller {
    public function index() {
        return Inertia::render('Administracion/Caja/Colecturia');
    }
}
