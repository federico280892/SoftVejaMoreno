<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    if(mysqli_query($stock, "UPDATE proveedores 
    SET nombre = '".strtoupper($_POST['nombre'])."', 
    razon_social = '".strtoupper($_POST['razonSocial'])."', 
    CUIT_CUIL = '".$_POST['cuil_cuit']."', 
    domicilio = '".strtoupper($_POST['domicilio'])."', 
    telefono = '".$_POST['telefono']."', 
    celular = '".$_POST['celular']."', 
    CBU = '".$_POST['CBU']."', 
    alias = '".strtoupper($_POST['alias'])."', 
    banco = '".strtoupper($_POST['banco'])."', 
    mail = '".$_POST['mail']."', 
    observacion = '".strtoupper($_POST['observacion'])."', 
    activo = '".$_POST['activo']."' 
    WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
        mysqli_close($stock);
    }else{
        echo "0";
    }
}
?>