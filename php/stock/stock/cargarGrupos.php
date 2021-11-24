<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT id, nombre FROM rubros WHERE activo = '1' ORDER BY nombre ASC");
    while($r = mysqli_fetch_assoc($peticion)){
      echo '<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
    }
    mysqli_close($stock);
}
?>