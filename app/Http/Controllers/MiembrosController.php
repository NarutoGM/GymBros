<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Membresias;
use App\Models\Miembros;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Strings;

use function Laravel\Prompts\alert;



class MiembrosController extends Controller
{
    const PAGINATION =25;
  public function edit(Request $request,$dni)
    {
        $miembros = Miembros::with('membresias:idMembresia,nombre')->where('dni',$dni)->first();
        $membresias=Membresias::all();

          return Inertia::render('Miembros/Edit', [
              'miembros' => $miembros,
              'membresias' => $membresias
          ]);

       // return response()->json([    'miembros' => $miembros, 'membresias' => $membresias]);
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
    
    public function update(Request $request,  string $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'dni' => 'required|digits:8',  // Valida que 'dni' tenga 8 dígitos y sea único en la tabla 'miembros'
            'nombre' => 'required|max:90',  // Valida que 'nombre' sea requerido y tenga un máximo de 90 caracteres
            'direccion' => 'required|max:255',  // Valida que 'direccion' sea requerido y tenga un máximo de 255 caracteres
            'telefono' => 'required|digits:9',  // Valida que 'telefono' tenga exactamente 9 dígitos
            'telefonoContacto' => 'required|digits:9',  // Valida que 'telefono' tenga exactamente 9 dígitos
            'edad' => 'required|integer|min:0|max:120',  // Valida que 'edad' sea un número entero entre 0 y 120
            'nombreContacto' => 'required|max:90',  // Valida que 'nombreContacto' sea requerido y tenga un máximo de 90 caracteres
            'enfermedad' => 'nullable|max:255',  // Valida que 'enfermedad' no exceda los 255 caracteres (es opcional)
            'institucion' => 'nullable|max:255'  // Valida que 'institucion' no exceda los 255 caracteres (es opcional)
        ]);
    
        $miembro = Miembros::where('dni', $id)->first();

        $miembro->nombre = $request->nombre;
        $miembro->direccion = $request->direccion;
        $miembro->telefono = $request->telefono;
        $miembro->edad = $request->edad;
        $miembro->nombreContacto = $request->nombreContacto;  // Asegúrate de que esta columna existe en la tabla
        $miembro->enfermedad = $request->enfermedad;
        $miembro->institucion = $request->institucion;
        $miembro->telefonoContacto = $request->telefonoContacto;

        // Guardar el nuevo miembro en la base de datos
        $miembro->save();
    
        // Redirigir a la página de índice de miembros u otra página
        return redirect()->route('miembros.index')->with('success', 'Información editada exitosamente.');
    }


    public function create()
    {
        return Inertia::render('Miembros/Create');
    }




    public function index(Request $request)
    {   
        $membresias=Membresias::all();
        $miembros = Miembros::with('membresias:idMembresia,nombre')->paginate(5);
        
        return Inertia::render('Miembros/Index', [
            'miembros' => $miembros,
            'membresias' => $membresias
        ]);
    }
    
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'dni' => 'required|digits:8|unique:miembros,dni',  // Valida que 'dni' tenga 8 dígitos y sea único en la tabla 'miembros'
            'nombre' => 'required|max:90',  // Valida que 'nombre' sea requerido y tenga un máximo de 90 caracteres
            'direccion' => 'required|max:255',  // Valida que 'direccion' sea requerido y tenga un máximo de 255 caracteres
            'telefono' => 'required|digits:9',  // Valida que 'telefono' tenga exactamente 9 dígitos
            'telefonoContacto' => 'required|digits:9',  // Valida que 'telefono' tenga exactamente 9 dígitos
            'edad' => 'required|integer|min:0|max:120',  // Valida que 'edad' sea un número entero entre 0 y 120
            'nombreContacto' => 'required|max:90',  // Valida que 'nombreContacto' sea requerido y tenga un máximo de 90 caracteres
            'enfermedad' => 'nullable|max:255',  // Valida que 'enfermedad' no exceda los 255 caracteres (es opcional)
            'institucion' => 'nullable|max:255'  // Valida que 'institucion' no exceda los 255 caracteres (es opcional)
        ]);
    
        // Crear un nuevo miembro con los datos validados
        $miembro = new Miembros(); // Asegúrate de usar el modelo correcto (probablemente sea singular: `Miembro`)
        $miembro->dni = $request->dni;
        $miembro->nombre = $request->nombre;
        $miembro->direccion = $request->direccion;
        $miembro->telefono = $request->telefono;
        $miembro->edad = $request->edad;
        $miembro->nombreContacto = $request->nombreContacto;  // Asegúrate de que esta columna existe en la tabla
        $miembro->enfermedad = $request->enfermedad;
        $miembro->institucion = $request->institucion;
        $miembro->telefonoContacto = $request->telefonoContacto;

        // Guardar el nuevo miembro en la base de datos
         $miembro->save();
    
        // Redirigir a la página de índice de miembros u otra página
        return redirect()->route('miembros.index')->with('success', 'Miembro creado exitosamente.');
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