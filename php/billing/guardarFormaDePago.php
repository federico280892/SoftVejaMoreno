<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if($_POST['descripcionPago'] == ""){
        $descripcion = "-";
    }else{
        $descripcion = $_POST['descripcionPago'];
    }
    if(mysqli_query($veja, "INSERT INTO formas_pago VALUES(NULL, '".strtoupper($_POST['formaPago'])."', '".strtoupper($descripcion)."', '1')")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>