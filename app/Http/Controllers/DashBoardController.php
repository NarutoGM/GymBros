<?php

namespace App\Http\Controllers;


use Carbon\Carbon;

use App\Models\Cursos;
use App\Models\Membresias;
use App\Models\Miembros;
use App\Models\Movimientos;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\alert;



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




    public function index(Request $request, $month = null, $year = null)
    {
        // Usa el mes y año actuales si no se proporciona ninguno
        $month = $month ? (int) $month : Carbon::now()->month;
        $year = $year ? (int) $year : Carbon::now()->year;

        // Obtén los movimientos del mes y año seleccionados
        $movimientos = Movimientos::with('productos:producto')
            ->whereMonth('fecha', $month)
            ->whereYear('fecha', $year)
            ->get();

        // Cuenta las entradas y salidas
        $entradaCount = $movimientos->where('tipo', 'E')->count();
        $salidaCount = $movimientos->where('tipo', 'S')->count();

        return Inertia::render('Dashboard', [
            'movimientos' => $movimientos,
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