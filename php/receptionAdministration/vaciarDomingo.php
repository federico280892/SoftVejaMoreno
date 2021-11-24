<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE horarios_semanales SET 
    apDom = '00:00:00',
    ciDom = '00:00:00'
    WHERE id_medico = '".$_POST['id']."'
    LIMIT 2") &&
    mysqli_query($veja, "UPDATE consultorios SET 
    dom = '-'
    WHERE id_medico = '".$_POST['id']."'
    LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}else{
    header("Location: ../../");
}
?>