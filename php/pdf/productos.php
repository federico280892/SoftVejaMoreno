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
        $this->Cell(20,10,utf8_decode('Clínica Veja Moreno - Productos'),0,1,'C');
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
    $pdf = new PDF('P','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','B',12);
    $peticion = mysqli_query($stock, "SELECT * FROM items ORDER BY nombre ASC");
    
    $pdf->Cell(0, 10, 'Lista de productos a la fecha '.date('d-m-Y H:i:s')." - Cantidad: ".mysqli_num_rows($peticion), 0, 1, 'C');
    $pdf->SetFont('Times','B',11);
    $pdf->Cell(10, 10, 'Act', 1, 0, 'C');
    $pdf->Cell(55, 10, 'Producto', 1, 0, 'C');
    $pdf->Cell(60, 10, utf8_decode('Descripción'), 1, 0, 'C');
    $pdf->Cell(65, 10, 'Observaciones', 1, 1, 'C');
    $pdf->SetFont('Times','',10);
    while($i = mysqli_fetch_assoc($peticion)){
        $pdf->Cell(10, 10, $i['activo'], 1, 0, 'C');
        $pdf->Cell(55, 10, utf8_decode($i['nombre']), 1, 0, 'C');
        $pdf->Cell(60, 10, utf8_decode($i['descripcion']), 1, 0, 'C');
        $pdf->Cell(65, 10, utf8_decode($i['observaciones']), 1, 1, 'C');
    }
    
    $pdf->Output();


}
?>