<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    if(mysqli_query($stock, "DELETE FROM proveedores WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
        mysqli_close($stock);
    }else{
        echo "0";
    }
}
?>