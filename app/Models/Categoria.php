<?php

namespace App\Models;

use App\Http\Controllers\ProductosController;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;

    protected $fillable = [
        'categoria'
    ];

    
    public function Productos()
    {
        return $this->hasMany(Producto::class, 'idCategoria', 'idCategoria');
    }


}

