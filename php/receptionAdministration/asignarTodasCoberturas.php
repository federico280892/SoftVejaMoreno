<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id FROM coberturas_sociales");
    while($c = mysqli_fetch_assoc($peticion)){
        $peticion2 = mysqli_query($veja, "SELECT id FROM medicos_coberturas_sociales WHERE id_medico = '".$_POST['id']."' AND id_cobertura_social = '".$c['id']."'");
        if(mysqli_num_rows($peticion2) == 0){
            mysqli_query($veja, "INSERT INTO medicos_coberturas_sociales VALUES(NULL, '".$_POST['id']."', '".$c['id']."')");
        }
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>