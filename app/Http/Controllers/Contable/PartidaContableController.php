<?php

namespace App\Http\Controllers\Contable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartidaContableController extends Controller {
    
    public function index() {
        return Inertia::render('contable/PartidaContable');
    }
}
