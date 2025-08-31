<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Expediente;
use App\Models\DExpCli;
use App\Models\DocumentacionExp; // <-- CORREGIDO: Apunta al nuevo modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExpedientesController extends Controller
{
    /**
     * Muestra la lista de expedientes de un cliente.
     */
    public function index(Cliente $cliente)
    {
        $expedientes = $cliente->expedientes()->get();
        return view('clientes.expedientes.index', compact('cliente', 'expedientes'));
    }

    /**
     * Muestra el formulario para crear un nuevo expediente.
     */
    public function create(Cliente $cliente)
    {
        return view('clientes.expedientes.create', compact('cliente'));
    }

    /**
     * Guarda un nuevo expediente y crea su carpeta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NºExpediente' => 'required|unique:Expedientes,NºExpediente',
            'clienteRef' => 'required|exists:clientes,NºRef',
            'Titulo' => 'required',
        ]);

        $datosExpediente = $request->except(['_token', 'clienteRef']);
        $datosExpediente['Terminado'] = $request->has('Terminado');
        Expediente::create($datosExpediente);

        DExpCli::create([
            'NºExpediente' => $request->input('NºExpediente'),
            'RefCliente' => $request->input('clienteRef'),
        ]);

        $numeroExpediente = $request->input('NºExpediente');
        Storage::disk('expedientes_reales')->makeDirectory($numeroExpediente);

        // CORREGIDO: Usa el nuevo modelo DocumentacionExp
        DocumentacionExp::create([
            'NºExpediente' => $numeroExpediente,
            'Escritos'     => 'Carpeta Expediente Nº' . $numeroExpediente,
            'Ruta'         => $numeroExpediente,
            'Tipo'         => 'Carpeta Escritos',
        ]);

        return redirect()->route('clientes.expedientes.index', $request->input('clienteRef'))
                         ->with('success', '¡Expediente y su carpeta creados correctamente!');
    }

    /**
     * Muestra los detalles y documentos de un expediente.
     */
     public function show($expedienteId)
    {
        // CORREGIDO: Carga la nueva relación 'documentos'
        $expediente = Expediente::with('documentos')->where('NºExpediente', $expedienteId)->firstOrFail();

        $relacion = DExpCli::where('NºExpediente', $expedienteId)->firstOrFail();
        $clienteRef = $relacion->RefCliente;
        return view('clientes.expedientes.show', compact('expediente', 'clienteRef'));
    }

    /**
     * Muestra el formulario para editar un expediente.
     */
    public function edit($expedienteId)
    {
        $expediente = Expediente::where('NºExpediente', $expedienteId)->firstOrFail();
        $relacion = DExpCli::where('NºExpediente', $expedienteId)->firstOrFail();
        $clienteRef = $relacion->RefCliente;
        return view('clientes.expedientes.edit', compact('expediente', 'clienteRef'));
    }

    /**
     * Actualiza un expediente existente.
     */
    public function update(Request $request, $expedienteId)
    {
        $expediente = Expediente::where('NºExpediente', $expedienteId)->firstOrFail();
        $datosAActualizar = $request->except(['_token', '_method']);
        $datosAActualizar['Terminado'] = $request->has('Terminado');
        $expediente->update($datosAActualizar);
        $relacion = DExpCli::where('NºExpediente', $expedienteId)->firstOrFail();
        return redirect()->route('clientes.expedientes.index', $relacion->RefCliente)->with('success', '¡Expediente actualizado!');
    }

    /**
     * Sube un nuevo documento a un expediente.
     */
    public function subirDocumento(Request $request, $expedienteId)
    {
        $request->validate(['documento' => 'required|file|max:20480']);
        $archivo = $request->file('documento');
        $rutaGuardada = $archivo->store($expedienteId, 'expedientes_reales');

        // CORREGIDO: Usa el nuevo modelo DocumentacionExp
        DocumentacionExp::create([
            'NºExpediente'      => $expedienteId,
            'Resumen'           => $archivo->getClientOriginalName(),
            'Ruta'              => $rutaGuardada,
            'Tipo'              => $archivo->getClientMimeType(),
        ]);
        return back()->with('success', '¡Documento subido correctamente!');
    }

    /**
     * Descarga un documento.
     */
    public function descargarDocumento($documentoId)
    {
        // CORREGIDO: Usa el nuevo modelo DocumentacionExp
        $documento = DocumentacionExp::findOrFail($documentoId);
        $rutaRelativa = $documento->Ruta;
        $nombreOriginal = $documento->Resumen ?: 'documento.bin';

        return Storage::disk('expedientes_reales')->download($rutaRelativa, $nombreOriginal);
    }
}
