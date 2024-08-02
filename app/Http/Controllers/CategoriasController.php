<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Membresias;
use COM;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Laravel\Prompts\alert;



class CategoriasController extends Controller
{
    const PAGINATION =25;
  public function edit(Request $request,$CodCurso)
    {

    }

    public function update(Request $request, $idCategoria)
    {
        $request->validate([
            'categoria' => 'required|max:50'
            // Agrega más reglas de validación según sea necesario
        ]);
    
        // Buscar el curso por su CodCurso
        $categoria = Categoria::where('idCategoria', $idCategoria)->firstOrFail();
    
        $categoria->categoria = $request->categoria;  // Assigning the value 
        $categoria->save();
    
        // Redireccionar a la vista de índice de cursos
        return redirect()->route('categorias.index');
    }
    


    public function create()
    {
        return view('categorias.create');
    }




    public function index(Request $request)
    {
        $categoria = Categoria::with(['productos'])->withCount('productos')->paginate(9);
    
        return Inertia::render('Categoria/Index', [
            'categoria' => $categoria
        ]);


     //   return response()->json([
      //      'categoria' => $categoria
      //  ]);
    }
    
    
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'categoria' => 'required|max:50',
           
            // Agrega más reglas de validación según sea necesario
        ]);
    
        $categoria = new Categoria();
        $categoria->categoria = $request->categoria;  // Assigning the value 
        
        $categoria->save();
    
        // Redirigir a la página de índice de cursos u otra página
        return redirect()->route('categorias.index');
    }

    
    public function destroy( $idCategoria)
    {
        $categoria = Categoria::where('idCategoria', $idCategoria)->first();
        if ($categoria) {
            $categoria->delete();
            return redirect('categorias');
        } else {
            // Handle the case when the record doesn't exist
            return redirect('categorias');
        }

    }
   
} 