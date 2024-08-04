<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Miembros extends Model
{
    protected $table = 'miembros';
    protected $primaryKey = 'dni';
    public $timestamps = false;     

    protected $fillable = [
        'nombre','telefono','direccion','edad','sufreEnfermedad','tieneSeguro','enfermedad','institucion','nombreContacto','estado','fechaRegistro',
        'fechaInicio','fechaFin','idMembresia','membresia'
    ];

    

    // Relación uno a uno con Membresia
    public function Membresias()
    {
        return $this->belongsTo(Membresias::class, 'idMembresia', 'idMembresia');
    }


}

