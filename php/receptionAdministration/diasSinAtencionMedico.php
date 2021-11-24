<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT * FROM dias_sin_atencion_medicos WHERE id_medico = '".$_POST['id']."' LIMIT 1");
    if(mysqli_num_rows($peticion) == "0"){
        echo "0";
    }else{
        echo '<ul class="list-group-flush" style="font-size: 12px;">';
        //echo '<i role="button" class="fas fa-edit text-info" data-id="'.$_POST['id'].'" id="verDiasSinAtencionMedicos"></i><ul class="list-group-flush">';
            while($d = mysqli_fetch_assoc($peticion)){
                echo '<li class="list-group-item">
                    <p><b class="text-danger">Inicio permiso: </b>'.date("d-m-Y H:i:s", strtotime($d['start']. " ".$d['fecha_start'])).'</p>
                    <p><b class="text-danger">Fin permiso: </b>'.date("d-m-Y H:i:s", strtotime($d['end']. " ".$d['fecha_end'])).'</p>
                    <h6><b class="text-danger">Motivo: </b>'.$d['title'].'</h6>
                </li>';
            }
        echo '</ul>';
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>