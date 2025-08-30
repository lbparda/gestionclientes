<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscritoExp extends Model
{
    use HasFactory;

    protected $table = 'escritosexp';
    protected $primaryKey = 'IdEscrito';
    public $timestamps = false;

    // AÑADIMOS TODOS LOS CAMPOS NUEVOS AL ARRAY $fillable
    protected $fillable = [
        'NºExpediente',
        'Ruta',
        'Escritos', // Para el nombre "Carpeta Expediente Nº..."
        'Resumen',  // Para el nombre original del archivo
        'FechaEscrito',
        'FechaEs',
        'Tipo',
    ];
}
