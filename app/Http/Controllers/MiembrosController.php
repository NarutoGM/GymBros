<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Membresias;
use App\Models\Miembros;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Laravel\Prompts\alert;



class MiembrosController extends Controller
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
        return view('membresias.create');
    }




    public function index(Request $request)
    {   
        $miembros = Miembros::paginate(9);
    
        return Inertia::render('Miembros/Index', [
            'miembros' => $miembros
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