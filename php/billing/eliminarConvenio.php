<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "DELETE FROM convenios WHERE id_cobertura_social = '".$_POST['id']."'")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>