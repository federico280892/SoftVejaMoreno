<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT * FROM prestaciones WHERE id = '".$_POST['id']."'");
    while($p = mysqli_fetch_assoc($peticion)){
        echo $p['codigo']."|".$p['descripcion']."|".$p['nivel']."|".$p['complejidad']."|".$p['expediente_osp']."|".$p['un_medico']."|".$p['un_gastos']."|".$p['activo'];
    }
    mysqli_close($veja);
}
?>