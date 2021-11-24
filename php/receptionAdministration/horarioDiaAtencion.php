<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id FROM horarios_semanales WHERE id_medico = '".$_POST['idMedico']."'");
    if(mysqli_num_rows($peticion) == 0){
        for($i = 1; $i < 3; $i++){
            mysqli_query($veja, "INSERT INTO horarios_semanales VALUES(
                NULL, 
                '".$_POST['idMedico']."', 
                '".$i."', 
                '00:00', '00:00',
                '00:00', '00:00',
                '00:00', '00:00',
                '00:00', '00:00',
                '00:00', '00:00',
                '00:00', '00:00',
                '00:00', '00:00')");
        }
    }
    if($_POST['tiempo'] == ""){
        $tiempo = "00:00";
    }else{
        $tiempo = $_POST['tiempo'];
    }
    mysqli_query($veja, "UPDATE horarios_semanales SET ".$_POST['dia']." = '".$tiempo."' WHERE id_medico = '".$_POST['idMedico']."' AND turno = '".$_POST['turno']."' LIMIT 1");
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>