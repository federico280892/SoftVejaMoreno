<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT insumos.id AS 'id', insumos.nombre AS 'nombre', insumos.cod_barras AS 'cod_barras', insumos.vencimiento AS 'vencimiento', insumos.activo AS 'activo', proveedores.nombre AS 'proveedor' FROM insumos INNER JOIN proveedores ON insumos.proveedor = proveedores.id ORDER BY insumos.nombre ASC");
    if(mysqli_num_rows($peticion) > 0){
        while($i = mysqli_fetch_assoc($peticion)){
            if($i['activo'] == '1'){
                $estado = '<td class="text-center">Activo</td>';
                $visible = "Activo";
                $nombre = '<td class="align-middle text-center text-success">'.$i['nombre'].'</td>';
            }else{
                $estado = '<td class="text-center">Inactivo</td>';
                $visible = "Inactivo";
                $nombre = '<td class="align-middle text-center text-danger">'.$i['nombre'].'</td>';
            }
            echo '<tr data-buscar="'.$i['nombre'].' '.$i['cod_barras'].' '.$i['proveedor'].' '.$estado.' '.$i['vencimiento'].'" class="registroFila">
                '.$nombre.'
                <td class="align-middle text-center">'.$i['cod_barras'].'</td>
                <td class="align-middle text-center">'.$i['proveedor'].'</td>
                <td class="align-middle text-center">'.$i['vencimiento'].'</td>
                <td class="align-middle text-center">
                    <i role="button" class="fas fa-search-plus text-info" onclick=verInsumo(\''.$i['id'].'\')></i>
                    <i role="button" class="fas fa-pencil-alt text-warning ml-3" onclick=editarInsumo(\''.$i['id'].'\')></i>
                    <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick=eliminarInsumo(\''.$i['id'].'\')></i>
                </td>
            </tr>';
        }
    }else{
        echo '<tr>
            <td colspan="5" class="text-center">No se encontraron registros</td>
        </tr>';
    }
}
?>