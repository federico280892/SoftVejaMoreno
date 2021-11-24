<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $horarios = "";
    for($i = 0; $i <= 2; $i++){
        $peticion = mysqli_query($veja, "SELECT * FROM otros_horarios WHERE id_medico = '".$_POST['id']."' AND turno = '".$i."'");
        while($h = mysqli_fetch_assoc($peticion)){
            if($i == 1){
                $trailer = "|";
            }else{
                $trailer = "";
            }
            $horarios .= $h['desde']."|".$h['hasta']."|".date("H:i", strtotime($h['apLun']))."|".date("H:i", strtotime($h['ciLun']))."|".date("H:i", strtotime($h['apMar']))."|".date("H:i", strtotime($h['ciMar']))."|".date("H:i", strtotime($h['apMie']))."|".date("H:i", strtotime($h['ciMie']))."|".date("H:i", strtotime($h['apJue']))."|".date("H:i", strtotime($h['ciJue']))."|".date("H:i", strtotime($h['apVie']))."|".date("H:i", strtotime($h['ciVie']))."|".date("H:i", strtotime($h['apSab']))."|".date("H:i", strtotime($h['ciSab']))."|".date("H:i", strtotime($h['apDom']))."|".date("H:i", strtotime($h['ciDom'])).$trailer;
        }
    }
    echo $horarios;
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>