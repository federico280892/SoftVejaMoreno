<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    mysqli_query($veja, "INSERT INTO dias_no_laborales VALUES(
        NULL, 
        '".$_POST['dia']."', 
        date_add('".date("Y-m-d", strtotime($_POST['dia']))."', interval 1 day),
        'false', 
        'background', 
        '#ff9f89', 
        '".$_POST['observacion']."')");
    mysqli_close($veja);
}
?>