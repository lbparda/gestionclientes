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
        <p class="mb-6 border-b pb-4">Asignando a Cliente: <strong class="font-mono">{{ $clienteRef }}</strong></p>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('expedientes.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="clienteRef" value="{{ $clienteRef }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="NºExpediente" class="block text-sm font-medium text-gray-700">Nº Expediente</label>
                    <input type="text" name="NºExpediente" value="{{ old('NºExpediente') }}" required class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
                </div>
                <div>
                    <label for="Titulo" class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" name="Titulo" value="{{ old('Titulo') }}" required class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
                </div>
                <div>
                    <label for="FechaEx" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="FechaEx" value="{{ old('FechaEx') }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
                </div>
            </div>
            <div class="flex justify-end space-x-2 mt-8 border-t pt-6">
                <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md transition">Cancelar</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-md transition">💾 Crear</button>
            </div>
        </form>
    </div>
</body>
</html>
