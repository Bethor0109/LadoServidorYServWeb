<?php
require('fpdf/fpdf.php');
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    
    // Arial bold 15
    $this->SetFont('Arial','I',15);
    // Movernos a la derecha
    $this->Cell(55);
    // Título
    $this->Cell(70,10,'Reportes De Cuentas',0,0,'C');
    
    // Salto de línea
    $this->Ln(20);

    $this->Cell(26,10,'ID Usuario',1,0,'C',0);
    $this->Cell(50,10,utf8_decode('Nombre'),1,0,'C',0);
    $this->Cell(60,10,'Apellido',1,0,'C',0);
    $this->Cell(50,10,'Fecha Nacimiento',1,1,'C',0);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Páginas').$this->PageNo().'/{nb}',0,0,'C');

}
}
require 'bd_conec.php';
$consulta = "SELECT * FROM `usuarios`";
$resultado = $mysqli->query($consulta);

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',16);
//(40,10,utf8_decode('¡Hola, Mundo!'));
while ($row = $resultado->fetch_assoc()) {

    $date = date_create($row['fecha_na']);
    $formato =date_format($date,'d/m/Y');
    # code...
    $pdf->Cell(26,10,$row['id_usuario'],1,0,'L',0);
    $pdf->Cell(50,10,$row['nombre'],1,0,'C',0);
    $pdf->Cell(60,10,$row['apellido'],1,0,'C',0);
    $pdf->Cell(50,10,$formato,1,1,'C',0);

}
$pdf->Output();
?>