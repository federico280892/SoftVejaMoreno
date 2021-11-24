<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    mysqli_query($veja, "DELETE FROM turnos WHERE id = '".$_POST['id']."' LIMIT 1");
    mysqli_close($veja);
}
?>