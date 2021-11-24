<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT 
    articulos.nombre AS 'nombre', 
    existencias.cantidad AS 'cantidad' 
    FROM articulos 
    INNER JOIN existencias 
    ON existencias.id_articulo = articulos.id 
    WHERE existencias.cantidad <= 20
    AND articulos.activo = '1'");

    if(mysqli_num_rows($peticion) > 0){
        while($i = mysqli_fetch_assoc($peticion)){
            echo '<li class="list-group-item"><small>'.$i['nombre'].' ('.$i['cantidad'].' items)</small></li>';
        }
    }else{
        echo '<li class="list-group-item">Sin informes</li>';
    }
    mysqli_close($stock);
}
?>

                    