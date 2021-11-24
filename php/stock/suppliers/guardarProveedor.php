<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    if(mysqli_query($stock, "INSERT INTO proveedores VALUES(NULL, 
    '".strtoupper($_POST['nombre'])."',
    '".strtoupper($_POST['r_social'])."',
    '".$_POST['cuit_cuil']."',
    '".strtoupper($_POST['domicilio'])."',
    '".$_POST['telefono']."',
    '".$_POST['celular']."',
    '".$_POST['cbu']."',
    '".strtoupper($_POST['alias'])."',
    '".strtoupper($_POST['banco'])."',
    '".$_POST['mail']."',
    '".strtoupper($_POST['observacion'])."',
    '".$_POST['activo']."')")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}

?>