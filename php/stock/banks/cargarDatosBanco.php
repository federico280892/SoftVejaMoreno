<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    
    $peticion = mysqli_query($veja, "SELECT * FROM bancos WHERE id = '".$_POST['id']."' LIMIT 1");
    while($b = mysqli_fetch_assoc($peticion)){
        echo $b['nombre']."|".$b['activo'];
    }

    mysqli_close($stock);
}
?>