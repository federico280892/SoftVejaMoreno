<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
require_once("../conn.php");
mysqli_query($veja, "INSERT INTO medicos VALUES(
    NULL, 
    '".$_POST['codigo']."',
    '".$_POST['usuario']."',
    '".$_POST['dni']."',
    '".strtoupper($_POST['apellido'])."',
    '".strtoupper($_POST['nombre'])."',
    '".$_POST['domicilio']."',
    '".$_POST['telefono']."',
    '".$_POST['celular']."',
    '".$_POST['telefono_consultorio']."',
    '".$_POST['especialidad']."',
    '".$_POST['matricula']."',
    '".$_POST['anestesista']."',
    '".strtoupper($_POST['observaciones'])."',
    '".$_POST['activo']."'
    )");

    $peticion = mysqli_query($veja, "SELECT id FROM medicos WHERE dni = '".$_POST['dni']."' AND codigo = '".$_POST['codigo']."' AND usuario = '".$_POST['usuario']."' ORDER BY id DESC LIMIT 1");
    while($m = mysqli_fetch_assoc($peticion)){
        mysqli_query($veja, "INSERT INTO tiempo_consulta VALUES(NULL, '".$m['id']."', '20', '20', '20', '20', '20', '20', '-')");
        mysqli_query($veja, "INSERT INTO consultorios VALUES(NULL, '".$m['id']."', '1', '1', '1', '1', '1', '1', '0')");
        mysqli_query($veja, "INSERT INTO otros_tiempos VALUES(NULL, '".$m['id']."', '15', '15', '15', '15', '15', '15', '-')");
        mysqli_query($veja, "INSERT INTO otros_consultorios VALUES(NULL, '".$m['id']."', '1', '1', '1', '1', '1', '1', '0')");
        for($i=0; $i < 2; $i++){
            mysqli_query($veja, "INSERT INTO horarios_semanales VALUES(NULL, '".$m['id']."', '".$i."', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00')");
        }
        for($i = 1; $i<=2; $i++){
            mysqli_query($veja, "INSERT INTO otros_horarios  VALUES (NULL, '".$m['id']."', '".$i."', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '".date("Y-m-d")."', '".date("Y-m-d")."')");
        }
    }
mysqli_close($veja);
}
?>