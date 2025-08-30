<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Editar Cliente: <span class="text-indigo-600">{{ $cliente->Nombre }}</span></h1>

        <div class="w-full overflow-x-auto">
            <form
                action="{{ route('clientes.update', $cliente->{'NºRef'}) }}"
                method="POST"
                class="min-w-[1200px] bg-white p-6 rounded-lg shadow space-y-6"
            >
                @csrf
                @method('PUT')

                @php
                    // Lista completa de campos a mostrar en el formulario
                    $campos = [
                        "NºRef", "FechaEntrada", "Nombre", "DNI", "Dirección",
                        "Localidad", "Provincia", "CP", "TeléfonodeContacto", "TeléfonoMóvil",
                        "Fax", "Email", "Pendiente", "Observaciones", "AsuntoP", "Procurador",
                        "Historico", "Banco", "DireBanco", "LocBanco", "ProBanco", "Entidad",
                        "Sucursal", "DC", "Cuenta", "RefPro", "Poder", "Pais", "Representacion",
                        "Iguala", "FNacimiento", "IBAN", "Procedencia"
                    ];

                    // Lista de los campos que son booleanos (tinyint)
                    // El BaseModel los convertirá a true/false
                    $camposBooleanos = ['Pendiente', 'Historico', 'Iguala'];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($campos as $campo)
                        <div class="min-w-[300px]">
                            <label for="{{ $campo }}" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $campo }}
                            </label>

                            {{-- Comprobamos si el campo actual está en nuestra lista de booleanos --}}
                            @if(in_array($campo, $camposBooleanos))
                                {{-- Si es booleano, mostramos un desplegable <select> --}}
                                <select
                                    name="{{ $campo }}"
                                    id="{{ $campo }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="1" @if($cliente->$campo) selected @endif>Sí</option>
                                    <option value="0" @if(!$cliente->$campo) selected @endif>No</option>
                                </select>
                            @else
                                {{-- Si no es booleano, mostramos un campo de texto normal <input> --}}
                                <input
                                    type="text"
                                    name="{{ $campo }}"
                                    id="{{ $campo }}"
                                    value="{{ old($campo, $cliente->{$campo}) }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                            @endif
                        </div>
                    @endforeach
                </div>

                 {{-- Botones de acción --}}
                <div class="flex justify-end space-x-2 mt-6 border-t pt-6">
                    {{-- BOTÓN "ATRÁS" CORREGIDO --}}
                    <a href="{{ route('clientes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md transition">
                        ← Volver al Listado
                    </a>

                    {{-- Botón Ver Expedientes --}}
                    <a href="{{ route('clientes.expedientes.index', $cliente->{'NºRef'}) }}" class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M1 10s4-6 9-6 9 6 9 6-4 6-9 6-9-6-9-6z" />
                          <circle cx="10" cy="10" r="3" />
                        </svg>
                        Ver Expedientes
                    </a>

                    {{-- Botón Guardar Cambios --}}
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-md transition">
                        💾 Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
