<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE pacientes
        SET DNI = '".$_POST['dni']."',
        apellido = '".strtoupper($_POST['apellido'])."',
        nombre = '".strtoupper($_POST['nombre'])."',
        fecha_nacimiento = '".$_POST['fechaNacimiento']."',
        domicilio = '".strtoupper($_POST['domicilio'])."',
        provincia = '".$_POST['provincia']."',
        localidad = '".$_POST['localidad']."',
        sexo = '".strtoupper($_POST['sexo'])."',
        tel1 = '".$_POST['tel1']."',
        tel2 = '".$_POST['tel2']."',
        cel = '".$_POST['cel']."',
        email = '".$_POST['email']."',
        cobertura_social = '".$_POST['coberturaSocial']."',
        n_carnet = '".strtoupper($_POST['nCarnetCobertura'])."',
        coseguro = '".$_POST['coseguro']."',
        n_carnet_coseguro = '".strtoupper($_POST['nCarnetCoseguro'])."',
        observacion = '".strtoupper($_POST['observacion'])."' 
        WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>