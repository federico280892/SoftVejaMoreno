<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if($_POST['accion'] == "1"){
        $accion = "CURRENT_TIMESTAMP";
    }else{
        $accion = "'-'";
    }
    if(mysqli_query($veja, "UPDATE turnos SET ingreso = ".$accion.", f_registro = '".date("d-m-Y H:i:s")."' WHERE id = '".$_POST['idTurno']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>