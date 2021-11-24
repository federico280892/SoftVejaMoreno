<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<table class="table table-hover table-bordered tabla-consultaCodigos" id="tabla-consultaCodigos">
        <thead>
            <tr class="bg-info text-white">
            <th class="text-center" style="height: 20px; vertical-align: middle;"><small>Descripción</small></th>
            <th class="text-center" style="height: 20px; vertical-align: middle;"><small>Código</small></th>
            </tr>
        </thead>
        <tbody>';
            $peticion = mysqli_query($veja, "SELECT convenios.*, 
            prestaciones.id AS 'id', 
            prestaciones.codigo AS 'codigoPrestacion', 
            prestaciones.descripcion AS 'descripcionPrestacion' 
                FROM convenios 
                INNER JOIN prestaciones ON prestaciones.id = convenios.id_prestacion
                WHERE id_cobertura_social = '".$_POST['id']."'
                AND prestaciones.nivel = '".$_POST['nivel']."'");

            if(mysqli_num_rows($peticion) == 0){
                echo '<tr>
                    <td class="text-center" colspan="2" style="height: 18px; vertical-align: middle;">La cobertura social no posee convenios</td>
                </tr>';
            }else{
                while($d = mysqli_fetch_assoc($peticion)){
                    echo '<tr id="filaDatosPrestacion" data-id="'.$d['id'].'" data-codigo="'.$d['codigoPrestacion'].'" data-descripcion="'.$d['descripcionPrestacion'].'" data-precio="'.$d['precio_fijo'].'">
                        <td style="height: 18px; vertical-align: middle;">'.$d['descripcionPrestacion'].'</td>
                        <td style="height: 18px; vertical-align: middle;">'.$d['codigo_cobertura_social'].'</td>
                    </tr>';
                }
            }
        echo '</tbody>
    </table>';
    mysqli_close($veja);


    // <td>'.$d['descripcion'].'</td>
    // <td>'.$d['codigo'].'</td>
}
?>