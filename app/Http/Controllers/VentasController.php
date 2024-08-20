<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Detalle_venta;
use App\Models\Membresias;
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
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipofacturacion' => 'required|string',
            'cliente' => 'required|string',
            'montobruto' => 'required|numeric',
            'igv' => 'required|integer',
            'montoneto' => 'required|numeric',
            'productos' => 'required|array',
            'productos.*.idProducto' => 'required|integer',
            'productos.*.cantidad' => 'required|integer',
            'productos.*.precio' => 'required|numeric',
        ]);
    
        // Crear la venta
        $venta = Ventas::create([
            'tipofacturacion' => $validated['tipofacturacion'],
            'fecha' => now(),
            'montobruto' => $validated['montobruto'],
            'igv' => $validated['igv'],
            'montoneto' => $validated['montoneto'],
            'id' => auth()->id(),  // El ID del usuario autenticado
            'cliente' => $validated['cliente'],
        ]);
    
        // Crear los detalles de la venta
        foreach ($validated['productos'] as $producto) {
            Detalle_venta::create([
                'idVentas' => $venta->idVentas,
                'idProducto' => $producto['idProducto'],
                'precio' => $producto['precio'],
                'cantidad' => $producto['cantidad'],
            ]);
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