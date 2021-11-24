<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $carpeta = "../../../img/products/";
    $peticion = mysqli_query($stock, "SELECT img FROM articulos WHERE id = '".$_POST['id']."' LIMIT 1");
    while($i = mysqli_fetch_assoc($peticion)){
        if($i['img'] != "default_product.jpg"){
            unlink($carpeta.$i['img']);
        }
    }
    if(mysqli_query($stock, "DELETE FROM articulos WHERE id = '".$_POST['id']."' LIMIT 1") 
    && 
    mysqli_query($stock, "DELETE FROM existencias WHERE id_articulo = '".$_POST['id']."' LIMIT 1")){
        echo "1";
        mysqli_close($stock);
    }else{
        echo "0";
    }
}
?>