<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    switch(date('D', strtotime($_POST['inicio']))){
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

    $diaSemana = mysqli_query($veja, "SELECT $columnaMinutos FROM tiempo_consulta WHERE id_medico = '".$_POST['idMedico']."' LIMIT 1");
    while($min = mysqli_fetch_assoc($diaSemana)){
        $tiempo_consulta = $min[$columnaMinutos];
    }

    $contador = 0;
    $tiempo = "00:".($tiempo_consulta - 1).":00";
    if($_POST['sobreturno'] == "0"){
        $peticion = mysqli_query($veja, "SELECT start, end FROM turnos");
        while($row = mysqli_fetch_assoc($peticion)){
            $peticion2 = mysqli_query($veja, "SELECT id FROM turnos WHERE '".date("Y-m-d H:i:s", strtotime($_POST['inicio']))."' BETWEEN '".date("Y-m-d H:i:s", strtotime($row['start']))."' AND '".date("Y-m-d H:i:s", strtotime($row['end']))."' AND id_medico = '".$_POST['idMedico']."'");
            if(mysqli_num_rows($peticion2) > 0){
                $contador++;
            }
        }
    }

    $primeraVez = mysqli_query($veja, "SELECT id FROM turnos WHERE primera_vez = '1' AND dni_solicitante = '".$_POST['dniSolicitante']."'");
    if(mysqli_num_rows($primeraVez) > 0){
        $pV = "0";
        //mysqli_query($veja, "UPDATE pacientes SET primera_vez = '1', fecha_primera_vez = '".date("Y-m-d H:i:s")."' WHERE DNI = '".$_POST['dniSolicitante']."'");
    }else{
        $pV = "1";
        //mysqli_query($veja, "UPDATE pacientes SET primera_vez = '0' WHERE DNI = '".$_POST['dniSolicitante']."'");
    }

    if($contador == 0){
        $hora = $_POST['inicio'];
        $t = new DateTime($hora);
        $tiempoConsul = "+".$tiempo_consulta." minute";
        for($i = 1; $i <= $_POST['cantidad']; $i++){
            $nuevaHora = $t->format("Y-m-d H:i:s");
            mysqli_query($veja, "INSERT INTO turnos VALUES(
                NULL, 
                '".$_POST['tipoTurno']."', 
                '".strtoupper($_POST['title'])."', 
                '".$_POST['idMedico']."', 
                '".$_POST['mSolicitante']."', 
                '".$_POST['mEfector']."', 
                '".$_POST['dniSolicitante']."', 
                '".$nuevaHora."',
                ADDTIME('".$nuevaHora."', '".$tiempo."'),
                '".$_POST['sobreturno']."',
                '".$_POST['confirmado']."',
                '".$_POST['urgencia']."',
                '".$_POST['lente']."',
                '".$_POST['diop']."',
                '".$_POST['ojoD']."',
                '".$_POST['ojoI']."',
                '".strtoupper($_POST['observacion'])."',
                '-',
                '0',
                '-',
                '-',
                '-',
                '".$_SESSION['id']."',
                '".date("Y-m-d H:i:s")."',
                '".$pV."'
            )");
            $t->modify($tiempoConsul);
        }
    }else{
        echo "0";
    }

    mysqli_close($veja);
}
?>