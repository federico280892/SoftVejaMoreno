<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE coberturas_sociales SET plus = '".$_POST['plus']."', descripcion = '".$_POST['descripcion']."' WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>