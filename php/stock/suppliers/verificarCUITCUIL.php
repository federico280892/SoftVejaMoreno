<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    if(mysqli_num_rows(mysqli_query($stock, "SELECT id FROM proveedores WHERE CUIT_CUIL = '".$_POST['cuit']."'")) > 0){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}
?>