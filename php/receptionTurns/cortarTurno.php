<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id FROM turnos WHERE id_medico = '".$_POST['idMedico']."' AND start = '".$_POST['fecha']."'");
    if(mysqli_num_rows($peticion) > 0){
        echo "0";
    }else if(mysqli_query($veja, "UPDATE turnos SET start = '".$_POST['fecha']."' WHERE id_medico ='".$_POST['idMedico']."' AND id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>