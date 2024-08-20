<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_venta extends Model
{
    protected $table = 'detalle_venta';
    public $incrementing = false;  // Desactivar la auto-incrementación
    public $timestamps = false;    

    protected $fillable = [
        'idVentas', 'idProducto', 'precio', 'cantidad'
    ];

    // Relaciones con otros modelos
    public function Productos()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }

    public function Ventas()
    {
        return $this->belongsTo(Ventas::class, 'idVentas', 'idVentas');
    }

}

