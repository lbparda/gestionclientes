<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentacionExp;
use App\Models\Expediente;
use Illuminate\Support\Facades\Log;

class ReconstruirArbolDocumentosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rutaBase;

    public function __construct(string $rutaBase)
    {
        $this->rutaBase = $rutaBase;
    }

    public function handle(): void
    {
        Log::info('--- Iniciando Reconstrucción (con Limpieza de Nombres) ---');
        DocumentacionExp::truncate();
        Log::info('Tabla documentacionexp borrada.');

        $disk = Storage::build(['driver' => 'local', 'root' => $this->rutaBase]);
        $directorios = $disk->directories();

        foreach ($directorios as $nombreCarpeta) {
            preg_match('/(\d{7,})/', $nombreCarpeta, $matches);

            if (isset($matches[1])) {
                $numeroExpediente = $matches[1];
                if (Expediente::where('NºExpediente', $numeroExpediente)->exists()) {
                    Log::info("   -> Procesando expediente '{$numeroExpediente}' desde la carpeta '{$nombreCarpeta}'...");

                    $rutaAbsolutaCarpeta = $disk->path($nombreCarpeta);
                    $archivosEnCarpeta = scandir($rutaAbsolutaCarpeta);

                    foreach ($archivosEnCarpeta as $nombreArchivoOriginal) {
                        if ($nombreArchivoOriginal === '.' || $nombreArchivoOriginal === '..') {
                            continue;
                        }

                        $rutaAbsolutaArchivo = $rutaAbsolutaCarpeta . DIRECTORY_SEPARATOR . $nombreArchivoOriginal;

                        // LÓGICA MEJORADA: Intentamos limpiar el nombre del archivo
                        // Convierte el nombre a UTF-8, reemplazando caracteres inválidos
                        $nombreArchivoLimpio = mb_convert_encoding($nombreArchivoOriginal, 'UTF-8', 'UTF-8');

                        // Si el nombre sigue siendo inválido o queda vacío, lo omitimos
                        if (!is_file($rutaAbsolutaArchivo) || empty(trim($nombreArchivoLimpio))) {
                             Log::error("   -> ¡ARCHIVO OMITIDO! El nombre de archivo '{$nombreArchivoOriginal}' es completamente ilegible o no es un archivo.");
                             continue;
                        }

                        $rutaRelativa = $nombreCarpeta . '/' . $nombreArchivoOriginal;

                        DocumentacionExp::create([
                            'NºExpediente' => $numeroExpediente,
                            'Escritos'     => $nombreArchivoLimpio, // Guardamos el nombre limpio
                            'Ruta'         => $rutaRelativa, // La ruta física sigue siendo la original
                            'Tipo'         => $disk->mimeType($rutaRelativa),
                            'Resumen'      => $nombreArchivoLimpio, // Guardamos el nombre limpio
                        ]);
                    }
                }
            }
        }
        Log::info('--- Reconstrucción Completada ---');
    }
}
