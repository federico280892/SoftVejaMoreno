<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    if(mysqli_query($veja, "INSERT INTO mensajes VALUES(NULL,
        '".date("Y-m-d H:i:s")."',
        '".$_POST['asunto']."',
        '".$_POST['mensaje']."',
        '".$_SESSION['id']."',
        '".$_POST['destino']."',
        '".$_POST['prioridad']."',
        '1'
        )")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>