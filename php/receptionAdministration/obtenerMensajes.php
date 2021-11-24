<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT id, asunto, urgencia FROM mensajes WHERE destino = '".$_SESSION['id']."' AND estado = '1'");

    if(mysqli_num_rows($peticion) > 0){
        echo '<p class=\'font-weight-bold\'>Mensajes</p>
        <ul class=\'list-group list-group-flush\' id=\'listaMensajes\'>';
            while($m = mysqli_fetch_assoc($peticion)){
                switch($m['urgencia']){
                    case "0":
                        $clase = "list-group-item-light";
                        break;
                    case "1":
                        $clase = "list-group-item-warning";
                    break;
                    case "2":
                        $clase = "list-group-item-danger";
                    break;
                }
                echo '<li role=\'button\' id=\'pop'.$m['id'].'\' class=\'list-group-item list-group-item-action '.$clase.' font-weight-bold\'>'.$m['asunto'].'</li>';
            }
        echo '</ul>';
    }else{
        echo '<b>No hay mensajes</b>';
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>