<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membresias extends Model
{
    protected $table = 'membresias';
    protected $primaryKey = 'idMembresia';
    public $timestamps = false;

    protected $fillable = [
        'nombre','duracion','precio'
    ];

    
    public function evento()
    {
        return $this->hasOne(Miembros::class, 'idMembresia', 'idMembresia');
    }


}

