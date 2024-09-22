<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Carbon\Carbon;

use App\Models\Membresias;
use App\Models\Miembros;
use App\Models\Movimientos;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;




class DashBoardController extends Controller
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
    
    
    


    public function create()
    {
        return Inertia::render('Miembros/Create');
    }




    public function index(Request $request)
    {

        $query = Movimientos::orderBy('fecha', 'desc'); // Cambia 'desc' a 'asc' si necesitas un orden ascendente

// Usa el mes y año actuales si no se proporciona ninguno
$year = $request->query('year', now()->year);   // Si 'year' no está presente, usa el año actual
$month = $request->query('month', now()->month); // Si 'month' no está presente, usa el mes actual


        
        if (!empty($year) && !empty($month)) {
            $query->whereYear('fecha', $year)
                  ->whereMonth('fecha', $month);
        } elseif (!empty($year)) { // Filtrar solo por año si el mes no está presente
            $query->whereYear('fecha', $year);
        } elseif (!empty($month)) { // Filtrar solo por mes si el año no está presente
            $query->whereMonth('fecha', $month);
        }

        $movimientos = $query->paginate(15);

        // Cuenta las entradas y salidas
        $entradaCount = $movimientos->where('tipo', 'E')->count();
        $salidaCount = $movimientos->where('tipo', 'S')->count();

        return Inertia::render('Dashboard', [
            'movimientos' => $movimientos,
            'totalcategorias' => Categoria::all()->count(),
            'productos' => Producto::all(),
            'entradaCount' => $entradaCount,
            'salidaCount' => $salidaCount,
        ]);
    }
    
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