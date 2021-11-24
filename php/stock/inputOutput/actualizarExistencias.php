<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $total = 0;
    $consulta = mysqli_query($stock, "SELECT insumos.descripcion AS 'insumo' FROM insumos INNER JOIN items ON items.id = insumos.id_item WHERE insumos.id = '".$_POST['id']."' LIMIT 1");
    while($i = mysqli_fetch_assoc($consulta)){
        $insumo = $i['insumo'];
    }

    $peticion = mysqli_query($stock, "SELECT cantidad FROM existencias WHERE id_insumo = '".$_POST['id']."' LIMIT 1");
    while($c = mysqli_fetch_assoc($peticion)){
        if($_POST['accion'] == "0"){
            $total = ($c['cantidad'] + $_POST['cantidad']);
        }else if($_POST['accion'] == "1"){
            $total = ($c['cantidad'] - $_POST['cantidad']);
        }
    }

    if(mysqli_query($stock, "UPDATE existencias SET cantidad = '".$total."' WHERE id_insumo = '".$_POST['id']."' LIMIT 1") 
    && 
    mysqli_query($stock, "INSERT INTO historial_altas_bajas VALUES(NULL, '".date("d-m-Y H:i:s")."', '".$_SESSION['nombre']."', '".$_POST['accion']."', '".$_POST['cantidad']."', '".$insumo."')")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}

?>