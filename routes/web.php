<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ExpedientesController;
use App\Http\Controllers\DashboardController; // ¡Importante añadir el nuevo controlador!
use App\Http\Controllers\ConfiguracionController;

// --- RUTA DE LA PÁGINA PRINCIPAL ---
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');




Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index')->where('cliente', '[a-zA-Z0-9\-]+');
// --- NUEVAS RUTAS AQUÍ ---
Route::get('/clientes/create', [ClientesController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClientesController::class, 'store'])->name('clientes.store');
Route::get('/clientes/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit')->where('cliente', '[a-zA-Z0-9\-]+');
Route::put('/clientes/{id}', [ClientesController::class, 'update'])->name('clientes.update')->where('cliente', '[a-zA-Z0-9\-]+');
Route::get('clientes/{cliente}/expedientes', [ExpedientesController::class, 'index'])->name('clientes.expedientes.index')->where('cliente', '[a-zA-Z0-9\-]+');


// ¡ORDEN CORRECTO! La ruta 'create' debe ir ANTES de 'show'.
Route::get('/expedientes/create', [ExpedientesController::class, 'create'])->name('expedientes.create');
Route::post('/expedientes', [ExpedientesController::class, 'store'])->name('expedientes.store');

// Las rutas con comodines van después.
Route::get('/expedientes/{expediente}', [ExpedientesController::class, 'show'])->name('expedientes.show');
Route::get('/expedientes/{expediente}/edit', [ExpedientesController::class, 'edit'])->name('expedientes.edit');
Route::put('/expedientes/{expediente}', [ExpedientesController::class, 'update'])->name('expedientes.update');



// --- RUTAS PARA DOCUMENTOS DE EXPEDIENTES ---
Route::post('/expedientes/{expediente}/crear-carpeta', [ExpedientesController::class, 'crearCarpeta'])->name('expedientes.crearCarpeta');

Route::post('/expedientes/{expediente}/subir-documento', [ExpedientesController::class, 'subirDocumento'])->name('expedientes.documentos.subir');
Route::get('/documentos/{documento}/descargar', [ExpedientesController::class, 'descargarDocumento'])->name('expedientes.documentos.descargar');


// --- RUTAS PARA CONFIGURACIÓN ---
Route::get('/configuracion/rutas', [ConfiguracionController::class, 'mostrarFormularioRutas'])->name('configuracion.rutas.index');
Route::post('/configuracion/rutas', [ConfiguracionController::class, 'actualizarRutas'])->name('configuracion.rutas.actualizar');
