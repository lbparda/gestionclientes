<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración de Rutas de Expedientes</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Reconstruir Documentos de Expedientes</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">¡Atención!</p>
            <p>Este proceso borrará todos los registros de documentos actuales y los reconstruirá desde cero escaneando la carpeta que especifiques.</p>
        </div>

        <form action="{{ route('configuracion.rutas.actualizar') }}" method="POST">
            @csrf
            <div>
                <label for="nueva_ruta_base" class="block text-sm font-medium text-gray-700">Ruta Base de Expedientes</label>
                <div class="mt-1">
                    <input type="text" name="nueva_ruta_base" id="nueva_ruta_base" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ej: D:/Servidor/Archivos" required>
                </div>
                <p class="mt-2 text-sm text-gray-500">Pega aquí la ruta principal. Usa barras normales (/) para evitar errores.</p>
            </div>

            <div class="mt-8 text-right">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-md transition">
                    Borrar y Reconstruir
                </button>
            </div>
        </form>
    </div>
</body>
</html>
