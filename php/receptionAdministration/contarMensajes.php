<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id FROM mensajes WHERE destino = '".$_SESSION['id']."' AND estado = '1'");

    echo mysqli_num_rows($peticion);

    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>