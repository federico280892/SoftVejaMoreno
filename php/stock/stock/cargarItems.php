<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "
    SELECT grupos.*, 
    rubros.nombre AS 'nombreRubro' 
    FROM grupos 
    INNER JOIN rubros 
    ON rubros.id = grupos.rubro 
    ORDER BY nombre ASC");

    if(mysqli_num_rows($peticion) > 0){
        while($i = mysqli_fetch_assoc($peticion)){
            if($i['activo'] == '1'){
                $estado = '<td class="align-middle text-center">Activo</td>';
                $visible = "Activo";
                $nombre = '<td class="align-middle text-left text-success">'.$i['nombre'].'</td>';
            }else{
                $estado = '<td class="align-middle text-center">Inactivo</td>';
                $visible = "Inactivo";
                $nombre = '<td class="align-middle text-left text-danger">'.$i['nombre'].'</td>';
            }
            echo '<tr data-buscar="'.$i['nombre'].' '.$visible.' '.$i['descripcion'].' '.$i['observaciones'].'" class="itemFila">
                '.$nombre.'
                <td class="align-middle text-left">'.$i['descripcion'].'</td>
                <td class="align-middle text-center">'.$i['nombreRubro'].'</td>
                <td class="align-middle text-center">'.$i['observaciones'].'</td>
                '.$estado.'
                <td class="align-middle text-center">
                    <i role="button" class="fas fa-search-plus text-info" onclick=verItem(\''.$i['id'].'\')></i>
                    <i role="button" class="fas fa-pencil-alt text-warning ml-3" onclick=editarItem(\''.$i['id'].'\')></i>
                    <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick=eliminarItem(\''.$i['id'].'\')></i>
                </td>
            </tr>';
        }
    }else{
        echo '<tr>
            <td colspan="6" class="text-center">No se encontraron registros</td>
        </tr>';
    }
}
?>