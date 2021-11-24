<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE prestaciones 
        SET codigo = '".$_POST['codigo']."',
        descripcion = '".$_POST['descripcion']."',
        nivel = '".$_POST['nivel']."',
        complejidad = '".$_POST['complejidad']."',
        expediente_osp = '".$_POST['expediente']."',
        un_medico = '".$_POST['unMedico']."',
        un_gastos = '".$_POST['unGastos']."',
        activo = '".$_POST['estado']."'
            WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>