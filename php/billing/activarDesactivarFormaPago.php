<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT activo FROM formas_pago WHERE id = '".$_POST['id']."'");
    while($f = mysqli_fetch_assoc($peticion)){
        $estado = $f['activo'];
    }

    if($estado == "0"){
        $nuevoValor = "1";
    }else{
        $nuevoValor = "0";
    }

    if(mysqli_query($veja, "UPDATE formas_pago SET activo = '".$nuevoValor."' WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>