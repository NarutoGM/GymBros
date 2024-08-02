<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;     

    protected $fillable = [
        'nombre','telefono','direccion','edad','sufreEnfermedad','tieneSeguro','enfermedad','institucion','nombreContacto','estado','fechaRegistro',
        'fechaInicio','fechaFin','idMembresia','membresia'
    ];

    

    // Relación uno a uno con Membresia
    public function Categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria', 'idCategoria');
    }


}

