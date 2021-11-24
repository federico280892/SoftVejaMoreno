<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "INSERT INTO pacientes VALUES(
        NULL,
        '".$_POST['dni']."',
        '".strtoupper($_POST['apellido'])."',
        '".strtoupper($_POST['nombre'])."',
        '".$_POST['fechaNacimiento']."',
        '".strtoupper($_POST['sexo'])."',
        '".strtoupper($_POST['domicilio'])."',
        '".$_POST['provincia']."',
        '".$_POST['localidad']."',
        '".$_POST['tel1']."',
        '".$_POST['tel2']."',
        '".$_POST['cel']."',
        '".$_POST['email']."',
        '".strtoupper($_POST['coberturaSocial'])."',
        '".$_POST['coseg']."',
        '".$_POST['nCarnet']."',
        '".$_POST['nCoseguro']."',
        '".strtoupper($_POST['observacion'])."'
        )")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>