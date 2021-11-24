<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT medicos.*, users.avatar AS 'avatar', users.id AS 'idUser' FROM medicos INNER JOIN users ON users.id = medicos.usuario WHERE medicos.id = '".$_POST['id']."'");
    while($m = mysqli_fetch_assoc($peticion)){
        echo $m['activo']."|".$m['codigo']."|".$m['matricula']."|".strtoupper($m['apellido'])."|".strtoupper($m['nombre'])."|".$m['dni']."|".strtoupper($m['domicilio'])."|".$m['telefono_particular']."|".$m['telefono_consultorio']."|".$m['celular']."|".$m['usuario']."|".$m['especialidad']."|".$m['anestesista']."|".strtoupper($m['observaciones'])."|".$m['avatar']."|".$m['idUser'];
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>