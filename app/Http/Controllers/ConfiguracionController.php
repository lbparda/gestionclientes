<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// ¡CAMBIO IMPORTANTE! Apuntamos al Job correcto
use App\Jobs\ReconstruirArbolDocumentosJob;

class ConfiguracionController extends Controller
{
    public function mostrarFormularioRutas()
    {
        return view('configuracion.rutas');
    }

    public function actualizarRutas(Request $request)
    {
        $request->validate(['nueva_ruta_base' => 'required|string']);
        $nuevaRutaBase = $request->input('nueva_ruta_base');

        // Despachamos el Job correcto, que se encargará de borrar y reconstruir todo.
        ReconstruirArbolDocumentosJob::dispatch($nuevaRutaBase);

        return back()->with('success', "¡Proceso iniciado! La tabla de documentos se está reconstruyendo desde cero en segundo plano.");
    }
}
