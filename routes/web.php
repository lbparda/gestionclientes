<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpedientesController;
use App\Http\Controllers\ConfiguracionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTA PRINCIPAL ---
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// --- RUTAS PARA CLIENTES ---
Route::resource('clientes', ClientesController::class);

// --- RUTAS PARA EXPEDIENTES ---
Route::get('clientes/{cliente}/expedientes', [ExpedientesController::class, 'index'])->name('clientes.expedientes.index');
Route::get('clientes/{cliente}/expedientes/create', [ExpedientesController::class, 'create'])->name('clientes.expedientes.create');
Route::post('/expedientes', [ExpedientesController::class, 'store'])->name('expedientes.store');
Route::get('/expedientes/{expediente}', [ExpedientesController::class, 'show'])->name('expedientes.show');
Route::get('/expedientes/{expediente}/edit', [ExpedientesController::class, 'edit'])->name('expedientes.edit');
Route::put('/expedientes/{expediente}', [ExpedientesController::class, 'update'])->name('expedientes.update');

// --- RUTAS PARA DOCUMENTOS ---
Route::post('/expedientes/{expediente}/subir-documento', [ExpedientesController::class, 'subirDocumento'])->name('expedientes.documentos.subir');
Route::get('/documentos/{documento}/descargar', [ExpedientesController::class, 'descargarDocumento'])->name('expedientes.documentos.descargar');
// --- LÍNEA AÑADIDA PARA LA RUTA DE BORRADO ---
Route::delete('/documentos/{documento}', [ExpedientesController::class, 'destruirDocumento'])->name('documentos.destruir');


// --- RUTAS PARA LA CONFIGURACIÓN ---
Route::get('/configuracion/rutas', [ConfiguracionController::class, 'mostrarFormularioRutas'])->name('configuracion.rutas.index');
Route::post('/configuracion/rutas', [ConfiguracionController::class, 'actualizarRutas'])->name('configuracion.rutas.actualizar');
