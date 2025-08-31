<?php

namespace App\Models;

// No necesitas heredar de BaseModel si no le añade funcionalidad específica.
// use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'NºReferencia';
    public $timestamps = false; // Tu tabla no tiene timestamps

    protected $fillable = [
        'NºRef', 'Nombre', 'DNI', 'Dirección', 'Localidad', 'Provincia', 'CP',
        'TeléfonodeContacto', 'TeléfonoMóvil', 'Email' // etc.
    ];

    /**
     * Define la relación correcta de muchos a muchos con Expediente.
     */
    public function getRouteKeyName()
    {
        return 'NºRef';
    }
    public function expedientes()
    {
        return $this->belongsToMany(
            Expediente::class,      // El modelo final al que queremos llegar
            'DExpCli',              // La tabla intermedia (pivote)
            'RefCliente',           // La clave foránea en la tabla pivote que se refiere a ESTE modelo (Cliente)
            'NºExpediente',         // La clave foránea en la tabla pivote que se refiere al OTRO modelo (Expediente)
            'NºRef',                // La clave en ESTA tabla (clientes) con la que se relaciona la tabla pivote
            'NºExpediente'          // La clave en la OTRA tabla (Expedientes) con la que se relaciona la tabla pivote
        );
    }
}
