<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expedientes de {{ $cliente->Nombre }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-8">
    <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="border-b pb-4 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Expedientes de: <span class="text-indigo-600">{{ $cliente->Nombre }}</span></h1>
                    <p class="text-md text-gray-600 mt-1">Cliente NºRef: <strong class="font-mono">{{ $cliente->NºRef }}</strong></p>
                </div>
                <div>
                    <a href="{{ route('expedientes.create', ['clienteRef' => $cliente->NºRef]) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-md transition shadow-sm hover:shadow-lg">+ Crear Expediente</a>
                </div>
            </div>
        </div>
        @if($expedientes->isEmpty())
            <p>Este cliente no tiene ningún expediente registrado.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nº Expediente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terminado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($expedientes as $expediente)
                            {{-- La variable $expediente es un objeto DExpCli.
                                 Para acceder a los detalles, usamos la relación que creamos: $expediente->detalles --}}
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('expedientes.show', $expediente->NºExpediente) }}'">
                                <td class="px-6 py-4 text-sm font-medium text-indigo-600 hover:underline">{{ $expediente->NºExpediente }}</td>

                                {{-- Ahora accedemos a los detalles a través de la relación --}}
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $expediente->detalles->Titulo ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $expediente->detalles->FechaEx ? \Carbon\Carbon::parse($expediente->detalles->FechaEx)->format('Y/m/d') : 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    {{-- El BaseModel se encarga de convertir Terminado a true/false --}}
                                    <span class="{{ optional($expediente->detalles)->Terminado ? 'text-green-600' : 'text-red-600' }}">
                                        {{ optional($expediente->detalles)->Terminado ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="mt-8 pt-6 border-t text-right">
            <a href="{{ route('clientes.edit', $cliente->NºRef) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-md transition">← Volver a la Ficha del Cliente</a>
        </div>
    </div>
</body>
</html>
