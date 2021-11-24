<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    $unidadesRecibidas = $_POST['cantidades'];
    $articulosRecibidos = $_POST['articulos'];

    $suma = 0;

    for($i = 0; $i < count($unidadesRecibidas); $i++){
        $peticion = mysqli_query($stock, "SELECT cantidad FROM existencias WHERE id_articulo = '".$articulosRecibidos[$i]."' LIMIT 1");
        while($c = mysqli_fetch_assoc($peticion)){
            $cantidadActual = $c['cantidad'];
        }
        
        $nuevaCantidad = (floatval($cantidadActual) - floatval($unidadesRecibidas[$i]));

        if(mysqli_query($stock, "UPDATE existencias SET cantidad = '".$nuevaCantidad."' WHERE id_articulo = '".$articulosRecibidos[$i]."' LIMIT 1")){
            $flag = true;
        }else{
            $flag = false;
        }
        
        $monto = mysqli_query($stock, "SELECT precio_costo FROM articulos WHERE id = '".$articulosRecibidos[$i]."'");
        while($m = mysqli_fetch_assoc($monto)){
            $suma += (floatval($m['precio_costo']) * floatval($unidadesRecibidas[$i]));
        }
    }

    switch($_POST['motivo']){
        case "0":
            $motivo = "Rotura";
            break;
        case "1":
            $motivo = "Vencimiento";
            break;
        case "2":
            $motivo = "Uso";
            break;
        case "3":
            $motivo = "Por ajuste";
            break;
    }

    if(mysqli_query($stock, "INSERT INTO comprobantes VALUES(NULL, '3', '".strtoupper($motivo)."', '".$suma."', '-', '".$_POST['fecha']."', '".date("d-m-Y H:i:s")."', '".$_SESSION['id']."')")){
        $comprobanteEgreso = mysqli_query($stock, "SELECT id FROM comprobantes WHERE tipo_comprobante = '3' AND importe = '".$suma."' AND n_comprobante = '".$motivo."' ORDER BY id DESC LIMIT 1");
        while($idC = mysqli_fetch_assoc($comprobanteEgreso)){
            $idComprobanteEgreso = $idC['id'];
        }

        for($c = 0; $c < count($unidadesRecibidas); $c++){
            if($unidadesRecibidas[$c] != ""){
                mysqli_query($stock, "INSERT INTO cantidades_cargadas VALUES(NULL, '".$idComprobanteEgreso."', '".$articulosRecibidos[$c]."', '".$unidadesRecibidas[$c]."', '".$_POST['fecha']."', '".date("d-m-Y H:i:s")."')");
            }
        }

        $flag = true;
    }else{
        $flag = false;
    }

    if($flag){
        echo "1";
    }else{
        echo "0";
    }

    mysqli_close($stock);
}
?>