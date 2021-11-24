<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $localidades = mysqli_query($veja, "SELECT * FROM localidades WHERE id_provincia = '".$_POST['id']."' ORDER BY localidad ASC");
    while($l = mysqli_fetch_assoc($localidades)){
      echo '<option value="'.$l['id'].'">'.strtoupper($l['localidad']).'</option>';
      
    }
    mysqli_close($veja);
}
?>