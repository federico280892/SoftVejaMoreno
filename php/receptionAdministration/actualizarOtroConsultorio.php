<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");

    if(mysqli_query($veja, "UPDATE otros_consultorios SET 
    ".$_POST['dia']." = '".$_POST['consultorio']."'
    WHERE id_medico = '".$_POST['idMedico']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }

    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>