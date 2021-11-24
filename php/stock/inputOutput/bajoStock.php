<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT articulos.nombre, existencias.cantidad FROM articulos INNER JOIN existencias ON existencias.id_articulo = articulos.id WHERE existencias.cantidad < 21");
       
    if(mysqli_num_rows($peticion) > 0){
        echo '<div class="list-group">';
        while($i = mysqli_fetch_assoc($peticion)){
            echo "<li class='list-group-item'>".$i['nombre'].": ".$i['cantidad']." unidades</li>";
        }
        echo '</div>';
    }
}
?>