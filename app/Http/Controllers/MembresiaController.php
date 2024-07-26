<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Membresias;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Laravel\Prompts\alert;



class MembresiaController extends Controller
{
    const PAGINATION =25;
  public function edit(Request $request,$CodCurso)
    {

    }

    public function update(Request $request, $CodCurso)
    {
        // Validar los datos del formulario
        $request->validate([
            'NombreCurso' => 'required|max:90'
            // Agrega más reglas de validación según sea necesario
        ]);
    
        // Buscar el curso por su CodCurso
        $curso = Cursos::where('CodCurso', $CodCurso)->firstOrFail();
    
        // Asignar los nuevos valores desde la solicitud
        $curso->NombreCurso = $request->NombreCurso;
        // Asigna otros campos según sea necesario
    
        // Guardar los cambios
        $curso->save();
    
        // Redireccionar a la vista de índice de cursos
        return redirect()->route('cursos.index');
    }
    


    public function create()
    {
        return view('cursos.create');
    }




    public function index(Request $request)
    {
        $membresia = Membresias::orderBy('idMembresia', 'asc')->paginate(9);
    
        return Inertia::render('Membresias/Index', [
            'membresia' => $membresia
        ]);
    }
    
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'NombreCurso' => 'required|max:90',
            'CodCurso' => 'required|max:6|min:6'
            // Agrega más reglas de validación según sea necesario
        ]);
    
        // Verificar si ya existe un curso con el código proporcionado
        $cursoExistente = Cursos::where('CodCurso', $request->codigo)->exists();
        if ($cursoExistente) {
            return redirect()->route('cursos');
        }

        $curso = new Cursos(); // Asignar el valor del código del curso
        $curso->CodCurso = $request->CodCurso;  // Assigning the value of CodCurso
        $curso->NombreCurso = $request->NombreCurso;  // Assigning the value of NombreCurso

        $curso->save();
    
        // Redirigir a la página de índice de cursos u otra página
        return redirect()->route('cursos.index');
       //  return response()->json([    'NombreCurso' => $request->NombreCurso, 'CodCurso' => $request->CodCurso]);
    }

    
    public function destroy( $CodCurso)
    {
        $curso = Cursos::where('CodCurso', $CodCurso)->first();
        if ($curso) {
            $curso->delete();
            return redirect('cursos');
        } else {
            // Handle the case when the record doesn't exist
            return redirect('cursos');
        }

    }
   
} 