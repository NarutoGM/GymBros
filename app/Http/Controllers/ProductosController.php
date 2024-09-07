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
         return response()->json([
             'idCategoria' => $request->idCategoria ]);
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
        $producto->idCategoria = $request->idCategoria;  // Assigning the value 

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
            
                    // Si se sube una imagen, manejar la subida y almacenar la ruta
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time().'.'.$imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('imagenes', $nombreImagen, 'public'); // Guarda la imagen en storage/app/public/imagenes
    
            // Almacena la ruta de la imagen en la base de datos
            $producto->imagen = $rutaImagen;
        }
            
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


 // Calcular el tiempo transcurrido
 //$endTime = now()->timestamp * 1000; // Convertir a milisegundos
 //$timeTaken = $endTime - $request->tiempoini; // Diferencia en milisegundos

 // Convertir a segundos (si es necesario)
 //$timeDifference = round($timeTaken / 1000, 2);

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
        // Validación de los campos, incluyendo la imagen
        $request->validate([
            'producto' => 'required|max:90',
            'idCategoria' => 'required|integer',  // Valida que 'idCategoria' sea un número entero
            'precio' => 'required|numeric',  // Valida que 'precio' sea un número decimal
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Valida que el archivo sea una imagen
        ]);
    
        // Crear un nuevo producto
        $producto = new Producto();
        $producto->producto = $request->producto;
        $producto->precio = $request->precio;
        $producto->idCategoria = $request->idCategoria;
    
        // Si se sube una imagen, manejar la subida y almacenar la ruta
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time().'.'.$imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('imagenes', $nombreImagen, 'public'); // Guarda la imagen en storage/app/public/imagenes
    
            // Almacena la ruta de la imagen en la base de datos
            $producto->imagen = $rutaImagen;
        }
    
        // Guardar el producto en la base de datos
        $producto->save();
    // return response()->json([    'rutaImagen' => $rutaImagen]);
        // Redirigir a la lista de productos con un mensaje de éxito
      return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }
    
       //  

    
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