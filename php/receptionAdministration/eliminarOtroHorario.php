<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    mysqli_query($veja, "DELETE FROM otros_horarios WHERE id_medico = '".$_POST['id']."' LIMIT 1");
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>