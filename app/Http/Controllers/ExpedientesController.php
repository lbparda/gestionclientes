<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Expediente;
use App\Models\DExpCli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // <-- ¡Importante añadir Carbon para manejar fechas!

class ExpedientesController extends Controller
{
    public function index(Cliente $cliente)
    {
        $expedientes = $cliente->expedientes()->with('detalles')->get();
        return view('clientes.expedientes.index', compact('cliente', 'expedientes'));
    }

    // --- MÉTODO 'show' CORREGIDO ---
    public function show($expedienteId)
    {
        $expediente = Expediente::with('escritos')->where('NºExpediente', $expedienteId)->firstOrFail();
        $relacion = DExpCli::where('NºExpediente', $expedienteId)->firstOrFail();
        $clienteRef = $relacion->RefCliente;

        return view('clientes.expedientes.show', compact('expediente', 'clienteRef'));
    }

    // --- NUEVA FUNCIÓN PARA CREAR LA CARPETA Y EL REGISTRO ---
    public function crearCarpeta(Request $request, $expedienteId)
    {
        $expediente = Expediente::findOrFail($expedienteId);
        $rutaCarpeta = 'escritos/' . $expediente->NºExpediente;

        // 1. Crea la carpeta en el servidor si no existe
        Storage::makeDirectory($rutaCarpeta);

        // 2. Crea el registro en la base de datos
        EscritoExp::create([
            'NºExpediente' => $expediente->NºExpediente,
            'Escritos' => 'Carpeta Expediente Nº' . $expediente->NºExpediente,
            'Ruta' => $rutaCarpeta,
            'FechaEscrito' => Carbon::now()->format('Y d m'), // Formato Año Día Mes
            'FechaEs' => Carbon::now()->format('Y d m'),
            'Tipo' => 'Carpeta Escritos',
        ]);

        return back()->with('success', '¡Carpeta del expediente creada correctamente!');
    }

    public function subirDocumento(Request $request, $expedienteId)
{
    $request->validate(['documento' => 'required|file|max:10240']);
    $expediente = Expediente::findOrFail($expedienteId);
    $archivo = $request->file('documento');

    // Guarda el archivo DENTRO de la carpeta específica del expediente
    $rutaGuardada = $archivo->store('escritos/' . $expediente->NºExpediente);

    // Crea el registro del archivo en la base de datos
    $expediente->escritos()->create([
        'NºExpediente'      => $expediente->NºExpediente,
        'Resumen'           => $archivo->getClientOriginalName(), // <-- Nombre real del archivo
        'Ruta'              => $rutaGuardada,
        'FechaEscrito'      => now()->format('Y d m'),
        'FechaEs'           => now()->format('Y d m'),
        'Tipo'              => $archivo->getClientMimeType(),
        // 'Escritos' se deja en null para los archivos
    ]);

    return back()->with('success', '¡Documento subido correctamente!');
}

    // --- FUNCIÓN DE DESCARGAR DOCUMENTO (ACTUALIZADA) ---
    public function descargarDocumento($documentoId)
    {
        $documento = EscritoExp::findOrFail($documentoId);

        // 1. Obtenemos la ruta completa y absoluta desde la base de datos
        $rutaCompleta = $documento->Ruta;

        // 2. Obtenemos el nombre original que tendrá el archivo al descargarse
        $nombreOriginal = $documento->Resumen ?: 'documento.bin';

        // 3. ¡Importante! Verificamos que el archivo realmente existe en esa ruta
        if (!file_exists($rutaCompleta)) {
            // Si no existe, devolvemos un error 404 (No encontrado)
            abort(404, 'El archivo no se encuentra en la ubicación especificada.');
        }

        // 4. Usamos la respuesta de descarga directa de Laravel, que funciona
        //    perfectamente con rutas absolutas.
        return response()->download($rutaCompleta, $nombreOriginal);
    }
    // --- MÉTODO 'edit' CORREGIDO ---
    public function edit($expedienteId)
    {
        $expediente = Expediente::where('NºExpediente', $expedienteId)->firstOrFail();

        // 1. También buscamos la referencia del cliente aquí
        $relacion = DExpCli::where('NºExpediente', $expedienteId)->firstOrFail();
        $clienteRef = $relacion->RefCliente;

        // 2. Pasamos AMBAS variables a la vista de edición
        return view('clientes.expedientes.edit', compact('expediente', 'clienteRef'));
    }

    public function update(Request $request, $expedienteId)
    {
        $expediente = Expediente::where('NºExpediente', $expedienteId)->firstOrFail();
        $expediente->update($request->all());
        return redirect()->route('expedientes.show', $expediente->NºExpediente)->with('success', '¡Expediente actualizado!');
    }

    public function create(Request $request)
    {
        $clienteRef = $request->query('clienteRef');
        return view('clientes.expedientes.create', ['clienteRef' => $clienteRef]);
    }

     public function store(Request $request)
    {
        // 1. Validación (esto se queda igual)
        $request->validate([
            'NºExpediente' => 'required|unique:Expedientes,NºExpediente',
            'clienteRef' => 'required|exists:clientes,NºRef',
            'Titulo' => 'required',
        ]);

        // 2. Creación del Expediente y la Relación (esto se queda igual)
        Expediente::create($request->all());
        DExpCli::create([
            'NºExpediente' => $request->input('NºExpediente'),
            'RefCliente' => $request->input('clienteRef'),
        ]);

        // --- LÓGICA AÑADIDA PARA CREAR LA CARPETA AUTOMÁTICAMENTE ---
        $numeroExpediente = $request->input('NºExpediente');

        // 3. Crear la carpeta física en tu disco
        // Usa el disco 'expedientes_reales' que configuramos
        Storage::disk('expedientes_reales')->makeDirectory($numeroExpediente);

        // 4. Crear el registro de la carpeta en la tabla 'escritosexp'
        EscritoExp::create([
            'NºExpediente' => $numeroExpediente,
            'Escritos'     => 'Carpeta Expediente Nº' . $numeroExpediente,
            'Ruta'         => $numeroExpediente,
            'FechaEscrito' => Carbon::now()->format('Y d m'),
            'FechaEs'      => Carbon::now()->format('Y d m'),
            'Tipo'         => 'Carpeta Escritos',
        ]);
        // --- FIN DE LA LÓGICA AÑADIDA ---

        // 5. Redirección con mensaje de éxito mejorado
        return redirect()->route('clientes.expedientes.index', $request->input('clienteRef'))
                         ->with('success', '¡Expediente y su carpeta creados correctamente!');
    }
}
