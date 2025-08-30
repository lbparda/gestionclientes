<?php

namespace App\Models;

// ¡IMPORTANTE! Cambiamos el 'use' para que apunte a nuestro BaseModel
// use Illuminate\Database\Eloquent\Model; // <-- Ya no usamos esta
use App\Models\BaseModel; // <-- Usamos esta en su lugar, aunque no es estrictamente necesario si están en el mismo namespace.

class Expediente extends BaseModel // <-- ¡ESTE ES EL CAMBIO MÁS IMPORTANTE!
{
    // Nombre de la tabla en la base de datos
    protected $table = 'Expedientes';

    // Clave primaria de la tabla
    protected $primaryKey = 'NºExpediente';

    // Indicamos que la clave primaria no es un número que se autoincrementa
    public $incrementing = false;

    // Indicamos que el tipo de la clave es string (texto)
    protected $keyType = 'string';

    // Desactivamos los timestamps (created_at y updated_at)
    public $timestamps = false;

    // El array $fillable está perfecto, lo dejamos como está.
    protected $fillable = [
        "NºExpediente", "FechaEx", "Titulo", "Observaciones", "Terminado",
        "NºMinuta", "Facturado", "Cobrado", "Permitir", "LetradoCli1",
        "LetradoCli2", "LetradoCli3", "ProcuradorCli1", "ProcuradorCli2",
        "ProcuradorCli3", "LetradoContra1", "LetradoContra2", "LetradoContra3",
        "ProcuradorContra1", "ProcuradorContra2", "ProcuradorContra3",
        "Notario1", "Notario2", "Notario3", "Perito1", "Perito2", "Perito3",
        "Perito4", "Descripcion1", "Descripcion2", "Descripcion3",
        "Descripcion4", "Descripcion5", "Descripcion6", "Descripcion7",
        "RefPCli1", "RefPCli2", "RefPCli3", "RefLContra1", "RefLContra2",
        "RefLContra3", "RefPContra1", "RefPContra2", "RefPContra3", "No1",
        "No2", "No3", "Pe1", "Pe2", "Pe3", "Pe4", "Turno", "Materia",
        "Compartido", "DECON", "FechaCompartido", "Colaborador",
        "ImporteCompartido", "ObservacionComp", "NCampo", "NIG", "PstLPo",
        "PstNPe", "PstProcesos", "PstSitu", "PstDoc", "PstAnota",
        "Procedentede", "Campo1", "Campo2", "Campo3", "Campo4", "Campo5",
        "Campo6", "Campo7", "Campo8", "Campo9", "Campo10", "IdInteg1",
        "IdInteg2", "IdInteg3", "EtiCampo1", "EtiCampo2", "EtiCampo3",
        "EtiCampo4", "EtiCampo5", "EtiCampo6", "EtiCampo7", "EtiCampo8",
        "EtiCampo9", "EtiCampo10",
    ];

    // Permitimos que se use NºExpediente directamente en la URL
    public function getRouteKeyName()
    {
        return 'NºExpediente';
    }

    // NO NECESITAS NADA MÁS. El BaseModel se encarga del resto.
    public function escritos()
    {
        // El primer argumento es el modelo relacionado (EscritoExp).
        // El segundo es la columna foránea en la tabla 'escritosexp' (NºExpediente).
        // El tercero es la clave primaria en esta tabla, 'Expedientes' (NºExpediente).
        return $this->hasMany(EscritoExp::class, 'NºExpediente', 'NºExpediente');
    }
}
