<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    if(mysqli_query($stock, "UPDATE rubros SET 
        nombre = '".strtoupper($_POST['nombre'])."', 
        dioptria = '".$_POST['dioptria']."',
        observacion = '".strtoupper($_POST['observacion'])."', 
        activo = '".$_POST['activo']."' 
        WHERE id = '".$_POST['id']."' 
        LIMIT 1")){
        echo "1";
        mysqli_close($stock);
    }else{
        echo "0";
    }
}
?>