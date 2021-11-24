<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $contador = 0;
    $peticion = mysqli_query($veja, "SELECT id FROM dias_no_laborales WHERE start = '".$_POST['fecha']."'");
    $peticion2 = mysqli_query($veja, "SELECT id_medico, start, end FROM dias_sin_atencion_medicos");
    
    if($_POST['fecha'] < date('Y-m-d')){
        $contador++;
    }
    
    if(mysqli_num_rows($peticion) > 0){
        $contador++;
    }
    
    while($d2 = mysqli_fetch_assoc($peticion2)){

        $peticion3 = mysqli_query($veja, "SELECT id_medico FROM dias_sin_atencion_medicos WHERE '".$_POST['fecha']."' BETWEEN '".$d2['start']."' AND date_add('".date("Y-m-d", strtotime($d2['end']))."', interval -1 day)");
        
        if(mysqli_num_rows($peticion3) > 0 && $d2['id_medico'] == $_POST['medico']){
            $contador++;
        }

    }

    if($contador > 0){
        echo "1";
    }else{
        echo "0";
    }

}

?>