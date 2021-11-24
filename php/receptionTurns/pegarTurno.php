<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    switch(date('D', strtotime($_POST['fecha']))){
        case 'Mon':
            $columnaMinutos = "lun";
            break;
        case 'Tue':
            $columnaMinutos = "mar";
            break;
        case 'Wed':
            $columnaMinutos = "mie";
            break;
        case 'Thu':
            $columnaMinutos = "jue";
            break;
        case 'Fri':
            $columnaMinutos = "vie";
            break;
        case 'Sat':
            $columnaMinutos = "sab";
            break;
        case 'Sun':
            $columnaMinutos = "dom";
            break;
    }

    $diaSemana = mysqli_query($veja, "SELECT $columnaMinutos FROM tiempo_consulta WHERE id_medico = '".$_POST['medico']."' LIMIT 1");
    while($min = mysqli_fetch_assoc($diaSemana)){
        $tiempo_consulta = $min[$columnaMinutos];
    }

    $tiempo = "00:".($tiempo_consulta - 1).":00";

    if(mysqli_query($veja, "UPDATE turnos SET start = '".date("Y-m-d H:i:s", strtotime($_POST['fecha']." ".$_POST['hora']))."', end = ADDTIME('".date("Y-m-d H:i:s", strtotime($_POST['fecha']." ".$_POST['hora']))."', '".$tiempo."'), f_registro = '".date("d-m-Y H:i:s")."' WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }

    mysqli_close($veja);
}
?>