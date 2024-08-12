<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'idVentas';
    public $timestamps = false;     

    protected $fillable = [
        'tipofacturacion','id','fecha','montobruto','igv','montoneto','tipopago','name'
    ];

    

    public function detalleVentas()
    {
        return $this->hasMany(Detalle_venta::class, 'idVentas', 'idVentas');
    }

}

