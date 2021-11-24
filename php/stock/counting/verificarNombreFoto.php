<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT id FROM insumos WHERE img = '".$_POST['nombre']."'");
    if(mysqli_num_rows($peticion) > 0){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}
?>