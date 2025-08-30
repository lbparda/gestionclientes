<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{
    // --- MÉTODO 'index' ACTUALIZADO CON LÓGICA DE BÚSQUEDA ---
    public function index(Request $request)
    {
        // 1. Obtenemos el término de búsqueda de la URL.
        $busqueda = $request->input('busqueda');

        // 2. Empezamos una consulta a la tabla de clientes.
        $query = Cliente::query();

        // 3. Si hay un término de búsqueda, aplicamos los filtros.
        if ($busqueda) {
            $query->where(function($q) use ($busqueda) {
                $q->where('Nombre', 'LIKE', "%{$busqueda}%")
                  ->orWhere('DNI', 'LIKE', "%{$busqueda}%");
            });
        }

        // 4. Obtenemos los clientes (filtrados o todos).
        $clientes = $query->get();

        // 5. Pasamos los clientes y el término de búsqueda a la vista.
        return view('clientes.index', compact('clientes', 'busqueda'));
    }

    // --- NUEVO MÉTODO PARA MOSTRAR EL FORMULARIO DE CREACIÓN ---
    public function create()
    {
        // 1. Busca el último cliente para saber cuál es el NºRef más alto.
        // CAST(NºRef AS UNSIGNED) asegura que ordene los números correctamente (ej. 10 vendrá después de 9).
        $ultimoCliente = Cliente::orderByRaw('CAST(NºRef AS UNSIGNED) DESC')->first();

        // 2. Calcula el siguiente número. Si no hay clientes, empieza en 1.
        $siguienteNum = $ultimoCliente ? ((int)$ultimoCliente->NºRef) + 1 : 1;

        // 3. Formatea el número para que tenga 5 dígitos, añadiendo ceros a la izquierda (ej. "00038").
        $siguienteNRef = str_pad($siguienteNum, 5, '0', STR_PAD_LEFT);

        // 4. Pasa solo el siguiente NºRef a la vista.
        return view('clientes.create', [
            'siguienteNRef' => $siguienteNRef
        ]);
    }

    // --- NUEVO MÉTODO PARA GUARDAR EL NUEVO CLIENTE ---
    public function store(Request $request)
    {
        // Validación de los campos más importantes
        $request->validate([
           // 'NºReferencia' => 'required|unique:clientes,NºReferencia',
            'NºRef' => 'required|unique:clientes,NºRef',
            'Nombre' => 'required',
        ]);

        // Crea el nuevo cliente en la base de datos
        Cliente::create($request->all());

        // Redirige a la lista de clientes con un mensaje de éxito
        return redirect()->route('clientes.index')
                         ->with('success', '¡Cliente creado correctamente!');
    }


    public function edit($id)
    {
        $cliente = Cliente::where('NºRef', $id)->firstOrFail();
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::where('NºRef', $id)->firstOrFail();
        $cliente->update($request->all());
        return redirect()->route('clientes.index');
    }
}
