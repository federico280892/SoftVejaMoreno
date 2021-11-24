<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM insumos ORDER BY nombre ASC");
    if(mysqli_num_rows($peticion) > 0){
        while($i = mysqli_fetch_assoc($peticion)){
            if($i['activo'] == '1'){
                $visible = "Activo";
                $nombre = '<p class="align-middle text-center text-success">'.$i['nombre'].'</p>';
            }else{
                $visible = "Inactivo";
                $nombre = '<p class="align-middle text-center text-danger">'.$i['nombre'].'</p>';
            }
            echo '<li data-buscar="'.$i['nombre'].' '.$i['cod_barras'].' '.$i['proveedor'].' '.$visible.' '.$i['vencimiento'].'" class="list-group-item insumoFilaMovil">
                <div class="row">
                    <div class="col text-left">
                        <small>'.$i['nombre'].'</small>
                    </div>
                    <div class="col text-right">
                        <i role="button" class="fas fa-search-plus text-info" onclick=verInsumo(\''.$i['id'].'\')></i>
                        <i role="button" class="fas fa-pencil-alt text-warning ml-3" onclick=editarInsumo(\''.$i['id'].'\')></i>
                        <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick=eliminarInsumo(\''.$i['id'].'\')></i>
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