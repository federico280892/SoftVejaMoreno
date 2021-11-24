<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    
    if(mysqli_query($stock, "UPDATE articulos SET
    id_grupo = '".$_POST['grupo']."',
    id_rubro = '".$_POST['rubro']."',
    codigo_barra = '".$_POST['cod_barras']."',
    nombre = '".strtoupper($_POST['nombre'])."',
    img = '".$_POST['img']."', 
    stockMin = '".$_POST['stockMin']."', 
    observaciones = '".strtoupper($_POST['observacion'])."', 
    activo = '".$_POST['activo']."'
    WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }

    mysqli_close($stock);
}
?>