<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT * FROM formas_pago WHERE id = '".$_POST['id']."'");
    while($f = mysqli_fetch_assoc($peticion)){
        echo $f['pago']."|".$f['descripcion'];
    }
    mysqli_close($veja);
}
?>