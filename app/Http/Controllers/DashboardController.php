<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra la página principal o dashboard de la aplicación.
     */
    public function index()
    {
        return view('dashboard');
    }
}
