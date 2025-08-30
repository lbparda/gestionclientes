<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Cliente</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-8">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">

        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Crear Nuevo Cliente</h1>

        {{-- Muestra errores de validación si los hay --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">¡Error!</strong> Por favor, corrige los siguientes errores:
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clientes.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">



                {{-- CAMPO Nº Ref (Automático) --}}
                <div>
                    <label for="NºRef" class="block text-sm font-medium text-gray-700">Nº Ref (Automático)</label>
                    <input type="text" name="NºRef" id="NºRef" value="{{ $siguienteNRef }}" readonly
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100 cursor-not-allowed">
                </div>

                 <div>
                    <label for="Nombre" class="block text-sm font-medium text-gray-700">Nombre (Obligatorio)</label>
                    <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre') }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="DNI" class="block text-sm font-medium text-gray-700">DNI</label>
                    <input type="text" name="DNI" id="DNI" value="{{ old('DNI') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="TeléfonoMóvil" class="block text-sm font-medium text-gray-700">Teléfono Móvil</label>
                    <input type="text" name="TeléfonoMóvil" id="TeléfonoMóvil" value="{{ old('TeléfonoMóvil') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="Email" id="Email" value="{{ old('Email') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end space-x-2 mt-8 border-t pt-6">
                <a href="{{ route('clientes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-md transition">
                    💾 Guardar Cliente
                </button>
            </div>
        </form>

    </div>

</body>
</html>
