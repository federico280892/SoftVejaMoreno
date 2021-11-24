<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $contador = 0;
    $peticion = mysqli_query($veja, "SELECT * FROM otros_horarios WHERE id_medico = '".$_POST['id']."'");
    if(mysqli_num_rows($peticion) == 0){
        echo '<tr>
            <td colspan="11" class="font-weight-bold text-center">No se enconrtaron reglas</td>
        </tr>';
    }else{
        while($o = mysqli_fetch_assoc($peticion)){
            echo '<tr>';
                if($contador == 0){
                    echo '<td rowspan="2" class="text-center align-middle">'.date("d-m-y", strtotime($o['desde'])).' - '.date("d-m-y", strtotime($o['hasta'])).'</td>';
                }
                echo' <td class="text-center">'.date("H:i", strtotime($o['apLun'])).' - '.date("H:i", strtotime($o['ciLun'])).'</td>
                <td class="text-center">'.date("H:i", strtotime($o['apMar'])).' - '.date("H:i", strtotime($o['ciMar'])).'</td>
                <td class="text-center">'.date("H:i", strtotime($o['apMie'])).' - '.date("H:i", strtotime($o['ciMie'])).'</td>
                <td class="text-center">'.date("H:i", strtotime($o['apJue'])).' - '.date("H:i", strtotime($o['ciJue'])).'</td>
                <td class="text-center">'.date("H:i", strtotime($o['apVie'])).' - '.date("H:i", strtotime($o['ciVie'])).'</td>
                <td class="text-center">'.date("H:i", strtotime($o['apSab'])).' - '.date("H:i", strtotime($o['ciSab'])).'</td>
                <td class="text-center">'.date("H:i", strtotime($o['apDom'])).' - '.date("H:i", strtotime($o['ciDom'])).'</td>';
                if($contador == 0){
                    echo '<td class="text-center align-middle" rowspan="2">
                        <i role="button" class="fas fa-edit text-primary ml-3" id="modificarOtroHorario" data-id="'.$o['id'].'"></i>
                        <i role="button" class="fas fa-trash text-danger ml-3" id="eliminarOtroHorario" data-id="'.$o['id_medico'].'"></i>
                    </td>';
                }
            echo '</tr>';
            $contador++;
        }
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>