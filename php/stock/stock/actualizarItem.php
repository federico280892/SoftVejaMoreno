<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    if(mysqli_query($stock, "UPDATE grupos 
    SET nombre = '".strtoupper($_POST['nombre'])."', 
    descripcion = '".strtoupper($_POST['descripcion'])."', 
    rubro = '".$_POST['grupo']."',
    observaciones = '".strtoupper($_POST['observaciones'])."',
    activo = '".$_POST['activo']."' 
    WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}
?>