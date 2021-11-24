<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT * FROM formas_pago ORDER BY pago ASC");
    if(mysqli_num_rows($peticion) > 0){
            while($p = mysqli_fetch_assoc($peticion)){
                if($p['activo'] == "1"){
                    $clase = "";
                    $accion = '<i onclick="activarDesactivarFormaPago(\''.$p['id'].'\')" title="Desactivar forma de pago" role="button" class="fas fa-eye-slash text-danger mr-3"></i>';
                }else{
                    $clase = "text-danger";
                    $accion = '<i onclick="activarDesactivarFormaPago(\''.$p['id'].'\')" title="Activar forma de pago" role="button" class="fas fa-eye text-success mr-3"></i>';
                }
                echo '<tr class="'.$clase.'">
                    <td class="text-center">'.$p['pago'].'</td>
                    <td class="text-center">'.$p['descripcion'].'</td>
                    <td class="text-center">
                        <i onclick="modificarFormaDePago(\''.$p['id'].'\')" title="Editar forma de pago" role="button" class="fas fa-pencil-alt mr-3 text-success"></i>';
                        echo $accion;
                        echo '<i onclick="eliminarFormaPago(\''.$p['id'].'\')" title="Eliminar forma de pago" role="button" class="fas fa-trash text-danger mr-3"></i>
                    </td>
                </tr>';
            }
    }else {
        echo '<tr style="line-height: 15px;">
            <td colspan="3" class="text-center font-weight-bold">No existen formas de pago registradas.</td>
        </tr>';
    }
    mysqli_close($veja);
}
?>