<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT items.nombre AS 'nombre', insumos.id AS 'id', insumos.img AS 'img', insumos.descripcion AS 'descripcion', existencias.cantidad AS 'cantidad' FROM insumos INNER JOIN existencias ON insumos.id = existencias.id_insumo INNER JOIN items ON items.id = insumos.id_item");
    if(mysqli_num_rows($peticion) > 0){
        while($i = mysqli_fetch_assoc($peticion)){
            echo '<li data-buscar="'.$i['nombre'].' '.$i['descripcion'].' '.$i['cantidad'].'" class="list-group-item altaBajaFilaMovil">
                <div class="row">
                    <div class="col text-left align-middle">
                        <small><span class="text-center align-middle">'.$i['nombre'].' '.$i['descripcion'].'</span></small>
                    </div>
                    <div class="col text-right align-middle">
                        <i role="button" onclick="editarAltasBajas(\''.$i['id'].'\')" class="fas fa-cubes text-success"></i>
                    </div>
                </div>    
            </li>';
        }
        }else{
            echo '<li>
                <span class="text-center list-group-item">No se encontraron registros</span>
            </li>';
        }
    mysqli_close($stock);
}
?>