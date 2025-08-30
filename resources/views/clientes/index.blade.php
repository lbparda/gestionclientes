<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-8">

    <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-md">

        {{-- ENCABEZADO CON BUSCADOR Y BOTÓN --}}
        <div class="border-b pb-4 mb-6 md:flex justify-between items-center space-y-4 md:space-y-0">
            <h1 class="text-3xl font-bold text-gray-800">Directorio de Clientes</h1>

            <div class="flex items-center space-x-4">
                {{-- FORMULARIO DE BÚSQUEDA --}}
                <form action="{{ route('clientes.index') }}" method="GET" class="flex items-center">
                    <input type="text" name="busqueda" value="{{ $busqueda ?? '' }}" placeholder="Buscar por Nombre o DNI..."
                           class="w-80 border border-gray-300 rounded-l-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold px-4 py-2 rounded-r-md">
                        Buscar
                    </button>
                </form>

                {{-- BOTÓN DE CREAR CLIENTE --}}
                <a href="{{ route('clientes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-md transition shadow-sm hover:shadow-lg whitespace-nowrap">
                    + Crear Cliente
                </a>
            </div>
        </div>

        @if(isset($busqueda) && $busqueda)
            <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-2 rounded-md mb-6 flex justify-between items-center">
                <span>Resultados para: <strong>"{{ $busqueda }}"</strong></span>
                <a href="{{ route('clientes.index') }}" class="text-blue-600 hover:underline font-semibold">Limpiar búsqueda</a>
            </div>
        @endif

        @if($clientes->isEmpty())
            <p>No se encontraron clientes.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nº Ref</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DNI</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pendiente</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($clientes as $cliente)
                            {{-- CORRECCIÓN AQUÍ: Usamos NºReferencia en lugar de NºRef --}}
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('clientes.edit', $cliente->NºRef) }}'">
                                <td class="px-6 py-4 text-sm font-medium text-indigo-600 hover:underline">{{ $cliente->{'NºRef'} }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $cliente->Nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->DNI ?: 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->{'TeléfonoMóvil'} ?: 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <span class="{{ $cliente->Pendiente ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $cliente->Pendiente ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>
