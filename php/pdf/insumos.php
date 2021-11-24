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
        $this->Cell(35,10,utf8_decode('Clínica Veja Moreno - ARTICULOS'),0,1,'C');
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
    $peticion = mysqli_query($stock, "SELECT 
    articulos.id AS 'id', 
    articulos.activo AS 'activo', 
    articulos.nombre AS 'articulo',
    articulos.codigo_barra AS 'codigo_barra',
    articulos.observaciones AS 'observaciones', 
    articulos.stockMin AS 'stockMin', 
    articulos.n_lote AS 'lote', 
    articulos.vencimiento AS 'vencimiento',
    articulos.marca AS 'marca',
    rubros.nombre AS 'rubro',
    existencias.cantidad AS 'cantidad' 
    FROM articulos 
    INNER JOIN existencias
    ON existencias.id_articulo = articulos.id
    INNER JOIN rubros
    ON rubros.id = articulos.id_rubro
    WHERE articulos.id_grupo != '2'
    ORDER BY articulos.nombre ASC");
    
    $pdf->Cell(0, 10, utf8_decode('Lista de artículos a la fecha '.date('d-m-Y H:i:s')." - Cantidad: ".mysqli_num_rows($peticion)), 0, 1, 'C');
    while($a = mysqli_fetch_assoc($peticion)){
        $pdf->SetFont('Times','B',11);
        $pdf->Cell(10, 10, 'Act', 1, 0, 'C');
        $pdf->Cell(50, 10, utf8_decode('Artículo'), 1, 0, 'C');
        $pdf->Cell(30, 10, utf8_decode('Código de barra'), 1, 0, 'C');
        $pdf->Cell(50, 10, 'Rubro', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Proveedor', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Precio de costo', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Precio de venta', 1, 1, 'C');
        
        $pdf->SetFont('Times','',10);
        if($a['activo'] == "1"){
            $pdf->Cell(10, 6, "Act", 1, 0, 'C');
        }else{
            $pdf->Cell(10, 6, "Inac", 1, 0, 'C');
        }
        $pdf->Cell(50, 6, utf8_decode($a['articulo']), 1, 0, 'C');
        if($a['codigo_barra'] == ""){
            $pdf->Cell(40, 6, "-", 1, 0, 'C');
        }else{
            $pdf->Cell(30, 6, utf8_decode($a['codigo_barra']), 1, 0, 'C');
        }
        $pdf->Cell(50, 6, utf8_decode($a['rubro']), 1, 0, 'C');
        // $pdf->Cell(50, 10, utf8_decode($i['nombreProveedor']), 1, 0, 'C');
        // $pdf->Cell(30, 10, '$'.utf8_decode($i['precio_costo']), 1, 0, 'C');
        // $pdf->Cell(30, 10, '$'.utf8_decode($i['precio_venta']), 1, 1, 'C');
        
        // $pdf->SetFont('Times','B',11);
        // $pdf->Cell(30, 10, utf8_decode('N° de lote'), 1, 0, 'C');
        // $pdf->Cell(35, 10, 'Vencimiento', 1, 0, 'C');
        // $pdf->Cell(30, 10, 'Marca', 1, 0, 'C');
        // $pdf->Cell(20, 10, 'Diop', 1, 0, 'C');
        // $pdf->Cell(155, 10, 'Observaciones', 1, 1, 'C');
        // $pdf->SetFont('Times','',10);
        
        // $pdf->SetFont('Times','',10);
        // $pdf->Cell(30, 10, utf8_decode($i['n_lote']), 1, 0, 'C');
        // $pdf->Cell(35, 10, utf8_decode($i['vencimiento']), 1, 0, 'C');
        // $pdf->Cell(30, 10, utf8_decode($i['marca']), 1, 0, 'C');
        // $pdf->Cell(20, 10, utf8_decode($i['dioptrias']), 1, 0, 'C');
        // $pdf->Cell(155, 10, utf8_decode($i['observaciones']), 1, 1, 'C');

        $pdf->Ln(10);
    }
    
    $pdf->Output();


}
?>