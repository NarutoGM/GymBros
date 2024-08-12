<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_venta extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = ['idVentas', 'idProducto'];
    public $timestamps = false;     

    protected $fillable = [
        'precio','cantidad'
    ];

    

    // Relación uno a uno con Membresia
    public function Productos()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }
    public function Ventas()
    {
        return $this->belongsTo(Ventas::class, 'idVentas', 'idVentas');
    }

}

