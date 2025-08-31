<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expedientes de {{ $cliente->Nombre }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-8">
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-md">

        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Expedientes</h1>
                <p class="text-lg text-gray-600">Cliente: {{ $cliente->Nombre }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('clientes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-md transition">← Volver a Clientes</a>
                <a href="{{ route('clientes.expedientes.create', ['cliente' => $cliente]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md transition">+ Crear Nuevo Expediente</a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($expedientes->isEmpty())
            <p class="text-center text-gray-500 py-8">Este cliente no tiene expedientes registrados.</p>
        @else
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Nº Expediente</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($expedientes as $expediente)
                        <tr>
                            <td class="py-4 px-6">{{ $expediente->NºExpediente }}</td>
                            <td class="py-4 px-6">{{ $expediente->Titulo }}</td>
                            <td class="py-4 px-6">{{ $expediente->FechaEx ? \Carbon\Carbon::parse($expediente->FechaEx)->format('d/m/Y') : 'N/A' }}</td>
                            <td class="py-4 px-6 text-center">
                                @if($expediente->Terminado)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terminado</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Abierto</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center space-x-4">
                                <a href="{{ route('expedientes.show', $expediente->NºExpediente) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Ver Docs</a>
                                <a href="{{ route('expedientes.edit', $expediente->NºExpediente) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
