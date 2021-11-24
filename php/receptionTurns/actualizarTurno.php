<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    
    if(mysqli_query($veja, "UPDATE turnos 
        SET title = '".strtoupper($_POST['title'])."', 
        urgencia = '".$_POST['urgencia']."', 
        observacion = '".strtoupper($_POST['observacion'])."',
        responsable = '".$_SESSION['id']."',
        f_registro = '".date("Y-m-d H:i:s")."'
        WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>