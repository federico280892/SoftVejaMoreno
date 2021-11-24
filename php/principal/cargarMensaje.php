<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT * FROM mensajes WHERE id = '".$_POST['id']."' LIMIT 1");
    while($m = mysqli_fetch_assoc($peticion)){
        echo $m['destino']."|".$m['asunto']."|".$m['mensaje']."|".$m['urgencia'];
    }
    mysqli_close($veja);
}
?>