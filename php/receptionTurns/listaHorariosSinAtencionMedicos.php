<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT start, fecha_start, end, fecha_end, title, id_medico, id, TIMESTAMPDIFF(DAY, start, end) AS dias FROM dias_sin_atencion_medicos WHERE id_medico = '".$_POST['id']."' ORDER BY start DESC");
    
    if(mysqli_num_rows($peticion) > 0){

        while($d = mysqli_fetch_assoc($peticion)){
            echo "<tr>
            <td>Receso: ".date('d-m-y', strtotime($d['start']))." ".date("H:i", strtotime($d['fecha_start']))." Regreso: ".date('d-m-y', strtotime($d['end']))." ".date("H:i", strtotime($d['fecha_end']))." <small>(".$d['dias']." días)</small></td>
            <td>".$d['title']."</td>
            <td class='text-center'>
                <button id='botonEliminarFechaSinAtencion' role='button' onclick='eliminarFechaSinAtencion(".$d['id'].")' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></button>
            </td>
            </tr>";
        }

    }else{
        echo "<tr><td colspan='3' class='text-center font-weight-bold'>No se registran eventos</td></tr>";
    }

}
?>