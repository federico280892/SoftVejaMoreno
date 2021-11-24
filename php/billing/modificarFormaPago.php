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
    if(mysqli_query($veja, "UPDATE formas_pago SET pago = '".strtoupper($_POST['formaPago'])."', descripcion = '".strtoupper($descripcion)."' WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>