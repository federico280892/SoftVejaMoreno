<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    if(mysqli_query($stock, "INSERT INTO grupos VALUES(NULL, 
            '".strtoupper($_POST['nombre'])."',
            '".strtoupper($_POST['descripcion'])."',
            '".strtoupper($_POST['rubro'])."',
            '".strtoupper($_POST['observaciones'])."',
            '".$_POST['activo']."')")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}
?>