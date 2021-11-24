<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../../fpdf/fpdf.php");
    require_once("../conn.php");

    class PDF extends FPDF
    {
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../../img/actives/icon.png',10,8,15);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(120,10,utf8_decode('Clínica Veja Moreno - PROVEEDORES'),0,1,'C');
        // Salto de línea
        $this->Ln(15);
    }
    
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    }
    
    // Creación del objeto de la clase heredada
    $pdf = new PDF('L','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    $peticion = mysqli_query($stock, "SELECT * FROM proveedores ORDER BY nombre ASC");
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(0, 10, 'Lista de proveedores a la fecha '.date('d-m-Y H:i:s')." - Cantidad: ".mysqli_num_rows($peticion), 0, 1, 'C');
    while($i = mysqli_fetch_assoc($peticion)){
        $pdf->SetFont('Times','B',11);
        $pdf->Cell(10, 10, 'Act', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Razon social', 1, 0, 'C');
        $pdf->Cell(30, 10, 'CUIT / CUIL', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Domicilio', 1, 0, 'C');
        $pdf->Cell(25, 10, utf8_decode('Teléfono'), 1, 0, 'C');
        $pdf->Cell(55, 10, 'Email', 1, 0, 'C');
        $pdf->Cell(45, 10, 'CBU', 1, 1, 'C');
        
        $pdf->SetFont('Times','',10);
        $pdf->Cell(10, 10, $i['activo'], 1, 0, 'C');
        $pdf->Cell(40, 10, utf8_decode($i['nombre']), 1, 0, 'C');
        $pdf->Cell(40, 10, utf8_decode($i['razon_social']), 1, 0, 'C');
        $pdf->Cell(30, 10, utf8_decode($i['CUIT_CUIL']), 1, 0, 'C');
        $pdf->Cell(35, 10, utf8_decode($i['domicilio']), 1, 0, 'C');
        $pdf->Cell(25, 10, utf8_decode($i['telefono']), 1, 0, 'C');
        $pdf->Cell(55, 10, utf8_decode($i['mail']), 1, 0, 'C');
        $pdf->Cell(45, 10, utf8_decode($i['CBU']), 1, 1, 'C');

        $pdf->SetFont('Times','B',11);
        $pdf->Cell(65, 10, 'Alias', 1, 0, 'C');
        $pdf->Cell(55, 10, 'Banco', 1, 0, 'C');
        $pdf->Cell(160, 10, 'Observaciones', 1, 1, 'C');

        $pdf->SetFont('Times','',10);
        $pdf->Cell(65, 10, utf8_decode($i['alias']), 1, 0, 'C');
        $pdf->Cell(55, 10, utf8_decode($i['banco']), 1, 0, 'C');
        $pdf->Cell(160, 10, utf8_decode($i['observacion']), 1, 1, 'C');
        $pdf->Ln(10);
    }
    
    $pdf->Output();


}
?>