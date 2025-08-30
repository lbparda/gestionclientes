<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Expediente: {{ $expediente->NºExpediente }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editando Expediente</h1>
        <p class="text-lg font-mono text-indigo-600 mb-6 border-b pb-4">{{ $expediente->NºExpediente }}</p>
        <form action="{{ route('expedientes.update', $expediente->NºExpediente) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @php
                $camposEditables = ['Titulo', 'FechaEx', 'Materia'];
                $camposBooleanos = ['Terminado', 'Facturado', 'Cobrado'];
                $camposTextoLargo = ['Observaciones'];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($camposEditables as $campo)
                    <div>
                        <label for="{{ $campo }}" class="block text-sm font-medium text-gray-700">{{ $campo }}</label>
                        <input type="text" name="{{ $campo }}" value="{{ old($campo, $expediente->$campo) }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
                    </div>
                @endforeach
                @foreach($camposBooleanos as $campo)
                    <div>
                        <label for="{{ $campo }}" class="block text-sm font-medium text-gray-700">{{ $campo }}</label>
                        <select name="{{ $campo }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
                            <option value="1" @if($expediente->$campo) selected @endif>Sí</option>
                            <option value="0" @if(!$expediente->$campo) selected @endif>No</option>
                        </select>
                    </div>
                @endforeach
            </div>
            <div class="space-y-4 mt-6">
                @foreach($camposTextoLargo as $campo)
                    <div>
                        <label for="{{ $campo }}" class="block text-sm font-medium text-gray-700">{{ $campo }}</label>
                        <textarea name="{{ $campo }}" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">{{ old($campo, $expediente->$campo) }}</textarea>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-end space-x-2 mt-8 border-t pt-6">
                <a href="{{ route('expedientes.show', $expediente->NºExpediente) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md transition">Cancelar</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-md transition">💾 Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>
