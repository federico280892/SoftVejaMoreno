<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM proveedores ORDER BY nombre ASC");
    while($r = mysqli_fetch_assoc($peticion)){
        if($r['activo'] == '1'){
            $estado = '<td class="text-center">Activo</td>';
            $bandera = '<i class="fas fa-eye text-success"></i>';
            $visible = "Activo";
        }else{
            $estado = '<td class="text-center">Inactivo</td>';
            $bandera = '<i class="fas fa-eye-slash text-danger"></i>';
            $visible = "Inactivo";
        }
        echo '<li data-buscar="'.$r['nombre'].' '.$r['observacion'].' '.$visible.'" class="list-group-item proveedoresFilaMovil">
            <div class="row">
                <div class="col text-left">
                    <small class="text-center">'.$bandera.' '.$r['nombre'].'</small>
                </div>
                <div class="col text-right">
                    <i role="button" class="fas fa-pencil-alt text-warning" onclick=editarProveedor(\''.$r['id'].'\')></i>
                    <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick=eliminarProveedor(\''.$r['id'].'\')></i>
                </div>
            </div>
        </li>';
    }
}
?>