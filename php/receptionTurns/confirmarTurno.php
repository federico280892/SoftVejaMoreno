<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT confirmado FROM turnos WHERE id = '".$_POST['id']."' LIMIT 1");
    if(mysqli_num_rows($peticion) > 0){
        while($t = mysqli_fetch_assoc($peticion)){
            if($t['confirmado'] == "0"){
                mysqli_query($veja, "UPDATE turnos SET confirmado = '1', f_registro = '".date("Y-m-d H:i:s")."' WHERE id = '".$_POST['id']."' LIMIT 1");
                echo "1";
            }else if($t['confirmado'] == "1"){
                mysqli_query($veja, "UPDATE turnos SET confirmado = '0', f_registro = '".date("Y-m-d H:i:s")."' WHERE id = '".$_POST['id']."' LIMIT 1");
                echo "2";
            }
        }
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>