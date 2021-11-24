<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT modulada FROM coberturas_sociales WHERE codigo = '".$_POST['codigo']."' LIMIT 1");
    while($p = mysqli_fetch_assoc($peticion)){
        if($p['modulada'] == "1"){
            echo "1";
        }else if($p['modulada'] == "0" || $p['modulada'] == "2"){
            echo "0";
        }
    }
    mysqli_close($veja);
}
?>