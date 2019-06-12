<?php
require 'fpdf/fpdf.php';
class PDF extends FPDF
{
// Cabecera de página
    public function Header()
    {
// Logo

// Arial bold 15
        $this->SetFont('Arial', 'I', 15);
// Movernos a la derecha
        $this->Cell(62);
// Título
        $this->Cell(68, 10, 'Repositorios ligados a mi cuenta', 0, 0, 'C');
// Salto de línea
        $this->Ln(20);

        $this->Cell(15, 10, 'Id', 1, 0, 'C', 0);
        $this->Cell(40, 10, utf8_decode('Tipo repositorio'), 1, 0, 'C', 0);
        $this->Cell(80, 10, 'Nombre del repositorio', 1, 0, 'C', 0);
        $this->Cell(55, 10, 'fecha de creacion', 1, 1, 'C', 0);

        /*
        $this->Cell(60, 10, 'Correo', 1, 0, 'C', 0);
        $this->Cell(40, 10, utf8_decode('Contraseña'), 1, 0, 'C', 0);
        $this->Cell(40, 10, 'Id del Usuario', 1, 0, 'C', 0);
        $this->Cell(40, 10, 'Estado', 1, 1, 'C', 0);
        */
    }

// Pie de página
    public function Footer()
    {
// Posición: a 1,5 cm del final
        $this->SetY(-15);
// Arial italic 8
        $this->SetFont('Arial', 'I', 8);
// Número de página``
        $this->Cell(0, 10, utf8_decode('Páginas ') . $this->PageNo() . '/{nb}', 0, 0, 'C');

    }
}
require 'bd_conec.php';
$idCuenta = $_POST["id_cuenta"];
$consulta = "SELECT * FROM `repositorio` WHERE `id_cuenta` = $idCuenta";
$resultado = $mysqli->query($consulta);

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 16);
//(40,10,utf8_decode('¡Hola, Mundo!'));
while ($row = $resultado->fetch_assoc()) {
# code...
    $pdf->Cell(15, 10, $row['id_repositorio'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $row['id_tiporepositorio'], 1, 0, 'C', 0);
    $pdf->Cell(80, 10, $row['nombre_rep'], 1, 0, 'C', 0);
    $pdf->Cell(55, 10, $row['fecha_ceacion'], 1, 1, 'C', 0);
}
$pdf->Output();
