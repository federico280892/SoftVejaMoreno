<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id, dni, apellido, nombre FROM pacientes WHERE apellido LIKE '%%".$_POST['ApyNom']."%%' OR nombre LIKE '%%".$_POST['ApyNom']."%%' OR '".$_POST['ApyNom']."' LIKE CONCAT(apellido, ' ' ,nombre) LIMIT 5");
    echo '<ul class="list-group">';
    while($res = mysqli_fetch_assoc($peticion)){
        echo '<li class="list-group-item" role="button" onclick="ingresarPacienteSeleccionado(\''.$res['id'].'\', \''.$res['dni'].'\', \''.$res['apellido'].'\', \''.$res['nombre'].'\')">'.substr($res['apellido'].' '.$res['nombre'], 0, 24).'</li>';
    }
    echo '</ul>';
    mysqli_close($veja);
}
?>