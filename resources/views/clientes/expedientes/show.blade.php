<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle: {{ $expediente->NºExpediente }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md space-y-8">

        {{-- SECCIÓN 1: DETALLES DEL EXPEDIENTE --}}
        <div>
            <div class="border-b pb-4 mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Detalles del Expediente</h1>
                    <p class="text-lg font-mono text-indigo-600 mt-1">{{ $expediente->NºExpediente }}</p>
                </div>
                <a href="{{ route('expedientes.edit', $expediente->NºExpediente) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md transition">✏️ Editar</a>
            </div>
            {{-- Aquí puedes añadir más detalles del expediente si lo necesitas --}}
        </div>

        {{-- SECCIÓN 2: GESTIÓN DE DOCUMENTOS --}}
        <div class="border-t pt-6">
            <div class="mb-4">
                 <h2 class="text-2xl font-bold text-gray-800">Documentos del Expediente</h2>
            </div>

            {{-- Formulario para subir archivos --}}
            <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                <form action="{{ route('expedientes.documentos.subir', $expediente->NºExpediente) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="documento" class="block text-sm font-medium text-gray-700">Subir nuevo documento</label>
                    <div class="mt-1 flex items-center space-x-2">
                        <input type="file" name="documento" id="documento" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md text-sm">Subir</button>
                    </div>
                </form>
            </div>

            {{-- Lista de documentos existentes --}}
            @if($expediente->documentos->isEmpty())
                <p class="text-center text-gray-500 py-4">No se encontraron documentos para este expediente.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($expediente->documentos as $documento)
                        <li class="py-3 flex justify-between items-center">
                            <span class="text-gray-700 font-semibold">{{ $documento->Resumen }}</span>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('expedientes.documentos.descargar', ['documento' => $documento->IdEscrito]) }}" class="text-indigo-600 hover:underline font-semibold">Descargar</a>

                                <form action="{{ route('documentos.destruir', ['documento' => $documento->IdEscrito]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este documento? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-semibold">Borrar</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- SECCIÓN 3: BOTÓN DE VOLVER --}}
        <div class="mt-8 pt-6 border-t text-right">
             <a href="{{ route('clientes.expedientes.index', $clienteRef) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-md transition">← Volver a la Lista</a>
        </div>
    </div>
</body>
</html>
