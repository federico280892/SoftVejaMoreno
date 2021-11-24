<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    if(mysqli_query($stock, "INSERT INTO rubros VALUES(NULL, 
    '".strtoupper($_POST['nombre'])."',
    '".$_POST['dioptria']."',
    '".strtoupper($_POST['observacion'])."',
    '".$_POST['estado']."')")){
        echo "1";
        mysqli_close($stock);
    }else{
        echo "0";
    }
}
?>