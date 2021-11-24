<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    echo "Fecha: ".date("Y-m-d", strtotime($_POST['inicio']));
    echo "Hora: ".date("H:i", strtotime($_POST['inicio']));
    if($_POST['modo'] == "0"){

        mysqli_query($veja, "INSERT INTO dias_sin_atencion_medicos VALUES(
            NULL, 
            '".date("Y-m-d", strtotime($_POST['inicio']))."',
            '".date("H:i:s", strtotime($_POST['inicio']))."', 
            date_add('".date("Y-m-d", strtotime($_POST['inicio']))."', interval 1 day),
            '".date("H:i:s", strtotime($_POST['inicio']))."',
            'false',
            'background',
            '#ff9f89', 
            '".$_POST['observacion']."', 
            '".$_POST['idMedico']."')");
            
    }else if($_POST['modo'] == "1"){

            mysqli_query($veja, "INSERT INTO dias_sin_atencion_medicos VALUES(
                NULL, 
                '".date("Y-m-d", strtotime($_POST['inicio']))."',
                '".date("H:i:s", strtotime($_POST['inicio']))."',
                date_add('".date("Y-m-d", strtotime($_POST['fin']))."', interval 1 day), 
                '".date("H:i:s", strtotime($_POST['inicio']))."', 
                'false',
                'background',
                '#ff9f89', 
                '".$_POST['observacion']."', 
                '".$_POST['idMedico']."')");

    }else if($_POST['modo'] == "2"){

        mysqli_query($veja, "INSERT INTO dias_sin_atencion_medicos VALUES(
            NULL, 
            '".date("Y-m-d", strtotime($_POST['inicio']))."',
            '".date("H:i:s", strtotime($_POST['desde']))."', 
            date_add('".date("Y-m-d", strtotime($_POST['inicio']))."', interval 1 day),
            '".date("H:i:s", strtotime($_POST['hasta']))."',
            'false',
            'background',
            '#ff9f89', 
            '".$_POST['observacion']."', 
            '".$_POST['idMedico']."')");

    }
    mysqli_close($veja);
}
?>