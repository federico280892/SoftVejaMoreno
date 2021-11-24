<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    
    if(mysqli_query($veja, "INSERT INTO bancos VALUES(NULL, '".strtoupper($_POST['nombre'])."', '".$_POST['estado']."')")){
        echo "1";
    }else{
        echo "0";
    }

    mysqli_close($stock);
}
?>
