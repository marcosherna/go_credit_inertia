<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller {

    public function __invoke() { }

    public function index(){
        return Inertia::render('Welcome');
    }

    public function Login(Request $request) {  
        return Inertia::render('Dashboard');
    }
}
