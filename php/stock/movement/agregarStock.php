<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    // if(isset($_SESSION['columnas_lentes'])){

    //     for($i = 0; $i < count($_SESSION['listaArticulos']); $i++){

    //         $peticion = mysqli_query($stock, "SELECT ".$_SESSION['columnas_lentes'][$i]." FROM lentes WHERE id_articulo = '".$_SESSION['listaArticulos'][$i][0]."' LIMIT 1");

    //         while($c = mysqli_fetch_assoc($peticion)){
    //             if($c[$_SESSION['columnas_lentes'][$i]] != "0"){
    //                 $cantidad = (floatval($c[$_SESSION['columnas_lentes'][$i]]) + floatval($_SESSION['cantidad_lentes'][$i]));

    //                 mysqli_query($stock, "UPDATE lentes SET ".$_SESSION['columnas_lentes'][$i]." = ".$cantidad." WHERE id_articulo = '".$_SESSION['listaArticulos'][$i][0]."' LIMIT 1");

    //             }else{

    //                 mysqli_query($stock, "UPDATE lentes SET ".$_SESSION['columnas_lentes'][$i]." = ".$_SESSION['cantidad_lentes'][$i]." WHERE id_articulo = ".$_SESSION['listaArticulos'][$i][0]." LIMIT 1");
                
    //             }
    //         }
    //     }
    // }

    mysqli_query($stock, "INSERT INTO comprobantes VALUES(NULL, 
    '".$_POST['comprobante']."', 
    '".$_POST['nComprobante']."', 
    '".$_SESSION['totalComprobante']."',
    '".$_POST['proveedor']."', 
    '".$_POST['fechaComprobante']."', 
    '".date("d-m-Y H:i:s")."',
    '".$_SESSION['id']."')");

    $peticion = mysqli_query($stock, "SELECT id, fecha_comprobante FROM comprobantes WHERE n_comprobante = '".$_POST['nComprobante']."' ORDER BY fecha_carga DESC LIMIT 1");
    while($c = mysqli_fetch_assoc($peticion)){
        $idComprobante = $c['id'];
    }

    for($i = 0; $i < count($_SESSION['listaArticulos']); $i++){

        //$peticion = mysqli_query($stock, "SELECT * FROM articulos WHERE id = '".$_SESSION['']."' AND dioptrias = '".$_SESSION['']."'");

        mysqli_query($stock, "INSERT INTO cantidades_cargadas VALUES(NULL, 
        '".$idComprobante."',
        '".$_SESSION['listaArticulos'][$i][0]."',
        '".$_SESSION['listaArticulos'][$i][5]."',
        '".$_POST['fechaComprobante']."',
        '".date("d-m-Y H:i:s")."')");

        mysqli_query($stock, "UPDATE articulos SET 
        precio_costo = '".$_SESSION['listaArticulos'][$i][3]."',
        n_lote = '".$_SESSION['listaArticulos'][$i][1]."',
        vencimiento = '".$_SESSION['listaArticulos'][$i][2]."',
        marca = '".strtoupper($_SESSION['listaArticulos'][$i][4])."'
         WHERE id = '".$_SESSION['listaArticulos'][$i][0]."' LIMIT 1");

        mysqli_query($stock, "INSERT INTO stock VALUES(NULL, '".$_SESSION['listaArticulos'][$i][0]."', '".$idComprobante."', '".date("d-m-Y H:i:s")."')");      

        $cantidad = mysqli_query($stock, "SELECT cantidad FROM existencias WHERE id_articulo = '".$_SESSION['listaArticulos'][$i][0]."' LIMIT 1");
        while($c = mysqli_fetch_assoc($cantidad)){
            $cantidadActual = $c['cantidad'];
        }
        $nuevaCantidad = ($cantidadActual + $_SESSION['listaArticulos'][$i][5]);
        mysqli_query($stock, "UPDATE existencias SET cantidad = '".$nuevaCantidad."' WHERE id_articulo = '".$_SESSION['listaArticulos'][$i][0]."'");

    }

    // // if(isset($_SESSION['dioptrias_lentes'])){
    // //     $peticion = mysqli_query($stock, "SELECT 
    // //     id_grupo, 
    // //     id_rubro, 
    // //     codigo_barra, 
    // //     nombre,
    // //     img,
    // //     stockMin,
    // //     observaciones
    // //     FROM articulos
    // //     WHERE id = '".$_SESSION['lente']."' LIMIT 1");

    // //     while($datos = mysqli_fetch_assoc($peticion)){
    // //         $grupo = $datos['id_grupo'];
    // //         $rubro = $datos['id_rubro'];
    // //         $codBarra = $datos['codigo_barra'];
    // //         $nombre = $datos['nombre'];
    // //         $img = $datos['img'];
    // //         $stockMin = $datos['stockMin'];
    // //         $observaciones = $datos['observaciones'];
    // //     }

    // //     for($l = 0; $l < count($_SESSION['cantidad_lentes']); $l++){
    // //         mysqli_query($stock, "INSERT INTO articulos VALUES(NULL, 
    // //         '".$grupo."',
    // //         '".$rubro."',
    // //         '".$codBarra."',
    // //         '".$nombre."',
    // //         '".$_SESSION['detalles_lentes'][2]."',
    // //         '".$_SESSION['detalles_lentes'][0]."',
    // //         '".$_SESSION['detalles_lentes'][1]."',
    // //         '".$_SESSION['detalles_lentes'][3]."',
    // //         '".$img."',
    // //         '".$stockMin."',
    // //         '".$_SESSION['dioptrias_lentes'][$l]."',
    // //         '".$observaciones."',
    // //         '1')");
            
    // //         mysqli_query($stock, "INSERT INTO cantidades_cargadas VALUES(NULL, 
    // //         '".$idComprobante."',
    // //         '".$_SESSION['cantidad_lentes'][$l]."',
    // //         '".$_SESSION['lente']."',
    // //         '".$_POST['fechaComprobante']."',
    // //         '".date("d-m-Y H:i:s")."')");




    // //     }


    // // }

    // $_SESSION['listaArticulos'] = array();

    mysqli_close($stock);
}
?>