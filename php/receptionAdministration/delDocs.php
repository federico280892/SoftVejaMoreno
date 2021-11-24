<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id FROM turnos WHERE id_medico = '".$_POST['idM']."'");
    if(mysqli_num_rows($peticion) > 0){
        echo "0";
    }else{
        $carpeta = "../../img/users/";
        mysqli_query($veja, "DELETE FROM medicos WHERE id = '".$_POST['idM']."' LIMIT 1");
        mysqli_query($veja, "DELETE FROM tiempo_consulta WHERE id_medico = '".$_POST['idM']."' LIMIT 1");
        mysqli_query($veja, "DELETE FROM dias_sin_atencion_medicos WHERE id_medico = '".$_POST['idM']."' LIMIT 1");
        mysqli_query($veja, "DELETE FROM horarios_semanales WHERE id_medico = '".$_POST['idM']."' LIMIT 1");
        mysqli_query($veja, "DELETE FROM otros_horarios WHERE id_medico = '".$_POST['idM']."' LIMIT 1");
        mysqli_query($veja, "DELETE FROM consultorios WHERE id_medico = '".$_POST['idM']."' LIMIT 1");
        $foto = mysqli_query($veja, "SELECT avatar FROM users WHERE id = (SELECT id FROM users WHERE id = (SELECT usuario FROM medicos WHERE id = '".$_POST['idM']."')) LIMIT 1");
        while($f = mysqli_fetch_assoc($foto)){
            if($f['avatar'] != "default_user.jpg"){
                unlink($carpeta.$f['avatar']);
            }
        }
        mysqli_query($veja, "DELETE FROM users WHERE id = (SELECT id FROM users WHERE id = (SELECT usuario FROM medicos WHERE id = '".$_POST['idM']."')) LIMIT 1");
        echo "1";
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>