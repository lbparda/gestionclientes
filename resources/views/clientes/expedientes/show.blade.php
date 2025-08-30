<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle: {{ $expediente->NºExpediente }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md space-y-8">

        {{-- SECCIÓN DE DETALLES DEL EXPEDIENTE --}}
        <div>
            <div class="border-b pb-4 mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Detalles del Expediente</h1>
                    <p class="text-lg font-mono text-indigo-600 mt-1">{{ $expediente->NºExpediente }}</p>
                </div>
                <a href="{{ route('expedientes.edit', $expediente->NºExpediente) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md transition">✏️ Editar</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                {{-- Aquí va tu grid con los detalles del expediente --}}
                <div>
                    <label class="text-sm font-semibold text-gray-500 block">Título</label>
                    <p class="text-lg text-gray-900">{{ $expediente->Titulo ?: 'No especificado' }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500 block">Fecha</label>
                    <p class="text-lg text-gray-900">{{ $expediente->FechaEx ? \Carbon\Carbon::parse($expediente->FechaEx)->format('d/m/Y') : 'No especificada' }}</p>
                </div>
            </div>
        </div>

        {{-- SECCIÓN DE DOCUMENTOS (CORREGIDA) --}}
        <div class="border-t pt-6">
            <div class="flex justify-between items-center mb-4">
                 <h2 class="text-2xl font-bold text-gray-800">Escritos / Documentos</h2>
                 <form action="{{ route('expedientes.crearCarpeta', $expediente->NºExpediente) }}" method="POST">
                     @csrf
                     <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md text-sm">
                         Crear Carpeta del Expediente
                     </button>
                 </form>
            </div>

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

            @if($expediente->escritos->isEmpty())
                <p class="text-gray-500">No hay documentos ni carpetas para este expediente.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($expediente->escritos as $escrito)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                {{--
                                |--------------------------------------------------------------------------
                                | LÓGICA CORREGIDA AQUÍ
                                |--------------------------------------------------------------------------
                                |
                                | Si el 'Tipo' es 'Carpeta Escritos', muestra el nombre de la carpeta.
                                | Para cualquier otro caso, muestra el nombre real del archivo.
                                |
                                --}}
                                @if($escrito->Tipo === 'Carpeta Escritos')
                                    <span class="text-gray-700 font-semibold">{{ $escrito->Escritos }}</span>
                                @else
                                    <span class="text-gray-700">{{ $escrito->Resumen }}</span>
                                @endif
                            </div>

                            @if($escrito->Tipo !== 'Carpeta Escritos')
                                <a href="{{ route('expedientes.documentos.descargar', $escrito->IdEscrito) }}" class="text-indigo-600 hover:underline font-semibold">Descargar</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mt-8 pt-6 border-t text-right">
             <a href="{{ route('clientes.expedientes.index', $clienteRef) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-md transition">← Volver a la Lista</a>
        </div>
    </div>
</body>
</html>
