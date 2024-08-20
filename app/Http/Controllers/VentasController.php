<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Detalle_venta;
use App\Models\Membresias;
use App\Models\Movimientos;
use App\Models\Producto;
use App\Models\User;
use App\Models\Ventas;
use COM;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Laravel\Prompts\alert;



class VentasController extends Controller
{
    const PAGINATION =25;
  public function edit(Request $request,$CodCurso)
    {

    }

    public function update(Request $request, $idMembresia)
    {
        $request->validate([
            'nombre' => 'required|max:90',
            'duracion' => 'required|integer|max:90',  // Valida que 'duracion' sea un número entero
            'precio' => 'required|numeric',  // Valida que 'precio' sea un número decimal
        
            // Agrega más reglas de validación según sea necesario
        ]);
    
        // Buscar el curso por su CodCurso
        $membresia = Membresias::where('idMembresia', $idMembresia)->firstOrFail();
    
        $membresia->nombre = $request->nombre;  // Assigning the value 
        $membresia->duracion = $request->duracion;  // Assigning the value of NombreCurso
        $membresia->precio = $request->precio;  // Assigning the value of NombreCurso
        $membresia->save();
    
        // Redireccionar a la vista de índice de cursos
        return redirect()->route('membresias.index');
    }
    


    public function create()
    { 
        $productos=Producto::all();

        return Inertia::render('Ventas/Create', [
            'productos' => $productos
            ]);
   // return response()->json([    'productos' => $productos]);

    }




    public function index(Request $request)
    {
        $user=User::all();
        $ventas = Ventas::with('user:id,name')->paginate(15);

    //   return response()->json([    'ventas' => $ventas]);

        return Inertia::render('Ventas/Index', [
            'ventas' => $ventas
            ]);
    }
  //  public function store(Request $request)
 //   {
        // Obtener el contenido del arreglo 'productos'
  //      $productos = $request->input('productos');
    
        // Retornar el contenido en formato JSON
  //      return response()->json($productos);
 //   }
      
    public function store(Request $request)
    {
        // Validación (opcional)
      //  $request->validate([
    //        'tipofacturacion' => 'required|string',
   //         'montobruto' => 'required|numeric',
     //       'igv' => 'required|numeric',
      //      'montoneto' => 'required|numeric',
      //      'cliente' => 'required|string',
      //      'productos' => 'required|array',
      //      'productos.*.idProducto' => 'required|integer',
       //     'productos.*.precio' => 'required|numeric',
      //      'productos.*.cantidad' => 'required|integer',
       // ]);
    
        // Crear la venta
        $venta = new Ventas();
        $venta->tipofacturacion = $request->tipofacturacion;  // Asignar el valor 
        $venta->id = auth()->id();  // Asignar el valor 
        $venta->fecha = now();  // Usar el helper 'now()' para obtener la fecha y hora actual
        $venta->montobruto = $request->montobruto;  // Asignar el valor 
        $venta->igv = $request->igv;  // Asignar el valor 
        $venta->montoneto = $request->montoneto;  // Asignar el valor 
       $venta->cliente = $request->cliente;  // Asignar el valor 
    
        // Guardar la venta para obtener el idVentas
            $venta->save();

        foreach ($request->productos as $producto) {
                $detalleventa = new Detalle_venta();
                $detalleventa->idVentas = $venta->idVentas;  // Asignar el id de la venta guardada
                $detalleventa->idProducto = $producto['idProducto'];  // Asignar el id del producto
                $detalleventa->precio = $producto['precio'];  // Asignar el precio del producto
                $detalleventa->cantidad = $producto['cantidad'];  // Asignar la cantidad del producto
                $detalleventa->save();

                $p = Producto::where('idProducto', $producto['idProducto'])->firstOrFail();
                $p->stock= $p->stock - $producto['cantidad'];


                $movimiento = new Movimientos();
                $movimiento->fecha = now(); // Usa la fecha y hora actuales
                $movimiento->tipo = 'S';
                $movimiento->cantidad = $producto['cantidad'];
                $movimiento->stock = $p->stock;
                $movimiento->idProducto = $producto['idProducto']; ;
                $movimiento->id = auth()->id(); // Asegúrate de que el campo en tu tabla se llama 'user_id' o similar
    
                $movimiento->save();
            }


        
     return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito');
 }
    


    
    public function destroy( $idMembresia)
    {
        $membresia = Membresias::where('idMembresia', $idMembresia)->first();
        if ($membresia) {
            $membresia->delete();
            return redirect('membresias');
        } else {
            // Handle the case when the record doesn't exist
            return redirect('membresias');
        }

    }
   
} 