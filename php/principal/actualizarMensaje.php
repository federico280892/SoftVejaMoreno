<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE mensajes SET 
        destino = '".$_POST['destino']."',
        fecha = '".date("Y-m-d H:i:s")."',
        asunto = '".$_POST['asunto']."',
        mensaje = '".$_POST['mensaje']."',
        urgencia = '".$_POST['prioridad']."',
        estado = '".$_POST['estado']."'
         WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>