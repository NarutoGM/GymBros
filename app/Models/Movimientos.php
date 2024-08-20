<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    protected $table = 'movimientos';
    protected $primaryKey = 'idMovimientos';
    public $timestamps = false;     

    protected $fillable = [
        'fecha','tipo','direccion','cantidad'
    ];

    

    // Relación uno a uno con Membresia
    public function Productos()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }


}

