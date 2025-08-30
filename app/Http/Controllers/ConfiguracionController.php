<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ActualizarRutasEscritos; // Importa el "Trabajador"

class ConfiguracionController extends Controller
{
    /**
     * Muestra la vista con el formulario.
     */
    public function mostrarFormularioRutas()
    {
        return view('configuracion.rutas');
    }

    /**
     * Recibe la petición y despacha el trabajo a la cola.
     */
    public function actualizarRutas(Request $request)
    {
        $request->validate(['nueva_ruta_base' => 'required|string']);
        $nuevaRutaBase = $request->input('nueva_ruta_base');

        ActualizarRutasEscritos::dispatch($nuevaRutaBase);

        return back()->with('success', "¡Proceso iniciado! Las rutas se están actualizando en segundo plano.");
    }
}
