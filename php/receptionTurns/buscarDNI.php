<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id, apellido, nombre FROM pacientes WHERE dni = '".$_POST['dni']."' LIMIT 1");
    if(mysqli_num_rows($peticion) > 0){
        while($res = mysqli_fetch_assoc($peticion)){
            echo $res['apellido']." ".$res['nombre']."|".$res['id'];
        }
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>