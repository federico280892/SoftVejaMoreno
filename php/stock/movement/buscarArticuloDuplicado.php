<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT id FROM articulos WHERE nombre = '".$_POST['articulo']."'");
    if(mysqli_fetch_assoc($peticion) > 0){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}
?>