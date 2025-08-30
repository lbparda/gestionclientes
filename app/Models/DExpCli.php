<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DExpCli extends Model
{
    // Si tu tabla no sigue el plural predeterminado, especifícala
    protected $table = 'DExpCli';
    protected $primaryKey = 'RefCliente';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;


    // Define los campos rellenables
    protected $fillable = [
    "NºExpediente",
    "RefCliente",
    "IdLetrado",
    "IdProcu",
    "Pagar",
    "IProcesal",
    ];      // 'campo1', 'campo2', ...
     public function detalles()
    {
        return $this->belongsTo(Expediente::class, 'NºExpediente', 'NºExpediente');
    }

}
