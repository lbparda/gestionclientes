<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\EscritoExp;

class ActualizarRutasEscritos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $nuevaRutaBase;

    public function __construct(string $nuevaRutaBase)
    {
        $this->nuevaRutaBase = $nuevaRutaBase;
    }

    public function handle(): void
    {
        EscritoExp::chunkById(200, function ($escritos) {
            foreach ($escritos as $escrito) {
                $rutaAntigua = $escrito->Ruta;
                $nuevaRutaCompleta = null;

                $buscarExp = '\Expedientes\\';
                $posicionExp = strripos($rutaAntigua, $buscarExp);

                if ($posicionExp !== false) {
                    $parteFinal = substr($rutaAntigua, $posicionExp + strlen($buscarExp));
                    $nuevaRutaCompleta = rtrim($this->nuevaRutaBase, '\\') . '\\expedientes\\' . $parteFinal;
                } else {
                    $buscarCli = '\clientes\\';
                    $posicionCli = strripos($rutaAntigua, $buscarCli);

                    if ($posicionCli !== false) {
                        $parteFinal = substr($rutaAntigua, $posicionCli + strlen($buscarCli));
                        $nuevaRutaCompleta = rtrim($this->nuevaRutaBase, '\\') . '\\clientes\\' . $parteFinal;
                    }
                }

                if ($nuevaRutaCompleta && $escrito->Ruta !== $nuevaRutaCompleta) {
                    $escrito->Ruta = $nuevaRutaCompleta;
                    $escrito->save();
                }
            }
        });
    }
}
