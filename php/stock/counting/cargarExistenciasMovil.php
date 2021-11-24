<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT 
    articulos.id AS 'id', 
    articulos.activo AS 'activo', 
    articulos.nombre AS 'articulo',
    articulos.vencimiento AS 'vencimiento',
    articulos.codigo_barra AS 'cod_barras',
    existencias.cantidad AS 'cantidad'
    FROM articulos 
    INNER JOIN existencias 
    ON existencias.id_articulo = articulos.id 
    WHERE articulos.activo = '1'");
    if(mysqli_num_rows($peticion) > 0){
        while($i = mysqli_fetch_assoc($peticion)){
            if($i['activo'] == '1'){
                $visible = "Activo";
                $nombre = '<small class="align-middle text-center text-success">'.$i['articulo'].'</small>';
            }else{
                $visible = "Inactivo";
                $nombre = '<small class="align-middle text-center text-danger">'.$i['articulo'].'</small>';
            }
            echo '<li data-buscar="'.$i['articulo'].' '.$i['cod_barras'].' '.$visible.' '.$i['vencimiento'].'" class="list-group-item insumoFilaMovil">
                <div class="row">
                    <div class="col text-left">
                        '.$nombre.'
                    </div>
                    <div class="col text-right">
                        <i role="button" class="fas fa-search-plus text-info" onclick=verExistencia(\''.$i['id'].'\')></i>
                        <i role="button" class="fas fa-pencil-alt text-warning ml-3" onclick=editarExistencia(\''.$i['id'].'\')></i>
                        <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick=eliminarExistencia(\''.$i['id'].'\')></i>
                    </div>
                </div>
            </li>';
        }
    }else{
        echo '<div>
            <p class="text-center">No se encontraron registros</p>
        </div>';
    }
}
?>