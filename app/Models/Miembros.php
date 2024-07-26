<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Miembros extends Model
{
    protected $table = 'miembros';
    protected $primaryKey = 'dni';
    public $timestamps = false;     

    protected $fillable = [
        'nombre','duracion','precio'
    ];

    

    // Relación uno a uno con Membresia
    public function Membresias()
    {
        return $this->belongsTo(Membresias::class, 'idMembresia', 'idMembresia');
    }


}

