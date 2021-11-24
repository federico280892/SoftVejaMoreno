<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $ids = $_POST['id'];
    for($i = 0; $i < count($ids); $i++){
        mysqli_query($veja, "DELETE FROM medicos_coberturas_sociales WHERE id = '".$ids[$i]."' LIMIT 1");
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>