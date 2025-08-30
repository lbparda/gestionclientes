<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Gestión de Clientes</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex flex-col items-center p-8">

        {{-- CABECERA MODIFICADA PARA INCLUIR EL BOTÓN --}}
        <header class="w-full max-w-4xl flex justify-between items-center mb-12">
            <div class="text-left">
                <h1 class="text-5xl font-bold text-gray-800">Gestión de Clientes</h1>
                <p class="text-xl text-gray-500 mt-2">Bienvenido a tu panel de control</p>
            </div>

            {{-- INICIO: Botón de Configuración --}}
            <div class="relative inline-block text-left">
                <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0s-1.56 2.6 0 2.98c1.56.38 2.6 1.56 2.98 0s1.56-2.6 0-2.98zM10 18a8 8 0 100-16 8 8 0 000 16zM8.51 16.83c.38 1.56 2.6 1.56 2.98 0s1.56-2.6 0-2.98c-1.56-.38-2.6-1.56-2.98 0s-1.56 2.6 0 2.98z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" id="config-menu">
                    <div class="py-1" role="none">
                        <a href="{{ route('configuracion.rutas.index') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1">
                            Rutas de Expedientes
                        </a>
                    </div>
                </div>
            </div>
            {{-- FIN: Botón de Configuración --}}

        </header>

        <main class="w-full max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Tarjeta de Clientes --}}
                <a href="{{ route('clientes.index') }}" class="block p-8 bg-white rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out">
                    <div class="flex items-center space-x-6">
                        <div class="bg-indigo-100 p-4 rounded-full">
                            <svg class="h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Clientes</h2>
                            <p class="text-gray-600 mt-1">Ver, crear y editar clientes</p>
                        </div>
                    </div>
                </a>

                {{-- Puedes añadir más tarjetas aquí en el futuro --}}
                <div class="block p-8 bg-white rounded-xl shadow-lg text-gray-400">
                     <div class="flex items-center space-x-6">
                         <div class="bg-gray-100 p-4 rounded-full">
                             <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                             </svg>
                         </div>
                         <div>
                             <h2 class="text-2xl font-bold">Expedientes</h2>
                             <p class="mt-1">(Acceso desde cada cliente)</p>
                         </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    {{-- SCRIPT PARA EL MENÚ DESPLEGABLE --}}
    <script>
        const menuButton = document.getElementById('menu-button');
        const configMenu = document.getElementById('config-menu');

        menuButton.addEventListener('click', (event) => {
            event.stopPropagation();
            configMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
          if (!configMenu.classList.contains('hidden')) {
            configMenu.classList.add('hidden');
          }
        });
    </script>

</body>
</html>
