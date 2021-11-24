<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $contador = 0;
    if(mysqli_query($stock, "DELETE FROM articulos WHERE id_grupo = '".$_POST['id']."'")){
        $contador++;
        if(mysqli_query($stock, "DELETE FROM grupos WHERE id = '".$_POST['id']."' LIMIT 1")){
        $contador++;
        }
    }
    
    if($contador == 2){        
        echo "1";
        mysqli_close($stock);
    }else{
        echo "0";
    }
}
?>