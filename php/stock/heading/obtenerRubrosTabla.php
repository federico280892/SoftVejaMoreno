<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM rubros ORDER BY nombre ASC");
    while($r = mysqli_fetch_assoc($peticion)){
        if($r['dioptria'] == "1"){
            $dioptria = "SI";
        }else{
            $dioptria = "NO";
        }
        if($r['activo'] == '1'){
            $estado = '<td class="text-center text-success">Activo</td>';
            $visible = "Activo";
        }else{
            $estado = '<td class="text-center text-danger">Inactivo</td>';
            $visible = "Inactivo";
        }
        echo '<tr data-buscar="'.$r['nombre'].' '.$r['observacion'].' '.$visible.'" class="rubroFila">
            <td class="text-left">'.$r['nombre'].'</td>
            <td class="text-left">'.$r['observacion'].'</td>
            <td class="text-center">'.$dioptria.'</td>';
            echo $estado;
            echo '<td class="text-center">
                <i role="button" class="fas fa-pencil-alt text-warning" onclick=editarRubro(\''.$r['id'].'\')></i>
                <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick=eliminarRubro(\''.$r['id'].'\')></i>
            </td>
        </tr>';
    }
}
?>