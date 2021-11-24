<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $flag = false;
    $cobertura = $_POST['convenio'][0];
    $fechaConvenio = $_POST['convenio'][1];
    $vencimientoConvenio = $_POST['convenio'][2];
    $prestacion = $_POST['convenio'][3];
    $codigoCobertura = $_POST['convenio'][4];
    $precio = $_POST['convenio'][5];
    $fechaCarga = date("d-m-Y H:i:s");
    if(mysqli_query($veja, "DELETE FROM convenios WHERE id_cobertura_social = '".$cobertura."'")){
        $flag = true;
    }else{
        $flag = false;
    }
    for($i = 0; $i < count($_POST['convenio']); $i++){
        if($codigoCobertura[$i] != ""){
            if(mysqli_query($veja, "INSERT INTO convenios VALUES(NULL, 
            '".$fechaConvenio."', 
            '".$vencimientoConvenio."', 
            '".$cobertura."', 
            '".$prestacion[$i]."', 
            '".$precio[$i]."', 
            '".$codigoCobertura[$i]."', 
            '".$fechaCarga."', 
            '".$_SESSION['id']."')")){
                $flag = true;
            }else{
                $flag = false;
            }
        }
    }
    if($flag){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>