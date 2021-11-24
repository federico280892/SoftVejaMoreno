<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    $contador = 0;
    $peticion = mysqli_query($veja, "SELECT start, end FROM turnos");
    while($row = mysqli_fetch_assoc($peticion)){
        $peticion2 = mysqli_query($veja, "SELECT id FROM turnos WHERE '".date("Y-m-d H:i:s", strtotime($_POST['nuevaFecha']))."' BETWEEN '".date("Y-m-d H:i:s", strtotime($row['start']))."' AND '".date("Y-m-d H:i:s", strtotime($row['end']))."'");
        if(mysqli_num_rows($peticion2) > 0){
            $contador++;
        }
    }

    $peticion3 = mysqli_query($veja, "SELECT start, end FROM dias_no_laborales");
    while($d = mysqli_fetch_assoc($peticion3)){
        $peticion4 = mysqli_query($veja, "SELECT id FROM dias_no_laborales WHERE '".date("Y-m-d", strtotime($_POST['nuevaFecha']))."' BETWEEN '".date("Y-m-d", strtotime($d['start']))."' AND '".date("Y-m-d", strtotime($d['end']))."'");
        if(mysqli_num_rows($peticion4) > 0){
            $contador++;
        }


    }

    if($contador == 0){
        mysqli_query($veja, "UPDATE turnos SET start = '".date("Y-m-d H:i:s", strtotime($_POST['nuevaFecha']))."', end = ADDTIME('".date("Y-m-d H:i:s", strtotime($_POST['nuevaFecha']))."', '00:19:00') WHERE id = '".$_POST['id']."'");
        echo "1";
    }else{
        echo "0";
    }
    
    mysqli_close($veja);
}
?>