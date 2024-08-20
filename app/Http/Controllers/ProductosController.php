<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Membresias;
use App\Models\Movimientos;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Laravel\Prompts\alert;



class ProductosController extends Controller
{
    const PAGINATION =25;
  public function edit(Request $request,$CodCurso)
    {

    }

    public function update(Request $request, $idProducto)
    {
        $numero = $request->input('numero');

        if ($numero==1){
        $request->validate([
            'producto' => 'required|max:90',
            'idCategoria' => 'required|integer',  // Valida que 'duracion' sea un número entero
            'precio' => 'required|numeric',  // Valida que 'precio' sea un número decimal
    //        'stock' => 'required|integer',  // Valida que 'precio' sea un número decimal

            // Agrega más reglas de validación según sea necesario
        ]);
    
        // Buscar el curso por su CodCurso
        $producto = Producto::where('idProducto', $idProducto)->firstOrFail();
    
        $producto->producto = $request->producto;  // Assigning the value 
        $producto->precio = $request->precio;  // Assigning the value of NombreCurso
      //  $producto->stock = $request->stock;  // Assigning the value of NombreCurso
        $producto->save();
    
        // Redireccionar a la vista de índice de cursos
        return redirect()->route('productos.index');

        }else{
            $request->validate([
                'producto' => 'required|max:90',
                'idCategoria' => 'required|integer',  // Valida que 'duracion' sea un número entero
                'precio' => 'required|numeric',  // Valida que 'precio' sea un número decimal
        //        'stock' => 'required|integer',  // Valida que 'precio' sea un número decimal
    
                // Agrega más reglas de validación según sea necesario
            ]);
        
            // Buscar el curso por su CodCurso
            $producto = Producto::where('idProducto', $idProducto)->firstOrFail();
        
            $producto->stock = $producto->stock + $request->stock;  // Assigning the value of NombreCurso
            $producto->save();
        
            $movimiento = new Movimientos();
            $movimiento->fecha = now(); // Usa la fecha y hora actuales
            $movimiento->tipo = 'E';
            $movimiento->cantidad = $request->stock;
            $movimiento->stock = $producto->stock;
            $movimiento->idProducto = $idProducto;
            $movimiento->id = auth()->id(); // Asegúrate de que el campo en tu tabla se llama 'user_id' o similar

            $movimiento->save();

            // Redireccionar a la vista de índice de cursos
            return redirect()->route('productos.index');
    
        }

    }
    


    public function create()
    {
        return view('productos.create');
    }



    public function index(Request $request)
    {
        $categoria=Categoria::all();

        $producto = Producto::with('categoria:idCategoria,categoria')->paginate(15);
    
        return Inertia::render('Producto/Index', [
            'producto' => $producto,
            'categoria' => $categoria
        ]);
        
    //     return response()->json([
     //        'producto' => $producto,
     //        'categoria' => $categoria
     //    ]);
    }
    
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'producto' => 'required|max:90',
            'idCategoria' => 'required|integer',  // Valida que 'duracion' sea un número entero
            'precio' => 'required|numeric',  // Valida que 'precio' sea un número decimal
     //       'stock' => 'required|integer',  // Valida que 'precio' sea un número decimal

            // Agrega más reglas de validación según sea necesario
        ]);
    
        // Verificar si ya existe un curso con el código proporcionado

        $producto = new Producto();
        $producto->producto = $request->producto;  // Assigning the value 
        $producto->precio = $request->precio;  // Assigning the value of NombreCurso
        $producto->idCategoria = $request->idCategoria;  // Assigning the value of NombreCurso

    //    $producto->stock = $request->stock;  // Assigning the value of NombreCurso
        $producto->save();
    
        // Redirigir a la página de índice de cursos u otra página
        return redirect()->route('productos.index');
       //  return response()->json([    'NombreCurso' => $request->NombreCurso, 'CodCurso' => $request->CodCurso]);
    }

    
    public function destroy( $idProducto)
    {
        $producto = Producto::where('idProducto', $idProducto)->first();
        if ($producto) {
            $producto->delete();
            return redirect('productos');
        } else {
            // Handle the case when the record doesn't exist
            return redirect('productos');
        }

    }
   
} 