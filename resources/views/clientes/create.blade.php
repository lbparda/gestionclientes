<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Expediente</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Nuevo Expediente</h1>
        <p class="mb-6 border-b pb-4">Asignando a Cliente: <strong class="text-indigo-600">{{ $cliente->Nombre }}</strong></p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('expedientes.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="clienteRef" value="{{ $cliente->NºRef }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="NºExpediente" class="block text-sm font-medium text-gray-700">Nº Expediente</label>
                    <input type="text" name="NºExpediente" id="NºExpediente" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="{{ old('NºExpediente') }}">
                </div>

                <div>
                    <label for="Titulo" class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" name="Titulo" id="Titulo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="{{ old('Titulo') }}">
                </div>

                <div>
                    <label for="FechaEx" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="FechaEx" id="FechaEx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('FechaEx') }}">
                </div>

                <div class="flex items-center pt-6">
                    <input id="Terminado" name="Terminado" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="Terminado" class="ml-2 block text-sm font-medium text-gray-900">Marcar como Terminado</label>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t flex justify-end space-x-4">
                <a href="{{ route('clientes.expedientes.index', $cliente) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-md transition">Cancelar</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md transition">Guardar Expediente</button>
            </div>
        </form>
    </div>
</body>
</html>
