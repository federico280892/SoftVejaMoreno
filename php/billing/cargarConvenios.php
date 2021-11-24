<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if($_POST['id'] != "0"){
        $peticion = mysqli_query($veja, "SELECT prestaciones.id AS 'idPrestacion',
        prestaciones.descripcion AS 'prestacion', 
        convenios.precio_fijo AS 'precio', 
        convenios.codigo_cobertura_social AS 'codigo', 
        convenios.id_cobertura_social AS 'cobertura' 
        FROM prestaciones
            LEFT JOIN convenios ON convenios.id_prestacion = prestaciones.id 
            AND convenios.id_cobertura_social = '".$_POST['id']."'");
            while($p = mysqli_fetch_assoc($peticion)){
                // echo '<tr>
                // <td class="text-left">'.$p['prestacion'].'</td>
                // <td class="text-center"><input data-id="'.$p['idPrestacion'].'" value="'.$p['precio'].'" type="text" class="form-control-sm borde-input text-center" style="width:111px;"></td>
                // </tr>';
                echo '<tr>
                <td class="text-left">'.$p['prestacion'].'</td>
                <td class="text-center"><input type="text" value="'.$p['codigo'].'" class="modalNuevoConvenioCodigoCoberturaSocial form-control-sm borde-input text-center" style="width:180px;"></td>
                <td class="text-center"><input data-id="'.$p['idPrestacion'].'" value="'.$p['precio'].'" type="text" class="modalNuevoConvenioPrecioPrestacion form-control-sm borde-input text-center" style="width:111px;"></td>
                </tr>';
            }
    }else {
        echo '<tr style="line-height: 15px;">
            <td colspan="3" class="text-center">Seleccione una cobertura.</td>
        </tr>';
    }
    mysqli_close($veja);
}
?>