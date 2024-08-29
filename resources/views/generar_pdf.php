<?php
require_once public_path('fpdf186/fpdf.php');

class PDF extends FPDF
{
   function Header()
   {
      $this->SetFont('Arial', 'B', 16);
      $this->Cell(0, 10, utf8_decode("DETALLES DE VENTA"), 0, 1, 'C');
      $this->Ln(10);
   }

   function Footer()
   {
      $this->SetY(-30);
      $this->SetFont('Arial', 'I', 8);
      $hoy = date('d/m/Y');
      $this->Cell(0, 10, utf8_decode($hoy), 0, 0, 'C');
   }
}

// Crear instancia del objeto PDF
$pdf = new PDF();

// Define márgenes
$pdf->SetMargins(25, 25, 25);
$pdf->AddPage('P', 'A4');
$pdf->AliasNbPages();

// Configura la fuente
$pdf->SetFont('Arial', '', 12);

// Agrega información de la venta
$pdf->Cell(0, 10, utf8_decode('Detalles de la Venta'), 0, 1, 'L');
$pdf->Ln(10);

// Detalles de la venta
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Venta ID:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '12345', 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Fecha:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '21/08/2024', 0, 1);

$pdf->Ln(10);

// Detalle de venta
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(30, 10, 'Precio Unitario', 1);
$pdf->Cell(30, 10, 'Total', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

// Datos de ejemplo para detalle de venta
$productos = [
    ['Producto A', 2, 10.00],
    ['Producto B', 1, 20.00],
    ['Producto C', 3, 15.00]
];

foreach ($productos as $producto) {
    $pdf->Cell(80, 10, utf8_decode($producto[0]), 1);
    $pdf->Cell(30, 10, $producto[1], 1);
    $pdf->Cell(30, 10, number_format($producto[2], 2), 1);
    $pdf->Cell(30, 10, number_format($producto[1] * $producto[2], 2), 1);
    $pdf->Ln();
}

$pdf->Ln(10);

// Total general
$total = array_reduce($productos, function ($carry, $producto) {
    return $carry + ($producto[1] * $producto[2]);
}, 0);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 10, 'Total:', 1);
$pdf->Cell(30, 10, number_format($total, 2), 1);
$pdf->Ln(20);

// Firmas
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Firmado por:'), 0, 1);
$pdf->Ln(10);
$pdf->Cell(0, 10, utf8_decode('[Nombre Completo del Representante]'), 0, 1);

// Salida del PDF
$pdf->Output('Venta_12345.pdf', 'I');
?>
