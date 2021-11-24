<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    if(mysqli_query($stock, "UPDATE existencias SET cantidad = '".$_POST['cantidad']."' WHERE id_articulo = '".$_POST['articulo']."' LIMIT 1")
    && mysqli_query($stock, "INSERT INTO comprobantes VALUES(NULL, '4', 'AJUSTE', '-', '-', '-', '".date("d-m-Y H:i:s")."', '".$_SESSION['id']."')")){
        echo "1";
    }else{
        echo "0";
    }

    mysqli_close($stock);
}
?>