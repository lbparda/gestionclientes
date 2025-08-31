<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentacionExp extends BaseModel
{
    use HasFactory;

    // Apunta a la nueva tabla
    protected $table = 'documentacionexp';
    protected $primaryKey = 'IdEscrito';
    public $timestamps = false;

    protected $fillable = [
        'NºExpediente', 'Ruta', 'Escritos', 'Resumen', 'Tipo', 'FechaEscrito', 'FechaEs'
    ];
}