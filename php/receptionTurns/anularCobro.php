<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE turnos SET pago = '0', n_cobro = 'Anulado', ingreso = '-' WHERE id = '".$_POST['idTurno']."'")
    &&
    mysqli_query($veja, "DELETE FROM pagos WHERE id = '".$_POST['idPago']."'")
    &&
    mysqli_query($veja, "DELETE FROM pagos_metodos_de_pago WHERE id_pago = '".$_POST['idPago']."'")
    &&
    mysqli_query($veja, "DELETE FROM pagos_prestaciones WHERE id_pago = '".$_POST['idPago']."'")){
        echo "1";
    }else{
        echo "0";
    }
    
    mysqli_close($veja);
}
?>