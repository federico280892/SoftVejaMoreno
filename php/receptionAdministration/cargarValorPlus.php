<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT coberturas_sociales.id AS 'id', coberturas_sociales.plus AS 'plus', coberturas_sociales.descripcion AS 'descripcion' FROM coberturas_sociales INNER JOIN medicos_coberturas_sociales ON medicos_coberturas_sociales.id_cobertura_social = coberturas_sociales.id INNER JOIN medicos ON medicos.id = medicos_coberturas_sociales.id_medico WHERE medicos_coberturas_sociales.id = '".$_POST['id']."' LIMIT 1");
    while($c = mysqli_fetch_assoc($peticion)){
        echo $c['plus'].'|'.$c['descripcion'].'|'.$c['id'];
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>