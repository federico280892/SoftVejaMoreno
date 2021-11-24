<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT atendido, start, title FROM turnos WHERE dni_solicitante = '".$_POST['dni']."' ORDER BY start DESC");
    if(mysqli_num_rows($peticion) == 0){
        echo '<tr>
            <td colspan="4">El paciente no posee registros</td>
        </tr>';
    }else{
        while($p = mysqli_fetch_assoc($peticion)){
            if($p['atendido'] == "1"){
                $atendido = 'Atendido';
            }else if($p['atendido']  == "0"){
                $atendido = 'En espera';
            }else if($p['atendido']  == "2"){
                $atendido = 'Ausente';
            }else{
                $atendido = '-';
            }
            echo '<tr>
                <td style="font-size: 12px;">'.date("d-m-Y", strtotime($p['start'])).'</td>
                <td style="font-size: 12px;">'.date("H:i", strtotime($p['start'])).'</td>
                <td style="font-size: 12px;">'.substr($p['title'],0 ,20).'</td>
                <td style="font-size: 12px;">'.$atendido.'</td>
            </tr>';
        }
    }
    mysqli_close($veja);
}
?>