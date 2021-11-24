<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    mysqli_query($veja, "UPDATE tiempo_consulta SET ".$_POST['dia']." = '".$_POST['tiempo']."' WHERE id_medico = '".$_POST['idMedico']."' LIMIT 1");
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>