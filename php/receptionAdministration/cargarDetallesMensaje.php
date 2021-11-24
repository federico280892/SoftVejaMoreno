<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT mensajes.*, users.nombre AS 'para' FROM mensajes INNER JOIN users ON users.id = mensajes.destino WHERE mensajes.id = '".$_POST['id']."' AND mensajes.estado = '1' LIMIT 1");

        while($m = mysqli_fetch_assoc($peticion)){
            $peticion2 = mysqli_query($veja, "SELECT nombre FROM users WHERE id = '".$m['origen']."' LIMIT 1");
            while($d = mysqli_fetch_assoc($peticion2)){
                echo date("d-m-Y H:i:s", strtotime($m['fecha']))."|".$d['nombre']."|".$m['para']."|".$m['asunto']."|".$m['mensaje'];
            }
        }
    mysqli_query($veja, "UPDATE mensajes SET estado = '0' WHERE id = '".$_POST['id']."'");
  
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>