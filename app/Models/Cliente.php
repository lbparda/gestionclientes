<?php

namespace App\Models;

class Cliente extends BaseModel // <-- Asegúrate de que usa BaseModel
{
    protected $table = 'clientes';
    protected $primaryKey = 'NºRef';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // ... (tu array $fillable aquí) ...
    protected $fillable = [
        "NºReferencia", "NºRef", "FechaEntrada", "Nombre", "DNI", "Dirección",
        "Localidad", "Provincia", "CP", "TeléfonodeContacto", "TeléfonoMóvil",
        "Fax", "Email", "Pendiente", "Observaciones", "AsuntoP", "Procurador",
        "Historico", "Banco", "DireBanco", "LocBanco", "ProBanco", "Entidad",
        "Sucursal", "DC", "Cuenta", "RefPro", "Poder", "Pais", "Representacion",
        "Iguala", "FNacimiento", "IBAN", "Procedencia"
    ];


    public function getRouteKeyName()
    {
        return 'NºRef';
    }

    public function expedientes()
    {
        return $this->hasMany(DExpCli::class, 'RefCliente', 'NºRef');
    }

    // NO se necesita el array $casts.
}
