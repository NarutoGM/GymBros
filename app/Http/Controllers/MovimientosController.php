<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Membresias;
use App\Models\Miembros;
use App\Models\Movimientos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\alert;



class MovimientosController extends Controller
{
    const PAGINATION =25;
  public function edit(Request $request,$dni)
    {
        $miembros = Miembros::where('dni', $dni)->first();
        $membresias=Membresias::all();

        return Inertia::render('Miembros/Edit', [
            'miembros' => $miembros,
            'membresias' => $membresias, 
            'membresiasOfMiembros' => $miembros->membresias,
        ]);

     //   return response()->json([    'miembros' => $miembros, 'membresias' => $membresias,'membresiasOfMiembros' => $miembros->membresias]);

    }
    
    public function show(string $dni)
    {
        $miembros = Miembros::with('membresias:idMembresia,nombre')
            ->where('dni', $dni)
            ->first();
    
        return Inertia::render('Miembros/Show', [
            'miembros' => $miembros,
        ]);
    }
    
    public function update(string $dni)
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
        return Inertia::render('Miembros/Create');
    }




public function index(Request $request)
    {
        $query = Movimientos::with('productos:idProducto,producto', 'user:id,name')
                             ->orderBy('fecha', 'desc'); // Cambia 'desc' a 'asc' si necesitas un orden ascendente
        
        $year = $request->query('year');
        $month = $request->query('month');

        // Filtrar por año y mes si ambos parámetros están presentes
        if (!empty($year) && !empty($month)) {
            $query->whereYear('fecha', $year)
                  ->whereMonth('fecha', $month);
        } elseif (!empty($year)) { // Filtrar solo por año si el mes no está presente
            $query->whereYear('fecha', $year);
        } elseif (!empty($month)) { // Filtrar solo por mes si el año no está presente
            $query->whereMonth('fecha', $month);
        }

        // Obtener los movimientos con paginación
        $movimientos = $query->paginate(15);

        // Pasar los datos a la vista
        return Inertia::render('Movimiento/Index', [
            'movimientos' => $movimientos
        ]);
    }
      //  return response()->json([
     //       'movimientos' => $movimientos
     //   ]);    
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|max:90',
            'duracion' => 'required|integer|max:90',  // Valida que 'duracion' sea un número entero
            'precio' => 'required|numeric',  // Valida que 'precio' sea un número decimal
        
            // Agrega más reglas de validación según sea necesario
        ]);
    
        // Verificar si ya existe un curso con el código proporcionado

        $membresia = new Membresias();
        $membresia->nombre = $request->nombre;  // Assigning the value 
        $membresia->duracion = $request->duracion;  // Assigning the value of NombreCurso

        $membresia->precio = $request->precio;  // Assigning the value of NombreCurso

        $membresia->save();
    
        // Redirigir a la página de índice de cursos u otra página
        return redirect()->route('membresias.index');
       //  return response()->json([    'NombreCurso' => $request->NombreCurso, 'CodCurso' => $request->CodCurso]);
    }

    
    public function destroy( $dni)
    {
        $miembros = Miembros::where('dni', $dni)->first();
        if ($miembros) {
            $miembros->delete();
            return redirect('miembros')->with('success','Miembro eliminado');
        } else {
            // Handle the case when the record doesn't exist
            return redirect('miembros');
        }

    }
   
} 