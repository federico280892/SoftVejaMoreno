<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id, start, title FROM dias_no_laborales ORDER BY start DESC");
    while($d = mysqli_fetch_assoc($peticion)){
        echo '<tr>
            <td class="text-center">'.date('d-m-Y', strtotime($d['start'])).'</td>
            <td class="text-center">'.$d['title'].'</td>
            <td class="text-center"><i role="button" class="fas fa-minus-circle text-danger" onclick="eliminarFeriado(\''.$d['id'].'\')"></i></td>
        </tr>';
    }
    mysqli_close($veja);
}
?>