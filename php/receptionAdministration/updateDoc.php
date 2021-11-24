<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE medicos SET 
    codigo = '".$_POST['codigo']."',
    usuario = '".$_POST['usuario']."',
    dni = '".$_POST['dni']."',
    apellido = '".strtoupper($_POST['apellido'])."',
    nombre = '".strtoupper($_POST['nombre'])."',
    domicilio = '".strtoupper($_POST['domicilio'])."',
    telefono_particular = '".$_POST['tel_particular']."',
    celular = '".$_POST['celular']."',
    telefono_consultorio = '".$_POST['tel_consultorio']."',
    especialidad = '".$_POST['especialidad']."',
    matricula = '".$_POST['matricula']."',
    anestesista = '".$_POST['anestesista']."',
    observaciones = '".strtoupper($_POST['obs'])."',
    activo = '".$_POST['activo']."'
    WHERE id = '".$_POST['id']."'
    LIMIT 1
    ")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}else{
    header("Location: ../../");
}
?>