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
require_once public_path('fpdf186/fpdf.php');

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

    public function imprimir(string $id)
{
    // Encuentra la venta por su ID usando Eloquent
    $venta = Ventas::findOrFail($id);
    $detalleVenta = Detalle_venta::where('idVentas', $venta->idVentas)->get();

    // Crear instancia del objeto PDF
    $pdf = new \FPDF();
    $pdf->AddPage('P', 'A4');

    // Configura los márgenes
    $pdf->SetMargins(25, 25, 25);

    // Configura la fuente
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode("DETALLES DE VENTA"), 0, 1, 'C');
    $pdf->Ln(10);

    // Información de la venta
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Venta ID:', 0, 0);
    $pdf->Cell(0, 10, utf8_decode($venta->idVentas), 0, 1);

    $pdf->Cell(40, 10, 'Fecha:', 0, 0);
    $pdf->Cell(0, 10, utf8_decode($venta->fecha), 0, 1);

    $pdf->Ln(10);

    // Detalles de la venta
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Producto', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(30, 10, 'Precio Unitario', 1);
    $pdf->Cell(30, 10, 'Total', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);

    foreach ($detalleVenta as $detalle) {

        $producto = Producto::where('idProducto', $detalle->idProducto)->firstOrFail();

        $pdf->Cell(80, 10, utf8_decode($producto->producto), 1);


        $pdf->Cell(30, 10, $detalle->cantidad, 1);
        $pdf->Cell(30, 10, number_format($detalle->precio, 2), 1);
        $pdf->Cell(30, 10, number_format($detalle->cantidad * $detalle->precio, 2), 1);
        $pdf->Ln();
    }

    $pdf->Ln(10);

    // Total general
    $total = $detalleVenta->sum(function ($detalle) {
        return $detalle->cantidad * $detalle->precio;
    });

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(140, 10, 'Total:', 1);
    $pdf->Cell(30, 10, number_format($total, 2), 1);
    $pdf->Ln(20);

    // Firmas
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(0, 10, utf8_decode('Firmado por: ' . auth()->user()->name), 0, 1);
    $pdf->Ln(10);

    // Salida del PDF para visualización
    $pdfOutput = $pdf->Output('S'); // 'S' para obtener el PDF como cadena

    return response($pdfOutput, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Venta_'.$venta->idVentas.'.pdf"');
}

    

    public function index(Request $request)
    {
        $user=User::all();
        $query = Ventas::with('user:id,name');

        
        $year = $request->query('year');
        $month = $request->query('month');

        if (!empty($year) && !empty($month)) {
            $query->whereYear('fecha', $year)
                  ->whereMonth('fecha', $month);
        } elseif (!empty($year)) { // Filtrar solo por año si el mes no está presente
            $query->whereYear('fecha', $year);
        } elseif (!empty($month)) { // Filtrar solo por mes si el año no está presente
            $query->whereMonth('fecha', $month);
        }

        // Obtener los movimientos con paginación
        $ventas = $query->paginate(15);
        
    //   return response()->json([    'ventas' => $ventas]);
    $startTime = $request->query('start_time');
        
    if ($startTime) {
        $endTime = now()->timestamp * 1000; // Convertir a milisegundos
        $timeTaken = $endTime - $startTime; // Diferencia en milisegundos
    
        // Convertir a segundos
        $timeTakenInSeconds = round($timeTaken / 1000, 2);
    } else {
        $timeTakenInSeconds = null; // O asigna un valor predeterminado si lo prefieres
    }

        return Inertia::render('Ventas/Index', [
            'ventas' => $ventas,
            'timeTakenInSeconds' => $timeTakenInSeconds

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

            $startTime = $request->startTime;  // Asignar el valor 


   //  return response()->json([    'startTime' => $startTime]);

    return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito en segundos' );
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