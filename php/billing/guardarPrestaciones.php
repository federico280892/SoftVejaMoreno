<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "INSERT INTO prestaciones VALUES(NULL, '".strtoupper($_POST['codigo'])."', '".strtoupper($_POST['descripcion'])."', '".$_POST['nivel']."', '".$_POST['complejidad']."', '".$_POST['expediente']."', '".$_POST['unMedico']."', '".$_POST['unGastos']."', '1')")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>