<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseModel extends Model
{
    /**
     * Caché estática para no consultar el esquema de la BD más de una vez por tabla.
     */
    protected static $schemaCache = [];

    /**
     * Sobrescribimos el constructor. Se ejecuta cada vez que se crea un modelo.
     */
    public function __construct(array $attributes = [])
    {
        $this->applyAutomaticCasts();
        parent::__construct($attributes);
    }

    /**
     * Aplica el casting a los campos booleanos de forma automática.
     */
    protected function applyAutomaticCasts()
    {
        $tableName = $this->getTable();

        // Si no hemos analizado esta tabla antes, lo hacemos ahora.
        if (!isset(static::$schemaCache[$tableName])) {
            // Usamos un comando 'describe' que es directo y fiable en MySQL/MariaDB.
            $columns = DB::select('describe `' . $tableName . '`');
            static::$schemaCache[$tableName] = $columns;
        }

        // Recorremos las columnas de la tabla.
        foreach (static::$schemaCache[$tableName] as $column) {
            // Buscamos específicamente el tipo 'tinyint(1)', el booleano estándar.
            if (strtolower($column->Type) === 'tinyint(1)') {
                // Añadimos la columna a la propiedad $casts si no está ya definida manualmente.
                if (!array_key_exists($column->Field, $this->casts)) {
                    $this->casts[$column->Field] = 'boolean';
                }
            }
        }
    }
}
